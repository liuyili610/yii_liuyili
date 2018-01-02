<?php
$form=yii\bootstrap\ActiveForm::begin();
echo $form->field($admin,'name')->textInput();
echo $form->field($admin,'password')->passwordInput()->label('密码');
echo $form->field($admin,'email')->textInput()->label('邮箱');
echo yii\bootstrap\Html::submitButton('确认提交',['class'=>'btn btn-success']);
yii\bootstrap\ActiveForm::end();