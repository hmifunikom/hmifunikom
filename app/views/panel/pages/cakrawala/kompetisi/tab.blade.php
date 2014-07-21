{{
    Navigation::tabs(
        Navigation::links(
            array(
                array('Anggota', action('panel.cakrawala.kompetisi.tim.anggota.index', array($lomba, $tim->id_tim))),
                array('Persyaratan', action('panel.cakrawala.kompetisi.tim.persyaratan.index', array($lomba, $tim->id_tim))),
                array('Karya', action('panel.cakrawala.kompetisi.tim.karya.index', array($lomba, $tim->id_tim))),
            )
        )
    )
}}