<?php
/* @var $this RequestCommentsController */
/* @var $model RequestComments */

$this->breadcrumbs=array(
	'Request Comments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List RequestComments', 'url'=>array('index')),
	array('label'=>'Create RequestComments', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#request-comments-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Request Comments</h3>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'request-comments-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
		
		array(
		'name' => 'check',
		'id' => 'selectedIds',
		'value' => '$data->id',
		'class' => 'CCheckBoxColumn',
		'selectableRows' => '2',
		),
		
		
		'request_id',
		'user_id',
		'no_photo',
		'photo',
		'description',
		/*
		'no_description',
		'created_at',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
