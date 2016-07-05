<?php
ini_set('max_execution_time', 12000);
$this->breadcrumbs=array(
	'Cars'=>array('admin'),
	'Manage',
);

function showAdminColumn()
{
	$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
	$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
	$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
	if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
		return 1;
	}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='TM'){
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
	}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='TM'){
		return 1;
	}
}

if(hideAdminColumn()==1){
	$this->menu=array(
		array('label'=>'Add Car', 'url'=>array('create')),
		array('label'=>'View all Physical Damages', 'url'=>array('CarPhysicalDamages/admin')),
		array('label'=>'View all Mechanical Issues', 'url'=>array('CarMechanicalIssues/admin')),
	);
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cars-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Cars</h3>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<br><br><br>
<div class="export_add_wrapper">
<a class="export_link" href="<?php echo Yii::app()->controller->createUrl('ExportExcell');?>" target="_blank">Export Excell</a>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cars-grid',
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
		'htmlOptions'=>array('width'=>'80px'),
		'visible'=>showAdminColumn(),
		),

		array(
			'header' => 'Registration Number',
			'value'=>'$data->number_plate',
			'htmlOptions'=>array('width'=>'120px'),
		),
	
		array(
			'header' => 'Date Added',
			'value'=>'$data->DateFormart($data->created_at)',
			'htmlOptions'=>array('width'=>'200px'),
		),
		
		array(
		'header' => 'Car Photo',
		'value'=>'$data->DisplayBanner($data->photo)',
		'htmlOptions'=>array('width'=>'50px'),
		),
		
		
		array(
		'header' => 'Car Make',
		'value'=>'$data->make->title',
		'htmlOptions'=>array('width'=>'80px'),
		),
		
		array(
		'header' => 'Car Model',
		'value'=>'$data->model->title',
		'htmlOptions'=>array('width'=>'80px'),
		),
		
		array(
		'header' => 'Body Type',
		'value'=>'$data->bodyType->title',
		'htmlOptions'=>array('width'=>'100px'),
		),

		array(
		'header' => 'Physical Damages',
		'value'=>'$data->physicalDamages($data->id,$data->no_physical_damages)',
		'htmlOptions'=>array('width'=>'120px'),
		'visible'=>hideAdminColumn(),
		),
		
		array(
		'header' => 'Mechanical Issues',
		'value'=>'$data->MechanicalIssues($data->id,$data->no_mechanical_issues)',
		'htmlOptions'=>array('width'=>'120px'),
		'visible'=>hideAdminColumn(),
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
		'value'=>'$data->deleteRecord($data->id)',
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
		adminDeleteRecord('Cars',delete_record_id,'cars-grid');
		$("#delete_record_id").val('');
	}
});
});


function defaultModels()
{
	$('option', '#Cars_model_id').remove();
	default_values = { " ": "--Select Car Model--"};
	$.each(default_values, function(key, value) {   
			$('#Cars_model_id')
			.append($('<option>', { value : key })
			.text(value)); 
			});
}


function getModels(obj)
{
	defaultModels();
	var value=parseInt(obj.options[obj.selectedIndex].value);
	var text=obj.options[obj.selectedIndex].text;
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('getModels');?>",
	type: "POST",
	dataType: "html",
	data: {'make_id' : value},
	beforeSend: function(){
		$("#car_model_preloader_div").show();
	}
	}).done(function(html){
		var selectValues=jQuery.parseJSON(html);
		if (jQuery.isEmptyObject(selectValues))
		{
			$("#car_model_preloader_div").fadeOut(200,function(){
			$('#Cars_model_id').prop("disabled", true);
			});	
		}else{
			$.each(selectValues, function(key, value) {   
			$('#Cars_model_id')
			.append($('<option>', { value : key })
			.text(value)); 
				$("#car_model_preloader_div").fadeOut(200,function(){
					$('#Cars_model_id').prop("disabled", false);
				});	
			});	
		}	
	});	
}
</script>
