<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServerRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('server_record', function(Blueprint $table)
		{
			$table->integer('record');
			$table->boolean('world_id')->default(0);
			$table->bigInteger('timestamp');
			$table->unique(['record','world_id','timestamp'], 'record');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('server_record');
	}

}
