<?php
$this->breadcrumbs=array(
	'Requests'=>array('index'),
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

$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : "";
$this->menu=array(
	array('label'=>'Add Service Request', 'url'=>array('ServiceCreate')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#requests-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
?>

<h3>Manage Service Requests</h3>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_services_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<br><br><br>
<div class="export_add_wrapper">
<a class="export_link" href="<?php echo Yii::app()->controller->createUrl('ExportExcell',array('type'=>'service'));?>" target="_blank">Export Excell</a>
</div>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'requests-grid',
	'dataProvider'=>$model->search('service',$COMPANY_SUB_USER_ROLE,$LOGGED_IN_USER_ID),
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
		'header' => 'Request Narative',
		'value'=>'$data->requestNarative($data->car_id,$data->on_behalf,$data->user_id,$data->request_raised_user_id)',
		'htmlOptions'=>array('width'=>'220px'),
		),	
		
		array(
			'header' => 'Date Added',
			'value'=>'$data->DateFormart($data->created_at)',
			'htmlOptions'=>array('width'=>'200px'),
		),

		array(
		'header' => 'user',
		'value'=>'$data->requestUser($data->user->first_name,$data->user->last_name)',
		'htmlOptions'=>array('width'=>'80px'),
		'visible'=>showAdminColumn(),
		),	
		
		array(
		'header' => 'Registration Number',
		'value'=>'$data->car->number_plate',
		'htmlOptions'=>array('width'=>'160px'),
		),	
		
		array(
		'header' => 'Company',
		'value'=>'$data->user->company->title',
		'htmlOptions'=>array('width'=>'80px'),
		'visible'=>showAdminColumn(),
		),	
		
		array(
		'header' => 'System',
		'value'=>'$data->system->title',
		'htmlOptions'=>array('width'=>'160px'),
		),
		
		array(
		'header' => 'Sub System',
		'value'=>'$data->subsystem->title',
		'htmlOptions'=>array('width'=>'160px'),
		),	
		
		array(
		'header' => 'Description',
		'value'=>'$data->description',
		'htmlOptions'=>array('width'=>'150px'),
		),
	
		
		array(
		'header' => 'Request Details',
		'value'=>'$data->RequestSubDetails($data->id,$data->no_description,"service")',
		'htmlOptions'=>array('width'=>'120px'),
		'visible'=>hideAdminColumn(),
		),
		
		
		array(
		'header' => 'Send Email',
		'value'=>'$data->SendEmail($data->email_sent,$data->id)',
		'htmlOptions'=>array('width'=>'80px'),
		),
		
		
		array(
		'header' => 'Export',
		'value'=>'$data->ExportData($data->id,service)',
		'htmlOptions'=>array('width'=>'20px'),
		),
		
		array(
		'header' => 'Job Card',
		'value'=>'$data->BookCar($data->id,service)',
		'htmlOptions'=>array('width'=>'80px'),
		'visible'=>($COMPANY_SUB_USER_ROLE=='TM' ? 1 : 0),
		),
		

		
		
		array(
		'header' => 'Status',
		'value'=>'$data->Status($data->status)',
		'htmlOptions'=>array('width'=>'60px'),
		),
	
		
		array(
		'header' => 'Edit / Delete',
		'value'=>'$data->deleteRecord($data->id,"service")',
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
highlightMenu('Service Request');

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
		adminDeleteRecord('Requests',delete_record_id,'requests-grid');
		$("#delete_record_id").val('');
	}
});
});

//$('#Requests_subsystem_id').prop("disabled", true);
function defaultModels()
{
	$('option', '#Requests_subsystem_id').remove();
	default_values = { "0": "--Select Sub System--"};
	$.each(default_values, function(key, value) {   
			$('#Requests_subsystem_id')
			.append($('<option>', { value : key })
			.text(value)); 
			});
}

function getSubSystem(obj)
{
	defaultModels();
	var value=parseInt(obj.options[obj.selectedIndex].value);
	var text=obj.options[obj.selectedIndex].text;
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('getSubSystem');?>",
	type: "POST",
	dataType: "html",
	data: {'system_id' : value},
	beforeSend: function(){
		$("#sub_system_preloader_div").show();
	}
	}).done(function(html){
		var selectValues=jQuery.parseJSON(html);
		if (jQuery.isEmptyObject(selectValues))
		{
			$("#sub_system_preloader_div").fadeOut(200,function(){
			$('#Requests_subsystem_id').prop("disabled", true);
			});	
		}else{
			$.each(selectValues, function(key, value) {   
			$('#Requests_subsystem_id')
			.append($('<option>', { value : key })
			.text(value)); 
				$("#sub_system_preloader_div").fadeOut(200,function(){
					$('#Requests_subsystem_id').prop("disabled", false);
				});	
			});	
		}	
	});	
}


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

