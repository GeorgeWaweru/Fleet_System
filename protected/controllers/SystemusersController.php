<?php
error_reporting(0);
session_start();
class SystemusersController extends Controller
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
		$ADMIN_USER_ROLE_LEVEL=isset($_SESSION['ADMIN_USER_ROLE_LEVEL'])? $_SESSION['ADMIN_USER_ROLE_LEVEL']: "";
		$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND'])? $_SESSION['LOGGED_IN_USER_KIND']: "";
		if($LOGGED_IN_USER_KIND=="admin_user")
		{
			return 1;
		}else{
			return 1;
		}
	}
	
	
public function accessRules()
{
		$EnableRoutes=$this->EnableRoutes();
		if($EnableRoutes==1){
			return array(
			array('allow',
				'actions'=>array('create','update','admin','delete','ExportExcell','ExportPDF','changepassword','resetpassword','Updatepassword','Edm','PasswordResetConfirmEdm','PasswordchangeConfirmEdm'),
				'users'=>array('*'),
			),
		);
			
		}else{
		}		
}


public function actionuserlogin()
	 {
		 if(isset($_REQUEST['email']) && isset($_REQUEST['password'])){
 			 $email=isset($_REQUEST['email']) ? $_REQUEST['email']: "";
			 $password=isset($_REQUEST['password']) ? md5($_REQUEST['password']): "";
			 $user_login_details = array();	
			 
			 	$SystemusersData=Systemusers::model()->findAllByAttributes(array('email'=>$email,'password'=>$password,'status'=>1)); 
				if(count($SystemusersData))
				{			
					$_SESSION['LOGGED_IN_USER_NAMES']=$SystemusersData[0]->first_name." ".$SystemusersData[0]->last_name;
					$_SESSION['LOGGED_IN_USER_KIND']="admin_user";
					$_SESSION['LOGGED_IN_USER_ID']=$SystemusersData[0]->id;
					$_SESSION['LOGGED_IN_COMPANY']='';
					$_SESSION['USER_CHANGED_PASSWORD']=1;
					$user_login_details = array(
						"SUCCESSFUL_LOGIN"=>1,
						"LOGGIN_USER"=>"admin_user",
						"USER_CHANGED_PASSWORD"=>1
					);
				}else{
						unset($_SESSION['LOGGED_IN_USER_NAMES']);
					 	unset($_SESSION['LOGGED_IN_USER_KIND']);
					    unset($_SESSION['LOGGED_IN_USER_ID']);
						unset($_SESSION['LOGGED_IN_COMPANY']);
						unset($_SESSION['LOGGED_IN_COMPANY_NAME']);
						unset($_SESSION['USER_CHANGED_PASSWORD']);
							 
			 $CompaniesData=Companies::model()->findByAttributes(array('email'=>$email,'password'=>$password,'status'=>1)); 
			
			 if(count($CompaniesData)>0)
			 {
				    $_SESSION['LOGGED_IN_USER_NAMES']=$CompaniesData->contact_person;
					$_SESSION['LOGGED_IN_USER_KIND']="company_user";
					$_SESSION['LOGGED_IN_USER_ID']=$CompaniesData->id;
					$_SESSION['LOGGED_IN_COMPANY']=$CompaniesData->id;
					$_SESSION['LOGGED_IN_COMPANY_NAME']=$CompaniesData->title;
					$_SESSION['USER_CHANGED_PASSWORD']=$CompaniesData->changed_initial_password;
					$user_login_details = array(
						"SUCCESSFUL_LOGIN"=>1,
						"LOGGIN_USER"=>"company_user",
						"USER_CHANGED_PASSWORD"=>$CompaniesData->changed_initial_password
					);
			 }else{
				 
					unset($_SESSION['LOGGED_IN_USER_NAMES']);
					unset($_SESSION['LOGGED_IN_USER_KIND']);
					unset($_SESSION['LOGGED_IN_USER_ID']);
					unset($_SESSION['LOGGED_IN_COMPANY']);
					unset($_SESSION['LOGGED_IN_COMPANY_NAME']);
					unset($_SESSION['USER_CHANGED_PASSWORD']);
						
						
				 $UsersData=Users::model()->findByAttributes(array('email'=>$email,'password'=>$password));
				  
				 if(count($UsersData)>0)
				 {	
				 
					
				    $RolesData=Roles::model()->findByPk($UsersData->role_id);
					$is_driver=intval($RolesData->is_driver);
					$is_tm=intval($RolesData->is_tm);
					if($is_driver==1){
						$role='Driver';
					}else if($is_tm){
						$role='TM';
					}
					$CompaniesData=Companies::model()->findByPk($UsersData->company_id);
					$_SESSION['LOGGED_IN_COMPANY_NAME']=$CompaniesData->title;
				 	$_SESSION['LOGGED_IN_USER_KIND']="company_sub_user";
					$_SESSION['LOGGED_IN_USER_NAMES']=$UsersData->first_name." ".$UsersData->last_name;
					$_SESSION['LOGGED_IN_USER_ID']=$UsersData->id;
					$_SESSION['LOGGED_IN_COMPANY']=$UsersData->company_id;
					$_SESSION['COMPANY_SUB_USER_ROLE']=$role;
					$_SESSION['USER_CHANGED_PASSWORD']=$UsersData->changed_initial_password;
					$user_login_details = array(
						"SUCCESSFUL_LOGIN"=>1,
						"LOGGIN_USER"=>"company_sub_user",
						"USER_CHANGED_PASSWORD"=>$UsersData->changed_initial_password,
						"COMPANY_SUB_USER_ROLE"=>$role
					);
				 
				 }else{ 
					unset($_SESSION['LOGGED_IN_USER_NAMES']);
					unset($_SESSION['LOGGED_IN_USER_KIND']);
					unset($_SESSION['LOGGED_IN_USER_ID']);
					unset($_SESSION['LOGGED_IN_COMPANY']);
					unset($_SESSION['LOGGED_IN_COMPANY_NAME']);
					unset($_SESSION['USER_CHANGED_PASSWORD']);
					unset($_SESSION['LOGGED_IN_SUPPLIER_TITLE']);
					
					
				 $SuppliersData=Suppliers::model()->findByAttributes(array('email'=>$email,'password'=>$password));
				 if(count($SuppliersData)>0)
				 {	
				 	$_SESSION['LOGGED_IN_USER_KIND']="supplier";
					$_SESSION['LOGGED_IN_USER_NAMES']=$SuppliersData->contact_person;
					$_SESSION['LOGGED_IN_USER_ID']=$SuppliersData->id;
					$_SESSION['LOGGED_IN_COMPANY']=$SuppliersData->company_id;
					$_SESSION['LOGGED_IN_SUPPLIER_TITLE']=$SuppliersData->title;
					$_SESSION['USER_CHANGED_PASSWORD']=$SuppliersData->changed_initial_password;
					$user_login_details = array(
						"SUCCESSFUL_LOGIN"=>1,
						"LOGGIN_USER"=>"supplier",
						"USER_CHANGED_PASSWORD"=>$SuppliersData->changed_initial_password
					);
				 }else{
						$user_login_details = array(
						"SUCCESSFUL_LOGIN"=>0
						); 
						unset($_SESSION['LOGGED_IN_USER_NAMES']);
					 	unset($_SESSION['LOGGED_IN_USER_KIND']);
					    unset($_SESSION['LOGGED_IN_USER_ID']);
						unset($_SESSION['LOGGED_IN_COMPANY']);
				 
			 	 }
					 
					 
					 
				}
				 
				 
  
				  } 
				}
		}	 
					echo json_encode($user_login_details);	
     }
	 
	 
	 
	public function actionupdatepassword()
	{
		$model=new Systemusers();
		$pass_reset_record=isset($_SESSION['pass_reset_record']) ? intval($_SESSION['pass_reset_record']) :0;
		$pass_reset_record_type=isset($_SESSION['pass_reset_record_type']) ? intval($_SESSION['pass_reset_record_type']) :0;
		$password=isset($_REQUEST['password']) ? $_REQUEST['password']:"";
		$confirm_password=isset($_REQUEST['confirm_password']) ? $_REQUEST['confirm_password']:"";
		if($password!=$confirm_password){
			echo 3;
			exit;
		}
		$md5_password=md5($password);
		$form_token=isset($_REQUEST['form_token']) ? $_REQUEST['form_token']:"";
		
		if(intval($model->validateToken($pass_reset_record_type,$form_token))==1){
			if($pass_reset_record_type==1){
				if(Companies::model()->updateByPk($pass_reset_record,array('password'=>$md5_password,'raw_password'=>$password,'password_reset_token'=>'','initial_pass_changed'=>1))){
					//$returnValue= 1;
					$this->redirect(array('PasswordResetConfirmEdm'));
				}else{
					$returnValue= 0;
				}
			}else if($pass_reset_record_type==2){
				if(Users::model()->updateByPk($pass_reset_record,array('password'=>$md5_password,'raw_password'=>$password,'password_reset_token'=>'','initial_pass_changed'=>1))){
					//$returnValue= 1;
					$this->redirect(array('PasswordResetConfirmEdm'));
				}else{
					$returnValue= 0;
				}
			}else if($pass_reset_record_type==3){
				if(Systemusers::model()->updateByPk($pass_reset_record,array('password'=>$md5_password,'password_reset_token'=>''))){
					//$returnValue= 1;
					$this->redirect(array('PasswordResetConfirmEdm'));
				}else{
					$returnValue= 0;
				}
			}else if($pass_reset_record_type==4){
				if(Suppliers::model()->updateByPk($pass_reset_record,array('password'=>$md5_password,'raw_password'=>$password,'password_reset_token'=>'','initial_pass_changed'=>1))){
					//$returnValue= 1;
					$this->redirect(array('PasswordResetConfirmEdm'));
				}else{
					$returnValue= 0;
				}
			}
		}else{
			$returnValue =2;
		}
		echo $returnValue;	
	}
	
	
	
	 
	 public function actionchangepassword()
	 {
		 $password=isset($_REQUEST['password']) ? $_REQUEST['password']:"";
		 $md5_password=md5($password);
		 $LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ?  $_SESSION['LOGGED_IN_USER_KIND']:'';
		 $LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']):0;
		 
		 if($LOGGED_IN_USER_KIND=='company_user'){
			 $companiesData=Companies::model()->findByPk($LOGGED_IN_USER_ID);
			 if($companiesData->password!=$md5_password){
		if(Companies::model()->updateByPk($LOGGED_IN_USER_ID,array('password'=>$md5_password,'raw_password'=>$password,'changed_initial_password'=>1))){
					
					unset($_SESSION['LOGGED_IN_USER_NAMES']);
					unset($_SESSION['LOGGED_IN_USER_KIND']);
					unset($_SESSION['LOGGED_IN_USER_ID']);
					unset($_SESSION['LOGGED_IN_COMPANY']);
					unset($_SESSION['LOGGED_IN_COMPANY_NAME']);
					unset($_SESSION['USER_CHANGED_PASSWORD']);
					
				//Send EDM
				$this->redirect(array('PasswordchangeConfirmEdm', 
				'company_name'=>base64_encode($companiesData->title), 
				'contact_person'=>base64_encode($companiesData->contact_person), 
				'email'=>base64_encode($companiesData->email)));
				//End send EDM
				
				}else{
					echo 0;	 
				} 
				}else{
					echo 2;
				}
		 }else if($LOGGED_IN_USER_KIND=='company_sub_user'){
			 
			 $UsersData=Users::model()->findByPk($LOGGED_IN_USER_ID);
			 if($UsersData->password!=$md5_password){
				 if(Users::model()->updateByPk($LOGGED_IN_USER_ID,array('password'=>$md5_password,'raw_password'=>$password,'changed_initial_password'=>1))){
					//Send EDM
					
					unset($_SESSION['LOGGED_IN_USER_NAMES']);
					unset($_SESSION['LOGGED_IN_USER_KIND']);
					unset($_SESSION['LOGGED_IN_USER_ID']);
					unset($_SESSION['LOGGED_IN_COMPANY']);
					unset($_SESSION['LOGGED_IN_COMPANY_NAME']);
					unset($_SESSION['USER_CHANGED_PASSWORD']);


					$company_name="";
					$this->redirect(array('PasswordchangeConfirmEdm', 
					'company_name'=>base64_encode($company_name),
					'contact_person'=>base64_encode($UsersData->first_name." ".$UsersData->last_name), 
					'email'=>base64_encode($UsersData->email)));
					//End send EDM
				  }else{
					  echo 0;
				  }
			 }else{
				 	  echo 2;
			 }
		}else if($LOGGED_IN_USER_KIND=='supplier'){
		$SuppliersData=Suppliers::model()->findByPk($LOGGED_IN_USER_ID);
		if($SuppliersData->password!=$md5_password){
		if(Suppliers::model()->updateByPk($LOGGED_IN_USER_ID,array('password'=>$md5_password,'raw_password'=>$password,'changed_initial_password'=>1))){
		
		unset($_SESSION['LOGGED_IN_USER_NAMES']);
		unset($_SESSION['LOGGED_IN_USER_KIND']);
		unset($_SESSION['LOGGED_IN_USER_ID']);
		unset($_SESSION['LOGGED_IN_COMPANY']);
		unset($_SESSION['LOGGED_IN_COMPANY_NAME']);
		unset($_SESSION['USER_CHANGED_PASSWORD']);
		
		//Send EDM
		$this->redirect(array('PasswordchangeConfirmEdm', 
		'company_name'=>base64_encode($SuppliersData->title), 
		'contact_person'=>base64_encode($SuppliersData->contact_person), 
		'email'=>base64_encode($SuppliersData->email)));
		//End send EDM
		
		}else{
		echo 0;	 
		} 
		}else{
		echo 2;
		}
		}
	 }
	
	
      public function actionresetpassword()
	  {
		  $model=new Systemusers;
		   $email=isset($_REQUEST['email']) ? $_REQUEST['email']:"";
		   $Companies=Companies::model()->findByAttributes(array('email'=>$email)); 
 		   if(count($Companies)>0){
			       $pass_token=md5($model->getRandomString().$model->getRandomNumber());
					Companies::model()->updateByPk($Companies->id,array('password_reset_token'=>$pass_token));
					$this->redirect(array('edm', 
					'edm_reset_type'=>1, 
					'edm_user_names'=>base64_encode($Companies->contact_person), 
					'edm_pass_token'=>base64_encode($pass_token),
					'edm_email'=>base64_encode($Companies->email)
					));
						
		   }else{
			   $Users=Users::model()->findByAttributes(array('email'=>$email));
			   if(count($Users)>0){
			   	$pass_token=md5($model->getRandomString().$model->getRandomNumber());
					Users::model()->updateByPk($Users->id,array('password_reset_token'=>$pass_token));
					
					$this->redirect(array('edm', 
					'edm_reset_type'=>2, 
					'edm_user_names'=>base64_encode($Users->first_name." ".$Users->last_name), 
					'edm_pass_token'=>base64_encode($pass_token),
					'edm_email'=>base64_encode($Users->email)
					));
					
			   }else{
				 $Systemusers=Systemusers::model()->findByAttributes(array('email'=>$email)); 
				 if(count($Systemusers)>0){
			    	$pass_token=md5($model->getRandomString().$model->getRandomNumber());
					Systemusers::model()->updateByPk($Systemusers->id,array('password_reset_token'=>$pass_token));
					$this->redirect(array('edm',
					'edm_reset_type'=>3, 
					'edm_user_names'=>base64_encode($Systemusers->first_name." ".$Systemusers->last_name), 
					'edm_pass_token'=>base64_encode($pass_token),
					'edm_email'=>base64_encode($Systemusers->email)
					));
				 }else{
						$SuppliersUsers=Suppliers::model()->findByAttributes(array('email'=>$email)); 
						if(count($SuppliersUsers)>0){
						$pass_token=md5($model->getRandomString().$model->getRandomNumber());
						Suppliers::model()->updateByPk($SuppliersUsers->id,array('password_reset_token'=>$pass_token));
						$this->redirect(array('edm',
						'edm_reset_type'=>4, 
						'edm_user_names'=>base64_encode($SuppliersUsers->contact_person), 
						'edm_pass_token'=>base64_encode($pass_token),
						'edm_email'=>base64_encode($SuppliersUsers->email)
						));
						}else{
							echo 0;
						}
				 }  
			   }
			   
		   }
	  }
	  
	  
	   

	public function actionEdm()
	{
		$this->render('edm');
	}
	
	public function actionPasswordResetConfirmEdm()
	{
		$this->render('passwordresetconfirmedm');
	}
	
	public function actionPasswordchangeConfirmEdm()
	{
		$this->render('passwordchangeconfirmedm');
	}
	
	
	

	 

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	
	
	public function actionUpdate($id)
	{
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Systemusers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Systemusers']))
			$model->attributes=$_GET['Systemusers'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Systemusers the loaded model
	 * @throws CHttpException
	 */
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
