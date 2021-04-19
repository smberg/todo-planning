<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDevelopersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->string('developer');
            $table->integer('time');
            $table->integer('level');
        });

        $devs = array();
        for ($i=1; $i < 6; $i++) {
            $devs[] = array(
                'developer' => 'Dev'.$i,
                'time' => 1,
                'level' => $i
            );
        }

        DB::table('developers')->insert($devs);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('developers');
    }
}
