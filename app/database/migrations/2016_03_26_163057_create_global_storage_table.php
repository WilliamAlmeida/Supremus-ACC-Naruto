<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGlobalStorageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('global_storage', function(Blueprint $table)
		{
			$table->integer('key')->unsigned();
			$table->boolean('world_id')->default(0);
			$table->string('value')->default('0');
			$table->unique(['key','world_id'], 'key');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('global_storage');
	}

}
