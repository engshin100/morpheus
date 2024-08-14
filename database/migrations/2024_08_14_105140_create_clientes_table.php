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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf', 50)->unique();
            $table->date('data_nascimento')->nullable();
            $table->string('rg', 50)->nullable();
            $table->date('rg_exp', 50)->nullable();
            $table->string('naturalidade', 100)->nullable();
            $table->string('genitora', 100)->nullable();
            $table->string('genitor', 100)->nullable();
            $table->string('sexo', 50)->nullable();
            $table->string('estado_civil', 50)->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
