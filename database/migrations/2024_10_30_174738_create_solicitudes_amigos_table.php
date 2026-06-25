<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_amigos', function (Blueprint $table) {
    $table->id();

    $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');

    $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');

    $table->timestamps();

    $table->unique(['sender_id', 'receiver_id']);
    $table->index('sender_id');
    $table->index('receiver_id');
    $table->index('status');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_amigos');
    }
};
