<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbAcara extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_acara', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('kd_acara');
			$table->string('nama_acara');
			$table->date('tgl');
			$table->string('tempat', 30);
			$table->text('info');
			$table->string('pj');
			$table->date('tgl_selesai_LPJ');
			$table->string('tema');

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
		Schema::drop('tb_acara');
	}

}