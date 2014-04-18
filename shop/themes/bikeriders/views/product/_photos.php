<div class="row">
	<legend><?= Yii::t('global','Hover over image to zoom') ?></legend>
	<?php $this->widget('ext.Yii-Image-Zoomer.YiiImageZoomer',array(
		'multiple_zoom'=>count($model->AdditionalImages)>=1 ? true:false,
		'single_image'=>$model->Images,
		'images'=>$model->Images,
		'cursorshade'=>false,
		'imagevertcenter'=>false,
		'magvertcenter'=>true,
		'width'=>Yii::app()->params['DETAIL_IMAGE_WIDTH'],
		'height'=>Yii::app()->params['DETAIL_IMAGE_HEIGHT'],
		'magnifierpos'=>'left',
		'css_target'=>'targetarea span9',
		'css_thumbs'=>'image1 thumbs span9',
		'magnifiersize'=>array(512,512),
		'zoomrange'=>array(2,2),
		'initzoomablefade'=>true,
		'zoomablefade'=>true,
		'speed'=>300,
		'zIndex'=>4
	));
	?>
</div>