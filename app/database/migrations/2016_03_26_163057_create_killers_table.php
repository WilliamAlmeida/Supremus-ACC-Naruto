<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKillersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('killers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('death_id')->index('death_id');
			$table->boolean('final_hit')->default(0);
			$table->boolean('unjustified')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('killers');
	}

}
