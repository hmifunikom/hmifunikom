{{
    Navigation::tabs(
        Navigation::links(
            array(
                array('Deskripsi', action('panel.event.show', $acara->kd_acara)),
                array('Waktu Acara', action('panel.event.waktu.index', $acara->kd_acara)),
                array('Divisi Acara', action('panel.event.div.index', $acara->kd_acara)),
                array('Panitia', action('panel.event.panitia.index', $acara->kd_acara)),
                array('Peserta', action('panel.event.peserta.index', $acara->kd_acara)),
            )
        )
    )
}}