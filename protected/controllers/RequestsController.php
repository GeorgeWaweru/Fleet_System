<?php
error_reporting(0);
session_start();
class RequestsController extends Controller
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
		if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_sub_user' && ($COMPANY_SUB_USER_ROLE=='TM' || $COMPANY_SUB_USER_ROLE=='Driver')){
			return 1;
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
				'actions'=>array('create','update','admin','delete','Service','Repair','Fuel','ServiceCreate','RepairCreate','FuelCreate','getSubSystem','saveSubDetails','getRequestSubDetails','ServiceUpdate','RepairUpdate','FuelUpdate','ExportExcell','ExportData','Edm','SendEdm','Booking'),
				'users'=>array('*'),
			),
		);	
		}else{
			return array(
			array('deny',
				'actions'=>array('create','update','admin','delete','Service','Repair','Fuel','ServiceCreate','RepairCreate','FuelCreate','getSubSystem','saveSubDetails','getRequestSubDetails','ServiceUpdate','RepairUpdate','FuelUpdate','ExportExcell','ExportData','Edm','SendEdm','Booking'),
				'users'=>array('*'),
			),
		);

		}
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	 
	public function actionEdm()
	{
		$this->render('Edm');
	}
	
	public function actionBooking()
	{
		$this->render('booking');
	}
	
	
	
	
	
	public function actionsendEdm()
	{
		$id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		$this->redirect(array('Edm', 
		'id'=>base64_encode($id)));
	}
	
	 
	public function actionExportData()
	{	
		$id=$_REQUEST['id'] ? intval($_REQUEST['id']):0;
		$type=$_REQUEST['type'] ? ucfirst($_REQUEST['type']):'';
		$reportType=$_REQUEST['type'] ? $_REQUEST['type']:'';
		$Requests=Requests::model()->findByPk($id);	
		$Cars=Cars::model()->findByPk($Requests->car_id);
		$CarMake=CarMake::model()->findByPk($Cars->make_id);
		$CarModels=CarModels::model()->findByPk($Cars->model_id);	
		//$report_name=$Carsdata[$item->id] = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.") ".$type." Request"; 
		$report_name=$Carsdata[$item->id] = $Cars->number_plate." ".$type." Request"; 
		//echo "Report name is ".$file." The report name is ".$report_name;
		
		//exit;
		
		if($reportType=='service'){
				Yii::app()->request->sendFile($report_name." -Report".'.xls',
				$this->renderPartial('single_service_report', array(
				'id'=>$id,
				'type'=>$type
				), true)
				);
		}else if($reportType=='fuel'){
				Yii::app()->request->sendFile($report_name." -Report".'.xls',
				$this->renderPartial('single_fuel_report', array(
				'id'=>$id,
				'type'=>$type
				), true)
				);
		}else if($reportType=='repair'){
				Yii::app()->request->sendFile($report_name." -Report".'.xls',
				$this->renderPartial('single_repair_report', array(
				'id'=>$id,
				'type'=>$type
				), true)
				);

		}
		
	}


	public function actionExportExcell()
	{	
		$type=$_REQUEST['type'] ? ucfirst($_REQUEST['type']):'';
		if($type=='Service'){
				$file='service_report';
		}else if($type=='Fuel'){
				$file='fuel_report';
		}else if($type=='Repair'){
				$file='repair_report';
		}
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
		$sql=$sql." ORDER BY r.id DESC";
		$model= Yii::app()->db->createCommand($sql)->queryAll();
		Yii::app()->request->sendFile($type." Requests Report- ".date('YmdHis').'.xls',
			$this->renderPartial($file, array(
				'model'=>$model
			), true)
		);
	}


	 
	 public function actiongetRequestSubDetails()
	{
		$model=new Requests;
		$id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) :0;
		$Data=RequestSubDetails::model()->findAllByAttributes(array('request_id'=>$id,'status'=>1));
		
		if(count($Data)>0)
		{
		?>
		<table>
		<tr><td><b>Photo</b></td><td><b>Description</b></td><td><b>Edit / Delete</b></td></tr>
		<?php
		foreach($Data as $item)
		{
			$RequestsData=Requests::model()->findByPk($item->request_id);
			?>
			<tr>
			<td>
			<?php echo CHtml::image(Yii::app()->request->baseUrl.'/requests/'.$item->photo,$name,array("class"=>"banner_class","width"=>"100px"));?>
			</td>
			<td><?php echo $item->description;?></td>
			<td><?php echo $model->deleteChildRecord($item->id,$item->request_id,$RequestsData->request_type);?></td>
			</tr>
			<?php
			}
		}
		?>
        </table>
        <?php
	}
	
	
	 public function actionsaveSubDetails()
	{
		
		$model=new RequestSubDetails;
		if(isset($_POST['RequestSubDetails']))
		{
			$model->attributes=$_POST['RequestSubDetails'];
			$response=array(); 
			$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$fileName = "{$rnd}-{$uploadedFile}";
			$model->photo=$fileName;
			$model->created_at=date('Y-m-d h:i:s', time());
			if($model->save())
			if(!empty($uploadedFile)){
				$uploadedFile->saveAs(Yii::app()->basePath.'/../requests/'.$fileName);
			}
			echo 1; 
		}
	}
	
	 
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



	public function actionService()
	{		
		$model=new Requests('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Requests']))
			$model->attributes=$_GET['Requests'];
			if(isset($model->attributes)){
				$_SESSION['current_search_Requests']=$model->attributes;		
			}
			$_SESSION['current_search_Requests_model']=$model;
		$this->render('services_listing',array(
			'model'=>$model,
		));
	}
	
	public function actionServiceCreate()
	{
		$model=new Requests;	
		$this->render('service_frm',array(
			'model'=>$model,
		));
	}
	
	
	public function actionServiceUpdate()
	{
		
		if(isset($_REQUEST['id'])){
			$id=$_REQUEST['id'];
		}else{
			$id=$_REQUEST['id']=intval($_REQUEST['Requests']['id']);
		}
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Requests']))
		{
			$model->attributes=$_POST['Requests'];
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('service_frm',array(
			'model'=>$model,
		));
	}
	
	
	
	public function actionRepair()
	{	
		$model=new Requests('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Requests']))
			$model->attributes=$_GET['Requests'];
			if(isset($model->attributes)){
				$_SESSION['current_search_Requests']=$model->attributes;		
			}
				$_SESSION['current_search_Requests_model']=$model;
		$this->render('repair_listing',array(
			'model'=>$model,
		));
	}
	
	public function actionRepairCreate()
	{
		$model=new Requests;	
		$this->render('repair_frm',array(
			'model'=>$model,
		));
	}
	
	
	
	public function actionRepairUpdate()
	{
		
		if(isset($_REQUEST['id'])){
			$id=$_REQUEST['id'];
		}else{
			$id=$_REQUEST['id']=intval($_REQUEST['Requests']['id']);
		}
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Requests']))
		{
			$model->attributes=$_POST['Requests'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('repair_frm',array(
			'model'=>$model,
		));
	}
	
	
	public function actionFuel()
	{
		$model=new Requests('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Requests']))
			$model->attributes=$_GET['Requests'];
			if(isset($model->attributes)){
				$_SESSION['current_search_Requests']=$model->attributes;		
			}
				$_SESSION['current_search_Requests_model']=$model;
		$this->render('fuel_listing',array(
			'model'=>$model,
		));
	}
	
	public function actionFuelCreate()
	{
		$model=new Requests;	
		$this->render('fuel_frm',array(
			'model'=>$model,
		));
	}
	
	
	public function actionFuelUpdate()
	{
		
		if(isset($_REQUEST['id'])){
			$id=$_REQUEST['id'];
		}else{
			$id=$_REQUEST['id']=intval($_REQUEST['Requests']['id']);
		}
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Requests']))
		{
			$model->attributes=$_POST['Requests'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('fuel_frm',array(
			'model'=>$model,
		));
	}
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
		$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
		$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;

		$model=new Requests;
		if(isset($_POST['Requests']))
		{
			$model->attributes=$_POST['Requests'];
			if($model->request_type=='fuel'){
				$SystemData=System::model()->findByAttributes(array('is_default'=>1,'status'=>1));
				$SubSystemData=SubSystem::model()->findByAttributes(array('is_default'=>1,'status'=>1));
				$default_system=$SystemData->id;
				$default_sub_system=$SubSystemData->id;
				$model->system_id=$default_system;
				$model->subsystem_id=$default_sub_system;
				
				if(Cars::model()->updateByPk($model->car_id,array('millage'=>$model->current_millage))){
					
				}
			}
			$model->created_at=date('Y-m-d h:i:s', time());
			$model->company_id=$LOGGED_IN_COMPANY;
			if($COMPANY_SUB_USER_ROLE=='TM'){
				$model->request_raised_user_id=$LOGGED_IN_USER_ID;
				$UsersData=Users::model()->findByAttributes(array('car_id'=>$model->car_id)); 
				$model->user_id=$UsersData->id;
				$model->on_behalf=1;
			}else{
				$model->user_id=$LOGGED_IN_USER_ID;
				$DefaultUser=Users::model()->findByAttributes(array('is_default'=>1)); 
				$model->request_raised_user_id=$DefaultUser->id;
			}
			if($model->save())
			
				 echo $model->no_description." ".$model->getLastRecordID();
		}
		if(!isset($_POST['Requests'])){
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
	public function actionUpdate()
	{
		
		if(isset($_REQUEST['id'])){
			$id=$_REQUEST['id'];
		}else{
			$id=$_REQUEST['id']=intval($_REQUEST['Requests']['id']);
		}
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Requests']))
		{
			$model->attributes=$_POST['Requests'];
			if($model->no_description==1){
				$model->description="";
			}
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
		$model=new Requests('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Requests']))
			$model->attributes=$_GET['Requests'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Requests the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Requests::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Requests $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='requests-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
