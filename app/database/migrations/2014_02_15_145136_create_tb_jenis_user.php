<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbJenisUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_jenis_user', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id_jenis_user');
			$table->string('jenis_user', 20);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_jenis_user');
	}

}
