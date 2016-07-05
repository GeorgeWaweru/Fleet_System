<?php
/* @var $this EnginesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Engines',
);

$this->menu=array(
	array('label'=>'Create Engines', 'url'=>array('create')),
	array('label'=>'Manage Engines', 'url'=>array('admin')),
);
?>

<h1>Engines</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
