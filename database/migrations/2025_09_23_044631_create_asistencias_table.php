<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->timestamp('fecha_inscripcion')->useCurrent();
            $table->boolean('confirmado')->default(false);
            $table->boolean('asistio')->default(false);
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->unique(['evento_id', 'docente_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};