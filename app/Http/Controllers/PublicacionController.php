<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use Illuminate\Support\Facades\Auth;

class PublicacionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);

        Auth::User()->publicaciones()->create([
            'contenido' => $request->input('contenido')
        ]);

        return redirect()->route('perfil');
    }
}
