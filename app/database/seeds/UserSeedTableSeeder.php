<?php

class UserSeedTableSeeder extends Seeder {

	public function run()
	{
        $this->tb_user_umum();
        $this->tb_user();
        $this->Roles();
	}

    private function tb_user()
    {
        //DB::table('tb_user')->truncate();

        $userseed = array(
            'username'      => 'adminhmif2013',
            'password'      => Hash::make('hmifsiapakita3010'),
            'id_anggota'    => NULL,
            'id_user_umum'  => 1
        );

        DB::table('tb_user')->insert($userseed);
    }

    private function tb_user_umum()
    {
        //DB::table('tb_user_umum')->truncate();

        $userseed = array(
            'nama'   => 'Administrator',
            'nim'    => '000000',
            'alamat' => 'Sekretariat HMIF UNIKOM',
            'no_hp'  => '08xxxxxxxxxx',
            'email'  => 'admin@hmifunikom.com'
        );

        DB::table('tb_user_umum')->insert($userseed);
    }

    private function Roles()
    {
        // !!! All existing roles are deleted !!!
        DB::table('role_user')->truncate();
        DB::table('roles')->truncate();

        $user = User::where('username', 'adminhmif2013')->firstOrFail();
        $roleAdmin = Role::create(['name' => 'admin']);

        $user->roles()->attach($roleAdmin->id);
    }
}