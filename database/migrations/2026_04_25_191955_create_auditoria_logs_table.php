<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditoria_logs', function (Blueprint $table) {
            $table->id();
            $table->string('metodo');
            $table->string('endpoint');
            $table->json('payload_envio')->nullable();
            $table->json('erros_validacao')->nullable();
            $table->integer('status_http');
            $table->string('ip_origem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auditoria_logs');
    }
};
