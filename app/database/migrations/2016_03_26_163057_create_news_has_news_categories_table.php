<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsHasNewsCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news_has_news_categories', function(Blueprint $table)
		{
			$table->integer('news_id')->index('fk_news_has_news_categories_news1_idx');
			$table->integer('news_categories_id')->index('fk_news_has_categories_news_categories1_idx');
			$table->primary(['news_id','news_categories_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('news_has_news_categories');
	}

}
