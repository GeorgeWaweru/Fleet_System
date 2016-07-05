<?php
error_reporting(0);
session_start();
class SubSystemController extends Controller
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
			array('allow',
				'actions'=>array('create','update','admin','ExportExcell'),
				'users'=>array('*'),
			),
		);	
		}else{
			return array(
			array('deny',
				'actions'=>array('create','update','admin','ExportExcell'),
				'users'=>array('*'),
			),
		);

		}
	}

	 
	public function actionExportExcell()
	{	
		$session=new CHttpSession;
        $session->open();		
		$current_search_SubSystem_model=$_SESSION['current_search_SubSystem_model'];
		$sql_header="SELECT subsys.* ,system.title AS system_title FROM tbl_sub_system subsys JOIN tbl_system system ON subsys.system_id=system.id";
		$loop_counter=0;
		$total_records=count(array_filter($_SESSION['current_search_SubSystem'],create_function('$a','return trim($a)!=="";')));
		if($total_records>0){
			foreach(array_filter($_SESSION['current_search_SubSystem'],create_function('$a','return trim($a)!=="";')) as $key => $value) {
					if($loop_counter==0){
						 $sql_body.=" WHERE subsys.".$key." LIKE '%".$_SESSION['current_search_SubSystem_model'][$key]."%' AND subsys.is_default=0";
					}else{
					    $sql_body.=" AND subsys.".$key." LIKE '%".$_SESSION['current_search_SubSystem_model'][$key]."%' AND subsys.is_default=0";
				}
			$loop_counter++;	
			}
			$sql=$sql_header.$sql_body;
		}else{
			$sql=$sql_header." WHERE subsys.is_default=0";
		}
		$sql=$sql." ORDER BY subsys.id DESC";
	
		$model= Yii::app()->db->createCommand($sql)->queryAll();
		Yii::app()->request->sendFile("Sub Systems Report- ".date('YmdHis').'.xls',
			$this->renderPartial('report', array(
				'model'=>$model
			), true)
		);
	}



	public function actionCreate()
	{
		$model=new SubSystem;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SubSystem']))
		{
			$model->attributes=$_POST['SubSystem'];
			
			  $response=array(); 
			  $SubSystemExists=SubSystem::model()->findAllByAttributes(array('title'=>$model->title,'system_id'=>$model->system_id));
			  if(count($SubSystemExists)>0){
					$response['field']='SubSystem_title';
					$response['error_div']='title_error';
					$response['error']='The spare Part already exists.';
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
	public function actionUpdate()
	{
		if(isset($_REQUEST['id'])){
			$id=$_REQUEST['id'];
		}else{
			$id=$_REQUEST['id']=intval($_REQUEST['SubSystem']['id']);
		}
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SubSystem']))
		{
			$model->attributes=$_POST['SubSystem'];
			if($model->save())
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
		$session=new CHttpSession;
        $session->open();		
		$model=new SubSystem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SubSystem']))
			$model->attributes=$_GET['SubSystem'];

		if(isset($model->attributes)){
		$_SESSION['current_search_SubSystem']=$model->attributes;		
		}
		$_SESSION['current_search_SubSystem_model']=$model;


		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SubSystem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SubSystem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SubSystem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sub-system-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
