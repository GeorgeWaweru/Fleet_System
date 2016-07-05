<?php
/* @var $this CompanySuppliersController */
/* @var $model CompanySuppliers */

$this->breadcrumbs=array(
	'Company Suppliers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CompanySuppliers', 'url'=>array('index')),
	array('label'=>'Create CompanySuppliers', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#company-suppliers-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Company Suppliers</h3>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'company-suppliers-grid',
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
		
		

		'supplier_id',
		'company_id',
		'created_at',
		'status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
