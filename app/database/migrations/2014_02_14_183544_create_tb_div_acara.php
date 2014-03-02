<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbDivAcara extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_div_acara', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id_div');
			$table->string('nama_div');
			$table->integer('kd_acara')->unsigned();

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
		Schema::drop('tb_div_acara');
	}

}