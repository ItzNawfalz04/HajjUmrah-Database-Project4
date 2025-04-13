<?php

return [
    'model_label' => 'Umrah Participant',
    'plural_model_label' => 'Umrah Pilgrims',
    'sections' => [
        'participant_picture' => 'Participant Picture',
        'participant_code' => 'Umrah Participant Code',
        'participant_info' => 'Umrah Participant Information',
        'address_info' => 'Umrah Participant Address',
        'participant_waris' => 'Participant’s Next of Kin',
        'th_info' => 'Tabung Haji & Passport Details',
        'representative_media_sizes' => 'Representative, Media Survey & Clothing Sizes',
        'remarks_section_title' => 'Participant Remarks',
        'family_details_section_title' => 'Accompanying Family Member Details',
        'payment_details_section_title' => 'Payment Details',
    ],
    'descriptions' => [
        // PICTURE AND SECTION 1
        'upload_picture' => 'Upload / Edit participant picture (if available).',
        'unique_code' => 'Unique identifier code for Umrah participants.',
        
        //SECTION 2
        'participant_info' => 'Enter details about the Umrah participant.',

        //SECTION 3
        'address_info' => 'Enter the address details of the Umrah participant.',

        //SECTION 4
        'participant_waris' => 'Enter details of the participant’s next of kin.',
        'th_info' => 'Enter details about the Tabung Haji & Passport.',
        'representative_media_sizes' => 'Enter details about the representative, media survey, and clothing sizes.',

        //SECTION 5
        'remarks_section_description' => 'Enter any additional information for the participant.',
        'family_details_section_description' => 'Enter details of the accompanying family members.',

        'payment_details_section_description' => 'Enter payment details for the participant.',
    ],
    'labels' => [
        // PICTURE AND SECTION 1
        'picture'=> 'Participant Picture',
        'file_no' => 'File No.',
        'registration_no' => 'Registration No.',
        'no' => 'No.',
        'group_code' => 'Group Code',
        'status' => 'Appeal Status',
        'registration_date' => 'Registration Date',
        'registration_time' => 'Registration Time',
        'package' => 'Package',
        'package_code' => 'Package Code',
        'room_type' => 'Room Type',
        'edit' => 'Edit',

        //SECTION 2
        'name' => 'Name',
        'ic_no' => 'IC Number',
        'passport_no' => 'Passport Number',
        'age' => 'Age',
        'gender' => 'Gender',
        'race' => 'Race',
        'religion' => 'Religion',
        'marriage_status' => 'Marital Status',
        'job' => 'Job',
        'job_sector' => 'Job Sector',
        'title' => 'Title',
        'phone' => 'Phone Number',
        'email' => 'Email',

        //SECTION 3
        'address_1' => 'Address Line 1',
        'address_2' => 'Address Line 2',
        'address_3' => 'Address Line 3',
        'postcode' => 'Postcode',
        'district' => 'District',
        'state' => 'State',

        // Waris Section
        'nama_waris' => 'Next of Kin Name',
        'hubungan_waris' => 'Relationship with Next of Kin',
        'no_telefon_waris' => 'Next of Kin Phone Number',
        'e-mel_waris' => 'Next of Kin Email',
        'alamat_waris' => 'Next of Kin Address',

        // Tabung Haji Section
        'hajj_registration_no' => 'Hajj Registration No.',
        'th_account_no' => 'TH Account No.',
        'year_hajj_registration' => 'Year of Hajj Registration',
        'month_hajj_registration' => 'Month of Hajj Registration',

        // Representative & Media
        'representative' => 'Representative',
        'media_survey' => 'Media Survey',
        'shirt_size' => 'Shirt Size',
        'kurta_size' => 'Kurta Size',
        'kopiah_size' => 'Kopiah Size',

        // New labels for Remarks section
        'remarks_1_label' => 'Remarks 1',
        'remarks_2_label' => 'Remarks 2 (Other Requests)',
        'remarks_3_label' => 'Remarks 3 (Additional Services)',

        // New labels for Family Members section
        'family_member_label' => 'Family Members List',
        'family_member_name_label' => 'Family Member Name',
        'family_member_phone_label' => 'Family Member Phone Number',
        'family_member_relationship_label' => 'Relationship with Participant',

        'package_price' => 'Package Price (RM)',
        'discount' => 'Discount (RM)',
        'price_after_discount' => 'Price After Discount (RM)',
        //'wang_naik_haji' => 'Hajj Uplift (RM)',
        //'upgrade_khemah_khas' => 'Khemah Khas Upgrade (RM)',
        'upgrade' => 'Other Upgrades (RM)',
        'total' => 'Total (RM)',
        'payment_made' => 'Payments Made',
        'payment_amount' => 'Payment Amount (RM)',
        'receipt' => 'Receipt',
        'total_payment' => 'Total Payment (RM)',
        'payment_left' => 'Payment Left (RM)',
        'payment_remarks' => 'Remarks',
    ],
    'placeholders' => [
        // PICTURE AND SECTION 1
        'file_no' => 'Example: 1',
        'registration_no' => 'Example: FT 2024 - FT_001',
        'group_code' => 'Example: FELDX001',
        'package_code' => 'Example: FT001',
        'registration_date' => 'Example: 01/01/2001',
        
        //SECTION 2
        'name' => 'Example: Ahmad bin Ali',
        'ic_no' => 'Example: 901234567890',
        'passport_no' => 'Example: A12345678',
        'age' => 'Auto-calculated based on IC',
        'gender' => 'Select gender',
        'race' => 'Select race',
        'marriage_status' => 'Example: Married',
        'job' => 'Example: Teacher',
        'job_sector' => 'Example: Education',
        'title' => 'Example: Mr., Mrs., Haji',
        'phone' => 'Example: 012-3456789',
        'email' => 'Example: email@example.com',

        //SECTION 3
        'address_1' => 'Example: No. 123, Jalan Merdeka',
        'address_2' => 'Example: Taman Melati',
        'address_3' => 'Example: Kampung Baru',
        'postcode' => 'Example: 50050',
        'district' => 'Example: Petaling Jaya',
        'state' => 'Example: Selangor',

        // SECTION 4
        'nama_waris' => 'Example: Siti Aminah',
        'hubungan_waris' => 'Example: Mother, Father, Sister, Brother',
        'no_telefon_waris' => 'Example: 017-6543210',
        'e-mel_waris' => 'Example: waris@example.com',
        'alamat_waris' => 'Example: No. 45, Jalan Setia, Taman Melawati, 53100 Kuala Lumpur',
        
        // SECTION 5
        'hajj_registration_no' => 'Enter Hajj Registration Number',
        'th_account_no' => 'Enter Tabung Haji Account Number',
        'year_hajj_registration' => 'Example: 2025',
        'month_hajj_registration' => 'Example: January',

        //SECTION 6
        'representative' => 'Enter Representative Name',
        'media_survey' => 'Example: TV3, Astro Awani',
        'shirt_size' => 'Example: M, L, XL',
        'kurta_size' => 'Example: M, L, XL',
        'kopiah_size' => 'Example: S, M, L',

        // New placeholders for Remarks section
        'remarks_1_placeholder' => 'Enter any additional information',
        'remarks_2_placeholder' => 'Enter any other requests if available',
        'remarks_3_placeholder' => 'Enter any additional services',

        // New placeholder for Family Members section
        'family_member_relationship_placeholder' => 'Example: Mother, Father, Sister, Brother',

        'package_price' => 'Enter package price',
        'discount' => 'Enter discount if any',
        'price_after_discount' => 'Calculated automatically',
        //'wang_naik_haji' => 'Enter hajj uplift amount',
        //'upgrade_khemah_khas' => 'Enter cost for khemah khas upgrade',
        'upgrade' => 'Enter cost for other upgrades',
        'total' => 'Calculated automatically',
        'payment_amount' => 'Enter payment amount',
        'receipt' => 'Enter receipt number',
        'total_payment' => 'Calculated automatically',
        'payment_left' => 'Calculated automatically',
        'payment_remarks' => 'Enter any additional remarks',
    ],
    'status_options' => [
        'appeal' => 'Appeal',
        'special_appeal' => 'Special Appeal',
        'selected' => 'Selected',
        'late_selected' => 'Late Selected',
        'cancelled' => 'Cancelled',
    ],

    'gender_options' => [
        'male' => 'Male',
        'female' => 'Female',
    ],

    'room_options' => [
        'single' => 'SINGLE',
        'double' => 'DOUBLE',
        'triple' => 'TRIPLE',
        'quadruple' => 'QUADRUPLE',
        'quintuple' => 'QUINTUPLE',
    ],

    'race_options' => [
        'malay' => 'Malay',
        'chinese' => 'Chinese',
        'indian' => 'Indian',
        'other' => 'Other',
    ],

    'marital_options' => [
        'married' => 'Married',
        'divorced' => 'Divorced',
        'spouse_death' => 'Spouse Death',
        'single' => 'Single',
    ],

    'default_values' => [
        'religion' => 'Islam',
    ],

    'buttons' => [
        'tambah_waris' => 'Add Next of Kin',
        'tambah_keluarga'=> 'Add Family Member',
        'payment_made'=> 'Add Payment Made',
        'create_button_label' => 'Create Umrah Participant',
    ],
    'table_labels' => [
        'file_no'                => 'File No.',
        'registration_no'        => 'Registration No.',
        'no'                     => 'No.',
        'group_code'             => 'Group Code',
        'status'                 => 'Status',
        'registration_date'      => 'Registration Data',
        'registration_time'      => 'Registration Time',
        'package'                => 'Package',
        'package_code'           => 'Package Code',
        'room_type'              => 'Room Type',
        'name'                   => 'Name',
        'ic_no'                  => 'IC Number',
        'passport_no'            => 'Passport Number',
        'age'                    => 'Age',
        'gender'                 => 'Gender',
        'race'                   => 'Race',
        'religion'               => 'Religion',
        'marriage_status'        => 'Marital Status',
        'job'                    => 'Job',
        'job_sector'             => 'Job Sector',
        'title'                  => 'Title',
        'phone'                  => 'Phone Number',
        'email'                  => 'Email Address',
        'address_1'              => 'Address 1',
        'address_2'              => 'Address 2',
        'address_3'              => 'Address 3',
        'postcode'               => 'Postcode',
        'district'               => 'District',
        'state'                  => 'State',
        'hajj_registration_no'   => 'Hajj Registration No.',
        'th_account_no'          => 'TH Account No.',
        'month_hajj_registration'=> 'Month of Hajj Registration',
        'year_hajj_registration' => 'Year of Hajj Registration',
        'representative'         => 'Representative',
        'media_survey'           => 'Media Survey',
        'shirt_size'             => 'Shirt Size',
        'kurta_size'             => 'Kurta Size',
        'kopiah_size'            => 'Kopiah Size',
        'remarks_1'              => 'Remarks 1',
        'remarks_2'              => 'Remarks 2',
        'remarks_3'              => 'Remarks 3',
        'created_at'             => 'Created At',
        'updated_at'             => 'Updated At',
    ],
];
