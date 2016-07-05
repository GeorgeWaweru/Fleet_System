<?php

$this->breadcrumbs=array(
	'Car Assignments'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Add Car Assignment', 'url'=>array('create')),
	array('label'=>'Physical Damages', 'url'=>array('CarAssignPhysicalDamages/admin')),
	array('label'=>'Mechanical Issues', 'url'=>array('CarAssignMechanicalIssues/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#car-assignment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Car Assignment</h3>

<?php
/*$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
echo"The kidn of user is ".$LOGGED_IN_USER_KIND." Role is ".$COMPANY_SUB_USER_ROLE;	*/	
?>

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
	'id'=>'car-assignment-grid',
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
		'header' => 'Car',
		'value'=>'$data->carNarative($data->car_id)',
		'htmlOptions'=>array('width'=>'180px'),
		),
		
		array(
			'header' => 'Date Added',
			'value'=>'$data->DateFormart($data->created_at)',
			'htmlOptions'=>array('width'=>'200px'),
		),
		
		array(
		'header' => 'Driver',
		'value'=>'$data->UserNames($data->user->first_name,$data->user->last_name)',
		'htmlOptions'=>array('width'=>'120px'),
		),
		
		array(
		'header' => 'Physical Damages',
		'value'=>'$data->physicalDamages($data->id,$data->no_physical_damages)',
		'htmlOptions'=>array('width'=>'120px'),
		),
		
		array(
		'header' => 'Mechanical Issues',
		'value'=>'$data->MechanicalIssues($data->id,$data->no_mechanical_issues)',
		'htmlOptions'=>array('width'=>'120px'),
		),
		
		
		/*array(
		'header' => 'Disassign Car',
		'value'=>'$data->SendEmail($data->email_sent,$data->id)',
		'htmlOptions'=>array('width'=>'100px'),
		),*/
		
		
		
		array(
		'header' => 'Send Email',
		'value'=>'$data->SendEmail($data->email_sent,$data->id)',
		'htmlOptions'=>array('width'=>'80px'),
		),
		
		array(
		'header' => 'Export to excell',
		'value'=>'$data->ExportData($data->id)',
		'htmlOptions'=>array('width'=>'100px'),
		),
		
		
		array(
		'header' => 'Status',
		'value'=>'$data->Status($data->status)',
		'htmlOptions'=>array('width'=>'60px'),
		),
		
		array(
		'header' => 'Edit / Delete',
		'value'=>'$data->deleteRecord($data->id,$data->car_id)',
		'htmlOptions'=>array('width'=>'100px'),
		),
	),
));
?>
<input type="hidden" name="delete_record_id" id="delete_record_id">
<input type="hidden" name="car_id" id="car_id">


<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui.min.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.easy-confirm-dialog.js');?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css" />
<script language="javascript" type="text/javascript">
highlightMenu('Cars Assignment');
$(".delete_confirm").click(function() {
	var id=$(this).attr('id');
	var parts = id.split("#",2);
	$("#delete_record_id").val(parts[0]);
	$("#car_id").val(parts[1]);
});
$(document).ready(function() {
$(".delete_confirm").easyconfirm({locale: { title: 'Select Yes or No', button: ['No','Yes']}});
$(".ui-dialog-buttonpane .ui-state-default").click(function() {
	var box_text=$(this).text();
	var delete_record_id=$("#delete_record_id").val();
	var car_id=$("#car_id").val();
	if(box_text=="Yes"){
	
	var controller='CarAssignment';
	var delete_id=delete_record_id;
	var car_id=car_id;
		
	var path="index.php?r="+controller+"/delete&id="+delete_id+"&car_id="+car_id					
		$.ajax({ 
		url: path,
		type: "POST"
		}).done(function(html){
			$('#car-assignment-grid').yiiGridView('update', {
			data: $(this).serialize()
			});
		});	
		$("#delete_record_id").val('');
		$("#car_id").val('');
	}
});
});

function sendEmail(id)
{
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('sendEdm');?>",
	type: "POST",
	data: {'id' : id},
	beforeSend: function(){
		
	}
	}).done(function(html){
	});			
}
</script>
