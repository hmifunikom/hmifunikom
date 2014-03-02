<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbUserUmum extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_user_umum', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id_user_umum');
			$table->string('nama');
			$table->string('nim', 16);
			$table->string('alamat');
			$table->string('no_hp', 16);
			$table->string('email');

			$table->timestamps();

			$table->unique('email');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_user_umum');
	}

}
