<?php
/* @var $this ReportsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Votes',
);

$this->menu=array(
	array('label'=>'Create Votes', 'url'=>array('create')),
	array('label'=>'Manage Votes', 'url'=>array('admin')),
);
?>

<h1>Votes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
