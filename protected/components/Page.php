<?php

namespace app\components;

use Yii;
use yii\helpers\Url;

class Page extends \yii\base\Component
{

    public function structure()
    {
        $arr = [];
        return $arr;
    }

    public function paths($path = false, $url = false)
    {
        $arr = $this->structure();

        if ($path !== false) {
            if (isset($arr[$path])) {
                if (is_array($arr[$path])) {
                    return $arr[$path]["model"];
                } else
                    return $arr[$path];
            }
            return "";
        }

        $list = [];
        foreach ($arr as $path => $label) {
            if (is_array($label)) {
                $group = $label['model'] . " List";
                $modelname = "\\app\\models\\" . $label['model'];
                $pages = $modelname::find()->active()->all();
                foreach ($pages as $p) {
                    $link = [];
                    $link[] = $path;
                    foreach ($label['params'] as $param)
                        $link[$param] = $p->$param;

                    if ($url === true)
                        $list[$group][Url::to($link)] = $p->$label['attribute'];
                    else
                        $list[$group][json_encode($link)] = $p->$label['attribute'];
                }
            } else {
                if ($url === true)
                    $list[Url::to([$path])] = $label;
                else
                    $list[$path] = $label;
            }
        }

        return $list;
    }

    public function url($path)
    {
        if (strpos($path, '{') !== false) {
            $decode = json_decode($path, true);
            $link = Url::to($decode);
        } else
            $link = Url::to([$path]);

        return $link;
    }
}
