<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideoCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('video_comments', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('author')->nullable()->index('author');
			$table->integer('video')->nullable()->index('video');
			$table->integer('time')->nullable();
			$table->text('text')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('video_comments');
	}

}
