<?php
session_start();
error_reporting(0);
class UsersController extends Controller
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
		if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_user'){
			return 1;
		}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
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
				'actions'=>array('create','update','admin','delete','UpdateProfile','AccountCreateEdm','ExportExcell'),
				'users'=>array('*'),
			),
		);	
		}else if($EnableRoutes==2){
			return array(
			array('deny',
				'actions'=>array('create','update','delete','UpdateProfile','AccountCreateEdm'),
				'users'=>array('*'),
			),
		);

		}else{
			return array(
			array('deny',
				 'actions'=>array('create','update','admin','delete','UpdateProfile','AccountCreateEdm','ExportExcell'),
				'users'=>array('*'),
			),
		);

		}
	}
	


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	 
	 
	public function actionExportExcell()
	{	
		$session=new CHttpSession;
        $session->open();
		$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
		$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
		$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
		$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
		$current_search_users_model=$_SESSION['current_search_users_model'];
		$sql_header="SELECT u.first_name,u.last_name,u.email,u.phone_number,u.dl_number,u.photo,u.dl_photo,u.qualified_status,u.dl_expiry,"."
		 			 r.title as role_title, c.title as company_name,car.number_plate FROM tbl_users u JOIN tbl_roles r ON u.role_id=r.id JOIN "."
		 			 tbl_companies c ON u.company_id=c.id JOIN tbl_cars car ON u.car_id=car.id";
		$loop_counter=0;
		$total_records=count(array_filter($_SESSION['current_search_users'],create_function('$a','return trim($a)!=="";')));
		if($total_records>0){
			foreach(array_filter($_SESSION['current_search_users'],create_function('$a','return trim($a)!=="";')) as $key => $value) {
					if($loop_counter==0){
						 $sql_body.=" WHERE u.".$key." LIKE '%".$_SESSION['current_search_users_model'][$key]."%' AND u.is_default=0";
					}else{
					    $sql_body.=" AND u.".$key." LIKE '%".$_SESSION['current_search_users_model'][$key]."%' AND u.is_default=0";
				}
			$loop_counter++;	
			}
			$sql=$sql_header.$sql_body;
		}else{
			$sql=$sql_header." WHERE u.is_default=0";
		}
		
		if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND!='admin_user'){
			$sql=$sql." AND u.company_id=".$LOGGED_IN_COMPANY." ORDER BY u.id DESC";
		}else{
			$sql=$sql." ORDER BY u.id DESC";
		}
		
		$model= Yii::app()->db->createCommand($sql)->queryAll();
		Yii::app()->request->sendFile("Users Report- ".date('YmdHis').'.xls',
			$this->renderPartial('report', array(
				'model'=>$model
			), true)
		);
	}


	public function actionAccountCreateEdm()
	{
		$this->render('AccountCreateEdm');
	}
	
	
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			
			 $response=array(); 
     		 $rnd = rand(0,9999);
			 $uploadedFile=CUploadedFile::getInstance($model,'photo');
			 $fileName = "{$rnd}-{$uploadedFile}";

			 $rnd_dl_photo = rand(0,9999);
			 $uploadedFile_dl_photo=CUploadedFile::getInstance($model,'dl_photo');
			 $fileName_dl_photo = "{$rnd_dl_photo}-{$uploadedFile_dl_photo}";
			 			
			  $email_exists=Users::model()->findAllByAttributes(array('email'=>$model->email));
			  if(count($email_exists)>0){
					$response['field']='Users_email';
					$response['error_div']='email_error';
					$response['error']='The email address already exists.';
					echo json_encode($response);
					exit;
				}
				
			  $email_exists=Companies::model()->findAllByAttributes(array('email'=>$model->email));
			  if(count($email_exists)>0){
					$response['field']='Users_email';
					$response['error_div']='email_error';
					$response['error']='The email address already exists.';
					echo json_encode($response);
					exit;
				}
				
			$email_exists=Systemusers::model()->findAllByAttributes(array('email'=>$model->email));
			  if(count($email_exists)>0){
					$response['field']='Users_email';
					$response['error_div']='email_error';
					$response['error']='The email address already exists.';
					echo json_encode($response);
					exit;
				}
				
		$email_exists=Suppliers::model()->findAllByAttributes(array('email'=>$model->email));
		   if(count($email_exists)>0){
				$response['field']='Users_email';
				$response['error_div']='email_error';
				$response['error']='The email address already exists.';
				echo json_encode($response);
				exit;
			}

			  $phone_number_exists=Users::model()->findAllByAttributes(array('phone_number'=>$model->phone_number));
			  if(count($phone_number_exists)>0){
					$response['field']='Users_phone_number';
					$response['error_div']='phone_number_error';
					$response['error']='The Phone Number already exists.';
					echo json_encode($response);
					exit;
				}
				
			$phone_number_exists=Companies::model()->findAllByAttributes(array('phone_number'=>$model->phone_number));
			  if(count($phone_number_exists)>0){
					$response['field']='Users_phone_number';
					$response['error_div']='phone_number_error';
					$response['error']='The Phone Number already exists.';
					echo json_encode($response);
					exit;
				}


			
			if(!empty($uploadedFile)){
				$model->photo=$fileName;
			}
			
			if(!empty($uploadedFile_dl_photo)){
				$model->dl_photo=$fileName_dl_photo;
			}
			
			$raw_password=$model->getRandomString().$model->getRandomNumber();
			$md5_password=md5($raw_password);
				
			$model->raw_password=$raw_password;
			$model->password=$md5_password;
			$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
			$model->company_id=$LOGGED_IN_USER_ID;
			$model->created_at=date('Y-m-d h:i:s', time());


				$is_driver=Roles::model()->findByAttributes(array('is_driver'=>1,'status'=>1));
				$is_driver_id=$is_driver->id;

				$default_car=Cars::model()->findByAttributes(array('is_default'=>1,'status'=>1)); 
			    $default_car_id=$default_car->id;
				$model->car_id=$default_car_id;
			
				$RolesData=Roles::model()->findByPk($model->role_id);
				$user_names=$model->first_name." ".$model->last_name;
				$user_role=$RolesData->title;
				$user_email=$model->email;
				$user_password=$raw_password;
				
			if($model->save())
			
				if(!empty($uploadedFile)){
					$uploadedFile->saveAs(Yii::app()->basePath.'/../users/'.$fileName);
				}
				
				 if(!empty($uploadedFile_dl_photo)){
					$uploadedFile_dl_photo->saveAs(Yii::app()->basePath.'/../dl_photo/'.$fileName_dl_photo);
				}
				
				//Send EDM
				$this->redirect(array('AccountCreateEdm', 
				'names'=>base64_encode($user_names), 
				'role'=>base64_encode($user_role), 
				'email'=>base64_encode($user_email),
				'password'=>base64_encode($user_password)));
				//End send EDM
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
			$id=$_REQUEST['id']=intval($_REQUEST['Users']['id']);
		}
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			$response=array();
			
			 $rnd = rand(0,9999);
			 $uploadedFile=CUploadedFile::getInstance($model,'photo');
			 $fileName = "{$rnd}-{$uploadedFile}";

			 $rnd_dl_photo = rand(0,9999);
			 $uploadedFile_dl_photo=CUploadedFile::getInstance($model,'dl_photo');
			 $fileName_dl_photo = "{$rnd_dl_photo}-{$uploadedFile_dl_photo}";



			$photo_hidden=isset($_REQUEST['photo_hidden']) ? $_REQUEST['photo_hidden']:"";
			$dl_photo_hidden=isset($_REQUEST['dl_photo_hidden']) ? $_REQUEST['dl_photo_hidden']:"";
			
			if($uploadedFile=="" && $photo_hidden!="")
			{
				$model->photo=$photo_hidden;
			}else if($uploadedFile!="" && $photo_hidden=="")
			{
				$model->photo=$fileName;
			}else{
				$model->photo=$fileName;
			}
			
			if($uploadedFile_dl_photo=="" && $dl_photo_hidden!="")
			{
				$model->dl_photo=$dl_photo_hidden;
			}else if($uploadedFile!="" && $dl_photo_hidden=="")
			{
				$model->dl_photo=$fileName_dl_photo;
			}else{
				$model->dl_photo=$fileName_dl_photo;
			}
			if($model->save())
			if(!empty($uploadedFile)){
			    if(file_exists(Yii::app()->basePath.'/../users/'.$photo_hidden))
				{
					unlink(Yii::app()->basePath.'/../users/'.$photo_hidden);
				}
				$uploadedFile->saveAs(Yii::app()->basePath.'/../users/'.$fileName);
			}
				
			if(!empty($uploadedFile_dl_photo)){
				if(file_exists(Yii::app()->basePath.'/../dl_photo/'.$dl_photo_hidden))
				{
					unlink(Yii::app()->basePath.'/../dl_photo/'.$dl_photo_hidden);
				}
				$uploadedFile_dl_photo->saveAs(Yii::app()->basePath.'/../dl_photo/'.$fileName_dl_photo);
			}
				
				$this->redirect(array('admin'));
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
		$users=Users::model()->findByPk($id);
		$photo=$users->photo;
		$dl_photo=$users->dl_photo;
		if(file_exists(Yii::app()->basePath.'/../users/'.$photo)){
			unlink(Yii::app()->basePath.'/../users/'.$photo);
		}
		
		if(file_exists(Yii::app()->basePath.'/../dl_photo/'.$dl_photo)){
			unlink(Yii::app()->basePath.'/../dl_photo/'.$dl_photo);
		}
		
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
		 $session=new CHttpSession;
         $session->open();	
		 
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

			if(isset($model->attributes)){
				$_SESSION['current_search_users']=$model->attributes;		
			}
		$_SESSION['current_search_users_model']=$model;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
