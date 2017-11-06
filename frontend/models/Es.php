<?php
namespace app\models;

use yii\elasticsearch\ActiveRecord;

class Es extends ActiveRecord
{

    public function attributes()
    {
        return ['id', 'name', 'sex', 'age', 'create_time'];
    }
}
?>