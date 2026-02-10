<?php

namespace app\models;

use yii\db\ActiveQuery;

class Scope extends ActiveQuery {

    public function active() {
        return $this->andWhere(['deleted' => 0]);
    }

}
