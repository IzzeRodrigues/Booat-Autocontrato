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
        Schema::create('tb_contrato', function (Blueprint $table) {
            $table->id('cd_contrato');
            $table->string('nm_contrato', 50);
            $table->decimal('vl_contrato', 14,4);
            $table->string('ds_tipo_plano', 20);
            $table->integer('nr_parcelas');
            $table->integer('nr_tempo_duracao');
            $table->integer('nr_tempo_midia');
            $table->decimal('vl_rescisao', 14,4);
            $table->integer('nr_tempo_rescisao');
            $table->integer('nr_tempo_validade');
            $table->date('dt_contrato');
            $table->integer('nr_token');
            $table->enum('ds_status', ['A pagar','Nao pago','Pago']);
            $table->integer('cd_controle_contrato');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_contrato');
    }
};
