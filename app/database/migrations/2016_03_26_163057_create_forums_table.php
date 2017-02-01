<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForumsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forums', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 120)->nullable();
			$table->text('description')->nullable();
			$table->smallInteger('access')->nullable()->default(1);
			$table->boolean('closed')->nullable();
			$table->text('moderators')->nullable();
			$table->integer('order')->nullable();
			$table->boolean('requireLogin')->nullable();
			$table->integer('guild')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forums');
	}

}
