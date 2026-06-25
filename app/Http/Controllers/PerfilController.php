<?php

namespace App\Http\Controllers;

use App\Models\SolicitudAmigo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Publicacion;

class PerfilController extends Controller
{
    public function showPerfil()
    {
        $publicaciones = Publicacion::with('user')->latest()->get();

        $solicitudes = SolicitudAmigo::pendientesPara(Auth::id())->get();

        $amigos = Auth::user()->amigos;

        $sugerenciasAmigos = User::whereNotIn('id', array_merge($amigos->pluck('id')->toArray(), [Auth::id()]))->get();

        return view('perfil', compact('publicaciones', 'solicitudes', 'amigos', 'sugerenciasAmigos'));
    }
}
