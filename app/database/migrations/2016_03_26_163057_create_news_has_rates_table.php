<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsHasRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news_has_rates', function(Blueprint $table)
		{
			$table->integer('news_id')->index('fk_news_has_rates_news1_idx');
			$table->integer('rates_id')->index('fk_news_has_rates_rates1_idx');
			$table->primary(['news_id','rates_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('news_has_rates');
	}

}
