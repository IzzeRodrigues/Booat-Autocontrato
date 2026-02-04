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
        Schema::create('tb_representante', function (Blueprint $table) {
            $table->id('cd_representante');
            $table->string('nm_representante', 50);
            $table->string('cd_cpf_representante', 11);
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
        Schema::table('tb_representante', function (Blueprint $table) {
            $table->dropIndex('cd_contratante');
            $table->dropForeign(['cd_contratante']);
        });
        Schema::dropIfExists('tb_representante');
    }
};
