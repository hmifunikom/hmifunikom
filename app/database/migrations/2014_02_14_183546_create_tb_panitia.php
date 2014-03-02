<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbPanitia extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_panitia', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id_panitia');
			$table->integer('id_anggota')->unsigned();
			$table->integer('kd_acara')->unsigned();
			$table->integer('id_div')->unsigned()->nullable();
			$table->enum('jabatan', array('koor', 'angg'));

			$table->timestamps();

			$table->foreign('id_anggota')
				  ->references('id_anggota')->on('tb_anggota')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');
			$table->foreign('kd_acara')
				  ->references('kd_acara')->on('tb_acara')
				  ->onUpdate('cascade')
				  ->onDelete('cascade');
			$table->foreign('id_div')
				  ->references('id_div')->on('tb_div_acara')
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
		Schema::drop('tb_panitia');
	}

}