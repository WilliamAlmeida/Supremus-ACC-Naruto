<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsHasMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news_has_media', function(Blueprint $table)
		{
			$table->integer('news_id')->index('fk_news_has_media_news1_idx');
			$table->integer('media_id')->index('fk_news_has_media_media1_idx');
			$table->primary(['news_id','media_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('news_has_media');
	}

}
