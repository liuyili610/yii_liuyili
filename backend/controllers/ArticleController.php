<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/25
 * Time: 14:37
 */

namespace backend\controllers;


use app\models\ArticleCate;
use app\models\ArticleDetail;
use backend\models\Article;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;

class ArticleController extends Controller
{
    //文章展示
    public function actionIndex()
    {
        $articles = Article::find()->all();
        return $this->render('index',compact('articles'));
    }
    
    //文章添加
    public function actionAdd()
    {
        $articles = new Article();
        $detail = new ArticleDetail();
        $request = new Request();

        //得到分类的类型
        $categorys = ArticleCate::find()->asArray()->all();
        //然后把得到的数据转换成键值对
        $catesarr = ArrayHelper::map($categorys,'id','name');

        if($request->isPost){

            //绑定数据
            $articles->load($request->post());
            //去后台验证

            if ($articles->validate()) {
                $articles->create_time=date('Ymd D');
                //验证成功保存数据
                $articles->save();
            }

                $detail->load($request->post());
                //给对应的文章内容分表id
                $detail->article_id=$articles->id;
                    $detail->validate();

                    if ($detail->save()) {
                        echo 111;
                        return $this->redirect(['article/index']);
                    }
        }
        return $this->render('add',compact('articles','catesarr','detail'));
    }
    
    //文章修改
    public function actionEdit($id)
    {
        $articles =Article::findOne($id);
        $detail = ArticleDetail::findOne($id);
        $request = new Request();

        //得到分类的类型
        $categorys = ArticleCate::find()->asArray()->all();
        //然后把得到的数据转换成键值对
        $catesarr = ArrayHelper::map($categorys,'id','name');

        if($request->isPost){

            //绑定数据
            $articles->load($request->post());
            //去后台验证

            if ($articles->validate()) {
                $articles->create_time=date('Ymd H');
                //验证成功保存数据
                $articles->save();
            }

            $detail->load($request->post());
            //给对应的文章内容分表id
            $detail->article_id=$articles->id;
            $detail->validate();

            if ($detail->save()) {
                echo 111;
                return $this->redirect(['article/index']);
            }
        }
        return $this->render('add',compact('articles','catesarr','detail'));
    }
    
    //文章删除
    public function actionDel($id)
    {
        if ($article = Article::findOne($id)->delete() && $article_detaile = ArticleDetail::findOne($id)->delete()) {
            return $this->redirect(['article/index']);
        }
    }

    //文章回收站
    public function actionAr_back()
    {

    }

    //文章内容查询
    public function actionGetcon($id)
    {
        $article = Article::findOne($id);
        $articledetail = ArticleDetail::findOne($id);
        $articledetail->count=$articledetail->count+1;
        $articledetail->save();
        return $this->render('getcon',compact('articledetail','article'));
    }

    //富文本框
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction'
            ]
        ];
    }
}