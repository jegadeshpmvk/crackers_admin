<?php

namespace app\components;

use Yii;
use yii\helpers\Url;
use app\models\CustomPage;
use app\models\OfferCategory;
use app\models\Offer;

class UtilityFunctions extends \yii\base\Component
{
    /*     * * 
      DISPLAY STATE AS HTML
     * * */

    public function notification($data, $param = "message", $class = "class")
    {
        if (isset($data[$param]) && $data[$param] != "")
            return '<div class="message message-' . $data[$class] . '"><p>' . $data[$param] . '</p></div>';

        return "";
    }

    public function state($value = false)
    {
        $list = [
            0 => 'Draft',
            1 => 'Published'
        ];

        $cls = [
            0 => 'fa-pencil-square',
            1 => 'fa-check-circle',
        ];

        if ($value === false)
            return [$list, $cls];

        $html = '<div class="state-color c' . $value . '">';
        $html .= '<span>' . $list[$value] . '</span>';
        $html .= '</div>';

        return $html;
    }

    /*     * * 
      CHECK IF ALL ATTRIBUTES OF A MODEL ARE EMPTY
     * * */

    public function isEmpty($model)
    {
        $empty = true;
        foreach ($model->attributes() as $attr) {
            if (in_array($attr, ["_id", "state", "deleted", "type"]))
                continue;

            if (trim($model->{$attr}) != "") {
                $empty = false;
                break;
            }
        }

        return $empty;
    }

    public function checkEmailLinks($email)
    {
        return preg_replace('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/', 'mailto:$1', $email);
    }

    /*     * * 
      LIMIT TEXT
     * * */

    public function limit_text($text, $limit = 30)
    {
        $text = strip_tags($text);
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    public function getAllPageForSelect()
    {
        $mainArr = [
            [
                "id" => "",
                "text" => ""
            ]
        ];
        $homeUrl = Url::home(true);
        $homeUrl = substr($homeUrl, 0, strlen($homeUrl) - 1);

        /* Custom Pages */
        $CustomPage = CustomPage::find()->select(['id', 'name', 'url'])->active()->all();
        if (count($CustomPage) > 0) {
            foreach ($CustomPage as $c) {
                $customPageModel = new CustomPage();

                $pArr = [];
                $js = [
                    "id" => $c->id,
                    "controller" => "/site/custom-page",
                    "model" => "CustomPage"
                ];
                $pArr['id'] = json_encode($js);
                $pArr['text'] = $c->name . "<!_>" . $homeUrl . "" . $customPageModel->getEntireUrl($c->id);

                array_push($mainArr, $pArr);
            }
        }
        /* Custom Pages */

        $mainArr = json_encode($mainArr);
        return $mainArr;
    }

    public function constructLink($json)
    {

        $decode = json_decode($json, true);

        if (@$decode['model']) {
            $arr = [];
            $arr[0] = $decode['controller'];
            $arr['url'] = $this->getModelLink($decode);

            if ($arr['url'] != false) {
                return @$arr['url'];
            }
        } else {
            if ($json != "") {
                return $this->checkEmailLinks($json);
            }
        }
        return "#";
    }

    public function getModelLink($arr)
    {
        $modelName = '\app\\models\\' . @$arr['model'];

        if (@$arr['model'] == "CustomPage") {
            $model = new $modelName;

            return $model->getEntireUrl($arr['id']);
        }
        $model = $modelName::find()->andWhere(['id' => $arr['id']])->one();
        if ($model) {
            return $model->url;
        }
        return false;
    }

    public function flexibleContentTypes()
    {
        $flexibleTypes = [
            "banner" => [
                "title" => "Banner",
                "image" => Yii::getAlias('@icons') . "/widgets/banner.png",
                "type" => ["content_widgets"],
            ],
            "three-box" => [
                "title" => "Three Box",
                "image" => Yii::getAlias('@icons') . "/widgets/three-box.png",
                "type" => ["content_widgets"],
            ],
            "features" => [
                "title" => "Features",
                "image" => Yii::getAlias('@icons') . "/widgets/features.png",
                "type" => ["content_widgets"],
            ],
            "how-works" => [
                "title" => "How Works",
                "image" => Yii::getAlias('@icons') . "/widgets/how-works.png",
                "type" => ["content_widgets"],
            ],
            "faqs" => [
                "title" => "FAQ",
                "image" => Yii::getAlias('@icons') . "/widgets/faq.png",
                "type" => ["content_widgets"],
            ],
            "testimonials" => [
                "title" => "Testimonials",
                "image" => Yii::getAlias('@icons') . "/widgets/testimonials.png",
                "type" => ["content_widgets"],
            ],
            "tabs" => [
                "title" => "Tabs",
                "image" => Yii::getAlias('@icons') . "/widgets/tabs.png",
                "type" => ["content_widgets"],
            ],
            "login" => [
                "title" => "Login",
                "image" => Yii::getAlias('@icons') . "/widgets/login.png",
                "type" => ["content_widgets"],
            ],
        ];
        return $flexibleTypes;
    }

    public function seourl($string)
    {
        $string = strtolower(trim($string)); //Lower case everything
        $string = preg_replace("/\&/", "-and-", $string); //Change & to and
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string); //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[\s-]+/", " ", $string); //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s_]/", "-", $string); //Convert whitespaces and underscore to dash
        return $string;
    }

