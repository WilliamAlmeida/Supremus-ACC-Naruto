<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServerReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('server_reports', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->boolean('world_id')->default(0)->index('world_id');
			$table->integer('player_id')->default(1)->index('player_id');
			$table->integer('posx')->default(0);
			$table->integer('posy')->default(0);
			$table->integer('posz')->default(0);
			$table->bigInteger('timestamp')->default(0);
			$table->text('report', 65535);
			$table->integer('reads')->default(0)->index('reads');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('server_reports');
	}

}
