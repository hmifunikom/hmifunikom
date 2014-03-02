<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_user', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->string('username');
			$table->string('password');
			$table->integer('id_anggota')->unsigned()->nullable();
			$table->integer('id_jenis_user')->unsigned()->nullable();
			$table->integer('id_user_umum')->unsigned();

			$table->timestamps();

			$table->primary('username');
			$table->foreign('id_anggota')
				  ->references('id_anggota')->on('tb_anggota')
				  ->onUpdate('cascade')
				  ->onDelete('set null');
			$table->foreign('id_jenis_user')
				  ->references('id_jenis_user')->on('tb_jenis_user')
				  ->onUpdate('cascade')
				  ->onDelete('set null');
			$table->foreign('id_user_umum')
				  ->references('id_user_umum')->on('tb_user_umum')
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
		Schema::drop('tb_user');
	}

}
