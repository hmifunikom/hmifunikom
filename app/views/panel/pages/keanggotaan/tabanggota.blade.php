{{
    Navigation::tabs(
        Navigation::links(
            array(
                array('Identitas', action('panel.keanggotaan.show', $anggota->id_anggota)),
                array('No. Handphone', action('panel.keanggotaan.hp.index', $anggota->id_anggota)),
                array('E-mail', action('panel.keanggotaan.email.index', $anggota->id_anggota)),
                array('Kas', action('panel.keanggotaan.kas.index', $anggota->id_anggota)),
            )
        )
    )
}}