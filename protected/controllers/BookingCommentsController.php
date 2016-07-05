<?php
session_start();
error_reporting(0);
require_once('ImageUploader.class.php');
class BookingCommentsController extends Controller
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete','ExportExcell','ExportData','Edm','sendEdm','approvereject','ApproverejectEdm'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	 
	public function actionapprovereject()
	{
		$action=isset($_REQUEST['action']) ? $_REQUEST['action']:"";
		$id=isset($_REQUEST['id']) ? intval(base64_decode($_REQUEST['id'])):0;
		BookingComments::model()->updateByPk($id,array('approval_status'=>$action));
		// send EDM to Supplier informing him of status
		$this->redirect(array('ApproverejectEdm', 
		'id'=>base64_encode($id)
		));
		// End
	}
	 	 	
	public function actiongetComments()
	{
		$model=new CarAssignment;
		$car_assignment_id=isset($_REQUEST['car_assignment_id']) ? intval($_REQUEST['car_assignment_id']) :0;
		$Data=CarAssignPhysicalDamages::model()->findAllByAttributes(array('car_assignment_id'=>$car_assignment_id,'status'=>1));
		if(count($Data)>0)
		{
		?>
		<table>
		<tr><td><b>Photo</b></td><td><b>Description</b></td><td><b>Edit / Delete</b></td></tr>
		<?php
		foreach($Data as $item)
		{
			?>
			<tr>
			<td>
			<?php echo CHtml::image(Yii::app()->request->baseUrl.'/car_assign_physical_damage/'.$item->photo,$name,array("class"=>"banner_class","width"=>"100px"));?>
			</td>
			<td><?php echo $item->description;?></td>
			<td><?php echo $model->deleteChildRecord($item->id,$item->car_assignment_id,'Physical');?></td>
			</tr>
			<?php
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
	
	public function actionApproverejectEdm()
	{
		$this->render('ApproverejectEdm');
	}
	
	
	public function actionsendEdm()
	{
		$id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		$this->redirect(array('Edm', 
		'id'=>base64_encode($id)));
	}
	
	
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{	
	
/*		for($x=0;$x<=count($_FILES['more_spares_image']['name'])-1;$x++)
		{
			
				$rnd = rand(0,9999).time();
				$file_name =$rnd. $_FILES['more_spares_image']['name'][$x];
				$file_size =$_FILES['more_spares_image']['size'][$x];
				$file_tmp =$_FILES['more_spares_image']['tmp_name'][$x];
				$file_type=$_FILES['more_spares_image']['type'][$x];
				//$ImageSavepath=Yii::app()->basePath.'/../bookingCommentsPhotos/'.$file_name;
				echo"File name is ".$_FILES['more_spares_image']['name'][$x];	
		}
		echo"<pre>";
		print_r($_REQUEST);
		echo"</pre>";
		
		exit;*/
		if(!empty($_REQUEST))
		{
			$model=new BookingComments;
			$comment=$_POST['BookingComments']['comment'];
			$hidden_booking=$_POST['hidden_booking'];
			$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) :0;
			$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] :'';	
			$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] :'';
				
			if($LOGGED_IN_USER_KIND=='supplier')
			{
				 $UsersData=Users::model()->findByAttributes(array('is_default'=>1));
				 $user_id=$UsersData->id;
				 $supplier_id=$LOGGED_IN_USER_ID;
			}else if($LOGGED_IN_USER_KIND=='company_sub_user')
			{
				 $SuppliersData=Suppliers::model()->findByAttributes(array('is_default'=>1));
				 $supplier_id=$SuppliersData->id;
				 $user_id=$LOGGED_IN_USER_ID;
			}
				
			$model->booking_id=$hidden_booking;
			$model->supplier_id=$supplier_id;
			$model->user_id=$user_id;
			$model->comment=$comment;
			$model->created_at=date('Y-m-d h:i:s', time());
			$model->approval_status="Pending";
			$model->save($runValidation=false);
			$lastRecordID=$model->getLastRecordID();
			
			if(count($_FILES['spares_image']['name'])>0){
				for($x=0;$x<=count($_FILES['spares_image']['name'])-1;$x++)
				{
					$rnd = rand(0,9999).time();
					$file_name =$rnd. $_FILES['spares_image']['name'][$x];
					$file_size =$_FILES['spares_image']['size'][$x];
					$file_tmp =$_FILES['spares_image']['tmp_name'][$x];
					$file_type=$_FILES['spares_image']['type'][$x];
					$ImageSavepath=Yii::app()->basePath.'/../bookingCommentsPhotos/'.$file_name;
					move_uploaded_file($file_tmp,$ImageSavepath);
					$BookingSpares=new BookingSpares;
					$spare=$_REQUEST['spare_parts'][$x];
					$spare_cost=$_REQUEST['spare_cost'][$x];
					$BookingSpares->booking_comment_id=$lastRecordID;
					$BookingSpares->spare_id=$spare;
					$BookingSpares->spare_cost=$spare_cost;
					$BookingSpares->spare_photo=$file_name;
					$BookingSpares->is_more_spare_part=0;
					$BookingSpares->save($runValidation=false);	
				}
			}
			
			if(count($_FILES['more_spares_image']['name'])>0){
				for($y=0;$y<=count($_FILES['more_spares_image']['name'])-1;$y++)
				{
					$rnd = rand(0,9999).time();
					$file_name =$rnd. $_FILES['more_spares_image']['name'][$y];
					$file_size =$_FILES['more_spares_image']['size'][$y];
					$file_tmp =$_FILES['more_spares_image']['tmp_name'][$y];
					$file_type=$_FILES['more_spares_image']['type'][$y];
					$ImageSavepath=Yii::app()->basePath.'/../bookingCommentsPhotos/'.$file_name;
					move_uploaded_file($file_tmp,$ImageSavepath);
					$BookingSpares=new BookingSpares;
					$spare=$_REQUEST['more_spare_parts'][$y];
					$spare_cost=$_REQUEST['more_spare_cost'][$y];
					$BookingSpares->booking_comment_id=$lastRecordID;
					$BookingSpares->spare_id=$spare;
					$BookingSpares->spare_cost=$spare_cost;
					$BookingSpares->spare_photo=$file_name;
					$BookingSpares->is_more_spare_part=1;
					$BookingSpares->save($runValidation=false);	
				}
			}
				//Send EDM
				$this->redirect(array('Edm', 
				'id'=>base64_encode($lastRecordID)));
				//End send EDM
		}
							
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BookingComments']))
		{
			$model->attributes=$_POST['BookingComments'];
			if($model->save())
				$this->redirect(array('admin'));
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BookingComments']))
		{
			$model->attributes=$_POST['BookingComments'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
		$model=new BookingComments('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BookingComments']))
			$model->attributes=$_GET['BookingComments'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return BookingComments the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=BookingComments::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BookingComments $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='booking-comments-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
