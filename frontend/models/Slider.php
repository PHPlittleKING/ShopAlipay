<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%slider}}".
 *
 * @property integer $sid
 * @property string $img_path
 * @property string $excerpt
 * @property string $jump_url
 * @property string $big_text
 * @property string $sort
 * @property string $is_show
 */
class Slider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slider}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_path', 'excerpt', 'jump_url', 'big_text', 'sort', 'is_show'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sid' => 'Sid',
            'img_path' => '图片地址',
            'excerpt' => '摘录',
            'jump_url' => '跳转地址',
            'big_text' => '主要描述',
            'sort' => '排序',
            'is_show' => '1展示；0不展示',
        ];
    }
    /**
     * 查询轮播图
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    static function getSlider()
    {
        return self::find()
            ->where(['is_show'=>1])
            ->asArray()
            ->orderBy(['sort'=>SORT_DESC])
            ->all();
    }


}
