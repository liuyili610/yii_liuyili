<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28
 * Time: 18:14
 */

namespace backend\controllers;


use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use flyok666\qiniu\Qiniu;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsController extends Controller
{
    //主页面
    public function actionIndex()
    {
        $goods = Goods::find();
        $request = new Request();
        $minpri = $request->get('minpri');
        $maxpri = $request->get('maxpri');
        $keyword = $request->get('keyword');
        if($minpri){
            $goods->andWhere("shop_price>={$minpri}");
        }
        if($maxpri){
            $goods->andWhere("shop_price<={$maxpri}");
        }
        if($keyword){
            $goods->andWhere("name like '%{$keyword}%' or sn like '%{$keyword}%'");
        }
        $pages = new Pagination([
                'totalCount'=>$goods->count(),
                'pageSize'=>5,
        ]
        );
         $goods = $goods->offset($pages->offset)
             ->limit($pages->limit)
             ->all();

        return $this->render('index',compact('goods','pages'));
    }

    //添加
    public function actionAdd()
    {
        //创建一个新的商品详情表对象
        $goodsIntro = new GoodsIntro();
        //创建（new）一个新的商品对象
        $goods = new Goods();
        $daycount = GoodsDayCount::find()->count();
        $goodscate = GoodsCategory::find()->orderBy('tree,lft')->all();
        $goodsbrand = Brand::find()->asArray()->all();
        //两个下拉菜单的（一对一）的键值对转换
        $goodsArray1 = ArrayHelper::map($goodscate,'id','nameText');
        $goodsArray2 = ArrayHelper::map($goodsbrand,'id','name');
        //创建组件对象
        $request = new Request();
        if($request->isPost){
            //绑定数据
            $goods->load($request->post());
            //验证
            if ($goods->validate()) {
                //验证货号是否为空，为空按自己的规则写
                if(empty($goods->sn)){
                    //转换成时间戳  从当天时间的0时开始算起就可以求到所有的条数
                    $timeStart=strtotime(date('Ymd'));
                    //查出今天创建的所有商品数量
                    $count=Goods::find()->where("inputtime>={$timeStart}")->count();
                    //加一条就是现在的条数了额。
                    $count=$count+1;
                    //首先拼接一个字符串，在截取后四位
                    $count=substr("000".$count,-4);
                    //得到最终的货号
                    $goods->sn=date("Ymd").$count;
                }
                //商品表处理完那么保存数据
                $goods->save();
                //下面开始商品详情表的出理，首先绑定数据
                $goodsIntro->load($request->post());
                $goodsIntro->goods_id=$goods->id;
                $goodsIntro->save();

                foreach ($goods->imgFile as $img){
                    $imgGar = new GoodsGallery();
                    $imgGar->goods_id = $goods->id;
                    $imgGar->path = $img;
//                    var_dump($imgGar);exit;
                    $imgGar->save();
//                        var_dump($imgGar);exit;


                }
                return $this->redirect(['goods/index']);
            }

                var_dump($goods->errors);exit;
//                \yii::$app->session->setFlash('danger','验证错误，请重新输入');

        }

        return $this->render('add',compact('goods','goodsArray1','goodsArray2'));
    }

    //修改
    public function actionEdit($id)
    {

    }

    //删除
    public function actionDel($id)
    {

    }
    
    //回收站
    public function actionBack()
    {
        
    }
    
    //文件上传的方法
    public function actionUpload()
    {
        //得到上传文件的实例对象
//        $file = UploadedFile::getInstanceByName("file");
//        if ($file){
//            //路径
//            $path = "images/goods/" . uniqid() . "." . $file->extension;
//            //移动图片
//            if ($file->saveAs($path, false)) {
//                // {"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}
//                //这个是webupload的配置
//                $result = [
//                    'code' => 0,
//                    'url' => "/" . $path,
//                    'attachment' => $path
//                ];
//                return json_encode($result);
//            }
//        }

        // 正确时， 其中 attachment 指的是保存在数据库中的路径，url 是该图片在web可访问的地址
//        {"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}

        //得到上传对象
//        $upload = UploadedFile::getInstanceByName('file');
//        //拼接路径
//        if($upload){
//            $path = "images/brand/".uniqid().".".$upload->extension;
//            if ($upload->saveAs($path,false)) {
//                $result = ['code'=>0,'url'=>'/'.$path,'attachment'=>$path];
//
//            }
//            return json_encode($result);
//        }
        $config = [
            'accessKey' => 'EAd29Qrh05q78_cZhajAWcbB1wYCBLyHLqkanjOG',//AK
            'secretKey' => '_R5o3ZZpPJvz8bNGBWO9YWSaNbxIhpsedbiUtHjW',//SK
            'domain' => 'http://p1ht4b07w.bkt.clouddn.com',//临时域名
            'bucket' => 'php0830',//空间名称
            'area' => Qiniu::AREA_HUADONG//区域
        ];

        $qiniu = new Qiniu($config);
        $picname = uniqid();
        $qiniu->uploadFile($_FILES['file']['temp_name'],$picname);
        $url = $qiniu->getLink($picname);
        //返回的结果
        $result = [
            'code' => 0,
            'url' => $url,
            'attachment' => $url

        ];
        return json_encode($result);

    }


}