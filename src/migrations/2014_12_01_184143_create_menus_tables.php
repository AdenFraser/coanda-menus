<?php

use Illuminate\Database\Migrations\Migration;

class CreateMenusTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function ($table) {

			$table->increments('id');
			$table->string('name');
			$table->string('identifier')->unique();

			$table->timestamps();

		});

		Schema::create('menuitems', function ($table) {

			$table->increments('id');
			$table->integer('menu_id');
			$table->string('name');
			$table->integer('page_id');
			$table->string('link');
			$table->integer('order');

			$table->timestamps();
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menus');
		Schema::drop('menuitems');
	}

}
