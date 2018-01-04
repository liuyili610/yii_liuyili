<?php
/* @var $this yii\web\View */
?>
<h1>权限列表</h1>
<a href="<?= \yii\helpers\Url::to(['add']) ?>" class="btn btn-info">添加</a>

<table class="table">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php foreach ($permissions as $permission): ?>
        <tr>
            <td>
                <!--strpos 判断字符串中有没有另外一个字符串，根据路径中的/来判断-->
                <?= strpos($permission->name,'/')?"---":""?><?=$permission->name ?>
            </td>
            <td><?= $permission->description?></td>
            <td><a href="<?= \yii\helpers\Url::to(['edit', 'name' => $permission->name]) ?>" class="btn btn-success">编辑</a>
                <?= \yii\bootstrap\Html::a("删除", ['del', 'name' => $permission->name], ["class" => "btn btn-danger"]) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>