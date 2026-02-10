<?php

namespace app\modules\admin\controllers;

use app\models\Media;
use app\modules\admin\components\Controller;
use app\modules\admin\models\MediaSearch;
use Yii;
use yii\web\NotFoundHttpException;

class MediaController extends Controller
{

    public $tab = "media";

    public function behaviors()
    {
        return require __DIR__ . '/../filters/LoginCheck.php';
    }

    public function actionIndex()
    {
        $searchModel = new MediaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function renderForm($model)
    {
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Media details were saved successfully.');
                return $this->redirectCheck(['index']);
            } else {
                Yii::$app->session->setFlash('error', "Please fix the errors.");
            }
        }

        return $this->render('_form', [
            'model' => $model
        ]);
    }

    public function actionCreate()
    {
        $model = new Media();
        $model->saveType = 'created';
        return $this->renderForm($model);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->saveType = 'updated';
        return $this->renderForm($model);
    }

    public function actionDelete($id, $value)
    {
        $model = $this->findModel($id);
        $model->deleted = (int) $value;
        if ($value == 1) {
            $model->saveType = 'deleted';
        } else {
            $model->saveType = 'restored';
        }
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Media::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The request page does not exist.');
        }
    }

    public function actionExportExcel()
    {
        $cells[] = ["Name", "Discount", "Alignment", "Created at"];

        $Category = Media::find()->select(['id'])->all();
        if (count($Category) > 0) {
            foreach (Media::find()->each(10) as $m) {
                $createdAt = $m->created_at != "" ? date("M d, Y g:i:s A", $m->created_at) : "";

                $arr = [];
                $arr[] = $m->name;
                $arr[] = $m->discount;
                $arr[] = $m->alignment;
                $arr[] = $createdAt;
                $cells[] = $arr;
            }
        }
        $fname = 'Media_' . date('d_m_Y_H_i_s');
        Yii::$app->function->createSpreadSheet($cells, $fname, false);
    }
}
