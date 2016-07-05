<?php
error_reporting(0);
session_start();
class SpareController extends Controller
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
				'actions'=>array('create','update','admin','delete','ExportExcell'),
				'users'=>array('*'),
			),
		);	
		}else{
			return array(
			array('deny',
				'actions'=>array('create','update','admin','delete','ExportExcell'),
				'users'=>array('*'),
			),
		);

		}
	}
	
	
	
	public function actionExportExcell()
	{	
		$session=new CHttpSession;
        $session->open();		
		$current_search_SubSystem_model=$_SESSION['current_search_Spares_model'];
		$sql_header="SELECT spares.*, subsystem.title AS sub_system FROM tbl_spare spares JOIN tbl_sub_system subsystem ON spares.sub_system_id=subsystem.id";
		$loop_counter=0;
		$total_records=count(array_filter($_SESSION['current_search_Spares'],create_function('$a','return trim($a)!=="";')));
		if($total_records>0){
			foreach(array_filter($_SESSION['current_search_Spares'],create_function('$a','return trim($a)!=="";')) as $key => $value) {
					if($loop_counter==0){
						 $sql_body.=" WHERE spares.".$key." LIKE '%".$_SESSION['current_search_Spares_model'][$key]."%'";
					}else{
					    $sql_body.=" AND spares.".$key." LIKE '%".$_SESSION['current_search_Spares_model'][$key]."%'";
				}
			$loop_counter++;	
			}
			$sql=$sql_header.$sql_body;
		}else{
			$sql=$sql_header;
		}
		$sql=$sql." ORDER BY spares.id DESC";
		$model= Yii::app()->db->createCommand($sql)->queryAll();
		Yii::app()->request->sendFile("Spares Report- ".date('YmdHis').'.xls',
			$this->renderPartial('report', array(
				'model'=>$model
			), true)
		);
	}

	public function actionCreate()
	{
		$model=new Spare;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Spare']))
		{
			$model->attributes=$_POST['Spare'];
			
			$response=array(); 
			  $SpareExists=Spare::model()->findAllByAttributes(array('title'=>$model->title,'sub_system_id'=>$model->sub_system_id));
			  if(count($SpareExists)>0){
					$response['field']='Spare_title';
					$response['error_div']='title_error';
					$response['error']='The car sub system already exists.';
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

		if(isset($_POST['Spare']))
		{
			$model->attributes=$_POST['Spare'];
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
		$model=new Spare('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Spare']))
			$model->attributes=$_GET['Spare'];

		if(isset($model->attributes)){
			$_SESSION['current_search_Spares']=$model->attributes;		
		}
			$_SESSION['current_search_Spares_model']=$model;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Spare the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Spare::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Spare $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='spare-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
