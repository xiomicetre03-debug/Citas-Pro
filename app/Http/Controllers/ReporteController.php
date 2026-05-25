<?php

namespace App\Http\Controllers;

use App\Models\Cita;

class ReporteController extends Controller
{
    public function pdf()
    {
        $citas = Cita::with(['user', 'especialista'])->orderByDesc('fecha')->get();
        $html = view('pdf.citas', compact('citas'))->render();

        return response($this->simplePdf($html), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="reporte-citas.pdf"',
        ]);
    }

    private function simplePdf(string $html): string
    {
        $text = strip_tags(str_replace(['</tr>', '</p>', '<br>'], "\n", $html));
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
