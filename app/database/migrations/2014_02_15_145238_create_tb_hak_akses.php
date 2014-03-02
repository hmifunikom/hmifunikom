<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbHakAkses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_hak_akses', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->integer('id_jenis_user')->unsigned();
			$table->integer('id_hak_akses')->unsigned();

			$table->foreign('id_jenis_user')
				  ->references('id_jenis_user')->on('tb_jenis_user')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');

			$table->foreign('id_hak_akses')
				  ->references('id_hak_akses')->on('jenis_hak_akses')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_hak_akses');
	}

}
