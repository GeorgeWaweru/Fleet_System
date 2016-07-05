<?php
/* @var $this CarAssignmentController */
/* @var $model CarAssignment */

$this->breadcrumbs=array(
	'Car Assignments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CarAssignment', 'url'=>array('index')),
	array('label'=>'Create CarAssignment', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#car-assignment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Car Assignments</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'car-assignment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'car_id',
		'user_id',
		'company_id',
		'spare_tire',
		'fire_extinguisher',
		/*
		'jerk',
		'wheel_spanner',
		'physical_damages',
		'no_physical_damages',
		'mechanical_issues',
		'no_mechanical_issues',
		'created_at',
		'email_sent',
		'deleted_status',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
