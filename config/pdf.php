<?php

return [
	'mode'                  => 'utf-8',
//	'format'                => 'Letter',
	'format'                => [215, 330],
//	'format'                => 'Legal',
//    'marginTop'          => 500,
//    'marginBottom'       => 10,
//    'marginHeader'       => 0,
//    'marginFooter'       => 0,
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('./public/temp/'),
    'font_path' => base_path('resources/fonts/'),
    'font_data' => [
        'Times New Roman' => [
            'R'  => 'Times New Roman/times new roman.ttf',    // regular font
            'B'  => 'Times New Roman/times new roman bold.ttf',       // optional: bold font
            'I'  => 'Times New Roman/times new roman italic.ttf',     // optional: italic font
            'BI' => 'Times New Roman/times new roman bold italic.ttf' // optional: bold-italic font
            //'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            //'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
        ],
        'Sansita Swashed' => [
            'R'  => 'sansitaSwashed/SansitaSwashed-Regular.ttf',    // regular font
            'B'  => 'sansitaSwashed/SansitaSwashed-Bold.ttf',       // optional: bold font
            'I'  => 'sansitaSwashed/SansitaSwashed-Light.ttf',     // optional: italic font
            'BI' => 'sansitaSwashed/SansitaSwashed-SemiBold.ttf' // optional: bold-italic font
            //'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            //'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
        ]
        // ...add as many as you want.
    ]
];
