<?php
session_start();
error_reporting(0);
class ReportsController extends Controller
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
	public function AllowRoute($level)
	{
		$ADMIN_USER_ROLE_NAME=isset($_SESSION['ADMIN_USER_ROLE_NAME']) ? $_SESSION['ADMIN_USER_ROLE_NAME'] : "";
		$ADMIN_USER_ROLE_LEVEL=isset($_SESSION['ADMIN_USER_ROLE_LEVEL']) ? $_SESSION['ADMIN_USER_ROLE_LEVEL'] : "";	
		$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
		$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? $_SESSION['LOGGED_IN_USER_ID'] : "";
		$USER_CHANGED_PASSWORD=isset($_SESSION['USER_CHANGED_PASSWORD']) ? intval($_SESSION['USER_CHANGED_PASSWORD']) : 0;
		
	if($USER_CHANGED_PASSWORD>0){
		if($LOGGED_IN_USER_KIND=='admin_user'){
			   $return_value= true;
		}else if($LOGGED_IN_USER_KIND=='candidate_user'){
			if($level=='profile' || $level=='manifesto' || $level=='achivements' || $level=='questions' || $level=='candidate'){
				$return_value = true;
			}else{
				$return_value = false;
			}
		}else if($LOGGED_IN_USER_KIND=='candidate_admin_user'){
			
					$Candidate_areas=AccountAdminAreas::model()->findAllByAttributes(array('account_id'=>$LOGGED_IN_USER_ID));
					$actions_array=array();
					foreach($Candidate_areas as $item)
					{
						$admin_area_id=$item->admin_area_id;
						$ActionsAdminAreas=AdminAreas::model()->findByPk($admin_area_id);	
						$is_manifesto=$ActionsAdminAreas->is_manifesto;
						$is_profile=$ActionsAdminAreas->is_profile;
						$is_questions=$ActionsAdminAreas->is_questions;
						$is_achievements=$ActionsAdminAreas->is_achievements;
						if($is_manifesto==1){
							$actions_array[]='manifesto';
						}else if($is_profile==1){
							$actions_array[]='profile';
						}else if($is_questions==1){
							$actions_array[]='questions';
						}else if($is_achievements==1){
							$actions_array[]='achivements';
						}
					}
						if(in_array($level,$actions_array)){
							$return_value = true;
						}else{
							$return_value = false;
						}
			
		}
			if(!empty($return_value)){
				return $return_value;
			}else{
				return false;
			}	
		}else{
			return false;
		}
	}
	


	public function accessRules()
	{
		return array(
			array('allow',
			'actions'=>array('create','update','admin','delete','ExportExcell','ExportPDF','GetReport'),
			'users'=>array('*'),
			'expression'=>'Yii::app()->controller->AllowRoute("admin")',
			),
				
			array('allow',
			'actions'=>array('create','update','admin','delete','ExportExcell','ExportPDF','GetReport'),
			'users'=>array('*'),
			'expression'=>'Yii::app()->controller->AllowRoute("candidate")',
			),
			
			array('deny',
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
	public function actionCreate()
	{
		$model=new Votes;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Votes']))
		{
			$model->attributes=$_POST['Votes'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionGetReport()
	{
		$session=new CHttpSession;
        $session->open();	
		$model=new Countries;
		$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']):0;
		$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND']:'';
		$candidate_id=isset($_REQUEST['candidate_id']) ? intval($_REQUEST['candidate_id']):0;
		
		if($LOGGED_IN_USER_KIND=='candidate_user'){
			$record_id=$LOGGED_IN_USER_ID;
		}else if($LOGGED_IN_USER_KIND=='admin_user'){
			$record_id=$candidate_id;
		}
		
		echo $model->graphData($report,$record_id);
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

		if(isset($_POST['Votes']))
		{
			$model->attributes=$_POST['Votes'];
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
		$this->redirect(array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Votes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Votes']))
			$model->attributes=$_GET['Votes'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Votes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Votes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Votes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='votes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
