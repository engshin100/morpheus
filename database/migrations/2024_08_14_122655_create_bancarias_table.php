<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bancarias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('codigo', 50)->nullable();
            $table->string('banco')->nullable()->default('Não informado');
            $table->string('agencia', 50)->nullable();
            $table->string('conta', 50)->nullable();
            $table->string('tipo', 50)->nullable();
            $table->string('operacao', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bancarias');
    }
};
