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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
					'actions'=>array('index','view','create','update','admin','delete','ExportExcell','AccountCreateEdm'),
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
	 
	public function actionAccountCreateEdm()
	{
		$this->render('AccountCreateEdm');
	}
	
	
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
						 $sql_body.=" WHERE c.".$key." LIKE '%".$_SESSION['current_search_Companies_model'][$key]."%'";
					}else{
					    $sql_body.=" AND c.".$key." LIKE '%".$_SESSION['current_search_Companies_model'][$key]."%'";
				}
			$loop_counter++;	
			}
			$sql=$sql_header.$sql_body;
		}else{
			$sql=$sql_header;
		}
		$model= Yii::app()->db->createCommand($sql)->queryAll();
		Yii::app()->request->sendFile("Companies Report- ".date('YmdHis').'.xls',
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
				$response['error']="A company by the name ".$reg_no_exists[0]->title. " Has been registered before with this registration number.";
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
			$Companies=Companies::model()->findByPk($LOGGED_IN_USER_ID);
			$Company_name=$Companies[0]->title;
			
			
			$raw_password=$model->getRandomString().$model->getRandomNumber();
			$md5_password=md5($raw_password);
			$model->raw_password=$raw_password;
			$model->password=$md5_password;
			
			$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
			$model->company_id=$LOGGED_IN_USER_ID;
			$model->created_at=date('Y-m-d h:i:s', time());
			
		
			if($model->save())
			
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Suppliers');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
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
