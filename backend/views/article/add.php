<?php
$form=yii\bootstrap\ActiveForm::begin();
echo $form->field($articles,'name')->textInput();
echo $form->field($articles,'cate_id')->dropDownList($catesarr);
echo $form->field($articles,'intro')->textarea();
echo $form->field($articles,'status')->inline()->radioList(['1'=>'显示','2'=>'隐藏']);
echo $form->field($articles,'sort')->textInput();
echo $form->field($detail, 'content')->widget('kucha\ueditor\UEditor',[]);
echo yii\bootstrap\Html::submitButton('提交');
yii\bootstrap\ActiveForm::end();