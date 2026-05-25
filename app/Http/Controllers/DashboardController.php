<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Especialista;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
            if (auth()->user()->role !== 'admin') {
            $misCitas = Cita::with('especialista')
                ->where('user_id', auth()->id())
                ->latest('created_at')
                ->get();

            return view('dashboard.index', compact('misCitas'));
        }

        $citasPorMes = Cita::query()
            ->selectRaw("DATE_FORMAT(fecha, '%Y-%m') as mes, COUNT(*) as total")
            ->whereNotNull('fecha')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $especialistasMasSolicitados = Especialista::query()
            ->leftJoin('citas', 'citas.especialista_id', '=', 'especialistas.id')
            ->select('especialistas.nombre', DB::raw('COUNT(citas.id) as total'))
            ->groupBy('especialistas.id', 'especialistas.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('citasPorMes', 'especialistasMasSolicitados'));
    }
}