<?php
$this->breadcrumbs=array(
	'Car Mechanical Issues'=>array('admin'),
	'Manage',
);

function showAdminColumn()
{
	$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
	if($LOGGED_IN_USER_KIND=='admin_user'){
		return 1;
	}else{
		return 0;
	}
}

function hideAdminColumn()
{
	$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
	if($LOGGED_IN_USER_KIND=='admin_user'){
		return 0;
	}else{
		return 1;
	}
}


if(hideAdminColumn()==1){
$this->menu=array(
	array('label'=>'Add Car Mechanical Issues', 'url'=>array('create')),
	array('label'=>'Back To Cars', 'url'=>array('Cars/admin')),
);
}


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#car-mechanical-issues-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Car Mechanical Issues</h3>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'car-mechanical-issues-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
	
		array(
		'header' => "Car",
		'value'=>'$data->car->number_plate',
		'htmlOptions'=>array('width'=>'80px'),
		),
		
		array(
		'header' => "Company",
		'value'=>'$data->company->title',
		'htmlOptions'=>array('width'=>'80px'),
		'visible'=>showAdminColumn(),
		),
		
		array(
		'header' => "Photo",
		'value'=>'$data->DisplayBanner($data->photo)',
		'htmlOptions'=>array('width'=>'50px'),
		),
		
		
		array(
		'header' => "Description",
		'value'=>'$data->description',
		'htmlOptions'=>array('width'=>'300px'),
		),
		
	
		array(
		'header' => 'Status',
		'value'=>'$data->Status($data->status)',
		'htmlOptions'=>array('width'=>'60px'),
		),
		
		array(
		'header' => 'Edit / Delete',
		'value'=>'$data->deleteRecord($data->id)',
		'htmlOptions'=>array('width'=>'100px'),
		),
	),
));
?>
<input type="hidden" name="delete_record_id" id="delete_record_id">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui.min.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.easy-confirm-dialog.js');?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css" />
<script language="javascript" type="text/javascript">
highlightMenu('Cars');
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
		adminDeleteRecord('CarMechanicalIssues',delete_record_id,'car-mechanical-issues-grid');
		$("#delete_record_id").val('');
	}
});
});
</script>
