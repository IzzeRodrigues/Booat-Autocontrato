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
        Schema::create('tb_contratante', function (Blueprint $table) {
            $table->id('cd_contratante');
            $table->string('nm_contratante', 50);
            $table->string('cd_cnpj_contratante', 14);
            $table->string('nm_email_contratante', 100);
            $table->string('ds_tipo_estabelecimento', 20);
            $table->integer('cd_controle_contratante');
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
        Schema::table('tb_contratante', function (Blueprint $table) {
            $table->dropIndex('cd_contrato');
            $table->dropForeign(['cd_contrato']);
        });
        Schema::dropIfExists('tb_contratante');
    }
};
