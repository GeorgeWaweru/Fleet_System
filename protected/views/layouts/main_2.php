<?php date_default_timezone_set('Africa/Nairobi'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
 	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.alphanumeric.pack.js');?>
    
  



    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/cookies.js');?>
	<?php
    $cs=Yii::app()->clientScript;
    $cs->registerCSSFile(Yii::app()->request->baseUrl.'/css/main.css');
    ?>
    
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    
    <style>
	.error{ color:#F00;}
	</style>
</head>

<body>

<div class="container" id="page">

<div id="header">
<img src="logo.png" />
<div id="logo" class="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
</div>


<?php
$logged_in_user_name_session=isset($_SESSION['logged_in_user_name_session']) ? $_SESSION['logged_in_user_name_session'] : "";
$logged_role_level_session=isset($_SESSION['logged_role_level_session']) ? $_SESSION['logged_role_level_session'] : "";
$logged_country_session=isset($_SESSION['logged_country_session']) ? $_SESSION['logged_country_session'] : "";
$logged_in_user_id_session=isset($_SESSION['logged_in_user_id_session']) ? $_SESSION['logged_in_user_id_session'] : 0;
$my_Account="/Myaccount/update&id=".$logged_in_user_id_session;
function EnableRoutes($access_level)
{
	$logged_role_level_session=isset($_SESSION['logged_role_level_session'])? $_SESSION['logged_role_level_session']: "";
	if($access_level=="Low" && $logged_role_level_session=="High"){
		return 0;
	}else if($access_level=="Low" && $logged_role_level_session=="Low"){
		return 1;
	}else if($access_level=="High" && $logged_role_level_session=="Low"){
		return 0;
	}else if($access_level=="High" && $logged_role_level_session=="High"){
		return 1;
	}
	else{
		return 0;
	}
}
?>


	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
	array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>isset($_SESSION['logged_in_user_name_session'])? 0:1),
	array('label'=>'Users', 'url'=>array('/Users/admin'),'visible'=>EnableRoutes("High")),
	array('label'=>'Characters', 'url'=>array('/Characters/admin'),'visible'=>EnableRoutes("High")),
	array('label'=>'Questions', 'url'=>array('/Questions/admin'),'visible'=>EnableRoutes("High")),
	array('label'=>'Answers', 'url'=>array('/Answers/admin'),'visible'=>EnableRoutes("High")),
	array('label'=>'User Answers', 'url'=>array('/Useranswers/admin'),'visible'=>EnableRoutes("High")),
	
	
	
	
	
	array('label'=>'Logout ('.$logged_in_user_name_session.')', 'url'=>array('/site/logout'), 'visible'=>isset($_SESSION['logged_in_user_name_session'])? 1:0)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?><?php echo CHtml::encode(Yii::app()->name); ?>  Admin.<br/>
		All Rights Reserved.<br/>
		
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
