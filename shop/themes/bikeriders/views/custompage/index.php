<div id="custom_content" class="span9">
	<!-- <h1 class="shop"><span class="logo"></span><?php echo Yii::t('tabs',$model->title) ?></h1> -->

	<?php echo $model->page; ?>
</div>

<div class="span7 clearfix slider">
	<?php
		$this->widget('ext.JCarousel.JCarousel', array(
			'dataProvider' => $model->taggedProducts(),
			'thumbUrl' => '$data->SliderImage',
			'imageUrl' => '$data->Link',
			'emptyText'=>'',
			'titleText' => '$data->Title',
			'captionText' => '$data->Title',
			'target' => 'do-not-delete-this',
			//'wrap' => 'circular',
			'visible' => true,
			'skin' => 'slider',
			'clickCallback'=>'window.location.href=itemSrc;'
		)); ?>
</div>
