<?php
/* @var $this BookingCommentsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Booking Comments',
);

$this->menu=array(
	array('label'=>'Create BookingComments', 'url'=>array('create')),
	array('label'=>'Manage BookingComments', 'url'=>array('admin')),
);
?>

<h1>Booking Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
