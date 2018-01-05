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

<!--        搜索框开始-->
        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">-->
<!--            <div class="input-group">-->
<!--                <input type="text" name="q" class="form-control" placeholder="Search..."/>-->
<!--              <span class="input-group-btn">-->
<!--                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>-->
<!--                </button>-->
<!--              </span>-->
<!--            </div>-->
<!--        </form>-->
        <!-- /.search form -->
<!--        搜索框结束-->


        <?= dmstr\widgets\Menu::widget(
            [

//                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
//                'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id)


                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id),

//                'items' => [
//                    ['label' => '本大爷-刘毅力', 'options' => ['class' => 'header']],
////                    ['label' => '登录', 'icon' => 'file-code-o', 'url' => ['admin/login']],
////                    ['label' => '退出登录', 'icon' => 'file-code-o', 'url' => ['admin/logout']],
//                    ['label' => '文章列表', 'icon' => 'file-code-o', 'url' => ['article/index']],
//                    ['label' => '品牌列表', 'icon' => 'dashboard', 'url' => ['brand/index']],
//                    ['label' => '商品列表', 'icon' => 'dashboard', 'url' => ['goods/index']],
//                    ['label' => '管理员管理', 'icon' => 'dashboard', 'url' => ['admin/index']],
//                    ['label' => 'GII创建', 'icon' => 'dashboard', 'url' => ['/gii']],
////                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
//                    [
//                        'label' => '商品类型',
//                        'icon' => 'share',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => '添加', 'icon' => 'file-code-o', 'url' => ['/goods-category/add'],],
//                            ['label' => '查看', 'icon' => 'dashboard', 'url' => ['goods-category/index'],],
//                            [
//                                'label' => '后台管理员表',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
//                    [
//                        'label' => '关于权限',
//                        'icon' => 'share',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => '权限设置', 'icon' => 'file-code-o', 'url' => ['permission/index'],],
//                            ['label' => '角色分组', 'icon' => 'dashboard', 'url' => ['role/index'],],
//                            [
//                                'label' => '后台管理员表',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
            ]



        ) ?>

    </section>

</aside>
