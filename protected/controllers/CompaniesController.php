<?php
session_start();
error_reporting(0);
class CompaniesController extends Controller
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
		if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete','ExportExcell','AccountCreateEdm'),
				'users'=>array('*'),
			),
		);	
		}else{
			return array(
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);

		}
	}
	
	

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	
	
	public function actionAccountCreateEdm()
	{
		$this->render('AccountCreateEdm');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	 
	public function actionExportExcell()
	{	
		$session=new CHttpSession;
        $session->open();		
		$current_search_Companies_model=$_SESSION['current_search_Companies_model'];
		$sql_header="SELECT c.*, i.title AS industry FROM tbl_companies c JOIN tbl_industries i ON c.industry_id=i.id";
		$loop_counter=0;
		$total_records=count(array_filter($_SESSION['current_search_Companies'],create_function('$a','return trim($a)!=="";')));
		if($total_records>0){
			foreach(array_filter($_SESSION['current_search_Companies'],create_function('$a','return trim($a)!=="";')) as $key => $value) {
					if($loop_counter==0){
						 $sql_body.=" WHERE c.".$key." LIKE '%".$_SESSION['current_search_Companies_model'][$key]."%' AND c.is_default=0";
					}else{
					    $sql_body.=" AND c.".$key." LIKE '%".$_SESSION['current_search_Companies_model'][$key]."%' AND c.is_default=0";
				}
			$loop_counter++;	
			}
			$sql=$sql_header.$sql_body;
		}else{
			$sql=$sql_header." WHERE c.is_default=0";
		}
		$sql=$sql." ORDER BY c.id DESC";
		$model= Yii::app()->db->createCommand($sql)->queryAll();
		Yii::app()->request->sendFile("Companies Report- ".date('YmdHis').'.xls',
			$this->renderPartial('report', array(
				'model'=>$model
			), true)
		);
	}


	public function actionCreate()
	{
		$model=new Companies;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Companies']))
		{
			$model->attributes=$_POST['Companies'];
			
			$response=array(); 
     		$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$fileName = "{$rnd}-{$uploadedFile}";
			
			
		   $title_exists=Companies::model()->findAllByAttributes(array('title'=>$model->title));
		   if(count($title_exists)>0){
				$response['field']='Companies_title';
				$response['error_div']='title_error';
				$response['error']='The company already exists.';
				echo json_encode($response);
				exit;
			}
			
			
		   $email_exists=Companies::model()->findAllByAttributes(array('email'=>$model->email));
		   if(count($email_exists)>0){
				$response['field']='Companies_email';
				$response['error_div']='email_error';
				$response['error']='The email address already exists.';
				echo json_encode($response);
				exit;
			}
			
		   $email_exists=Users::model()->findAllByAttributes(array('email'=>$model->email));
		   if(count($email_exists)>0){
				$response['field']='Companies_email';
				$response['error_div']='email_error';
				$response['error']='The email address already exists.';
				echo json_encode($response);
				exit;
			}
			
		   $email_exists=Systemusers::model()->findAllByAttributes(array('email'=>$model->email));
		   if(count($email_exists)>0){
				$response['field']='Companies_email';
				$response['error_div']='email_error';
				$response['error']='The email address already exists.';
				echo json_encode($response);
				exit;
			}
			
		 $email_exists=Suppliers::model()->findAllByAttributes(array('email'=>$model->email));
		   if(count($email_exists)>0){
				$response['field']='Companies_email';
				$response['error_div']='email_error';
				$response['error']='The email address already exists.';
				echo json_encode($response);
				exit;
			}
			
			
			
		   $phone_number_exists=Companies::model()->findAllByAttributes(array('phone_number'=>$model->phone_number));
		   if(count($phone_number_exists)>0){
				$response['field']='Companies_phone_number';
				$response['error_div']='phone_number_error';
				$response['error']='The Phone Number already exists.';
				echo json_encode($response);
				exit;
			}
			
		   $phone_number_exists=Users::model()->findAllByAttributes(array('phone_number'=>$model->phone_number));
		   if(count($phone_number_exists)>0){
				$response['field']='Companies_phone_number';
				$response['error_div']='phone_number_error';
				$response['error']='The Phone Number already exists.';
				echo json_encode($response);
				exit;
			}
			
		   
			

			$model->photo=$fileName;
			$raw_password=$model->getRandomString().$model->getRandomNumber();
			$md5_password=md5($raw_password);
			$model->raw_password=$raw_password;
			$model->password=$md5_password;
			
			
		    $company_name=$model->title;
			$contact_person=$model->contact_person;
			$email=$model->email;
			
			if($model->save())
			   if(!empty($uploadedFile)){
					$uploadedFile->saveAs(Yii::app()->basePath.'/../companies/'.$fileName);
				}
				
				//Send EDM
				$this->redirect(array('AccountCreateEdm', 
				'company_name'=>base64_encode($company_name), 
				'contact_person'=>base64_encode($contact_person), 
				'email'=>base64_encode($email),
				'password'=>base64_encode($raw_password)));
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
			$id=$_REQUEST['id']=intval($_REQUEST['Companies']['id']);
		}
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Companies']))
		{
			$response=array();
			$company_hidden=isset($_REQUEST['company_hidden']) ? $_REQUEST['company_hidden']:"";
			$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$fileName = "{$rnd}-{$uploadedFile}";


			$model->attributes=$_POST['Companies'];
			
			if($uploadedFile=="" && $company_hidden!="")
			{
				$model->photo=$company_hidden;
			}else if($uploadedFile!="" && $company_hidden=="")
			{
				$model->photo=$fileName;
			}else{
				$model->photo=$fileName;
			}
			
			if($model->save())
			if(!empty($uploadedFile)){
				if(file_exists(Yii::app()->basePath.'/../companies/'.$company_hidden))
				{
					unlink(Yii::app()->basePath.'/../companies/'.$company_hidden);
				}
				$uploadedFile->saveAs(Yii::app()->basePath.'/../companies/'.$fileName);
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
		$Companies=Companies::model()->findByPk($id);
		$photo=$Companies->photo;
		
		if(file_exists(Yii::app()->basePath.'/../companies/'.$photo)){
			unlink(Yii::app()->basePath.'/../companies/'.$photo);
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
		
		$model=new Companies('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Companies']))
			$model->attributes=$_GET['Companies'];

		if(isset($model->attributes)){
		$_SESSION['current_search_Companies']=$model->attributes;		
		}
		$_SESSION['current_search_Companies_model']=$model;


		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Companies the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Companies::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Companies $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='companies-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
