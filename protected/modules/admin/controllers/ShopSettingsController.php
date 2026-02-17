<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\components\Controller;
use app\models\ShopSettings;
use yii\web\NotFoundHttpException;

class ShopSettingsController extends Controller
{

    public $tab = "shop-settings";

    public function behaviors()
    {
        return require(__DIR__ . '/../filters/LoginCheck.php');
    }


    public function actionIndex()
    {
        $model = ShopSettings::find()->one();
        if (!$model) {
            $model = new ShopSettings();
        }
        return $this->renderForm($model);
    }


    protected function renderForm($model)
    {
        $model->saveType = 'created';
        if ($model->created_at != '')
            $model->saveType = 'updated';
        if ($model->load(Yii::$app->request->post())) {
            $postRequest = Yii::$app->request->post("ShopSettings");
            $image = isset($postRequest["logo_id"]) && $postRequest["logo_id"] != "" ? $postRequest["logo_id"] : false;
            if (!$image) {
                $model->logo_id = "";
            }
            $banner = isset($postRequest["banner_ids"]) && $postRequest["banner_ids"] != "" ? $postRequest["banner_ids"] : false;
            if (!$banner) {
                $model->banner_ids = "";
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Shop Settings content was saved successfully.');
                return $this->redirectCheck(['index']);
            } else {
                //Html::errorSummary($model);
                Yii::$app->session->setFlash('error', 'Please fix the errors.');
            }
        }
        return $this->render('_form', [
            'model' => $model
        ]);
    }

    public function actionEnable()
    {
        $value = Yii::$app->request->post('checked');
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->shop_shutdown = (int) $value;
        if ($value == 1) {
            $model->saveType = 'deleted';
        } else {
            $model->saveType = 'restored';
        }
        $model->save(false);
        $arr = [
            'status' => 200,
            'message' => 'Estimate Page Status were ' . $model->saveType . 'd successfully.'
        ];
        return json_encode($arr);
    }

    protected function findModel($id)
    {
        if (($model = ShopSettings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The request page does not exist.');
        }
    }
}
