<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThreadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('threads', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 120)->nullable();
			$table->boolean('sticked')->nullable();
			$table->boolean('closed')->nullable();
			$table->string('author', 64)->nullable();
			$table->integer('time')->nullable();
			$table->integer('board_id')->nullable()->index('board_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('threads');
	}

}
