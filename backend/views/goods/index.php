<h1>商品列表</h1>
<div class="row">
    <div class="">
        <a href="<?=yii\helpers\Url::to(['add'])?>"><span class="btn btn-success col-lg-1">添加商品</span></a>
        <a href="<?=yii\helpers\Url::to(['back'])?>"><span class="btn btn-info col-lg-1">回收站</span></a>
    </div>
    <div class="pull-right">
        <!--搜索表单开始-->
        <form class="form-inline">
            <div class="form-group">
                <label for="exampleInputName2">价格区间</label>
                <input type="text" size="4" class="form-control" name="minpri" id="exampleInputName2" placeholder="最低价格">--
                <input type="text" size="4" class="form-control" name="maxpri" id="exampleInputName2" placeholder="最高价格">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail2">关键字</label>
                <input type="text" class="form-control" name="keyword" id="exampleInputEmail2" placeholder="可查询关键字或货号">
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search">搜索</span></button>
        </form>
        <!--搜索表单结束-->
    </div>
</div>
<table class="table table-responsive table-bordered table-striped">
    <tr>
        <td>商品编号</td>
        <td>商品名字</td>
        <td>商品货号</td>
        <td>商品图片</td>
        <td>商品分类</td>
        <td>商品品牌</td>
        <td>市场价格</td>
        <td>本店价格</td>
        <td>库存</td>
        <td>上架状态</td>
        <td>商品排序</td>
        <td>软删</td>
        <td>录入时间</td>
        <td>操作</td>
    </tr>
    <?php
    foreach ($goods as $good):
        ?>
        <tr>
            <td><?=$good->id?></td>
            <td><?=$good->name?></td>
            <td><?=$good->sn?></td>

            <td><?=\yii\bootstrap\Html::img("/".$good->logo,['width'=>'50'])?></td>
            <td><?=$good->cate->name?></td>
            <td><?=$good->brands->name?></td>
            <td><?=$good->market_price?></td>
            <td><?=$good->shop_price?></td>
            <td><?=$good->stock?></td>
            <td><?php
                if($good->is_on_sale == 1){
                    echo "上架";
                }else{
                    echo "不上架";
                }
                ?></td>
            <td><?=$good->sort?></td>
            <td><a href="<?=yii\helpers\Url::to(['goods/back','id'=>$good->id])?>"><span class="btn btn-danger">加入回收站</span></a></td>
            <td><?=$good->inputtime?></td>
            <td><a href="<?=yii\helpers\Url::to(['edit','id'=>$good->id])?>"><span class="btn btn-info">编辑</span></a>||<a href="<?=yii\helpers\Url::to(['del','id'=>$good->id])?>"><span class="btn btn-danger">删除</span></a></td>
        </tr>
        <?php
    endforeach;
    ?>
</table>
</table>
<?=\yii\widgets\LinkPager::widget(
    ['pagination' => $pages]
)?>
