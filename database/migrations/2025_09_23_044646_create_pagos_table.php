<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->string('concepto');
            $table->string('periodo');
            $table->date('fecha_pago');
            $table->enum('metodo', ['efectivo', 'transferencia', 'tarjeta', 'otros']);
            $table->string('comprobante')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('verificado')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};