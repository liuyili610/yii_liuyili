<a href="<?=yii\helpers\Url::to(['permission/index'])?>"><span class="btn btn-info">回主页</span></a>
<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description')->textarea();
//echo $form->field($model,'permission')->checkboxList($perArr);
echo \yii\bootstrap\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();