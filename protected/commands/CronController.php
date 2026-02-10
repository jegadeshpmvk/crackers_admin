<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Order;
use app\models\ShopSettings;
use mikehaertl\wkhtmlto\Pdf;

class CronController extends Controller
{

    public function actionPdf($id)
    {
        echo "Pdf generation process started ::" . date('d/m/Y H:i:s A') . "\n";
        echo "\n";

        $order = Order::find()->where(['order_id' => $id])->one();
        $settings = ShopSettings::find()->active()->one();

        // $html = $this->renderFile('@app/views/page/order-confirm-pdf', [
        //     'order' => $order,
        //     'settings' => $settings
        // ]);
        $viewFile = Yii::getAlias('@app/views/page/order-confirm-pdf.php');
        $html = Yii::$app->view->renderFile(
            $viewFile,
            [
                'order' => $order,
                'settings' => $settings
            ]
        );

        $headerHtmlPath = Yii::getAlias('@mediaroot') . "/icons/pdf/header.html";

        $file = Yii::getAlias('@webroot') . "/media/files/order/order_$order->order_id.pdf";

        $pdf = new Pdf([
            'margin-top'    => 30,
            'margin-bottom' => 20,
            'margin-left'   => 10,
            'margin-right'  => 10,
            'binary' => 'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe',
            //'orientation'   => Pdf::ORIENTATION_LANDSCAPE,
            'page-size'     => 'A4',
            'header-html'   => $headerHtmlPath,
            'commandOptions' => [
                'useExec' => true,
            ],
        ]);

        $pdf->addPage($html);

        if (!$pdf->saveAs($file)) {
            echo "PDF Generation Error: " . $pdf->getError();
            exit;
        }
    }
}
