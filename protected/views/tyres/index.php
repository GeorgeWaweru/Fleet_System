<?php
/* @var $this TyresController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tyres',
);

$this->menu=array(
	array('label'=>'Create Tyres', 'url'=>array('create')),
	array('label'=>'Manage Tyres', 'url'=>array('admin')),
);
?>

<h1>Tyres</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
