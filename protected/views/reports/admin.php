<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php
/* @var $this ReportsController */
/* @var $model Votes */

$this->breadcrumbs=array(
	'Votes'=>array('admin'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Votes', 'url'=>array('index')),
	//array('label'=>'Create Votes', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#votes-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3><b>Reports</b></h3>
<a href="javascript:void(0)" onClick="getReport('votes')"><b>Votes Report</b></a><br><br>
<a href="javascript:void(0)" onClick="getReport('questions')"><b>Candidate Responces Report</b></a><br>


<script language="javascript" type="application/javascript">
function getReport(report)
{
	$.ajax({ 
	url: "<?php echo Yii::app()->controller->createUrl('GetReport');?>",
	type: "POST",
	dataType: "html",
	data: {'report' : report},
	beforeSend: function(){
		//$("#constituency_preloader_div").show();
	}
	}).done(function(html){
		alert(html);
	});	
}

</script>



