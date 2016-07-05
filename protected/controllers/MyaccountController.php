<?php
session_start();
error_reporting(0);
class MyaccountController extends Controller
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
	 public function EnableRoutes($access_level)
	{
		$logged_role_level_session=!empty($_SESSION['logged_role_level_session']) ? $_SESSION['logged_role_level_session'] : "";
		if($access_level=="High" && $logged_role_level_session=="High"){
			return 1;
		}else if($logged_role_level_session=="High"){
			return 1;
		}else if($access_level=="Low" && $logged_role_level_session=="Low"){
			return 0;
		}else if($access_level=="High" && $logged_role_level_session=="Low"){
			return 1;
		}
		else if($access_level=="Low" && $logged_role_level_session=="High"){
			return 1;
		}else{
			return 0;
		}
	}
	
	public function accessRules()
	{
		$EnableRoutes=$this->EnableRoutes("High");
		if($EnableRoutes==1){
			return array(
			array('allow',
				'actions'=>array('update','changepassword'),
				'users'=>array('*'),
			),
		);
		}else{
			return array(
			array('deny',
				'users'=>array('*'),
			),
		);
		}
	}

	 public function actionChangepassword()
	 {
		 $logged_role_level_session=!empty($_SESSION['logged_role_level_session']) ? $_SESSION['logged_role_level_session']: "Low";
		
		 $Systemusers_first_name=isset($_REQUEST['Systemusers_first_name']) ? $_REQUEST['Systemusers_first_name']:"";
		 $Systemusers_last_name=isset($_REQUEST['Systemusers_last_name']) ? $_REQUEST['Systemusers_last_name']:"";
		 $Systemusers_email=isset($_REQUEST['Systemusers_email']) ? $_REQUEST['Systemusers_email']:"";
		
	    $id=isset($_REQUEST['hidden_user_id']) ? intval($_REQUEST['hidden_user_id']) :0;
		$password=isset($_REQUEST['password']) ? md5($_REQUEST['password']) :"";
		 
		
		 
			if($logged_role_level_session=="Low"){
				//echo"Super user update details ".$logged_role_level_session;
				if(Systemusers::model()->updateByPk($id, array('password' => $password))){
					echo 1;
				}
				
				
			}else if($logged_role_level_session=="High"){
				//echo"Super user update details ".$logged_role_level_session;
				if(Systemusers::model()->updateByPk($id, array(
				'password' => $password,'first_name'=>$Systemusers_first_name,'last_name'=>$Systemusers_last_name,'email'=>$Systemusers_email))){
					echo 1;
				}
			}

	 }
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Systemusers']))
		{
			$model->attributes=$_POST['Systemusers'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	
	public function loadModel($id)
	{
		$model=Systemusers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Systemusers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='systemusers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
