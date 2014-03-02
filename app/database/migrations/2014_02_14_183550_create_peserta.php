<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeserta extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('peserta', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id_peserta');
			$table->string('nama_peserta');
			$table->string('alamat');
			$table->enum('kategori', array('unikom', 'luar'));
			$table->integer('kd_acara')->unsigned()->nullable();
			$table->date('tgl_daftar');
			$table->string('nim', 8)->nullable();

			$table->timestamps();

			$table->foreign('kd_acara')
				  ->references('kd_acara')->on('tb_acara')
				  ->onUpdate('cascade')
				  ->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('peserta');
	}

}