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
        Schema::create('tb_assinatura', function (Blueprint $table) {
            $table->id('cd_assinatura');
            $table->string('nm_pessoa', 50);
            $table->string('cd_cpf_pessoa', 11);
            $table->date('dt_assinatura');
            $table->unsignedBigInteger('cd_contrato');
            $table->timestamps();

            $table->foreign('cd_contrato')->references('cd_contrato')->on('tb_contrato');
            $table->index('cd_contrato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_assinatura', function (Blueprint $table) {
            $table->dropIndex('cd_contrato');
            $table->dropForeign(['cd_contrato']);
        });
        Schema::dropIfExists('tb_assinatura');
    }
};
