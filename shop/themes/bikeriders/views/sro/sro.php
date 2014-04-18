<?php
	//$model for this view file is Sro::model()

if($model): ?>

<div id="orderdisplay">
    <h1 class="left10"><?= Yii::t('global','Service Repair Order') ?></h1>

    <div class="row">
        <div class="span2"><legend><?php echo Yii::t('sro','SRO ID') ?>:</legend></div>
        <div class="span2"><?= $model->ls_id; ?></div>
        <div class="span2"><legend><?php echo Yii::t('global','Date') ?>:</legend></div>
        <div class="span3"><?= $model->datetime_cre; ?></div>
	</div>

	<div class="row">
        <div class="span2"><legend><?php echo Yii::t('global','Name') ?>:</legend></div>
        <div class="span2"><?= $model->customer_name; ?></div>
	    <div class="span2"><legend><?php echo Yii::t('global','Status') ?>:</legend></div>
        <div class="span2"><?= $model->status; ?></div>
   </div>

    <div class="row">
        <div class="span2"><legend><?php echo Yii::t('sro','Problem') ?>:</legend></div>
        <div class="span7"><?= nl2br($model->problem_description) ?></div>
    </div>

    <div class="row">
        <div class="span2"><legend><?php echo Yii::t('global','Notes') ?>:</legend></div>
        <div class="span7"><?= nl2br($model->printed_notes) ?></div>
    </div>

	<div class="clearfix spaceafter"></div>

	<div class="clearfix spaceafter"></div>

	<fieldset class="span9">
			<div class="row">
	        <div class="span3"><legend><?php echo Yii::t('sro','Work Performed') ?>:</legend></div>
	        <div class="span6"><?= nl2br($model->work_performed) ?></div>
	    </div>
	</fieldset>

	<div class="clearfix spaceafter"></div>

	<fieldset class="span9">
	    <div class="row">
	        <div class="span3"><legend><?php echo Yii::t('sro','Parts Used') ?>:</legend></div>
	    </div>
		<?php echo $this->renderPartial('/sro/_sroitems',array('model'=>$model),true); ?>
	</fieldset>

	<div class="clearfix spaceafter"></div>

	<fieldset class="span9">
		<div class="row">
	        <div class="span9"><legend><?php echo Yii::t('sro','Repaired Items') ?>:</legend></div>
	    </div>
		<?php echo $this->renderPartial('/sro/_srorepairs',array('model'=>$model),true); ?>
	</fieldset>

	<div class="clearfix spaceafter"></div>

	<fieldset class="span9">
	    <div class="row">
		    <div class="span2"><legend><?php echo Yii::t('sro','Warranty') ?>:</legend></div>
		    <div class="span2"><?= $model->warranty; ?></div>
		    <div class="span2"><legend><?php echo Yii::t('sro','Warranty Info') ?>:</legend></div>
		    <div class="span2"><?= $model->warranty_info; ?></div>

	    </div>
	</fieldset>


</div>


<?php endif;