<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Especialista;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::with(['user', 'especialista'])
            ->when(auth()->user()->role !== 'admin', fn ($query) => $query->where('user_id', auth()->id()))
            ->latest('created_at')
            ->get();

        $especialistas = Especialista::orderBy('nombre')->get();

        return view('citas.index', compact('citas', 'especialistas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'motivo' => ['required', 'string'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['estado'] = 'pendiente';

        Cita::create($data);

        return redirect()->route('citas.index')->with('status', 'Solicitud de cita enviada.');
    }

    public function edit(Cita $cita)
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $especialistas = Especialista::orderBy('nombre')->get();

        return view('citas.edit', compact('cita', 'especialistas'));
    }

    public function update(Request $request, Cita $cita)
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $data = $request->validate([
            'especialista_id' => ['required', 'exists:especialistas,id'],
            'fecha' => ['required', 'date'],
            'hora' => ['required'],
            'motivo' => ['required', 'string'],
            'estado' => ['required', 'string', 'max:30'],
        ]);

        $cita->update($data);

        return redirect()->route('citas.index')->with('status', 'Cita actualizada.');
    }

    public function destroy(Cita $cita)
    {
        abort_unless(auth()->user()->role === 'admin' || ($cita->user_id === auth()->id() && $cita->estado === 'pendiente'), 403);

        $cita->delete();

        return redirect()->route('citas.index')->with('status', 'Cita eliminada.');
    }

    public function pdf(Cita $cita)
    {
        abort_unless(auth()->user()->role === 'admin' || $cita->user_id === auth()->id(), 403);

        $cita->load(['user', 'especialista']);
        $html = view('pdf.cita', compact('cita'))->render();

        return response($this->simplePdf($html), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="cita-' . $cita->id . '.pdf"',
        ]);
    }

    private function simplePdf(string $html): string
    {
        $text = strip_tags(str_replace(['</p>', '<br>', '</tr>'], "\n", $html));
        $lines = array_filter(array_map('trim', explode("\n", html_entity_decode($text))));
        $content = "BT /F1 11 Tf 50 780 Td ";

        foreach ($lines as $line) {
            $safe = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], substr($line, 0, 105));
            $content .= "($safe) Tj 0 -18 Td ";
        }

        $content .= 'ET';
        $objects = [
            "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj",
            "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj",
            "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj",
            "4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj",
            "5 0 obj << /Length " . strlen($content) . " >> stream\n$content\nendstream endobj",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object . "\n";
        }

        $xref = strlen($pdf);
        $pdf .= "xref\n0 6\n0000000000 65535 f \n";

        for ($i = 1; $i <= 5; $i++) {
            $pdf .= str_pad((string) $offsets[$i], 10, '0', STR_PAD_LEFT) . " 00000 n \n";
        }

        return $pdf . "trailer << /Size 6 /Root 1 0 R >>\nstartxref\n$xref\n%%EOF";
    }
}
