<?php
error_reporting(0);
session_start();
class BookingsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	 
	public function EnableRoutes()
	{
		$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
		$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
		$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
		if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='TM'){
			return 1;
		}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='supplier'){
			return 2;
		}else{
			return 0;
		}	
	}

	public function accessRules()
	{
		$EnableRoutes=$this->EnableRoutes();
		if($EnableRoutes==1){
			return array(
			array('allow',
				'actions'=>array('create','update','admin','delete','ExportExcell','ExportData','Edm','getComments','getSubSystem','getSpares'),
				'users'=>array('*'),
			),
		);	
		}else if($EnableRoutes==2){
			return array(
			array('allow',
				'actions'=>array('create','update','admin','ExportExcell','ExportData','Edm','getComments','getSubSystem','getSpares'),
				'users'=>array('*'),
			),
			
			array('deny',
				'actions'=>array('delete'),
				'users'=>array('*'),
			),
		);	
		}else{
			return array(
			array('deny',
				//'actions'=>array('create','update','admin','delete','ExportExcell','ExportData','Edm','getComments','getSubSystem','getSpares'),
				'users'=>array('*'),
			),
		);

		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	 
	public function actiongetSubSystem()
	{
		$system_id=isset($_REQUEST['system_id']) ? intval($_REQUEST['system_id']) :0;
		$Data=SubSystem::model()->findAllByAttributes(array('system_id'=>$system_id,'status'=>1,'is_default'=>0));
		if(count($Data)>0)
		{	
			$data_array=array();
			foreach($Data as $item)
			{
			   $id= $item->id;
			   $title=$item->title;
			   $data_array[$id]=$title;
			}
			echo json_encode($data_array);
		}
	}
	
	public function actiongetSpares()
	{
		$sub_system_id=isset($_REQUEST['sub_system_id']) ? intval($_REQUEST['sub_system_id']) :0;
		$Data=Spare::model()->findAllByAttributes(array('sub_system_id'=>$sub_system_id,'status'=>1));
		if(count($Data)>0)
		{
			?>
            <table>
            <tr><td><b>Select Spare Parts</b></td></tr>
<?php
foreach($Data as $item)
{
?>
<tr>
<td>
<input type="checkbox" class="more_spare_parts_cks" id="more_spare_parts_cks_<?php echo $item->id;?>" onClick="enableMoreSpareCostField(<?php echo $item->id;?>)" name="more_spare_parts[]" value="<?php echo $item->id;?>"><?php echo $item->title;?>
<span class="cost_title">Cost (KSHs)</span>
<input type="text" class="more_cost_field_element" disabled name="more_spare_cost[]" id="more_spare_cost_<?php echo $item->id;?>">
<div class="spares_error_div" id="error_more_spare_cost_<?php echo $item->id;?>"></div>
</td>

<td>

<span class="photo_title">Photo</span>
<input type="file" class="more_spares_image_element" disabled name="more_spares_image[]" id="more_spares_image_<?php echo $item->id;?>"><br>
<div class="more_spares_image_error_div" id="more_error_spare_image_<?php echo $item->id;?>"></div>


</td>
</tr>
<?php
}
?>
           
            <tr><td>
             <div id="more_spares_listing_error"></div><br><br>
            
            </td></tr>
             <table>
             <script language="javascript" type="text/javascript">
			$(".more_spare_parts_cks").click(function(){
				var more_spare_parts_cks=$('.more_spare_parts_cks').is(':checked');
				if(more_spare_parts_cks==true)
				{
					$("#AddMoreSpares").show();
				}else{
					$("#AddMoreSpares").hide();
				}
			});
			 </script>
            <?php
		}
	}
	
	
	public function actiongetComments()
	{
		$model=new BookingComments;
		$booking_id=isset($_REQUEST['booking_id']) ? intval($_REQUEST['booking_id']) :0;
		$Data=BookingComments::model()->findAllByAttributes(array('booking_id'=>$booking_id));
		if(count($Data)>0)
		{
		?>
		<table>
		<tr><td><b>Comments</b></td></tr>
		<?php
		$counter=1;
		$counterGrand=0;
		$grandTotal=0;
		foreach($Data as $item)
		{
			$approval_status=$item->approval_status;
			$BookingSpares=BookingSpares::model()->findAllByAttributes(array('booking_comment_id'=>$item->id));
			$Suppliers=Suppliers::model()->findByPk($item->supplier_id);
			if($Suppliers->is_default==0){
				$commentor=$Suppliers->title. " (".$Suppliers->contact_person.")";
				$commentDate=BookingComments::model()->fomartDate($item->created_at);
			}else{
				$Users=Users::model()->findByPk($item->user_id);
				$Companies=Companies::model()->findByPk($Users->company_id);
				$Roles=Roles::model()->findByPk($Users->role_id);
				$commentor=$Companies->title." (".$Roles->title."-".$Users->first_name." ".$Users->last_name.")";
				$commentDate=BookingComments::model()->fomartDate($item->created_at);
			}
			?>
			<tr class="comment_<?php echo $approval_status; ?>">
			<td width="350">
            <?php
			if($approval_status!='Pending'){
				?>
                 <span class="approvalStatus"><?php echo $approval_status;?></span><br><br>
                <?php
			}
			?>
            <b><?php echo $counter; ?>)</b> <?php echo $item->comment;?>
            <?php
			$Suppliers=Suppliers::model()->findByPk($item->supplier_id);
			$Users=Users::model()->findByPk($item->user_id);
			if(($Suppliers->is_default==0 && intval($_SESSION['LOGGED_IN_USER_ID'])==intval($item->supplier_id)) || ($Users->is_default==0 && intval($_SESSION['LOGGED_IN_USER_ID'])==intval($item->user_id))){
				?>
                 <span class="deleteComment"><a href="javascript:void(0);" onClick="deleteComment(<?php echo $item->id;?>)">Delete</a></span>
                <?php
			}
			?>
            <br> 
            <span class="commentor">
            <i>
            <?php echo $commentor;?> on <?php echo $commentDate; ?>
            </i>
            </span>
            <?php
			if(count($BookingSpares)>0)
			{
				$counterGrand++;
				?>
                <table>
                <tr>
                <td><b>Spare Part</b></td>
                <td><b>Cost</b></td>
                <td><b>Photo</b></td>
                <td><b>Delete</b></td>
                </tr>
                <?php
				$innerCounter=1;
				$totalCost=0;
				foreach($BookingSpares as $BookingSpare)
				{
					$totalCost=$totalCost+=intval($BookingSpare->spare_cost);
					?>
                    <tr>
                    <td><?php echo $BookingSpare->spare->title;?></td>
                    <td><?php echo number_format($BookingSpare->spare_cost)?></td>
                    <?php
					if(!empty($BookingSpare->spare_photo))
					{
						?>
                        <td><?php echo CHtml::image(Yii::app()->request->baseUrl.'/bookingCommentsPhotos/'.$BookingSpare->spare_photo,"advert",array("width"=>100,"height"=>100,'class'=>'parent_form_elements')); ?> </td>
                        <?php
					}
					?>
                    <td><a href="javascript:void(0);" onClick="deleteSpare(<?php echo $BookingSpare->id;?>)">Delete</a></td>
                    </tr>  
                    <?php
					if($innerCounter==count($BookingSpares)){
						$grandTotal=$grandTotal+=$totalCost;
						?>
                        <tr>
                        <td><b>Total Cost</b></td>
                        <td><span class="totalCostNo2"><?php echo number_format($totalCost);?></span></td>
                        </tr>
                        <?php
						
					}
					$innerCounter++;
				}
				?>
                </table>
                <?php
			}
			
			if(intval($_SESSION['LOGGED_IN_USER_ID'])!=intval($item->supplier_id) && $Suppliers->is_default==0 && $approval_status!='Approved'){
				?>
                <a class="commentAppove" href="javascript:void(0);" onClick="actionBookingComment('Approved','<?php echo base64_encode($item->id);?>')">Approve</a>  
                <?php
				if($approval_status!='Rejected')
				{
					?>
                     <a class="commentReject" href="javascript:void(0);" onClick="actionBookingComment('Rejected','<?php echo base64_encode($item->id);?>')">Reject</a> 
                    <?php
				}
				?>
               
                <?php
			}
			
			?>
            </td>
			</tr>
			<?php
			
			//if($counter==count($Data)){
				if($Suppliers->is_default==0 && count($BookingSpares)>0){
				?>
               <?php /*?> <tr>
                <td colspan="2">
                <span class="totalCost">Grand Total-</span><span class="totalCostNo"><?php echo number_format($grandTotal);?>
                </span></td>
                <td></td>
                </tr><?php */?>
                <?php
				}
			//}
			$counter++;
			}
		}
		?>
        </table>
        <?php
	}



	public function actionEdm()
	{
		$this->render('Edm');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		
		$model=new Bookings;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bookings']))
		{
			$model->attributes=$_POST['Bookings'];
			
			$company_id=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']):0;
			$model->created_at=date('Y-m-d h:i:s', time());
			$model->company_id=$company_id;
			if($model->save())
				$id=$model->getLastRecordID();
				
				//Send EDM
				$this->redirect(array('Edm', 
				'id'=>base64_encode($id)));
				//End send EDM
				
				//$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		
		if(isset($_REQUEST['id'])){
			$id=$_REQUEST['id'];
		}else{
			$id=$_REQUEST['id']=intval($_REQUEST['Bookings']['id']);
		}
		
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bookings']))
		{
			$model->attributes=$_POST['Bookings'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		if(!isset($_REQUEST['Bookings']['id']))
		{
			$this->render('update',array(
				'model'=>$model,
			));
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Bookings('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bookings']))
			$model->attributes=$_GET['Bookings'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Bookings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bookings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bookings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bookings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
