<div class="topnav">
    <div class="topnav_bd w1210 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好，欢迎来到京西！


                    <?php
                    if(!Yii::$app->user->isGuest){
                        echo  '<li class="line">'.yii::$app->user->identity->username.'</li>';
                    ?>
                        [<a href="<?=yii\helpers\Url::to(['user-login/logout','back'=>1])?>">退出登录</a>]
                      <?php
                    }else{
                        echo "请登录";
                        ?>

                        [<a href="<?=yii\helpers\Url::to(['user-login/login'])?>">登录</a>]

                    <?php
                    }
                    ?>




</li>
<li class="line">|</li>
<li><a href="<?=\yii\helpers\Url::to(['goods/cart-lists'])?>">我的订单</a></li>
<li class="line">|</li>
<li>客户服务</li>

</ul>
</div>
</div>
</div>