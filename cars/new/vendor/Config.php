<?php
    define('CURRENT_URL', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].explode('?', $_SERVER['REQUEST_URI'])[0]);

    return [
        'nestLevel' => 2,
        'baseUrl' => '/cars/new',
        'assetsUrl' => '/cars',
        'Api' => [
            'baseURL' => 'https://' . YApp::GO_API_DOMAIN . '/api/v1/cis',
            'token' => 'ef6541490c8bb9d481d37020b6a1953e',
            'mode' => 'new',
            'name' => 'Новые автомобили',
            'Params' => [
                // '!brand' => 'lada,xcite'
            ],
        ],
        'ItemsPerPage' => 30,
        'userExternalForms' => true,

        'Forms' => [
            'Reserv' => [
                'title' => 'Забронировать этот автомобиль?',
                'text' => 'Оставьте свои контакты, чтобы мы зарезервировали за вами автомобиль',
                'recipients' => [
                    'anton.boreckiy@yug-avto.ru'
                ]
            ],
            'Consult' => [
                'title' => 'Не знаете, какой автомобиль выбрать?',
                'text' => 'Воспользуйтесь формой и мы сможем ответить на все ваши вопросы',
                'recipients' => [
                    'anton.boreckiy@yug-avto.ru'
                ]
            ],
        ],

        'Filter' => [
            'BrandsList' => [
                'divtoh2' => [
                    'baic', 'chery', 'jaecoo', 'omoda', 'tank'
                ]
            ]
        ]
    ];
?>