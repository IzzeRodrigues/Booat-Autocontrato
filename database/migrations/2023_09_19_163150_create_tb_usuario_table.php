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
        Schema::create('tb_usuario', function (Blueprint $table) {
            $table->id('cd_usuario');
            $table->string('nm_usuario', 50);
            $table->string('nm_senha_usuario', 16);
            $table->string('nm_email_usuario', 50);
            $table->timestamps();

            $table->index('cd_usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_usuario');
    }
};
