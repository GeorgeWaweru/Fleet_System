<?php
session_start();
error_reporting(0);
class SupplierSystemsController extends Controller
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
		if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='supplier'){
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
				'actions'=>array('create','update','admin','delete','ExportExcell','AccountCreateEdm'),
				'users'=>array('*'),
			),
		);	
		}else{
			return array(
			array('deny',
				 'actions'=>array('create','update','admin','delete','ExportExcell','AccountCreateEdm'),
				'users'=>array('*'),
			),
		);

		}
	}
	
	

	
	public function actionCreate()
	{
		$model=new SupplierSystems;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SupplierSystems']))
		{
			$response=array();
			$model->attributes=$_POST['SupplierSystems'];
			$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] :"";
			$supplier_id=isset($_SESSION['LOGGED_IN_USER_ID']) ? $_SESSION['LOGGED_IN_USER_ID'] :"";
			
			$model->supplier_id=$supplier_id;
		   $SupplierSystems=SupplierSystems::model()->findAllByAttributes(array('system_id'=>$model->system_id,'supplier_id'=>$model->supplier_id));
		   if(count($SupplierSystems)>0){
				$response['field']='SupplierSystems_system_id';
				$response['error_div']='system_error';
				$response['error']="This system is already registed with this supplier.";
				echo json_encode($response);
				exit;
			}
			
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

		if(isset($_POST['SupplierSystems']))
		{
			$model->attributes=$_POST['SupplierSystems'];
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
		$model=new SupplierSystems('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SupplierSystems']))
			$model->attributes=$_GET['SupplierSystems'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SupplierSystems the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SupplierSystems::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SupplierSystems $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='supplier-systems-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
