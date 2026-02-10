<?php

namespace app\modules\admin\controllers;

use app\models\Product;
use app\modules\admin\components\Controller;
use app\modules\admin\models\ProductSearch;
use Yii;
use yii\web\UploadedFile;
use app\models\Category;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{

    public $tab = "product";

    public function behaviors()
    {
        return require __DIR__ . '/../filters/LoginCheck.php';
    }

    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function renderForm($model)
    {
        if ($model->load(Yii::$app->request->post())) {
            if (isset($model['image_ids']) && !empty($model['image_ids'])) {
                $model->image_ids = $model['image_ids'];
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Product details were saved successfully.');
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
        $model = new Product();
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
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The request page does not exist.');
        }
    }


    public function actionExportExcel()
    {
        $cells[] = ["Id", "Category", "Name", "Tamil Name", "Images",   "MRP", "Price", "Type", "Video URL", "Alignment", "Created at", "Status", "Updated at"];

        $Category = Product::find()->select(['id'])->all();
        if (count($Category) > 0) {
            foreach (Product::find()->each(10) as $m) {
                $createdAt = $m->created_at != "" ? date("M d, Y g:i:s A", $m->created_at) : "";
                $updatedAt = $m->updated_at != "" ? date("M d, Y g:i:s A", $m->updated_at) : "";

                $arr = [];
                $arr[] = $m->id;
                $arr[] = $m->category->name;
                $arr[] = $m->name;
                $arr[] = $m->tamil_name;
                $arr[] = $m->image_ids ? implode(', ', $m->image_ids) : '';
                $arr[] = $m->mrp;
                $arr[] = $m->price;
                $arr[] = $m->type;
                $arr[] = $m->video_url;
                $arr[] = $m->alignment;
                $arr[] = $createdAt;
                $arr[] = $m->deleted;
                $arr[] = $updatedAt;
                $cells[] = $arr;
            }
        }
        $fname = 'Product_' . date('d_m_Y_H_i_s');
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

            // Find category by name
            $category = Category::find()->where(['name' => trim($row[1])])->one();
            if (!$category) {
                $failed++;
                continue;
            }

            // Update or Create
            $model = !empty($row[0]) ? Product::findOne($row[0]) : new Product();

            if (!$model) {
                $model = new Product();
            }

            $model->category_id = $category->id;
            $model->name = trim((string)$row[2] ?? '');
            $model->tamil_name = trim((string)$row[3] ?? '');
            $model->image_ids = !empty($row[4]) ? explode(',', $row[4]) : [];
            $model->mrp = (float)$row[5];
            $model->price = (float)$row[6];
            $model->type = trim((string)$row[7] ?? '');
            $model->video_url = trim((string)$row[8] ?? '');
            $model->alignment = trim((string)$row[9] ?? '');
            $model->deleted = (int)$row[11];

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
