<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServerMotdTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('server_motd', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->boolean('world_id')->default(0);
			$table->text('text', 65535);
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
		Schema::drop('server_motd');
	}

}
