<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHouseDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('house_data', function(Blueprint $table)
		{
			$table->integer('house_id')->unsigned();
			$table->boolean('world_id')->default(0);
			$table->binary('data');
			$table->unique(['house_id','world_id'], 'house_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('house_data');
	}

}
