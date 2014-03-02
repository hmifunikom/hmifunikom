<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbAnggota extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_anggota', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id_anggota');
			$table->string('nim', 8);
			$table->string('alamat');
			$table->string('asal', 16);
			$table->integer('id_divisi')->unsigned()->nullable();

			$table->timestamps();

			$table->unique('nim');
			$table->foreign('id_divisi')
				  ->references('id_divisi')->on('tb_divisi')
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
		Schema::drop('tb_anggota');
	}

}