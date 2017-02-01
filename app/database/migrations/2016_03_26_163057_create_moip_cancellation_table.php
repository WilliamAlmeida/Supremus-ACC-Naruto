<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMoipCancellationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moip_cancellation', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('classification', 100)->nullable();
			$table->text('description', 16777215)->nullable();
			$table->text('message', 16777215)->nullable();
			$table->string('recovery', 50)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('moip_cancellation');
	}

}
