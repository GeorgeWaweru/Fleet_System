<?php
session_start();
error_reporting(0);
class CarAssignMechanicalIssuesController extends Controller
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
				'actions'=>array('create','update','admin','delete'),
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


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */

	public function actionCreate()
	{
		$model=new CarAssignMechanicalIssues;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CarAssignMechanicalIssues']))
		{
			$model->attributes=$_POST['CarAssignMechanicalIssues'];
			
			 $rnd = rand(0,9999);
			 $uploadedFile=CUploadedFile::getInstance($model,'photo');
			 $fileName = "{$rnd}-{$uploadedFile}";
			 if(!empty($uploadedFile)){
				$model->photo=$fileName;
			 }
			 $model->created_at=date('Y-m-d h:i:s', time());
			if($model->save())
				CarAssignment::model()->updateByPk($model->car_assignment_id,array('no_mechanical_issues'=>0));	
				if(!empty($uploadedFile)){
				$uploadedFile->saveAs(Yii::app()->basePath.'/../car_assign_mechanical_issues/'.$fileName);
				}
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
	public function actionUpdate()
	{
		if(isset($_REQUEST['id'])){
			$id=$_REQUEST['id'];
		}else{
			$id=$_REQUEST['id']=intval($_REQUEST['CarAssignMechanicalIssues']['id']);
		}
		
		$model=$this->loadModel($id);

		if(isset($_POST['CarAssignMechanicalIssues']))
		{
			$model->attributes=$_POST['CarAssignMechanicalIssues'];
			$photo_hidden=isset($_REQUEST['photo_hidden']) ? $_REQUEST['photo_hidden']:"";
			$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$fileName = "{$rnd}-{$uploadedFile}";
			if($uploadedFile=="" && $photo_hidden!="")
			{
				$model->photo=$photo_hidden;
			}else if($uploadedFile!="" && $photo_hidden=="")
			{
				$model->photo=$fileName;
			}else{
				$model->photo=$fileName;
			}
			if($model->save())
				if(!empty($uploadedFile)){
				if(file_exists(Yii::app()->basePath.'/../car_assign_mechanical_issues/'.$photo_hidden)){
					unlink(Yii::app()->basePath.'/../car_assign_mechanical_issues/'.$photo_hidden);
				}
					$uploadedFile->saveAs(Yii::app()->basePath.'/../car_assign_mechanical_issues/'.$fileName);
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
		$Data=CarAssignMechanicalIssues::model()->findByPk($id);
		$photo=$Data->photo;
		if(file_exists(Yii::app()->basePath.'/../car_assign_mechanical_issues/'.$photo)){
			unlink(Yii::app()->basePath.'/../car_assign_mechanical_issues/'.$photo);
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
		$model=new CarAssignMechanicalIssues('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CarAssignMechanicalIssues']))
			$model->attributes=$_GET['CarAssignMechanicalIssues'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CarAssignMechanicalIssues the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CarAssignMechanicalIssues::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CarAssignMechanicalIssues $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='car-assign-mechanical-issues-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
