<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopOfferHasMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_offer_has_media', function(Blueprint $table)
		{
			$table->integer('shop_offer_id')->index('fk_shop_offer_has_media_pages1_idx_idx');
			$table->integer('media_id')->index('fk_shop_offer_has_media_media1_idx_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop_offer_has_media');
	}

}
