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
        Schema::create('tb_endereco_contratante', function (Blueprint $table) {
            $table->id('cd_endereco');
            $table->string('nm_endereco', 20);
            $table->string('nr_numero', 6);
            $table->string('nm_bairro', 50);
            $table->string('nm_cidade', 50);
            $table->char('sg_uf', 2);
            $table->unsignedBigInteger('cd_contratante');
            $table->timestamps();

            $table->foreign('cd_contratante')->references('cd_contratante')->on('tb_contratante');
            $table->index('cd_contratante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_endereco_contratante', function (Blueprint $table) {
            $table->dropIndex('cd_contratante');
            $table->dropForeign(['cd_contratante']);
        });
        Schema::dropIfExists('tb_endereco_contratante');
    }
};
