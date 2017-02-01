<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHousesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('houses', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->boolean('world_id')->default(0);
			$table->integer('owner');
			$table->integer('paid')->unsigned()->default(0);
			$table->integer('warnings')->default(0);
			$table->integer('lastwarning')->unsigned()->default(0);
			$table->string('name');
			$table->integer('town')->unsigned()->default(0);
			$table->integer('size')->unsigned()->default(0);
			$table->integer('price')->unsigned()->default(0);
			$table->integer('rent')->unsigned()->default(0);
			$table->integer('doors')->unsigned()->default(0);
			$table->integer('beds')->unsigned()->default(0);
			$table->integer('tiles')->unsigned()->default(0);
			$table->boolean('guild')->default(0);
			$table->boolean('clear')->default(0);
			$table->unique(['id','world_id'], 'id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('houses');
	}

}
