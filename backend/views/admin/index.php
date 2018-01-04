<a href="<?=yii\helpers\Url::to(['admin/add'])?>"><span class="btn btn-info">注册</span></a>
<table class="table table-striped table-bordered">
    <tr>
        <td>用户编号</td>
        <td>用户姓名</td>
        <td>邮箱</td>
        <td>创建时间</td>
        <td>最后一次登陆时间</td>
        <td>最后一次登录IP</td>
        <td>操作</td>
    </tr>
    <?php
    foreach ($admin as $adm):
    ?>
    <tr>
        <td><?=$adm->id?></td>
        <td><?=$adm->username?></td>
        <td><?=$adm->email?></td>
        <td><?=$adm->add_time?></td>
        <td><?=date('Y-m-d H',$adm->last_login_time);?></td>
        <td><?=$adm->last_login_ip?></td>
        <td><a href="<?=yii\helpers\Url::to(['admin/edit','id'=>$adm->id])?>"><span class="btn btn-success">编辑</span></a><a href="<?=yii\helpers\Url::to(['admin/del','id'=>$adm->id])?>"><span class="btn btn-danger">删除</span></a></td>
    </tr>
    <?php
    endforeach;
    ?>
</table>