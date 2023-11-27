<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->integer('level')->default(1);
            $table->string('username')->unique();
            $table->string('password');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
