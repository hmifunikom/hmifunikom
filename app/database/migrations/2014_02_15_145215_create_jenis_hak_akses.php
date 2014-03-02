<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJenisHakAkses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jenis_hak_akses', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id_hak_akses');
			$table->string('hak_akses', 20);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('jenis_hak_akses');
	}

}
