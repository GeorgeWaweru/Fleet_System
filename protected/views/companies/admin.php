<?php
/* @var $this CompaniesController */
/* @var $model Companies */

$this->breadcrumbs=array(
	'Companies'=>array('admin'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Companies', 'url'=>array('index')),
	array('label'=>'Add Company', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#companies-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Companies</h3>

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
	'id'=>'companies-grid',
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
		'header' => 'Industry',
		'value'=>'$data->industry->title',
		'htmlOptions'=>array('width'=>'80px'),
		),
		
		array(
		'header' => 'Company Name',
		'value'=>'$data->title',
		'htmlOptions'=>array('width'=>'120px'),
		),
		
		array(
		'header' => "Logo",
		'value'=>'$data->DisplayBanner($data->photo,$data->photo)',
		'htmlOptions'=>array('width'=>'50px'),
		),
				
		array(
		'header' => 'Contact Person',
		'value'=>'$data->contact_person',
		'htmlOptions'=>array('width'=>'120px'),
		),
		
		array(
		'header' => 'Email',
		'value'=>'$data->email',
		'htmlOptions'=>array('width'=>'100px'),
		),
		
		array(
		'header' => 'Phone. No.',
		'value'=>'$data->phone_number',
		'htmlOptions'=>array('width'=>'100px'),
		),
		
		array(
		'header' => 'Location',
		'value'=>'$data->location',
		'htmlOptions'=>array('width'=>'100px'),
		),
		
	/*	array(
		'header' => 'No. of Employees',
		'value'=>'$data->no_employees',
		'htmlOptions'=>array('width'=>'100px'),
		),*/
		
		array(
		'header' => 'Password',
		'value'=>'$data->raw_password',
		'htmlOptions'=>array('width'=>'100px'),
		),
		

		array(
		'header' => 'Status',
		'value'=>'$data->Status($data->status)',
		'htmlOptions'=>array('width'=>'60px'),
		),
		
		array(
		'header' => 'Edit / Delete',
		'value'=>'$data->deleteRecord($data->id,$this->grid->dataProvider->pagination->currentPage)',
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
highlightMenu('Companies');
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
		adminDeleteRecord('Companies',delete_record_id,'companies-grid');
		$("#delete_record_id").val('');
	}
});
});
</script>
