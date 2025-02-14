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
        Schema::table('attributes', function (Blueprint $table) {
            $table->string('icon')->default('fa-solid fa-star')->after('name');
        });
    }

    public function down()
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
