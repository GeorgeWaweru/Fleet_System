<?php echo "<?php"; ?>  
 $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'type'=>'primary',
                        'icon'=>'plus white', 
			'label'=>'Create',
			'htmlOptions'=>array('onclick'=>'renderCreateForm();'),
		));
		echo " ";
                $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'type'=>'primary',
                        'icon'=>'edit white', 
			'label'=>'Update',
			'htmlOptions'=>array('onclick'=>'renderUpdateForm('.$model-><?php echo $this->tableSchema->primaryKey; ?>.');'),
		));
		
		
		echo " ";
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'type'=>'primary',
                        'icon'=>'trash white', 
			'label'=>'Delete',
			'htmlOptions'=>array('onclick'=>'delete_record('.$model-><?php echo $this->tableSchema->primaryKey; ?>.');'),
		));
		
		echo " ";
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'button',
			'type'=>'primary',
                        'icon'=>'print white', 
			'label'=>'Print',
			'htmlOptions'=>array('onclick'=>'print();'),
		));
		
		 echo "<div class='printableArea'>";
	         echo "<h1>View <?php echo $this->class2id($this->modelClass); ?> #".$model-><?php echo $this->tableSchema->primaryKey; ?>."</h1><hr />";
	         
	         $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				<?php
				foreach($this->tableSchema->columns as $column)
					echo "\t\t'".$column->name."',\n";
				?>
			),
		));
	         echo "</div>";