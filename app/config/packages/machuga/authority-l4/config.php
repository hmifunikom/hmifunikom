<?php

return array(

    'initialize' => function($authority) {
    	$user = Auth::guest() ? new User : $authority->getCurrentUser();
    	
        $authority->addAlias('manage', array('create', 'read', 'update', 'delete'));
        $authority->addAlias('moderate', array('update', 'delete'));
        $authority->addAlias('make', array('create', 'update', 'delete'));


        if($user->hasRole('admin'))
        {
            $authority->allow('manage', 'all');
            $authority->deny('delete', 'User', function ($self, $user){
                return $self->user()->id === $user->id;
            });
        }

        /*--------- HMIF ---------*/

        if($user->hasRole('inti'))
        {
            $authority->allow('manage', 'all');   
            $authority->deny('make', 'Kas');
        }

        if($user->hasRole('koord') OR $user->hasRole('sekredivisi'))
        {
            $authority->allow('read', 'Anggota');
            $authority->allow('read', 'Kas', function ($self, $divisi){
                return $self->user()->anggota->id_divisi === $divisi->id_divisi;
            });
            $authority->allow('read', 'Kas', function ($self, $kas){
                return $self->user()->anggota->id_divisi === $kas->pemilik->id_divisi;
            });
            $authority->allow('read', 'Hp');
            $authority->allow('read', 'Anggota');

            $authority->allow('create', 'Anggota', function ($self, $divisi){
                return $self->user()->anggota->id_divisi === $divisi->id_divisi;
            });
            $authority->allow('create', 'Hp', function ($self, $anggota){
                return $self->user()->anggota->id_divisi === $anggota->id_divisi;
            });
            $authority->allow('create', 'Email', function ($self, $anggota){
                return $self->user()->anggota->id_divisi === $anggota->id_divisi;
            });

            $authority->allow('moderate', 'Anggota', function ($self, $anggota){
                return $self->user()->anggota->id_divisi === $anggota->id_divisi;
            });
            $authority->allow('moderate', 'Hp', function ($self, $hp){
                return $self->user()->anggota->id_divisi === $hp->pemilik->id_divisi;
            });
            $authority->allow('moderate', 'Email', function ($self, $email){
                return $self->user()->anggota->id_divisi === $email->pemilik->id_divisi;
            });

            $authority->allow('read', 'Acara');
            $authority->allow('read', 'WaktuAcara');
            $authority->allow('read', 'Panitia');
            $authority->allow('read', 'Peserta');
        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
        if($user->hasRole('bendaharadivisi'))
        {
            $authority->allow('read', 'Anggota');
            $authority->allow('read', 'Kas', function ($self, $divisi){
                return $self->user()->anggota->id_divisi === $divisi->id_divisi;
            });
            $authority->allow('read', 'Kas', function ($self, $kas){
                return $self->user()->anggota->id_divisi === $kas->pemilik->id_divisi;
            });
            $authority->allow('read', 'Hp');
            $authority->allow('read', 'Anggota');

            $authority->allow('create', 'Kas', function ($self, $divisi){
                return $self->user()->anggota->id_divisi === $divisi->id_divisi;
            });

            $authority->allow('moderate', 'Anggota', function ($self, $anggota){
                return $self->user()->anggota->id_divisi === $anggota->id_divisi;
            });
            $authority->allow('moderate', 'Kas', function ($self, $kas){
                return $self->user()->anggota->id_divisi === $kas->pemilik->id_divisi;
            });
            $authority->allow('moderate', 'Hp', function ($self, $hp){
                return $self->user()->anggota->id_anggota === $hp->pemilik->id_anggota;
            });
            $authority->allow('moderate', 'Email', function ($self, $email){
                return $self->user()->anggota->id_anggota === $email->pemilik->id_anggota;
            });

            $authority->allow('read', 'Acara');
            $authority->allow('read', 'WaktuAcara');
            $authority->allow('read', 'Panitia');
            $authority->allow('read', 'Peserta');
        }

        if($user->hasRole('anggota'))
        {
            $authority->allow('read', 'Anggota');
            $authority->allow('read', 'Kas', function ($self, $kas){
                return $self->user()->anggota->id_anggota === $kas->pemilik->id_anggota;
            });
            $authority->allow('read', 'Hp');
            $authority->allow('read', 'Anggota');

            $authority->allow('create', 'Hp', function ($self, $anggota){
                return $self->user()->anggota->id_anggota === $anggota->id_anggota;
            });
            $authority->allow('create', 'Email', function ($self, $anggota){
                return $self->user()->anggota->id_anggota === $anggota->id_anggota;
            });

            $authority->allow('moderate', 'Anggota', function ($self, $anggota){
                return $self->user()->anggota->id_anggota === $anggota->id_anggota;
            });
            $authority->allow('moderate', 'Hp', function ($self, $hp){
                return $self->user()->anggota->id_anggota === $hp->pemilik->id_anggota;
            });
            $authority->allow('moderate', 'Email', function ($self, $email){
                return $self->user()->anggota->id_anggota === $email->pemilik->id_anggota;
            });

            $authority->allow('read', 'Acara');
            $authority->allow('read', 'WaktuAcara');
            $authority->allow('read', 'Panitia');
            $authority->allow('read', 'Peserta');
        }

        /*--------- Acara ---------*/

        if($user->hasRole('intiacara'))
        {
            $authority->allow('manage', 'DivAcara', function ($self, $acara){
                foreach($self->user()->anggota->kepanitiaan as $panitia)
                {
                    return $panitia->kd_acara == $acara->kd_acara && $panitia->jabatan == 'inti';
                }
            });
            $authority->allow('manage', 'WaktuAcara', function ($self, $acara){
                foreach($self->user()->anggota->kepanitiaan as $panitia)
                {
                    return $panitia->kd_acara == $acara->kd_acara && $panitia->jabatan == 'inti';
                }
            });
            $authority->allow('manage', 'Panitia', function ($self, $acara){
                foreach($self->user()->anggota->kepanitiaan as $panitia)
                {
                    return $panitia->kd_acara == $acara->kd_acara && $panitia->jabatan == 'inti';
                }
            });
            $authority->allow('manage', 'Peserta', function ($self, $acara){
                foreach($self->user()->anggota->kepanitiaan as $panitia)
                {
                    return $panitia->kd_acara == $acara->kd_acara && $panitia->jabatan == 'inti';
                }
            });
        }

        if($user->hasRole('koordpanitia'))
        {
            $authority->allow('manage', 'WaktuAcara', function ($self, $acara){
                foreach($self->user()->anggota->kepanitiaan as $panitia)
                {
                    return $panitia->kd_acara == $acara->kd_acara && $panitia->jabatan == 'koor' && $panitia->divisi->nama_div == 'acara';
                }
            });
            $authority->allow('manage', 'Panitia', function ($self, $div){
                foreach($self->user()->anggota->kepanitiaan as $panitia)
                {
                    return $panitia->kd_acara == $p->kd_acara && $panitia->jabatan == 'koor' && $panitia->id_div == $div->id_div;
                }
            });
            $authority->allow('manage', 'Peserta', function ($self, $acara){
                foreach($self->user()->anggota->kepanitiaan as $panitia)
                {
                    return $panitia->kd_acara == $acara->kd_acara && $panitia->jabatan == 'koor' && $panitia->divisi->nama_div == 'adm';
                }
            });

        }

        if($user->hasRole('panitia'))
        {
            $authority->allow('manage', 'WaktuAcara', function ($self, $acara){
                foreach($self->user()->anggota->kepanitiaan as $panitia)
                {
                    return $panitia->kd_acara == $acara->kd_acara && $panitia->jabatan == 'angg' && $panitia->divisi->nama_div == 'acara';
                }
            });
            $authority->allow('manage', 'Peserta', function ($self, $acara){
                foreach($self->user()->anggota->kepanitiaan as $panitia)
                {
                    return $panitia->kd_acara == $acara->kd_acara && $panitia->jabatan == 'angg' && $panitia->divisi->nama_div == 'adm';
                }
            });
        }
    }

);

