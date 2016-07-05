<div id="<?php echo $this->class2id($this->modelClass); ?>-update-modal-container" >

</div>

<script type="text/javascript">
function update()
 {
  
   var data=$("#<?php echo $this->class2id($this->modelClass); ?>-update-form").serialize();

  $.ajax({
   type: 'POST',
    url: '<?php echo "<?php"; ?> echo Yii::app()->createAbsoluteUrl("<?php echo $this->class2id($this->modelClass); ?>/update"); ?>',
   data:data,
success:function(data){
                if(data!="false")
                 {
                  $('#<?php echo $this->class2id($this->modelClass); ?>-update-modal').modal('hide');
                  renderView(data);
                  $.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
                     
                         });
                 }
                 
              },
   error: function(data) { // if error occured
          alert(JSON.stringify(data)); 

    },

  dataType:'html'
  });

}

function renderUpdateForm(id)
{
 
   $('#<?php echo $this->class2id($this->modelClass); ?>-view-modal').modal('hide');
 var data="id="+id;

  $.ajax({
   type: 'POST',
    url: '<?php echo "<?php"; ?> echo Yii::app()->createAbsoluteUrl("<?php echo $this->class2id($this->modelClass); ?>/update"); ?>',
   data:data,
success:function(data){
                 // alert("succes:"+data); 
                 $('#<?php echo $this->class2id($this->modelClass); ?>-update-modal-container').html(data); 
                 $('#<?php echo $this->class2id($this->modelClass); ?>-update-modal').modal('show');
              },
   error: function(data) { // if error occured
           alert(JSON.stringify(data)); 
         alert("Error occured.please try again");
    },

  dataType:'html'
  });

}
</script>
