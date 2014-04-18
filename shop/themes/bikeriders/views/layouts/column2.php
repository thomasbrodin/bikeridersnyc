<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
	<div class="span9">

		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
	        'links'=>$this->breadcrumbs,
			'homeLink'=>CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/css/images/breadcrumbs_home.png'), array('/site/index')),
			'separator'=>' / ',
	        ));	?> <!-- breadcrumbs -->
		<?php $this->widget('bootstrap.widgets.TbAlert', array(
			'block'=>true, // display a larger alert block?
			'fade'=>true, // use transitions?
			'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
			'alerts'=>array( // configurations per alert type
				'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
				'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
				'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
				'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
				'danger'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
			),
			)); ?><!-- flash messages -->
		<div id="viewport" class="row">
		    <?php echo $content; ?>
	    </div>
	</div>

	<div id="menuside" class="span3">
       
       <div id="shoppingcart">
		<?= $this->renderPartial('/site/_sidecart',null, true); ?>
		

        <div id="shoppingcartcheckout" onclick="window.top.location.href='<?php echo Yii::app()->createUrl('cart/checkout') ?>'">
            <div class="checkoutlink"><?php echo CHtml::link(Yii::t('cart','Checkout'),array('cart/checkout'),array('target'=>'_top')) ?><span class="arrow">→</span></div>
            
        </div>

        <div id="shoppingcarteditcart" onclick="window.location.href='<?php echo Yii::app()->createUrl('/cart') ?>'">
            <div class="editlink"><?php echo CHtml::link(Yii::t('cart','Edit Cart'),array('/cart')) ?></div>
        </div>
		
		<div id="login">
			<?php if(Yii::app()->user->isGuest): ?>
				<?php echo CHtml::ajaxLink(Yii::t('global','Login'),array('site/login'),
					array('onClick'=>'js:jQuery($("#LoginForm")).dialog("open")'),
					array('id'=>'btnLogin')); ?>
				&nbsp;/&nbsp;
				<a href="<?= _xls_site_url('myaccount/edit'); ?>"><?php echo Yii::t('global', 'Register'); ?></a>
			<?php else: ?>
				<?php echo CHtml::link(CHtml::image(Yii::app()->user->profilephoto).Yii::app()->user->firstname, array('/myaccount')); ?>
				&nbsp;&nbsp;/&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('global', 'Logout'), array("site/logout")); ?>
				<?php endif; ?>
		</div>
		<?php if(_xls_get_conf('LANG_MENU',0)): ?>
			<div id="langmenu">
				<?php $this->widget('application.extensions.'._xls_get_conf('PROCESSOR_LANGMENU').'.'._xls_get_conf('PROCESSOR_LANGMENU')); ?>
				</div>
		<?php endif; ?>
		
        <div id="sidebar" class="span3">
			<?php $this->widget("application.extensions.wsborderlookup.wsborderlookup",array()); ?>
	        <?php if(_xls_get_conf('ENABLE_WISH_LIST'))
				echo $this->renderPartial('/site/_wishlists',array(),true); ?>
	    </div>

	</div>
</div>

<?php $this->endContent();