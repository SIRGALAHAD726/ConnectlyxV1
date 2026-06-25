<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\AmigoController;
use App\Http\Controllers\MessageController;




Route::get('/', function () {
    return view('auth.login');
})->name('index');

Route::get('/inicio', function () {
    return view('inicio');
})->name('inicio');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/perfil', [PerfilController::class, 'showPerfil'])->middleware('auth')->name('perfil');

Route::post('/publicaciones', [PublicacionController::class, 'store'])->middleware('auth')->name('publicaciones.store');


Route::post('/agregar-amigo/{amigoId}', [AmigoController::class, 'agregarAmigo'])->name('amigos.agregar');



Route::post('/enviar-solicitud/{amigoId}', [AmigoController::class, 'enviarSolicitud'])->name('amigos.enviarSolicitud');
Route::post('/aceptar-solicitud/{solicitudId}', [AmigoController::class, 'aceptarSolicitud'])->name('amigos.aceptarSolicitud');
Route::post('/rechazar-solicitud/{solicitudId}', [AmigoController::class, 'rechazarSolicitud'])->name('amigos.rechazarSolicitud');

Route::delete('/eliminar-amigo/{amigoId}', [AmigoController::class, 'eliminarAmigo'])->name('amigos.eliminar');


Route::post('/messages/{amigoId}', [MessageController::class, 'store'])->name('messages.store');
Route::get('/chat/{userId}', [MessageController::class, 'showChat'])->name('chat.show');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');


