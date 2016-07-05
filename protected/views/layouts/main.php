<?php
error_reporting(0);
?>
<?php date_default_timezone_set('Africa/Nairobi'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
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

	
 	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.alphanumeric.pack.js');?>
    <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/cookies.js');?>
  
    
	<?php
    $cs=Yii::app()->clientScript;
    $cs->registerCSSFile(Yii::app()->request->baseUrl.'/css/main.css');
    ?>
    
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    
    <style>
	
	.error{ color:#F00;}
	.graph_selectors{ display:none;}
	.hidden_text_fields{display:none;}
	.forgot_pass_div{display:none;}
	.preloader_div{display:none; z-index:999999999;}
	.edit_btn{padding-right:30px; margin-left:15px;}
	.success{color:#1333F0;}
	.profile_frm{ display:none;}
	.manifesto_frm{ display:none;}
	.form_info_div{ display:none;}
	.change_pass_login{ display:none;}
	.campaign_periods{ display:none;}
	.inner_fields{ font-size:12px; font-style:italic; color:red; font-weight:bold;}
	.physical_damages_fields_section{ display:none;}
	.Mechanical_fields_section{ display:none;}
	.description_fields_section{ display:none;}
	.attachment_link{display:none;}
	.sub_details_add{padding-right:40px; margin-left:15px; z-index:999999999999999 !important;}
	.logged_in_company{ margin-left:30px; font-size:15px; color:#1333F0;}
	.logged_in_company_pic{ margin-left:30px;}
	#damages_attachment{display:none;}
	#mechanical_attachment{display:none;}
	.narrative{color:#1333F0; font-style:italic; size:12px;}.
	.password_change_text{ display:none;}
	.login_text{ display:none;}
	
	.current_suppliers_section{ margin-left:700px; width:200px; float:right;}
	.suppliers_frm_section{ margin-top:10px;}
	
	.comments_section{display:none;}
	.spare_parts_section{display:none;}
	.more_spare_parts_section{display:none;}
	.hide_comment{ display:none;}
	.hide_all_spares{display:none;}
	.hide_more_spares{display:none;}
	.add_more_spares{display:none;}
	.additional_spares_section{ margin-left: 500px; margin-top: -134px; width: 200px; margin-bottom:200px;}
	.cost_title{ color:#1787EF; font-weight:bold; margin-left:30px; margin-right:2px;}
	.photo_title{ color:#1787EF; font-weight:bold; margin-left:15px;}
	.spares_error_div{margin-left:280px; margin-right:5px;}
	.AddMoreSpares{ display:none;}
	.subSystemSection{ display:none;}
	.booking_comments_section { position: absolute; float: left; margin: -580px 0 0 600px; height:700px;}
	
	.totalCost{color:#F30C10; font-weight:bold;}
	.totalCostNo{ color:#F30C10; font-weight:bold; margin-left:144px;}
	
	.totalCostNo2{font-weight:bold;}
	.commentor{ font-size:12px; color:#2EC910;}
	.deleteComment{}
	
	.commentReject{
		display: inline-block;
		font-size: 11px;
		color:#FFFFFF;
		background:#F70B0F;
		border: 1px solid #aba8a8;
		padding: 6px 9px;
		margin: 0 8px 12px 0;
		transition: all 0.9s ease;
		font-family: 'Roboto', sans-serif;
	}
	.commentAppove{
		display: inline-block;
		font-size: 11px;
		color:#FFFFFF;
		background:#0AD434;
		border: 1px solid #aba8a8;
		padding: 6px 9px;
		margin: 0 8px 12px 0;
		transition: all 0.9s ease;
		font-family: 'Roboto', sans-serif;
		}
		
		.comment_Pending{}
		.comment_Approved{background-color:#03F86B;}
		.comment_Rejected{ background-color:#FBADB9;}
		
		.approvalStatus{
			background: #d3a66d;
			color: #fff !important;
			padding: 3px 15px!important;
		}
		
		.rowTextdiv{ font-size:10.5px; color:#7C7C7C; font-weight:bold;}
		.prevMillage{font-size:12.5px; color:#F00609; font-weight:bold;}

	</style>
</head>

<body>

<div class="container" id="page">

<div id="header">
<?php
$LOGGED_IN_USER_NAMES=isset($_SESSION['LOGGED_IN_USER_NAMES']) ? $_SESSION['LOGGED_IN_USER_NAMES'] : "Default User";
$ADMIN_USER_ROLE_NAME=isset($_SESSION['ADMIN_USER_ROLE_NAME']) ? $_SESSION['ADMIN_USER_ROLE_NAME'] : "";
$ADMIN_USER_ROLE_LEVEL=isset($_SESSION['ADMIN_USER_ROLE_LEVEL']) ? $_SESSION['ADMIN_USER_ROLE_LEVEL'] : "";	
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$USER_CHANGED_PASSWORD=isset($_SESSION['USER_CHANGED_PASSWORD']) ? intval($_SESSION['USER_CHANGED_PASSWORD']) : 0;
$LOGGED_IN_COMPANY_NAME=isset($_SESSION['LOGGED_IN_COMPANY_NAME']) ? $_SESSION['LOGGED_IN_COMPANY_NAME'] : '';
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_SUPPLIER_TITLE=isset($_SESSION['LOGGED_IN_SUPPLIER_TITLE']) ? $_SESSION['LOGGED_IN_SUPPLIER_TITLE'] : '';
function showMenu()
{
	$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
	$USER_CHANGED_PASSWORD=isset($_SESSION['USER_CHANGED_PASSWORD']) ? intval($_SESSION['USER_CHANGED_PASSWORD']) : 0;
	if($USER_CHANGED_PASSWORD==1 && $LOGGED_IN_USER_ID>0){
		return 1;
	}else if($USER_CHANGED_PASSWORD==0 && $LOGGED_IN_USER_ID>0){
		return 0;
	}else{
		return 0;
	}
}


function showChangePasswordMenu()
{
	$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
	$USER_CHANGED_PASSWORD=isset($_SESSION['USER_CHANGED_PASSWORD']) ? intval($_SESSION['USER_CHANGED_PASSWORD']) : 0;
	if($USER_CHANGED_PASSWORD==0 && $LOGGED_IN_USER_ID>0){
		return 1;
	}else{
		return 0;
	}
}

function showLoginMenu()
{
	$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
	if($LOGGED_IN_USER_ID>0){
		return 0;
	}else{
		return 1;
	}
}
?>
<div id="logo" class="logo"> <?php echo CHtml::image('images/fleetfy.png',array('class'=>'logo'));?> <div class="slogan">
<?php echo CHtml::encode(Yii::app()->name); ?></div>  </div>
<?php
if(!empty($LOGGED_IN_COMPANY_NAME))
{
	?>
    <div class="logged_in_company_pic">
    <?php
	$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
	$Companies=Companies::model()->findByPk($LOGGED_IN_COMPANY);
	echo CHtml::image(Yii::app()->request->baseUrl.'/companies/'.$Companies->photo,$name,array("class"=>"banner_class","width"=>"100px"));
	?>
    </div>
    <div class="logged_in_company">
    Logged in as Company <b><?php echo $LOGGED_IN_COMPANY_NAME;?></b>
    </div>
    <?php
}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='supplier'){
	?>
    <div class="logged_in_company">
    Logged in as Supplier <b><?php echo $LOGGED_IN_SUPPLIER_TITLE;?></b>
    </div>
    <?php
}
?>
</div>

<div id="mainmenu">
<?php 
if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user')
{
/*$this->widget('zii.widgets.CMenu', array(
       'activeCssClass'=>'active',
        'id'=>'navigation',
        
        'items'=>array(
            
        array('label'=>'Cal4info', 'url'=>array('/site/index')),
        array('label'=>'Hot Deals', 'url'=>array('/company/aboutUs'),
           
            'submenuOptions'=>array('class'=>'nav-sub'),'items'=>array(
            array('label'=>'SubItem1', 'url'=>array('site/anot','id'=>'12')),
            array('label'=>'SubItem2', 'url'=>array('site/anot','id'=>'13')),
        )
            
            
            ),
        array('label'=>'Event', 'url'=>array('/company/careers'),
                 
            'submenuOptions'=>array('class'=>'nav-sub'),'items'=>array(
            array('label'=>'SubItem1', 'url'=>array('site/anot','id'=>'12')),
            array('label'=>'SubItem2', 'url'=>array('site/anot','id'=>'13')),
      
            )),
        array('label'=>'Travels', 'url'=>array('/company/contactUs')),
        array('label'=>'Hospital', 'url'=>array('/company/storeLocator')),
        array('label'=>'Real Estate', 'url'=>array('/company/storeLocator')),
        array('label'=>'Advertise', 'url'=>array('/company/storeLocator')),
        array('label'=>'Contact', 'url'=>array('/site/contact')),
      ),
        'htmlOptions'=>array('class'=>'nav-main'),
));
*/

	$this->widget('zii.widgets.CMenu',array(
	'items'=>array(
		array('label'=>'Industries', 'url'=>array('/Industries/admin'),'visible'=>showMenu()),
		array('label'=>'Companies', 'url'=>array('/Companies/admin'),'visible'=>showMenu()),
		array('label'=>'Suppliers', 'url'=>array('/Suppliers/admin'),'visible'=>showMenu()),
		array('label'=>'User Roles', 'url'=>array('/Roles/admin'),'visible'=>showMenu()),
		array('label'=>'Users', 'url'=>array('/Users/admin'),'visible'=>showMenu()),
		array('label'=>'Car Make', 'url'=>array('/CarMake/admin'),'visible'=>showMenu()),
		array('label'=>'Car Models', 'url'=>array('/CarModels/admin'),'visible'=>showMenu()),
		array('label'=>'Body Types', 'url'=>array('/BodyType/admin'),'visible'=>showMenu()),
		array('label'=>'Engines', 'url'=>array('/Engines/admin'),'visible'=>showMenu()),
		array('label'=>'Tyres', 'url'=>array('/Tyres/admin'),'visible'=>showMenu()),
		array('label'=>'Car Years', 'url'=>array('/CarYears/admin'),'visible'=>showMenu()),
		array('label'=>'Cars', 'url'=>array('/Cars/admin'),'visible'=>showMenu()),
		array('label'=>'Systems', 'url'=>array('/System/admin'),'visible'=>showMenu()),
		array('label'=>'Sub Systems', 'url'=>array('/SubSystem/admin'),'visible'=>showMenu()),
		array('label'=>'Spares', 'url'=>array('/Spare/admin'),'visible'=>showMenu()),
		array('label'=>'Change Password', 'url'=>array('/site/Changepassword'), 'visible'=>showChangePasswordMenu()),
		array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>showLoginMenu()),
		array('label'=>'Logout ('.$LOGGED_IN_USER_NAMES.')', 'url'=>array('/site/logout'), 'visible'=>showMenu()),
	),
	));
	
}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_user'){
	$this->widget('zii.widgets.CMenu',array(
	'items'=>array(
	array('label'=>'Users', 'url'=>array('/Users/admin'),'visible'=>showMenu()),
	array('label'=>'Change Password', 'url'=>array('/site/Changepassword'), 'visible'=>showChangePasswordMenu()),
	array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>showLoginMenu()),
	array('label'=>'Logout ('.$LOGGED_IN_USER_NAMES.')', 'url'=>array('/site/logout'), 'visible'=>showMenu()),
	),
	)); 
}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='Driver'){
	$logged_in_title="(Driver) ";
	$this->widget('zii.widgets.CMenu',array(
	'items'=>array(
	array('label'=>'Service Request', 'url'=>array('/Requests/service'),'visible'=>showMenu()),
	array('label'=>'Repair Request', 'url'=>array('/Requests/repair'),'visible'=>showMenu()),
	array('label'=>'Fuel Request', 'url'=>array('/Requests/fuel'),'visible'=>showMenu()),
	array('label'=>'Change Password', 'url'=>array('/site/Changepassword'), 'visible'=>showChangePasswordMenu()),
	array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>isset($LOGGED_IN_USER_NAMES)? 0:showLoginMenu()),
	array('label'=>'Logout ('.$logged_in_title.$LOGGED_IN_USER_NAMES.')', 'url'=>array('/site/logout'), 'visible'=>showMenu()),
	),
	)); 	
}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='TM'){
	$logged_in_title="(Transport Manger) ";
	$this->widget('zii.widgets.CMenu',array(
	'items'=>array(
	array('label'=>'Cars', 'url'=>array('/Cars/admin'),'visible'=>showMenu()),
	array('label'=>'Cars Assignment', 'url'=>array('/CarAssignment/admin'),'visible'=>showMenu()),
	array('label'=>'Suppliers', 'url'=>array('/Suppliers/admin'),'visible'=>showMenu()),
	array('label'=>'Service Request', 'url'=>array('/Requests/service'),'visible'=>showMenu()),
	array('label'=>'Repair Request', 'url'=>array('/Requests/repair'),'visible'=>showMenu()),
	array('label'=>'Fuel Request', 'url'=>array('/Requests/fuel'),'visible'=>showMenu()),
	array('label'=>'Maintainance Report', 'url'=>array('/Bookings/admin'),'visible'=>showMenu()),
	array('label'=>'Change Password', 'url'=>array('/site/Changepassword'), 'visible'=>showChangePasswordMenu()),
	array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>isset($LOGGED_IN_USER_NAMES)? 0:showLoginMenu()),
	array('label'=>'Logout ('.$logged_in_title.$LOGGED_IN_USER_NAMES.')', 'url'=>array('/site/logout'), 'visible'=>showMenu()),
	),
	)); 	
}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='supplier'){
	$this->widget('zii.widgets.CMenu',array(
	'items'=>array(
	array('label'=>'Dealers In', 'url'=>array('/SupplierSystems/admin'),'visible'=>showMenu()),
	array('label'=>'Job Card', 'url'=>array('/Bookings/admin'),'visible'=>showMenu()),
	array('label'=>'Change Password', 'url'=>array('/site/Changepassword'), 'visible'=>showChangePasswordMenu()),
	array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>showLoginMenu()),
	array('label'=>'Logout ('.$LOGGED_IN_USER_NAMES.')', 'url'=>array('/site/logout'), 'visible'=>showMenu()),
	),
	)); 	
}



else{
	$this->widget('zii.widgets.CMenu',array(
	'items'=>array(
	array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>1),
	),
	)); 
}
?>
</div>


	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> <?php echo CHtml::encode(Yii::app()->name); ?> Admin.<br/>
		All Rights Reserved.
		
		
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
  <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/formValidations.js');?>