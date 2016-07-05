<?php
$this->breadcrumbs=array(
	'Request Sub Details'=>array('admin'),
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

$type=isset($_REQUEST['type']) ? strtolower($_REQUEST['type']) :"";
if($type=='service'){
	$menu='Service Request';
	$text='Service';
}if($type=='repair'){
	$menu='Repair Request';
	$text='Repair';
}if($type=='fuel'){
	$menu='Fuel Request';
	$text='Fuel';
}


$this->menu=array(
	array('label'=>'Add Request Details', 'url'=>array('create','type'=>$type)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#request-sub-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");


?>
<h3>Manage <?php echo $type; ?> Request Sub Details</h3>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'request-sub-details-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		
		array(
		'header' => 'Request Narrative',
		'value'=>'$data->requestNarative($data->request_id)',
		'htmlOptions'=>array('width'=>'450px'),
		),
		
		
		array(
		'header' => "Photo",
		'value'=>'$data->DisplayBanner($data->photo)',
		'htmlOptions'=>array('width'=>'50px'),
		),
		
		array(
		'header' => "Description",
		'value'=>'$data->description',
		'htmlOptions'=>array('width'=>'200px'),
		),
		
		array(
		'header' => 'Status',
		'value'=>'$data->Status($data->status)',
		'htmlOptions'=>array('width'=>'60px'),
		),
		
		array(
		'header' => 'Edit / Delete',
		'value'=>'$data->deleteRecord($data->id,$data->request->request_type)',
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
highlightMenu('<?php echo $menu;?>');
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
		adminDeleteRecord('RequestSubDetails',delete_record_id);
		$("#delete_record_id").val('');
	}
});
});
</script>
