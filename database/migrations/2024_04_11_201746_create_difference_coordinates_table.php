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
        Schema::create('difference_coordinates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('difference_id');
            $table->float('x1');
            $table->float('y1');
            $table->float('x2');
            $table->float('y2');
            $table->timestamps();

            $table->foreign('difference_id')->references('id')->on('differences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('difference_coordinates');
    }
};
