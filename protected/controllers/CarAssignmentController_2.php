<?php
session_start();
error_reporting(0);
class CarAssignmentController extends Controller
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
				'actions'=>array('index','view','create','update','admin','delete','savePhysicalProblems','saveMechanicalIssues','getPhysicalDamages','getMechanicalIssues','ExportExcell','ExportData','Edm','sendEdm'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
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
	 
	 
	 
	public function actionExportData()
	{	
		$id=$_REQUEST['id'] ? intval($_REQUEST['id']):0;
		$file='single_report';
		$CarAssignment=CarAssignment::model()->findByPk($id);	
		$Cars=Cars::model()->findByPk($CarAssignment->car_id);
		$CarMake=CarMake::model()->findByPk($Cars->make_id);
		$CarModels=CarModels::model()->findByPk($Cars->model_id);	
		$report_name=$Carsdata[$item->id] = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.")  Assignment"; 
		Yii::app()->request->sendFile($report_name." -Report".'.xls',
			$this->renderPartial($file, array(
				'id'=>$id
			), true)
		);
	}


	public function actionExportExcell()
	{	
		$type=$_REQUEST['type'] ? ucfirst($_REQUEST['type']):'';
		$file='report';
		$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
		$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
		$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
		$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
		$session=new CHttpSession;
        $session->open();		
		$current_search_Requests_model=$_SESSION['current_search_Requests_model'];
		$sql_header="SELECT r.*, c.number_plate,u.first_name,u.last_name,s.title AS system,sub.title AS subsystem,comp.title AS company_name "."
					 FROM tbl_requests r JOIN tbl_cars c ON r.car_id=c.id JOIN tbl_users u ON r.user_id=u.id JOIN tbl_system s ON"."
					 r.system_id=s.id JOIN tbl_sub_system sub ON r.subsystem_id=sub.id JOIN tbl_companies comp ON r.company_id=comp.id";
		$loop_counter=0;
		$total_records=count(array_filter($_SESSION['current_search_Requests'],create_function('$a','return trim($a)!=="";')));
		if($total_records>0){
			foreach(array_filter($_SESSION['current_search_Requests'],create_function('$a','return trim($a)!=="";')) as $key => $value) {
					if($loop_counter==0){
						 $sql_body.=" WHERE r.".$key." LIKE '%".$_SESSION['current_search_Requests_model'][$key]."%'";
					}else{
					    $sql_body.=" AND r.".$key." LIKE '%".$_SESSION['current_search_Requests_model'][$key]."%'";
				}
			$loop_counter++;	
			}
			$sql=$sql_header.$sql_body." AND r.request_type='$type'";
		}else{
			$sql=$sql_header." AND r.request_type='$type'";
		}
		
		if($LOGGED_IN_USER_KIND=='company_user'){
			$sql=$sql;
		}else if($LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='TM'){
			$sql=$sql." AND r.company_id=".$LOGGED_IN_COMPANY."";
		}else if($LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='Driver'){
			$sql=$sql." AND r.user_id=".$LOGGED_IN_USER_ID." AND r.company_id=".$LOGGED_IN_COMPANY."";
		}
		$model= Yii::app()->db->createCommand($sql)->queryAll();
		Yii::app()->request->sendFile($type." Requests Report- ".date('YmdHis').'.xls',
			$this->renderPartial($file, array(
				'model'=>$model
			), true)
		);
	}





    public function actionEdm()
	{
		$this->render('Edm');
	}
	
	
	public function actionsendEdm()
	{
		$id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		$this->redirect(array('Edm', 
		'id'=>base64_encode($id)));
	}
	
	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	 
	 	
	public function actiongetPhysicalDamages()
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
	
	public function actiongetMechanicalIssues()
	{
		$model=new CarAssignment;
		$car_assignment_id=isset($_REQUEST['car_assignment_id']) ? intval($_REQUEST['car_assignment_id']) :0;
		$Data=CarAssignMechanicalIssues::model()->findAllByAttributes(array('car_assignment_id'=>$car_assignment_id,'status'=>1));
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
            <?php echo CHtml::image(Yii::app()->request->baseUrl.'/car_assign_mechanical_issues/'.$item->photo,$name,array("class"=>"banner_class","width"=>"100px"));?>
            </td>
            <td><?php echo $item->description;?></td>
            <td><?php echo $model->deleteChildRecord($item->id,$item->car_assignment_id,'Mechanical');?></td>
            </tr>
            <?php
			}
		}
		?>
        </table>
        <?php
	}



	public function actionsavePhysicalProblems()
	{
		$model=new CarAssignPhysicalDamages;
		if(isset($_POST['CarAssignPhysicalDamages']))
		{
			$model->attributes=$_POST['CarAssignPhysicalDamages'];
			$response=array(); 
			$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$fileName = "{$rnd}-{$uploadedFile}";
			$model->photo=$fileName;
			$model->created_at=date('Y-m-d h:i:s', time());
			if($model->save())
			if(!empty($uploadedFile)){
				$uploadedFile->saveAs(Yii::app()->basePath.'/../car_assign_physical_damage/'.$fileName);
			}
			echo 1; 
		}
	}
	
	public function actionsaveMechanicalIssues()
	{
		$model=new CarAssignMechanicalIssues;
		if(isset($_POST['CarAssignMechanicalIssues']))
		{
     		$model->attributes=$_POST['CarAssignMechanicalIssues'];
			$response=array(); 
			$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$fileName = "{$rnd}-{$uploadedFile}";
			$model->photo=$fileName;
			$model->created_at=date('Y-m-d h:i:s', time());
			if($model->save())
			if(!empty($uploadedFile)){
				$uploadedFile->saveAs(Yii::app()->basePath.'/../car_assign_mechanical_issues/'.$fileName);
			}
			echo 1; 
		}
	}
	
	
	public function actionCreate()
	{
		$model=new CarAssignment;
		if(isset($_POST['CarAssignment']))
		{
			$model->attributes=$_POST['CarAssignment'];
			$model->created_at=date('Y-m-d h:i:s', time());
			$CarsData=Cars::model()->findByPk($model->car_id);
			$UsersData=Users::model()->findByPk($model->user_id);
			if($model->save())
				Cars::model()->updateByPk($model->car_id,array('is_assigned'=>1));
				Users::model()->updateByPk($model->user_id,array('car_id'=>$model->car_id));
			 	echo $model->no_physical_damages." ".$model->no_mechanical_issues." ".$model->getLastRecordID();
				//$this->redirect(array('view','id'=>$model->id));
		}
		
		if(!isset($_POST['CarAssignment'])){
			$this->render('create',array(
				'model'=>$model,
			));
		}
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

		if(isset($_POST['CarAssignment']))
		{
			$model->attributes=$_POST['CarAssignment'];
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
	public function actionDelete($id,$car_id)
	{
		Cars::model()->updateByPk($car_id,array('is_assigned'=>0));
		// update users to the default car for the user who had this car.
		$CarAssignment=CarAssignment::model()->findByPk($id);
		$default_car=Cars::model()->findByAttributes(array('is_default'=>1,'status'=>1)); 
		$default_car_id=$default_car->id;
		Users::model()->updateByPk(intval($CarAssignment->user_id),array('car_id'=>$default_car_id));
				
				
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CarAssignment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CarAssignment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CarAssignment']))
			$model->attributes=$_GET['CarAssignment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CarAssignment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CarAssignment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CarAssignment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='car-assignment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
