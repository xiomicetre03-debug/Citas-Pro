<?php

namespace App\Http\Controllers;

use App\Models\Especialista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EspecialistaController extends Controller
{
    public function index()
    {
        $especialistas = Especialista::orderBy('nombre')->get();

        return view('especialistas.index', compact('especialistas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'especialidad' => ['required', 'string', 'max:120'],
            'telefono' => ['required', 'string', 'max:40'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('especialistas', 'public');
        }

        Especialista::create($data);

        return redirect()->route('especialistas.index')->with('status', 'Especialista creado.');
    }

    public function edit(Especialista $especialista)
    {
        return view('especialistas.edit', compact('especialista'));
    }

    public function update(Request $request, Especialista $especialista)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'especialidad' => ['required', 'string', 'max:120'],
            'telefono' => ['required', 'string', 'max:40'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($especialista->foto) {
                Storage::disk('public')->delete($especialista->foto);
            }

            $data['foto'] = $request->file('foto')->store('especialistas', 'public');
        }

        $especialista->update($data);

        return redirect()->route('especialistas.index')->with('status', 'Especialista actualizado.');
    }

    public function destroy(Especialista $especialista)
    {
        if ($especialista->foto) {
            Storage::disk('public')->delete($especialista->foto);
        }

        $especialista->delete();

        return redirect()->route('especialistas.index')->with('status', 'Especialista eliminado.');
    }
}