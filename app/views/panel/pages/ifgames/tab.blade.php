{{
    Navigation::tabs(
        Navigation::links(
            array(
                array('Tim', action('panel.ifgames.tim.index', $cabang->id_cabang)),
                array('Jabatan', action('panel.ifgames.jabatan.index', $cabang->id_cabang)),
            )
        )
    )
}}