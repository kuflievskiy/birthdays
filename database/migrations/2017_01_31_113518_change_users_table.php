<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (Schema::hasTable('users')) {
			Schema::table('users', function (Blueprint $table) {
				if (Schema::hasColumn('users', 'created_at')) {
					$table->dateTime('created_at')->nullable()->change();
				}

				if (Schema::hasColumn('users', 'updated_at')) {
					$table->dateTime('updated_at')->nullable()->change();
				}
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
