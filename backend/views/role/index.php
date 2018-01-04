<?php
/* @var $this yii\web\View */
?>
<h1>角色列表</h1>
<a href="<?= \yii\helpers\Url::to(['add']) ?>" class="btn btn-info">添加角色</a>

<table class="table">

    <tr>

        <th>名称</th>
        <th>描述</th>
        <th>权限</th>
        <th>操作</th>
    </tr>
    <?php foreach ($roles as $role):?>
        <tr>
            <td>
                <?=$role->name ?>
            </td>
            <td><?= $role->description?></td>
            <td>
                <?php
                $auth = \Yii::$app->authManager;
                //  var_dump( $auth->getPermissionsByRole($role->name));
                foreach ($auth->getPermissionsByRole($role->name) as $permission){
                    //通过对应的那个分组的名字来找到他所拥有的那些权限，然后遍历一个权限就在后面添加一个符号便于区分
                    echo $permission->description."||";
                }
                ?>
            </td>
            <td><a href="<?= \yii\helpers\Url::to(['edit', 'name' => $role->name]) ?>" class="btn btn-success">编辑</a>

                <?= \yii\bootstrap\Html::a("删除", ['del', 'name' => $role->name], ["class" => "btn btn-danger"]) ?>

            </td>
        </tr>
    <?php endforeach; ?>
</table>
