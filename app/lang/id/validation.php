<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    "accepted"         => ":attribute harus diterima.",
    "active_url"       => ":attribute bukan URL yang sah.",
    "after"            => ":attribute harus tanggal setelah :date.",
    "alpha"            => ":attribute hanya boleh berisi huruf.",
    "alpha_dash"       => ":attribute hanya boleh berisi huruf, angka, dan strip.",
    "alpha_num"        => ":attribute hanya boleh berisi huruf dan angka.",
    "array"            => ":attribute harus berupa sebuah array.",
    "before"           => ":attribute harus tanggal sebelum :date.",
    "between"          => array(
        "numeric" => ":attribute harus antara :min dan :max.",
        "file"    => ":attribute harus antara :min dan :max kilobytes.",
        "string"  => ":attribute harus antara :min dan :max karakter.",
        "array"   => ":attribute harus antara :min dan :max item.",
    ),
    "confirmed"        => "Konfirmasi :attribute tidak cocok.",
    "date"             => ":attribute bukan tanggal yang sah.",
    "date_format"      => ":attribute tidak cocok dengan format :format.",
    "different"        => ":attribute dan :other harus berbeda.",
    "digits"           => ":attribute harus berupa angka :digits.",
    "digits_between"   => ":attribute harus antara angka :min dan :max.",
    "email"            => "Format isian :attribute tidak sah.",
    "exists"           => ":attribute yang dipilih tidak sah.",
    "image"            => ":attribute harus berupa gambar.",
    "in"               => ":attribute yang dipilih tidak sah.",
    "integer"          => ":attribute harus merupakan bilangan bulat.",
    "ip"               => ":attribute harus berupa alamat IP yang sah.",
    "max"              => array(
        "numeric" => ":attribute seharusnya tidak lebih dari :max.",
        "file"    => ":attribute seharusnya tidak lebih dari :max kilobytes.",
        "string"  => ":attribute seharusnya tidak lebih dari :max karakter.",
        "array"   => ":attribute seharusnya tidak lebih dari :max item.",
    ),
    "mimes"            => ":attribute harus dokumen berjenis : :values.",
    "min"              => array(
        "numeric" => ":attribute harus minimal :min.",
        "file"    => ":attribute harus minimal :min kilobytes.",
        "string"  => ":attribute harus minimal :min karakter.",
        "array"   => ":attribute harus minimal :min item.",
    ),
    "not_in"           => ":attribute yang dipilih tidak sah.",
    "numeric"          => ":attribute harus berupa angka.",
    "regex"            => "The :attribute format is invalid.",
    "required"         => ":attribute wajib diisi.",
    "required_if"      => ":attribute wajib diisi ketika :other adalah :value.",
    "required_with"    => ":attribute wajib diisi ketika terdapat :values.",
    "required_without" => ":attribute wajib diisi ketika tidak terdapat :values.",
    "required_without_all" => "The :attribute field is required when none of :values are present.",
    "same"             => ":attribute dan :other harus sama.",
    "size"             => array(
        "numeric" => ":attribute harus berukuran :size.",
        "file"    => ":attribute harus berukuran :size kilobyte.",
        "string"  => ":attribute harus berukuran :size karakter.",
        "array"   => ":attribute harus mengandung :size item.",
    ),
    "unique"           => ":attribute sudah ada sebelumnya.",
    "url"              => "Format isian :attribute tidak sah.",
    "nim"              => "Format NIM tidak valid.",
    "nim_if"              => "Format NIM tidak valid.",
    "unique_if"           => ":attribute sudah ada sebelumnya.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => array(),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => array(
        'nama_acara'      => 'Nama Acara',
        'tgl'             => 'Tanggal Acara',
        'tempat'          => 'Tempat',
        'info'            => 'Deskripsi Acara',
        'pj'              => 'Program Kerja',
        'tgl_selesai_LPJ' => 'Tanggal Selesai LPJ',
        'tema'            => 'Tema Acara',
        
        'waktu'           => 'Waktu Acara',
        
        'nama_div'        => 'Nama Divisi Acara',
        
        'nama_peserta'    => 'Nama Peserta',
        'alamat'          => 'Alamat',
        'kategori'        => 'Kategori Peserta',
        'tgl_daftar'      => 'Tanggal Daftar',
        'nim'             => 'NIM',
        'no_hp'           => 'No. Handphone',
        'email'           => 'E-mail'
    ),

);