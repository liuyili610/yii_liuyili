<a href="<?=yii\helpers\Url::to(['test/add'])?>"><span class="btn btn-info">添加</span></a>
<table class="table table-striped table-bordered table-responsive">
    <tr>
        <td>测试编号</td>
        <td>名称</td>
        <td>图片</td>
        <td>操作</td>
    </tr>
    <?php
    foreach ($test as $tes):
    ?>
    <tr>
        <td><?=$tes->id?></td>
        <td><?=$tes->name?></td>
        <td><?=yii\bootstrap\Html::img("/".$tes->pic,['width'=>45])?></td>
        <td><a href="<?=yii\helpers\Url::to(['test/edit'])?>"><span class="btn btn-info">编辑</span></a>||<a href="<?=yii\helpers\Url::to(['test/del'])?>"><span class="btn btn-danger">删除</span></a></td>
    </tr>
    <?php
    endforeach;
    ?>
</table>