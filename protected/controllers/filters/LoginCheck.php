<?php

return [
    'access' => [
        'class' => yii\filters\AccessControl::className(),
        'user' => 'user',
        'except' => ['password'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
                'matchCallback' => function ($rule, $action) {
                    return true;
                }
            ]
        ],
    ]
];
