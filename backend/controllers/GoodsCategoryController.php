<?php

namespace backend\controllers;


use backend\models\GoodsCategory;
use yii\helpers\Json;
use yii\web\Request;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $goodscate = GoodsCategory::find()->orderBy("tree,lft")->all();
        return $this->render('index',compact('goodscate'));
    }

    public function actionAdd()
    {
        $model = new GoodsCategory();

        $category = GoodsCategory::find()->asArray()->all();
        $category[]=['id'=>0,'name'=>'顶级目录','parent_id'=>0];
        $category = Json::encode($category);
        $request = new Request();
        if($request->isPost){
//        $countries = new Menu(['name' => 'Countries']);
//        $countries = new Menu();
//        $countries->name = 'Countries';
//        $countries->makeRoot();
            $model->load($request->post());
            if ($model->validate()){
                if ($model->parent_id == 0){
                    $model->makeRoot();
                    \yii::$app->session->setFlash('success','添加父级分类：'.$model->name.'成功');
                    return $this->redirect(['goods-category/index']);
                }else{
//                    $russia = new Menu(['name' => 'Russia']);
//                    $russia->prependTo($countries);
                    $parent = GoodsCategory::findOne($model->parent_id);
                    $model->prependTo($parent);
                    \yii::$app->session->setFlash('success','添加子级分类：'.$model->name.'成功');
                    return $this->redirect(['goods-category/index']);
                }
            }
            return $this->refresh();
        }

        return $this->render('add',compact('model','category'));

    }


    public function actionEdit($id)
    {
        $model = GoodsCategory::findOne($id);
        $category = GoodsCategory::find()->asArray()->all();
        $category[]=['id'=>0,'name'=>'一级目录','parent_id'=>0];
        $category = Json::encode($category);
        $request = new Request();
        if($request->isPost){
//        $countries = new Menu(['name' => 'Countries']);
//        $countries = new Menu();
//        $countries->name = 'Countries';
//        $countries->makeRoot();
            $model->load($request->post());
            if ($model->validate()){
                if ($model->parent_id == 0){
//                    $model->makeRoot();
                    //如果不改成save的话那么上一级的分类就修改不了。腹肌分类修改不了是makeroot的原因
                    $model->save();
                    \yii::$app->session->setFlash('success','添加父级分类：'.$model->name.'成功');
                }else{
//                    $russia = new Menu(['name' => 'Russia']);
//                    $russia->prependTo($countries);
                    $parent = GoodsCategory::findOne($model->parent_id);
                    $model->prependTo($parent);
                    \yii::$app->session->setFlash('success','添加子级分类：'.$model->name.'成功');

                }
            }
            return $this->refresh();
        }

        return $this->render('add',compact('model','category'));
    }

    public function actionDel($id)
    {
        $goodscate = GoodsCategory::findOne($id)->delete();
        return $this->redirect('goods-category/index');
    }

}
