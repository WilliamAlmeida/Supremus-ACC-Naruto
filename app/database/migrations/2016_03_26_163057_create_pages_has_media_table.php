<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesHasMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages_has_media', function(Blueprint $table)
		{
			$table->integer('pages_id')->index('fk_pages_has_media_pages1_idx');
			$table->integer('media_id')->index('fk_pages_has_media_media1_idx');
			$table->primary(['pages_id','media_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pages_has_media');
	}

}
