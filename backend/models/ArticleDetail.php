<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article_detail".
 *
 * @property int $article_id 对应文章表的id
 * @property string $content 文章内容
 * @property int $count 访问次数
 */
class ArticleDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'content'], 'required'],
            [['article_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => '文章编号',
            'content' => '文章内容',
            'count' => '访问次数',
        ];
    }
}
