<?php

return array(
    'enabled' => [
        'title' => 'Включить плагин',
        'options' => [

            [
                'value' => 0,
                'title' => 'Выключен',
                'description' => '',
            ],

            [
                'value' => 1,
                'title' => 'Включен',
                'description' => '',
            ],

        ],
        'control_type' => waHtmlControl::SELECT,
    ],

    'sendFrom' => [
        'title' => 'E-mail отправителя',
        'control_type' => waHtmlControl::INPUT,
    ],

    'noticeMail' => [
        'title' => 'E-mail для уведомления',
        'control_type' => waHtmlControl::INPUT,
    ],

    'policyLink' => [
        'title' => 'Ссылка на политику обрабоки данных',
        'control_type' => waHtmlControl::INPUT,
    ],
);
