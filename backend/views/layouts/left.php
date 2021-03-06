<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>用户：
                <?php
                    if(empty(Yii::$app->user->identity->username)){
                        echo "请先登录";
                    }else{
                        echo Yii::$app->user->identity->username;
                    }
                   ?>
                </p>

                <a href="#"><i class="fa fa-circle text-success"></i><?php
                    if(empty(Yii::$app->user->identity->username)){
                        echo "离线";
                    }else{
                        echo "在线";
                    }
                    ?></a>
            </div>
        </div>


<!--        搜索框结束-->
        <?php
        $callback = function($menu){
            $data = json_decode($menu['data'], true);
            $items = $menu['children'];
            $return = [
                'label' => $menu['name'],
                'url' => [$menu['route']],
            ];
            //处理我们的配置
            if ($data) {
                //visible
                isset($data['visible']) && $return['visible'] = $data['visible'];
                //icon
                isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
                //other attribute e.g. class...
                $return['options'] = $data;
            }
            //没配置图标的显示默认图标
            (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o';
            $items && $return['items'] = $items;
            return $return;
        };
        //这里我们对一开始写的菜单menu进行了优化
        echo dmstr\widgets\Menu::widget( [
          //  'options' => ['class' => 'sidebar-menu'],
            'items' => mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback),
        ] );

        ?>


    </section>

</aside>
