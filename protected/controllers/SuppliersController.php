<?php
session_start();
error_reporting(0);
class SuppliersController extends Controller
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
		}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='TM'){
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
				'actions'=>array('admin'),
				'users'=>array('*'),
			),
			array('deny',
				'actions'=>array('create','update','delete','AccountCreateEdm','Associate'),
				'users'=>array('*'),
			),
		);	
		}else if($EnableRoutes==2){
			return array(
			array('allow',
				'actions'=>array('create','update','admin','delete','ExportExcell','AccountCreateEdm','Associate'),
				'users'=>array('*'),
			),
		);	
		}else{
			return array(
			array('deny',
				'actions'=>array('create','update','admin','delete','ExportExcell','AccountCreateEdm','Associate'),
				'users'=>array('*'),
			),
		);

		}
	}

	 
	public function actionAccountCreateEdm()
	{
		$this->render('AccountCreateEdm');
	}
	
	public function actionAssociate()
	{
		$supplier_id=isset($_REQUEST['supplier_id']) ? intval($_REQUEST['supplier_id']) :0;
		$action=isset($_REQUEST['action']) ? intval($_REQUEST['action']) :0;
		
		$company_id=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
		$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
		$CompanySuppliers=new CompanySuppliers;
		$companyAssociated=CompanySuppliers::model()->findAllByAttributes(array('supplier_id'=>$supplier_id,'company_id'=>$LOGGED_IN_COMPANY));
		if($action==1){
			if(count($companyAssociated)==0){
				$CompanySuppliers->supplier_id=$supplier_id;
				$CompanySuppliers->company_id=$LOGGED_IN_COMPANY;
				$CompanySuppliers->created_at=date('Y-m-d h:i:s', time());
				$CompanySuppliers->save($runValidation=false);
			}
		}else if($action==0){
			CompanySuppliers::model()->deleteAll("id=".$companyAssociated[0]->id."");
		}	
	}
	
	
	
	public function actionExportExcell()
	{	
		$session=new CHttpSession;
        $session->open();		
		$current_search_users_model=$_SESSION['current_search_suppliers_model'];
		$sql_header="SELECT s.*, c.title AS company_name FROM tbl_suppliers s JOIN tbl_companies c ON s.company_id=c.id";
		$loop_counter=0;
		$total_records=count(array_filter($_SESSION['current_search_suppliers'],create_function('$a','return trim($a)!=="";')));
		if($total_records>0){
			foreach(array_filter($_SESSION['current_search_suppliers'],create_function('$a','return trim($a)!=="";')) as $key => $value) {
					if($loop_counter==0){
						 $sql_body.=" WHERE s.".$key." LIKE '%".$_SESSION['current_search_suppliers_model'][$key]."%' AND s.is_default=0";
					}else{
					    $sql_body.=" AND s.".$key." LIKE '%".$_SESSION['current_search_suppliers_model'][$key]."%' AND s.is_default=0";
				}
			$loop_counter++;	
			}
			$sql=$sql_header.$sql_body;
		}else{
			$sql=$sql_header." WHERE s.is_default=0";
		}
		$sql=$sql." ORDER BY s.id DESC";
		$model= Yii::app()->db->createCommand($sql)->queryAll();
		Yii::app()->request->sendFile("Suppliers Report- ".date('YmdHis').'.xls',
			$this->renderPartial('report', array(
				'model'=>$model
			), true)
		);
	}

	
	
	public function actionCreate()
	{
		$model=new Suppliers;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Suppliers']))
		{
			
			$response=array();
			$model->attributes=$_POST['Suppliers'];
			
			
		   $reg_no_exists=Suppliers::model()->findAllByAttributes(array('reg_no'=>$model->reg_no));
		   if(count($reg_no_exists)>0){
				$response['field']='Suppliers_reg_no';
				$response['error_div']='reg_no_error';
				$response['error']="A company by the name <b>".$reg_no_exists[0]->title. "</b> Has been registered before with this registration number.";
				echo json_encode($response);
				exit;
			}
			
			
		   $email_exists=Suppliers::model()->findAllByAttributes(array('email'=>$model->email));
		   if(count($email_exists)>0){
				$response['field']='Suppliers_email';
				$response['error_div']='email_error';
				$response['error']='The email address already exists.';
				echo json_encode($response);
				exit;
			}
			
			
		   $email_exists=Companies::model()->findAllByAttributes(array('email'=>$model->email));
		   if(count($email_exists)>0){
				$response['field']='Suppliers_email';
				$response['error_div']='email_error';
				$response['error']='The email address already exists.';
				echo json_encode($response);
				exit;
			}
			
		   $email_exists=Users::model()->findAllByAttributes(array('email'=>$model->email));
		   if(count($email_exists)>0){
				$response['field']='Suppliers_email';
				$response['error_div']='email_error';
				$response['error']='The email address already exists.';
				echo json_encode($response);
				exit;
			}
			
		   $email_exists=Systemusers::model()->findAllByAttributes(array('email'=>$model->email));
		   if(count($email_exists)>0){
				$response['field']='Suppliers_email';
				$response['error_div']='email_error';
				$response['error']='The email address already exists.';
				echo json_encode($response);
				exit;
			}
			
			$supplier_name=$model->title;
			$reg_no=$model->reg_no;
			$contact_person=$model->contact_person;
			$email=$model->email;
			$Companies=Companies::model()->findByPk($LOGGED_IN_COMPANY);
			$Company_name=$Companies[0]->title;
			
			
			$raw_password=$model->getRandomString().$model->getRandomNumber();
			$md5_password=md5($raw_password);
			$model->raw_password=$raw_password;
			$model->password=$md5_password;
			
			$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
			$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
			$model->company_id=$LOGGED_IN_COMPANY;
			$model->created_at=date('Y-m-d h:i:s', time());
			
			if($model->save())
			
			$CompanySuppliers=new CompanySuppliers;
			$CompanySuppliers->supplier_id=$model->getLastRecordID();
			$CompanySuppliers->company_id=$LOGGED_IN_COMPANY;
			$CompanySuppliers->created_at=date('Y-m-d h:i:s', time());
			$CompanySuppliers->save($runValidation=false);
			
			//Send EDM
			$this->redirect(array('AccountCreateEdm', 
			'supplier_name'=>base64_encode($supplier_name), 
			'reg_no'=>base64_encode($reg_no), 
			'Company_name'=>base64_encode($Company_name), 
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
			$id=$_REQUEST['id']=intval($_REQUEST['Suppliers']['id']);
		}
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Suppliers']))
		{
			$model->attributes=$_POST['Suppliers'];
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Suppliers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Suppliers']))
			$model->attributes=$_GET['Suppliers'];
			
			if(isset($model->attributes)){
				$_SESSION['current_search_suppliers']=$model->attributes;		
			}
			
		$_SESSION['current_search_suppliers_model']=$model;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Suppliers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Suppliers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Suppliers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='suppliers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
