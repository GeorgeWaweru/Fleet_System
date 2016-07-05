<?php
/* @var $this BookingsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bookings',
);

$this->menu=array(
	array('label'=>'Create Bookings', 'url'=>array('create')),
	array('label'=>'Manage Bookings', 'url'=>array('admin')),
);
?>

<h1>Bookings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
