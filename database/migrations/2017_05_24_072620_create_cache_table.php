<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cache')) {
            Schema::table('cache', function (Blueprint $table) {
                //
                $table->string('key', 255);
                $table->text('value');
                $table->integer('expiration',false,true);
                $table->unique('key', 'cache_key_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cache', function (Blueprint $table) {
            //
        });
    }
}
