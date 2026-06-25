<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SolicitudAmigo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AmigoController extends Controller
{
    public function enviarSolicitud($amigoId)
    {
        $user = Auth::user();

        $existeSolicitud = SolicitudAmigo::where('sender_id', $user->id)
            ->where('receiver_id', $amigoId)
            ->where('status', 'pending')
            ->exists();

        if ($existeSolicitud) {
            return redirect()->route('perfil');
        }

        SolicitudAmigo::create([
            'sender_id' => $user->id,
            'receiver_id' => $amigoId,
            'status' => 'pending',
        ]);

        return redirect()->route('perfil');
    }

    public function aceptarSolicitud($solicitudId)
    {
        $solicitud = SolicitudAmigo::findOrFail($solicitudId);

        if ($solicitud->receiver_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No puedes aceptar esta solicitud.');
        }

        $solicitud->status = 'accepted';
        $solicitud->save();

        Auth::user()->amigos()->attach($solicitud->sender_id);
        $solicitud->sender->amigos()->attach(Auth::id());

        return redirect()->route('perfil')->with('message', 'Solicitud de amistad aceptada.');
    }

    public function rechazarSolicitud($solicitudId)
    {
        $solicitud = SolicitudAmigo::findOrFail($solicitudId);

        if ($solicitud->receiver_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No puedes rechazar esta solicitud.');
        }

        $solicitud->status = 'rejected';
        $solicitud->save();

        return redirect()->route('perfil');
    }

    public function listarAmigos()
    {
        $amigos = Auth::user()->amigos;

        return view('amigos.lista', compact('amigos'));
    }

    public function eliminarAmigo($amigoId)
{
    $user = Auth::user();

    // eliminar relación en ambos sentidos
    $user->amigos()->detach($amigoId);

    $amigo = User::find($amigoId);

    if ($amigo) {
        $amigo->amigos()->detach($user->id);
    }

    return back()->with('message', 'Amigo eliminado correctamente.');
}
}
