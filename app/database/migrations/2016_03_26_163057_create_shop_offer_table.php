<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopOfferTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_offer', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('points')->default(0);
			$table->integer('category')->default(1);
			$table->integer('type')->default(1);
			$table->integer('item')->default(0);
			$table->integer('count')->default(0);
			$table->text('description', 65535);
			$table->string('name');
			$table->integer('featured')->nullable()->default(0);
			$table->integer('points_off')->nullable()->default(0);
			$table->integer('stock')->nullable()->default(0);
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
		Schema::drop('shop_offer');
	}

}
