
    <div id='<?php echo $this->class2id($this->modelClass); ?>-create-modal' class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>Create <?php echo $this->class2id($this->modelClass); ?></h3>
    </div>
    
    <div class="modal-body">
    
    <div class="form">

   <?php echo "<?php\n"; ?>
   
         $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-create-form',
	'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'method'=>'post',
        'action'=>array("<?php echo $this->class2id($this->modelClass); ?>/create"),
	'type'=>'horizontal',
	'htmlOptions'=>array(
	                        'onsubmit'=>"return false;",/* Disable normal form submit */
                            ),
          'clientOptions'=>array(
                    'validateOnType'=>true,
                    'validateOnSubmit'=>true,
                    'afterValidate'=>'js:function(form, data, hasError) {
                                     if (!hasError)
                                        {    
                                          create();
                                        }
                                     }'
                                    

            ),                  
  
)); ?>
     	<fieldset>
		<legend>
			<p class="note">Fields with <span class="required">*</span> are required.</p>
		</legend>

	<?php echo "<?php";?> echo $form->errorSummary($model,'Opps!!!', null,array('class'=>'alert alert-error span12')); ?>
        		
   <div class="control-group">		
			<div class="span4">
			
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

		<?php echo "<?php\n"; ?>
		
		 $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
                        'icon'=>'ok white', 
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
			)
			
		);
		
		?>
              <?php echo "<?php\n"; ?> $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'reset',
                        'icon'=>'remove',  
			'label'=>'Reset',
		)); ?>
	</div> 
   </div><!--end modal footer-->	
</fieldset>

<?php echo "<?php\n"; ?> $this->endWidget(); ?>

</div>

</div><!--end modal-->

<script type="text/javascript">
function create()
 {
 
   var data=$("#<?php echo $this->class2id($this->modelClass); ?>-create-form").serialize();
     


  jQuery.ajax({
   type: 'POST',
    url: '<?php echo "<?php\n"; ?> echo Yii::app()->createAbsoluteUrl("<?php echo $this->class2id($this->modelClass); ?>/create"); ?>',
   data:data,
success:function(data){
                //alert("succes:"+data); 
                if(data!="false")
                 {
                  $('#<?php echo $this->class2id($this->modelClass); ?>-create-modal').modal('hide');
                  renderView(data);
                    $.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
                     
                         });
                   
                 }
                 
              },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
         alert(data);
    },

  dataType:'html'
  });

}

function renderCreateForm()
{
  $('#<?php echo $this->class2id($this->modelClass); ?>-create-form').each (function(){
  this.reset();
   });

  
  $('#<?php echo $this->class2id($this->modelClass); ?>-view-modal').modal('hide');
  
  $('#<?php echo $this->class2id($this->modelClass); ?>-create-modal').modal({
   show:true,
   
  });
}

</script>
