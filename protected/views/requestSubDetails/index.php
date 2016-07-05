<?php
/* @var $this RequestSubDetailsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Request Sub Details',
);

$this->menu=array(
	array('label'=>'Create RequestSubDetails', 'url'=>array('create')),
	array('label'=>'Manage RequestSubDetails', 'url'=>array('admin')),
);
?>

<h1>Request Sub Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
