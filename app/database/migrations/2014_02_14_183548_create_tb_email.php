<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbEmail extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_email', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('kd_email');
			$table->integer('id_anggota')->unsigned();
			$table->string('email');

			$table->timestamps();

			$table->foreign('id_anggota')
				  ->references('id_anggota')->on('tb_anggota')
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
		Schema::drop('tb_email');
	}

}