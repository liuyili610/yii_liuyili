<a href="<?=yii\helpers\Url::to(['article/index'])?>"><span class="btn btn-info">返回首页</span></a>
<table class="table table-bordered table-striped">
    <tr>
        <td>文章创建时间：<?php echo $article->create_time?></td>
    </tr>
    <tr>

        <td><?=$article->content->content?></td>
    </tr>
</table>
