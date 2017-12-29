<?php
$form=yii\bootstrap\ActiveForm::begin();
echo $form->field($test,'name')->textInput();
//echo $form->field($test,'files')->fileInput();

echo $form->field($test, 'pic')->widget('manks\FileInput', [
]);

echo yii\bootstrap\Html::submitButton('提交');
yii\bootstrap\ActiveForm::end();