<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('nombre_archivo');
            $table->string('ruta_archivo');
            $table->string('extension');
            $table->decimal('tamanio', 10, 2)->nullable();
            $table->enum('tipo', ['acta', 'informe', 'estatuto', 'minuta', 'resolucion', 'otros']);
            $table->foreignId('docente_id')->constrained('docentes');
            $table->foreignId('evento_id')->nullable()->constrained('eventos')->onDelete('set null');
            $table->foreignId('cargo_id')->nullable()->constrained('cargos_universitarios')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};