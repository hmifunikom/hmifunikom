{{
    Navigation::tabs(
        Navigation::links(
            array(
                array('Identitas', action('panel.cakrawala.kompetisi.tim.show', array($lomba, $tim->id_tim))),
                array('Anggota', action('panel.cakrawala.kompetisi.tim.anggota.index', array($lomba, $tim->id_tim))),
                array('Persyaratan', action('panel.cakrawala.kompetisi.tim.persyaratan.index', array($lomba, $tim->id_tim))),
                array('Karya', action('panel.cakrawala.kompetisi.tim.karya.index', array($lomba, $tim->id_tim))),
            )
        )
    )
}}