    public function count_digit($number)
    {
        return strlen($number);
    }

    public function divider($number_of_digits)
    {
        $tens = "1";

        if ($number_of_digits > 8)
            return 10000000;

        while (($number_of_digits - 1) > 0) {
            $tens .= "0";
            $number_of_digits--;
        }
        return $tens;
    }

    public function checkNumbervalues($num)
    {
        $ext = ""; //thousand,lac, crore
        $number_of_digits =  $this->count_digit($num); //this is call :)
        if ($number_of_digits > 3) {
            if ($number_of_digits % 2 != 0) {
                $divider =  $this->divider($number_of_digits - 1);
            } else {
                $divider =  $this->divider($number_of_digits);
            }
        } else
            $divider = 1;

        $fraction = $num / $divider;
        $fraction = number_format($fraction, 2);
        if ($number_of_digits == 4 || $number_of_digits == 5)
            $ext = "k";
        if ($number_of_digits == 6 || $number_of_digits == 7)
            $ext = "L";
        if ($number_of_digits == 8 || $number_of_digits == 9 || $number_of_digits > 9)
            $ext = "Cr";
        echo $fraction . " " . $ext;
    }

    public function getAmount($money)
    {
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

        return (float) str_replace(',', '.', $removedThousandSeparator);
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $specials = '!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomString = '';
        // Removed one from length to maintain desired length
        // for special character addition
        for ($i = 0; $i < $length - 1; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        // Add the special character:
        $randomString .= $specials[rand(0, strlen($specials) - 1)];
        // Shuffle the returned string so the special is not always at the end
        return str_shuffle($randomString);
    }

    public function createSpreadSheet($cells, $path, $save = true, $headerCellStyles = array())
    {
        if (empty($headerCellStyles)) {
            $headerCellStyles = array(
                'font' => [
                    'bold' => true,
                ]
            );
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $az = [];
        foreach (range('A', 'Z') as $char) {
            $az[] = $char;
        }

        if (count($cells) > 0) {
            foreach ($cells as $key => $list) {
                foreach ($list as $k => $v) {
                    $cellName = $this->getCellName($az, $k);
                    $cell = $cellName . ($key + 1);
                    $sheet->setCellValue($cell, $v);
                    if ($key == 0) {
                        $sheet->getStyle($cell)->applyFromArray($headerCellStyles);
                    }
                }
            }
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        if ($save) {
            $writer->save($path);
            return $path;
        } else {
            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $path . '.xlsx"'); /* -- $filename is  xsl filename --- */
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        }
    }

    public function getCellName($range, $num)
    {
        if ($num < 26)
            return $range[$num];

        $res = $num % 26;
        $div = floor($num / 26);
        $alp = "";

        return $range[$div - 1] . $range[$res];
    }
}
