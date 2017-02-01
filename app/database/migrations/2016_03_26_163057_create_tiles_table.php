<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tiles', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->boolean('world_id')->default(0);
			$table->integer('house_id')->unsigned();
			$table->integer('x')->unsigned();
			$table->integer('y')->unsigned();
			$table->boolean('z');
			$table->unique(['id','world_id'], 'id');
			$table->index(['x','y','z'], 'x');
			$table->index(['house_id','world_id'], 'house_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tiles');
	}

}
