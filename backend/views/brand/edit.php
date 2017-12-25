<?php
$form=yii\bootstrap\ActiveForm::begin();
echo $form->field($brands,'name')->textInput();
echo $form->field($brands,'sort')->textInput()->label('排序编号');
echo $form->field($brands,'status')->inline()->radioList(\backend\models\Brand::STATU);
//echo $form->field($brands,'fileImg')->fileInput();
//文件上传
echo $form->field($brands, 'logo')->widget('manks\FileInput');




echo $form->field($brands,'intro')->textarea();
echo yii\bootstrap\Html::submitButton('确认提交',['class'=>'btn btn-success']);
yii\bootstrap\ActiveForm::end();