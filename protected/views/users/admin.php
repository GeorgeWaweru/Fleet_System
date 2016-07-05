<?php
$this->breadcrumbs=array(
	'Drivers'=>array('admin'),
	'Manage',
);


function showAdminColumn()
{
	$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
	$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
	$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
	if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
		return 1;
	}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_user'){
		return 0;
	}else{
		return 0;
	}
}

function hideAdminColumn()
{
	$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
	$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
	$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
	if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
		return 0;
	}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_user'){
		return 1;
	}
}


$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";

if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_user'){
	$this->menu=array(
		array('label'=>'Add User', 'url'=>array('create')),
	);
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#drivers-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Drivers</h3>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="export_add_wrapper">
<a class="export_link" href="<?php echo Yii::app()->controller->createUrl('ExportExcell');?>" target="_blank">Export Excell</a>
</div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'drivers-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
	
		/*array(
		'name' => 'check',
		'id' => 'selectedIds',
		'value' => '$data->id',
		'class' => 'CCheckBoxColumn',
		'selectableRows' => '2',
		),*/
	
		array(
		'header' => 'Company',
		'value'=>'$data->company->title',
		'htmlOptions'=>array('width'=>'100px'),
		'visible'=>showAdminColumn(),
		),
		
		
		array(
		'header' => "User's Photo",
		'value'=>'$data->DisplayBanner($data->photo,$data->first_name,$data->last_name)',
		'htmlOptions'=>array('width'=>'50px'),
		),
		
		array(
		'header' => 'Role',
		'value'=>'$data->role->title',
		'htmlOptions'=>array('width'=>'80px'),
		),
	
		array(
		'header' => 'First Name',
		'value'=>'$data->first_name',
		'htmlOptions'=>array('width'=>'150px'),
		),
		
		
		array(
		'header' => 'Last Name',
		'value'=>'$data->last_name',
		'htmlOptions'=>array('width'=>'150px'),
		),
		
		array(
		'header' => 'Email',
		'value'=>'$data->email',
		'htmlOptions'=>array('width'=>'100px'),
		),
		
		array(
		'header' => 'Phone No.',
		'value'=>'$data->phone_number',
		'htmlOptions'=>array('width'=>'80px'),
		),
		
		array(
		'header' => 'Car',
		'value'=>'$data->car->number_plate',
		'htmlOptions'=>array('width'=>'150px'),
		),
		

		
		array(
		'header' => 'Password',
		'value'=>'$data->raw_password',
		'htmlOptions'=>array('width'=>'80px'),
		),
		
		
		array(
		'header' => 'Status',
		'value'=>'$data->Status($data->status)',
		'htmlOptions'=>array('width'=>'60px'),
		),
		
		array(
		'header' => 'Edit / Delete',
		'value'=>'$data->deleteRecord($data->id,$data->photo,$data->dl_photo)',
		'htmlOptions'=>array('width'=>'100px'),
		'visible'=>hideAdminColumn(),
		),
	),
));
?>
<input type="hidden" name="delete_record_id" id="delete_record_id">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui.min.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.easy-confirm-dialog.js');?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css" />
<script language="javascript" type="text/javascript">
highlightMenu('Users');
$(".delete_confirm").click(function() {
	var id=$(this).attr('id');
	$("#delete_record_id").val(id);
});
$(document).ready(function() {
$(".delete_confirm").easyconfirm({locale: { title: 'Select Yes or No', button: ['No','Yes']}});
$(".ui-dialog-buttonpane .ui-state-default").click(function() {
	var box_text=$(this).text();
	var delete_record_id=$("#delete_record_id").val();
	if(box_text=="Yes"){
		adminDeleteRecord('Users',delete_record_id,'drivers-grid');
		$("#delete_record_id").val('');
	}
});
});
</script>
