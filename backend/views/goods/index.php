<a href="<?=yii\helpers\Url::to(['add'])?>"><span class="btn btn-success col-lg-1">添加商品</span></a>
<a href="<?=yii\helpers\Url::to(['back'])?>"><span class="btn btn-info col-lg-1">回收站</span></a>
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
            <td><?=$good->brand->name?></td>
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
            <td><a href="<?=yii\helpers\Url::to(['edit','id'=>$good->id])?>"><span class="btn btn-info">品牌编辑</span></a>||<a href="<?=yii\helpers\Url::to(['del','id'=>$good->id])?>"><span class="btn btn-danger">删除品牌</span></a></td>
        </tr>
        <?php
    endforeach;
    ?>
</table>
