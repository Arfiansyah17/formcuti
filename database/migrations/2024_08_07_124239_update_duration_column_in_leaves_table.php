<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDurationColumnInLeavesTable extends Migration
{
    public function up()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->string('duration', 255)->change();
        });
    }

    public function down()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->integer('duration')->change();
        });
    }
}
