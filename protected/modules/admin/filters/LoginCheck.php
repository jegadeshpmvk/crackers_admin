<?php

return [
    'access' => [
        'class' => yii\filters\AccessControl::className(),
        'user' => 'admin',
        'except' => ['password'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
                'matchCallback' => function ($rule, $action) {
                //   print_r(Yii::$app->admin->identity->type);exit;
                    if (Yii::$app->admin->identity->type == "admin")
                        return true;
                    return false;
                }
            ]
        ],
    ]
];
