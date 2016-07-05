<?php
/* @var $this CarsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cars',
);

$this->menu=array(
	array('label'=>'Create Cars', 'url'=>array('create')),
	array('label'=>'Manage Cars', 'url'=>array('admin')),
);
?>

<h1>Cars</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
