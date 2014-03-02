<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbHp extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_hp', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('kd_hp');
			$table->integer('id_anggota')->unsigned();
			$table->string('no_hp', 16);

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
		Schema::drop('tb_hp');
	}

}