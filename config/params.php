<?php

return [
    'adminEmail' => 'admin@example.com',
    'menu'=>[
        ['name'=>'Обратный звонок','url'=>'/admin/email'],
        ['name'=>'Категории','url'=>'/admin/cats'],
        ['name'=>'Атрибуты','url'=>'/admin/characteristics'],
        ['name'=>'Типы продуктов','url'=>'/admin/producttypes'],
        ['name'=>'Продукты','url'=>'/admin/products'],
        ['name'=>'Статьи','url'=>'/admin/articles'],
        ['name'=>'Статьи2','url'=>'/admin/articles2'],
        ['name'=>'Видеоролики','url'=>'/admin/videos'],
        ['name'=>'Статичные страницы','url'=>'/admin/statictext'],
    ],
    'characteristics'=>[
        '0'=>'Текстовое поле',
        '1'=>'Радио кнопка',
        '2'=>'Чекбокс',
        '3'=>'Выпадающий список',
    ]
];
