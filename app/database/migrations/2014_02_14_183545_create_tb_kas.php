<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbKas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_kas', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('kd_kas');
			$table->integer('id_anggota')->unsigned()->nullable();
			$table->date('bulan');

			$table->timestamps();

			$table->index('bulan');
			$table->foreign('id_anggota')
				  ->references('id_anggota')->on('tb_anggota')
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
		Schema::drop('tb_kas');
	}

}