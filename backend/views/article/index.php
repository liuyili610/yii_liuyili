<a href="<?=yii\helpers\Url::to(['add'])?>"><span class="btn btn-success">添加文章</span></a>
<a href="<?=yii\helpers\Url::to(['article/ar_back'])?>"><span class="btn btn-danger">文章回收站</span></a>
<table class="table table-striped table-bordered table-responsive">
    <tr>
        <td>文章编号</td>
        <td>文章标题</td>
        <td>文章类型</td>
        <td>文章简介</td>
        <td>文章状态</td>
        <td>创建时间</td>
        <td>文章排序</td>
        <td>查看文章</td>
        <td>点击量</td>
        <td>操作</td>
    </tr>
    <?php
    foreach ($articles as $article):
    ?>
    <tr>
        <td><?=$article->id?></td>
        <td><?=$article->name?></td>
        <td><?=$article->cate->name?></td>
        <td><?=$article->intro?></td>
        <td><?php
            if($article->status == 1){
                echo "<span class='glyphicon glyphicon-ok'>激活</span>";
            }
            if($article->status == 2){
                echo "<span class='glyphicon glyphicon-remove'>隐藏</span>";
            }
            ?></td>
        <td><?=$article->create_time?></td>
        <td><?=$article->sort?></td>
        <td><a href="<?=yii\helpers\Url::to(['article/getcon','id'=>$article->id])?>"><span class="btn btn-info">查看文章</span></a></td>
        <td><?=$article->cotn->count?></td>
        <td><a href="<?=yii\helpers\Url::to(['article/edit','id'=>$article->id])?>"><span class="btn btn-info">编辑文章</span></a>||<a href="<?=yii\helpers\Url::to(['article/del','id'=>$article->id])?>"><span class="btn btn-danger">删除文章</span></a></td>
    </tr>
    <?php
    endforeach;
    ?>
</table>









