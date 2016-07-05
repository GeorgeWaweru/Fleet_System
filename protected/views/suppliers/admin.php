<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('admin'),
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
		array('label'=>'Add Supplier', 'url'=>array('create')),
	);
}


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#suppliers-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Suppliers</h3>


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
	'id'=>'suppliers-grid',
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
		'header' => "Supplier's Name",
		'value'=>'$data->title',
		'htmlOptions'=>array('width'=>'120px'),
		),
		
		array(
			'header' => 'Date Added',
			'value'=>'$data->DateFormart($data->created_at)',
			'htmlOptions'=>array('width'=>'200px'),
		),
		
		array(
		'header' => "Dealers In",
		'value'=>'$data->dealsIn($data->id)',
		'htmlOptions'=>array('width'=>'200px'),
		),
		
		array(
		'header' => "Registration No.",
		'value'=>'$data->reg_no',
		'htmlOptions'=>array('width'=>'120px'),
		),
		
		array(
		'header' => "Contact Person",
		'value'=>'$data->contact_person',
		'htmlOptions'=>array('width'=>'120px'),
		),
		
		
		array(
		'header' => "Associate Supplier",
		'value'=>'$data->associateSupplier($data->id)',
		'htmlOptions'=>array('width'=>'120px'),
		'visible'=>hideAdminColumn(),
		),
		
		
		array(
		'header' => "Email",
		'value'=>'$data->email',
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
highlightMenu('Suppliers');
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
		adminDeleteRecord('Suppliers',delete_record_id,'suppliers-grid');
		$("#delete_record_id").val('');
	}
});
});


function Associate(supplier_id,action)
{
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('associate'); ?>",
	type: "POST",
	data: {'supplier_id' : supplier_id,'action':action},
	beforeSend: function(){
		
	}
	}).done(function(html){
		$('#suppliers-grid').yiiGridView('update', {
			data: $(this).serialize()
		});	
	});
}
</script>
