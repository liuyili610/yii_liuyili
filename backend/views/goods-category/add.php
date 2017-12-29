<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoodsCategory */
/* @var $form ActiveForm */
?>
<div class="goods-category-add">

    <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'parent_id')->hiddenInput() ?>
    <?= \liyuze\ztree\ZTree::widget([
        'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parent_id",
				}
			},
			callback: {
				onClick: function(e,treeId, treeNode){
				//1.找到父类Id那个框框
				$("#goodscategory-parent_id").val(treeNode.id);
				console.dir(treeNode.id);
				}
			}
			
		}',
        'nodes' =>$category
    ]);
    ?>
        <?= $form->field($model, 'intro') ?>
    
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- goods-category-add -->
