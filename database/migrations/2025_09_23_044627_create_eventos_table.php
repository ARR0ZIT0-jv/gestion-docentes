<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->string('lugar')->nullable();
            $table->enum('tipo', ['reunion', 'seminario', 'taller', 'social', 'otros']);
            $table->enum('estado', ['planificado', 'confirmado', 'en_curso', 'finalizado', 'cancelado'])->default('planificado');
            $table->integer('cupo_maximo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};