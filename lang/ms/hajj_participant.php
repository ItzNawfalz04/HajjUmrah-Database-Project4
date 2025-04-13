<?php

return [
    'model_label' => 'Peserta Haji',
    'plural_model_label' => 'Jemaah Haji',
    'sections' => [
        'participant_picture' => 'Gambar Peserta',
        'participant_code' => 'Kod Peserta Haji',
        'participant_info' => 'Maklumat Peserta Haji',
        'address_info' => 'Alamat Peserta Haji',
        'participant_waris' => 'Waris Peserta Haji',
        'th_info' => 'Maklumat Tabung Haji & Passport',
        'representative_media_sizes' => 'Wakil, Tinjauan Media & Saiz Pakaian',
        'remarks_section_title' => 'Catatan Peserta',
        'family_details_section_title' => 'Butiran Ahli Keluarga Pergi Bersama',
        'payment_details_section_title' => 'Butiran Bayaran Peserta',
    ],
    'descriptions' => [
        'upload_picture' => 'Muat naik / Sunting gambar peserta (Jika Ada).',
        'unique_code' => 'Kod pengecam unik untuk peserta haji.',
        'participant_info' => 'Masukkan maklumat tentang peserta haji.',
        'address_info' => 'Masukkan alamat peserta haji.',
        'participant_waris' => 'Masukkan maklumat waris peserta haji.',
        'th_info' => 'Masukkan maklumat mengenai Tabung Haji & Passport.',
        'representative_media_sizes' => 'Masukkan maklumat tentang wakil, tinjauan media dan saiz pakaian peserta.',
        'remarks_section_description' => 'Masukkan maklumat tambahan peserta.',
        'family_details_section_description' => 'Masukkan butiran ahli keluarga yang turut serta.',
        'payment_details_section_description' => 'Masukkan butiran bayaran peserta.',
    ],
    'labels' => [

        // PICTURE AND SECTION 1
        'picture'=> 'Gambar Peserta',
        'file_no' => 'No. File',
        'registration_no' => 'No. Pendaftaran',
        'no' => 'Bil.',
        'group_code' => 'Kod Kumpulan',
        'status' => 'Status Rayuan',
        'registration_date' => 'Tarikh daftar',
        'registration_time' => 'Masa Daftar',
        'package' => 'Pakej',
        'package_code' => 'Kod Pakej',
        'room_type' => 'Jenis Bilik',
        'edit' => 'Edit',

        //SECTION 2
        'name' => 'Nama',
        'ic_no' => 'Nombor K/P',
        'passport_no' => 'Nombor Passport',
        'age' => 'Umur',
        'gender' => 'Jantina',
        'race' => 'Bangsa',
        'religion' => 'Agama',
        'marriage_status' => 'Status Perkahwinan',
        'job' => 'Pekerjaan',
        'job_sector' => 'Sektor Pekerjaan',
        'title' => 'Gelaran',
        'phone' => 'No. Telefon',
        'email' => 'E-mel',

        //SECTION 3
        'address_1' => 'Alamat 1',
        'address_2' => 'Alamat 2',
        'address_3' => 'Alamat 3',
        'postcode' => 'Poskod',
        'district' => 'Daerah',
        'state' => 'Negeri',

        //SECTION 4
        'nama_waris' => 'Nama Waris',
        'hubungan_waris' => 'Hubungan dengan Waris',
        'no_telefon_waris' => 'No. Telefon Waris',
        'e-mel_waris' => 'E-mel Waris',
        'alamat_waris' => 'Alamat Waris',

        //SECTION 5
        'hajj_registration_no' => 'No. Pendaftaran Haji',
        'th_account_no' => 'No. Akaun TH',
        'year_hajj_registration' => 'Tahun Daftar Haji',
        'month_hajj_registration' => 'Bulan Daftar Haji',

        //SECTION 6
        'representative' => 'Wakil',
        'media_survey' => 'Tinjauan Media',
        'shirt_size' => 'Saiz Baju',
        'kurta_size' => 'Saiz Kurta',
        'kopiah_size' => 'Saiz Kopiah',

        // New labels for Remarks section
        'remarks_1_label' => 'Catatan 1',
        'remarks_2_label' => 'Catatan 2 (Permintaan Lain - Lain)',
        'remarks_3_label' => 'Catatan 3 (Servis Tambahan)',

        // New labels for Family Members section
        'family_member_label' => 'Senarai Ahli Keluarga',
        'family_member_name_label' => 'Nama Ahli Keluarga',
        'family_member_phone_label' => 'No. Telefon Ahli Keluarga',
        'family_member_relationship_label' => 'Hubungan dengan Peserta',

        'package_price'              => 'Harga Pakej (RM)',
        'discount'                   => 'Diskaun (RM)',
        'price_after_discount'       => 'Harga Selepas Diskaun (RM)',
        'wang_naik_haji'             => 'Wang Naik Haji (RM)',
        'upgrade_khemah_khas'        => 'Upgrade Khemah Khas (RM)',
        'upgrade'                    => 'Upgrade Lain-Lain (RM)',
        'total'                      => 'Jumlah (RM)',
        'payment_made'               => 'Bayaran yang telah dibuat',
        'payment_amount'             => 'Bayaran (RM)',
        'receipt'                    => 'Resit',
        'total_payment'              => 'Jumlah Bayaran (RM)',
        'payment_left'               => 'Baki Bayaran (RM)',
        'payment_remarks'            => 'Catatan',
    ],
    'placeholders' => [
        // PICTURE AND SECTION 1
        'file_no' => 'Contoh: 1',
        'registration_no' => 'Contoh: FT 2024 - FT_001',
        'group_code' => 'Contoh: FELDX001',
        'package_code' => 'Contoh: FT001',
        'registration_date' => 'Contoh: 01/01/2001',

        //SECTION 2
        'name' => 'Contoh: Ahmad bin Ali',
        'ic_no' => 'Contoh: 901234567890',
        'passport_no' => 'Contoh: A12345678',
        'age' => 'Auto dikira berdasarkan K/P',
        'gender' => 'Pilih jantina',
        'race' => 'Pilih bangsa',
        'marriage_status' => 'Contoh: Berkahwin',
        'job' => 'Contoh: Guru',
        'job_sector' => 'Contoh: Pendidikan',
        'title' => 'Contoh: Tuan, Puan, Haji',
        'phone' => 'Contoh: 012-3456789',
        'email' => 'Contoh: email@example.com',

        //SECTION 3
        'address_1' => 'Contoh: No. 123, Jalan Merdeka',
        'address_2' => 'Contoh: Taman Melati',
        'address_3' => 'Contoh: Kampung Baru',
        'postcode' => 'Contoh: 50050',
        'district' => 'Contoh: Petaling Jaya',
        'state' => 'Contoh: Selangor',

        //SECTION 4
        'nama_waris' => 'Contoh: Siti Aminah',
        'hubungan_waris' => 'Contoh: Ibu, Bapa, Adik, Kakak',
        'no_telefon_waris' => 'Contoh: 017-6543210',
        'e-mel_waris' => 'Contoh: waris@example.com',
        'alamat_waris' => 'Contoh: No. 45, Jalan Setia, Taman Melawati, 53100 Kuala Lumpur',

        //SECTION 5
        'hajj_registration_no' => 'Masukkan nombor pendaftaran haji',
        'th_account_no' => 'Masukkan nombor akaun Tabung Haji',
        'year_hajj_registration' => 'Contoh: 2025',
        'month_hajj_registration' => 'Contoh: Januari',

        //SECTION 5
        'representative' => 'Masukkan nama wakil',
        'media_survey' => 'Contoh: TV3, Astro Awani',
        'shirt_size' => 'Contoh: M, L, XL',
        'kurta_size' => 'Contoh: M, L, XL',
        'kopiah_size' => 'Contoh: S, M, L',

        // New placeholders for Remarks section
        'remarks_1_placeholder' => 'Masukkan sebarang maklumat tambahan',
        'remarks_2_placeholder' => 'Masukkan permintaan lain jika ada',
        'remarks_3_placeholder' => 'Masukkan sebarang servis tambahan',

        // New placeholder for Family Members section
        'family_member_relationship_placeholder' => 'Contoh: Ibu, Bapa, Adik, Kakak',

        // ...existing placeholders...
        'package_price'         => 'Masukkan harga pakej',
        'discount'              => 'Masukkan diskaun jika ada',
        'price_after_discount'  => 'Auto dikira',
        'wang_naik_haji'        => 'Masukkan jumlah wang naik haji',
        'upgrade_khemah_khas'   => 'Masukkan kos upgrade khemah khas',
        'upgrade'               => 'Masukkan kos upgrade lain-lain',
        'total'                 => 'Auto dikira',
        'payment_amount'        => 'Masukkan jumlah bayaran',
        'receipt'               => 'Masukkan nombor resit',
        'total_payment'         => 'Auto dikira',
        'payment_left'          => 'Auto dikira',
        'payment_remarks'       => 'Masukkan sebarang catatan tambahan',
    ],
    'status_options' => [
        'appeal' => 'Rayuan',
        'special_appeal' => 'Rayuan Khas',
        'selected' => 'Terpilih',
        'late_selected' => 'Terpilih Lewat',
        'cancelled' => 'Batal',
    ],
    'room_options' => [
        'single' => 'SINGLE',
        'double' => 'DOUBLE',
        'triple' => 'TRIPLE',
        'quadruple' => 'QUADRUPLE',
        'quintuple' => 'QUINTUPLE',
    ],

    'gender_options' => [
        'male' => 'Lelaki',
        'female' => 'Perempuan',
    ],

    'race_options' => [
        'malay' => 'Melayu',
        'chinese' => 'Cina',
        'indian' => 'India',
        'other' => 'Lain-Lain',
    ],

    'marital_options' => [
        'married' => 'Berkahwin',
        'divorced' => 'Cerai',
        'spouse_death' => 'Kematian Pasangan',
        'single' => 'Bujang',
    ],

    'default_values' => [
        'religion' => 'Islam',
    ],

    'buttons' => [
        'tambah_waris' => 'Tambah Waris',
        'tambah_keluarga'=> 'Tambah Ahli Keluarga',
        'payment_made'=> 'Tambah Bayaran Yang Telah Dibuat',
        'create_button_label' => 'Cipta Peserta Haji',
    ],
    'table_labels' => [
        'file_no'                => 'No. File',
        'registration_no'        => 'No. Pendaftaran',
        'no'                     => 'Bil.',
        'group_code'             => 'Kod Kumpulan',
        'status'                 => 'Status',
        'registration_date'      => 'Tarikh Daftar',
        'registration_time'      => 'Masa Daftar',
        'package'                => 'Pakej',
        'package_code'           => 'Kod Pakej',
        'room_type'              => 'Jenis Bilik',
        'name'                   => 'Nama',
        'ic_no'                  => 'Nombor K/P',
        'passport_no'            => 'Nombor Passport',
        'age'                    => 'Umur',
        'gender'                 => 'Jantina',
        'race'                   => 'Bangsa',
        'religion'               => 'Agama',
        'marriage_status'        => 'Status Perkahwinan',
        'job'                    => 'Pekerjaan',
        'job_sector'             => 'Sektor Pekerjaan',
        'title'                  => 'Gelaran',
        'phone'                  => 'No. Telefon',
        'email'                  => 'Alamat E-mel',
        'address_1'              => 'Alamat 1',
        'address_2'              => 'Alamat 2',
        'address_3'              => 'Alamat 3',
        'postcode'               => 'Poskod',
        'district'               => 'Daerah',
        'state'                  => 'Negeri',
        'hajj_registration_no'   => 'Nombor Pendaftaran Haji',
        'th_account_no'          => 'Nombor Akaun Tabung Haji',
        'month_hajj_registration'=> 'Bulan Daftar Haji',
        'year_hajj_registration' => 'Tahun Daftar Haji',
        'representative'         => 'Wakil',
        'media_survey'           => 'Tinjauan Media',
        'shirt_size'             => 'Saiz Baju',
        'kurta_size'             => 'Saiz Kurta',
        'kopiah_size'            => 'Saiz Kopiah',
        'remarks_1'              => 'Catatan 1',
        'remarks_2'              => 'Catatan 2',
        'remarks_3'              => 'Catatan 3',
        'created_at'             => 'Dicipta Pada',
        'updated_at'             => 'Dikemas Kini Pada',
    ],
];
