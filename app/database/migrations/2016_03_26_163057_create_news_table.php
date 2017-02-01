<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title');
			$table->string('slug');
			$table->text('description', 65535);
			$table->integer('featured')->nullable()->default(0);
			$table->text('tags', 65535)->nullable();
			$table->integer('gallery')->nullable()->default(0);
			$table->integer('views')->default(0);
			$table->string('meta_title');
			$table->string('meta_description');
			$table->string('meta_keywords');
			$table->timestamps();
			$table->integer('account_id')->default(0)->index('news_account_id_idx');
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
		Schema::drop('news');
	}

}
