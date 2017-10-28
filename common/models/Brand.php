<?php

namespace common\models;

use Yii;
use \yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%brand}}".
 *
 * @property integer $id
 * @property string $b_name
 * @property string $b_logo
 * @property string $b_desc
 * @property string $site_url
 * @property integer $sort
 * @property integer $is_show
 */
class Brand extends ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%brand}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_name', 'brand_logo', 'brand_desc', 'site_url', 'sort', 'is_show'], 'required'],
            [['brand_desc'], 'string'],
            [['sort', 'is_show'], 'integer'],
            [['brand_name'], 'string', 'max' => 6],
            [['brand_logo'], 'string', 'max' => 80],
            [['site_url'], 'string', 'max' => 255],
            [['brand_name'],'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'brand_id' => '',
            'brand_name' => '品牌名称',
            'brand_logo' => 'Logo图片',
            'brand_desc' => '简单描述',
            'site_url' => '品牌的网址',
            'sort' => '排序',//品牌在前台页面的显示顺序,数字越大越靠后
            'is_show' => '是否显示',//;0否1显示
        ];
    }
    public function loadDefaultValues($skipIfSet = true)
    {
        $this->is_show = 1;
        $this->brand_sort = 50;
        return $this;
    }
    //商品品牌查询
    public function dropDownList()
    {
        $result = [];
        $typeList = self::find()->select('brand_id,brand_name')->asArray()->all();

        foreach ($typeList as $value)
        {
            $result[$value['brand_id']] = $value['brand_name'];
        }

        return $result;
    }
}
