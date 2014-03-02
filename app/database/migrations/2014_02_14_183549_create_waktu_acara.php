<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaktuAcara extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('waktu_acara', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id_waktu');
			$table->integer('kd_acara')->unsigned();
			$table->dateTime('waktu');

			$table->timestamps();

			$table->foreign('kd_acara')
				  ->references('kd_acara')->on('tb_acara')
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
		Schema::drop('waktu_acara');
	}

}