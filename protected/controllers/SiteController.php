<?php

namespace app\controllers;

use app\components\Controller;


class SiteController extends Controller
{

    public function actionIndex()
    {

        return $this->render('index', [
            'page' => 'Home',
        ]);
    }
}
