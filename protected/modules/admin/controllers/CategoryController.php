<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\modules\admin\components\Controller;
use app\modules\admin\models\CategorySearch;
use Yii;
use yii\web\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{

    public $tab = "category";

    public function behaviors()
    {
        return require __DIR__ . '/../filters/LoginCheck.php';
    }

    public function actionIndex()
    {
        $searchModel = new CategorySearch();
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
                Yii::$app->session->setFlash('success', 'Category details were saved successfully.');
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
        $model = new Category();
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
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The request page does not exist.');
        }
    }

    public function actionExportExcel()
    {
        $cells[] = ["Id", "Name", "Discount", "Alignment", "Created at"];

        $Category = Category::find()->select(['id'])->all();
        if (count($Category) > 0) {
            foreach (Category::find()->each(10) as $m) {
                $createdAt = $m->created_at != "" ? date("M d, Y g:i:s A", $m->created_at) : "";

                $arr = [];
                $arr[] = $m->id;
                $arr[] = $m->name;
                $arr[] = $m->discount;
                $arr[] = $m->alignment;
                $arr[] = $createdAt;
                $cells[] = $arr;
            }
        }
        $fname = 'Category_' . date('d_m_Y_H_i_s');
        Yii::$app->function->createSpreadSheet($cells, $fname, false);
    }


    public function actionImportExcel()
    {
        $file = UploadedFile::getInstanceByName('excel_file');

        if (!$file) {
            return $this->asJson(['status' => false, 'message' => 'No file uploaded']);
        }

        $spreadsheet = IOFactory::load($file->tempName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        // Remove header row
        unset($sheetData[0]);

        $success = 0;
        $failed = 0;

        foreach ($sheetData as $row) {

            if (empty($row[2])) { // Name column
                $failed++;
                continue;
            }

            // Update or Create
            $model = !empty($row[0]) ? Category::findOne($row[0]) : new Category();


            $model->name = trim((string)$row[1] ?? '');
            $model->discount = trim((string)$row[2] ?? '');

            if ($model->isNewRecord) {
                $model->created_at = time();
            }

            $model->updated_at = time();

            if ($model->save(false)) {
                $success++;
            } else {
                $failed++;
            }
        }

        return $this->asJson([
            'status' => true,
            'success' => $success,
            'failed' => $failed
        ]);
    }
}
