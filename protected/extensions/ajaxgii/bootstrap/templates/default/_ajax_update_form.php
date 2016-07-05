    <div id='<?php echo $this->class2id($this->modelClass); ?>-update-modal' class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
   
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>Update <?php echo $this->class2id($this->modelClass); ?> #<?php echo "<?php"; ?> echo $model-><?php echo $this->tableSchema->primaryKey; ?>; ?></h3>
    </div>
    
    <div class="modal-body">
 
    
    
    <div class="form">
<?php echo "<?php"; ?> $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-update-form',
	'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'method'=>'post',
        'action'=>array("<?php echo $this->class2id($this->modelClass); ?>/update"),
	'type'=>'horizontal',
	'htmlOptions'=>array(
                               'onsubmit'=>"return false;",/* Disable normal form submit */
                               'onkeypress'=>" if(event.keyCode == 13){ update(); } " /* Do ajax call when user presses enter key */
                            ),               
	
)); ?>
     	<fieldset>
		<legend>
			<p class="note">Fields with <span class="required">*</span> are required.</p>
		</legend>

	<?php echo "<?php"; ?> echo $form->errorSummary($model,'Opps!!!', null,array('class'=>'alert alert-error span12')); ?>
        		
   <div class="control-group">		
			<div class="span4">
			
			<?php echo "<?php"; ?> echo $form->hiddenField($model,'<?php echo $this->tableSchema->primaryKey; ?>',array()); ?>
			
	               <?php
			  foreach($this->tableSchema->columns as $column)
			  {
				  if($column->autoIncrement)
					  continue;
			  ?>
				  <div class="row">
					  <?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
					  <?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
					  <?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
				  </div>

			  <?php
			  }
			?>

                        </div>   
  </div>

  </div><!--end modal body-->
  
  <div class="modal-footer">
	<div class="form-actions">

	                
		<?php echo "<?php"; ?>
		
		 $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			//'id'=>'sub2',
			'type'=>'primary',
                        'icon'=>'ok white', 
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
			'htmlOptions'=>array('onclick'=>'update();'),
		));
		
		?>
             
	</div> 
   </div><!--end modal footer-->	
</fieldset>

<?php echo "<?php"; ?> $this->endWidget(); ?>

</div>


</div><!--end modal-->



