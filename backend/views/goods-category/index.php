<a href="<?=yii\helpers\Url::to(['goods-category/add'])?>"><span class="btn btn-success">添加</span></a>
<table class="table table-responsive table-bordered table-striped">
    <tr>
        <td>分类编号</td>
        <td>分类名字</td>
        <td>分类树</td>
        <td>左值</td>
        <td>右值</td>
        <td>深度</td>
        <td>父类编号</td>
        <td>分类介绍</td>
        <td>操作</td>
    </tr>

    <?php foreach ($goodscate as $cate): ?>
        <tr class="cate_tr" data-tree="<?= $cate->tree ?>" data-lft="<?= $cate->lft ?>"
            data-rgt="<?= $cate->rgt ?>">
            <td><?= $cate->id ?></td>
            <td><span class="glyphicon glyphicon-menu-right"></span><?= $cate->nameText ?></td>
            <td><?=$cate->tree?></td>
            <td><?=$cate->lft?></td>
            <td><?=$cate->rgt?></td>
            <td><?=$cate->depth?></td>
            <td><?=$cate->parent_id?></td>
            <td>
                <?=$cate->intro?>
            </td>
            <td><a href="<?=yii\helpers\Url::to(['goods-category/edit','id'=>$cate->id])?>"><span class="btn btn-info">编辑分类</span></a>||<a href="<?=yii\helpers\Url::to(['goods-category/del','id'=>$cate->id])?>"><span class="btn btn-danger">删除分类</span></a></td>

        </tr>


    <?php endforeach; ?>
</table>
<?php
//定义JS
$js = <<<JS
$(".cate_tr").click(function(){
var tr=$(this);

tr.find("span").toggleClass("glyphicon-resize-full ")
tr.find("span").toggleClass("glyphicon-resize-small")
var lft_parent=tr.attr('data-lft');//点击那一条的左值
var rgt_parent=tr.attr('data-rgt');//点击那一条的右值
var tree_parent=tr.attr('data-tree');//点击那一条的tree值
console.log(lft_parent,rgt_parent,tree_parent);
// 当前类的左值 右值 树
$(".cate_tr").each(function(k,v){
var lft=$(v).attr('data-lft');//所有的lft
var rgt=$(v).attr('data-rgt');//所有的右值
var tree=$(v).attr('data-tree');//所有的右值
console.log($(v).attr('data-lft'))

if(tree==tree_parent && lft-lft_parent>0 && rgt-rgt_parent<0){
//判断父类是不是展开状态
 if (tr.find('span').hasClass('glyphicon-resize-small')){
      $(v).find('span').removeClass('glyphicon-resize-full')
    $(v).find('span').addClass('glyphicon-resize-small')
     $(v).hide();
     
 }else {
     //是闭合状态
      $(v).find('span').removeClass('glyphicon-resize-small')
    $(v).find('span').addClass('glyphicon-resize-full')
$(v).show();
 }
    
}
})
console.dir(this);
});
JS;
//注意JS
$this->registerJs($js);
?>
