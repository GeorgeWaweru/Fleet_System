<?php
/* @var $this SystemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Systems',
);

$this->menu=array(
	array('label'=>'Create System', 'url'=>array('create')),
	array('label'=>'Manage System', 'url'=>array('admin')),
);
?>

<h1>Systems</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
