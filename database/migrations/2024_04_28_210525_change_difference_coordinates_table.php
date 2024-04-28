<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('difference_coordinates', function (Blueprint $table) {
            $table->dropColumn('x1');
        });

        Schema::table('difference_coordinates', function (Blueprint $table) {
            $table->dropColumn('y1');
        });

        Schema::table('difference_coordinates', function (Blueprint $table) {
            $table->dropColumn('x2');
        });

        Schema::table('difference_coordinates', function (Blueprint $table) {
            $table->dropColumn('y2');
        });

        Schema::table('difference_coordinates', function (Blueprint $table) {
            $table->float('x')->after('game_id');
            $table->float('y')->after('x');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('difference_coordinates', function (Blueprint $table) {
            $table->dropColumn('x');
        });

        Schema::table('difference_coordinates', function (Blueprint $table) {
            $table->dropColumn('y');
        });

        Schema::table('difference_coordinates', function (Blueprint $table) {
            $table->float('x1');
        });

        Schema::table('difference_coordinates', function (Blueprint $table) {
            $table->float('y1');
        });

        Schema::table('difference_coordinates', function (Blueprint $table) {
            $table->float('x2');
        });

        Schema::table('difference_coordinates', function (Blueprint $table) {
            $table->float('y2');
        });
    }
};
