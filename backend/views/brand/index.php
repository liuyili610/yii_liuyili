<a href="<?=yii\helpers\Url::to(['add'])?>"><span class="btn btn-success col-lg-1">添加品牌</span></a>
<a href="<?=yii\helpers\Url::to(['back'])?>"><span class="btn btn-info col-lg-1">回收站</span></a>
<table class="table table-responsive table-bordered table-striped">
    <tr>
        <td>品牌编号</td>
        <td>品牌名字</td>
        <td>排序</td>

        <td>品牌标志</td>
        <td>品牌简介</td>
        <td>操作</td>
    </tr>
    <?php
    foreach ($brands as $brand):
    ?>
    <tr>
        <td><?=$brand->id?></td>
        <td><?=$brand->name?></td>
        <td><?=$brand->sort?></td>

        <td><?=\yii\bootstrap\Html::img("/".$brand->logo,['width'=>'50'])?></td>
        <td><?=$brand->intro?></td>
        <td><a href="<?=yii\helpers\Url::to(['edit','id'=>$brand->id])?>"><span class="btn btn-info">品牌编辑</span></a>||<a href="<?=yii\helpers\Url::to(['del','id'=>$brand->id])?>"><span class="btn btn-danger">删除品牌</span></a></td>
    </tr>
    <?php
    endforeach;
    ?>
</table>

<?=\yii\widgets\LinkPager::widget([
    'pagination' => $pagination
])
?>