<?php
$form=yii\bootstrap\ActiveForm::begin();
echo $form->field($goods,'name')->textInput()->label('商品名称');
echo $form->field($goods,'sn')->textInput()->label('货号');
//echo $form->field($goods,'logo')->textInput()->label('商品图片');
echo $form->field($goods, 'logo')->widget('manks\FileInput', [
]);
echo $form->field($goods,'goods_category_id')->dropDownList($goodsArray1)->label('商品分类');
echo $form->field($goods,'brand_id')->dropDownList($goodsArray2)->label('商品品牌');
echo $form->field($goods,'market_price')->textInput()->label('市场价格');
echo $form->field($goods,'shop_price')->textInput()->label('本店价格');
echo $form->field($goods,'stock')->textInput()->label('库存量');
echo $form->field($goods,'sort')->textInput()->label('排序');
//echo $form->field($goods,'is_on_sale')->textInput()->label('上架状态');
echo $form->field($goods,'is_on_sale')->inline()->radioList(['1'=>'上架','2'=>'不上架']);
//echo $form->field($goods,'status')->textInput()->label('是否删除');
echo yii\helpers\Html::submitButton('提交');
yii\bootstrap\ActiveForm::end();