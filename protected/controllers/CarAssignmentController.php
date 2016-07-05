<?php
session_start();
error_reporting(0);
class CarAssignmentController extends Controller
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
		if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='TM'){
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
				'actions'=>array('create','update','admin','delete','savePhysicalProblems','saveMechanicalIssues','getPhysicalDamages','getMechanicalIssues','ExportExcell','ExportData','Edm','sendEdm'),
				'users'=>array('*'),
			),
		);	
		}else{
			return array(
			array('deny',
				'actions'=>array('create','update','admin','delete','savePhysicalProblems','saveMechanicalIssues','getPhysicalDamages','getMechanicalIssues','ExportExcell','ExportData','Edm','sendEdm'),
				'users'=>array('*'),
			),
		);

		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	 
	 
	 
public function actionExportData()
	{	
		$id=$_REQUEST['id'] ? intval($_REQUEST['id']):0;
		$CarAssignment=CarAssignment::model()->findByPk($id);	
		$car_id=$CarAssignment->car_id;
		$Cars=Cars::model()->findByPk($car_id);
		$report_name=$Cars->number_plate;
		Yii::app()->request->sendFile($report_name." -Report".'.xls',
			$this->renderPartial('single_report', array(
				'id'=>$id
			), true)
		);
	}


	public function actionExportExcell()
	{	
		$session=new CHttpSession;
        $session->open();
		$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
		$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
		$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
		$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
		
		$sql_header="SELECT ca.*, c.number_plate,make.title AS car_make,model.title AS car_model,u.first_name,u.last_name,comp.title AS company_name"."
					 FROM tbl_car_assignment ca JOIN tbl_cars c ON c.id=ca.car_id JOIN tbl_car_make make ON make.id=c.make_id JOIN tbl_car_models model"."
					 ON model.id=c.model_id JOIN tbl_users u ON u.id=ca.user_id JOIN tbl_companies comp ON comp.id=ca.company_id";
		$loop_counter=0;
		$total_records=count(array_filter($_SESSION['current_search_CarAssignment'],create_function('$a','return trim($a)!=="";')));
		if($total_records>0){
			foreach(array_filter($_SESSION['current_search_CarAssignment'],create_function('$a','return trim($a)!=="";')) as $key => $value) {
					if($loop_counter==0){
						 $sql_body.=" WHERE ca.".$key." LIKE '%".$_SESSION['current_search_CarAssignment_model'][$key]."%'";
					}else{
					    $sql_body.=" AND ca.".$key." LIKE '%".$_SESSION['current_search_CarAssignment_model'][$key]."%'";
				}
			$loop_counter++;	
			}
			$sql=$sql_header.$sql_body;
		}else{
			$sql=$sql_header;
		}
		
		if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND!='admin_user'){
			$sql=$sql." AND ca.company_id=".$LOGGED_IN_COMPANY." ORDER BY ca.id DESC";
		}else{
			$sql=$sql." ORDER BY ca.id DESC";
		}
		$model= Yii::app()->db->createCommand($sql)->queryAll();
		Yii::app()->request->sendFile("Cars Assignment Report- ".date('YmdHis').'.xls',
			$this->renderPartial('report', array(
				'model'=>$model
			), true)
		);
	}

    public function actionEdm()
	{
		$this->render('Edm');
	}
	
	
	public function actionsendEdm()
	{
		$id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		$this->redirect(array('Edm', 
		'id'=>base64_encode($id)));
	}
	
	
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	 
	 	
	public function actiongetPhysicalDamages()
	{
		$model=new CarAssignment;
		$car_assignment_id=isset($_REQUEST['car_assignment_id']) ? intval($_REQUEST['car_assignment_id']) :0;
		$Data=CarAssignPhysicalDamages::model()->findAllByAttributes(array('car_assignment_id'=>$car_assignment_id,'status'=>1));
		if(count($Data)>0)
		{
		?>
		<table>
		<tr><td><b>Photo</b></td><td><b>Description</b></td><td><b>Edit / Delete</b></td></tr>
		<?php
		foreach($Data as $item)
		{
			?>
			<tr>
			<td>
			<?php echo CHtml::image(Yii::app()->request->baseUrl.'/car_assign_physical_damage/'.$item->photo,$name,array("class"=>"banner_class","width"=>"100px"));?>
			</td>
			<td><?php echo $item->description;?></td>
			<td><?php echo $model->deleteChildRecord($item->id,$item->car_assignment_id,'Physical');?></td>
			</tr>
			<?php
			}
		}
		?>
        </table>
        <?php
	}
	
	public function actiongetMechanicalIssues()
	{
		$model=new CarAssignment;
		$car_assignment_id=isset($_REQUEST['car_assignment_id']) ? intval($_REQUEST['car_assignment_id']) :0;
		$Data=CarAssignMechanicalIssues::model()->findAllByAttributes(array('car_assignment_id'=>$car_assignment_id,'status'=>1));
		if(count($Data)>0)
		{
		?>
        <table>
        <tr><td><b>Photo</b></td><td><b>Description</b></td><td><b>Edit / Delete</b></td></tr>
        <?php
		foreach($Data as $item)
		{
			?>
            <tr>
            <td>
            <?php echo CHtml::image(Yii::app()->request->baseUrl.'/car_assign_mechanical_issues/'.$item->photo,$name,array("class"=>"banner_class","width"=>"100px"));?>
            </td>
            <td><?php echo $item->description;?></td>
            <td><?php echo $model->deleteChildRecord($item->id,$item->car_assignment_id,'Mechanical');?></td>
            </tr>
            <?php
			}
		}
		?>
        </table>
        <?php
	}



	public function actionsavePhysicalProblems()
	{
		$model=new CarAssignPhysicalDamages;
		if(isset($_POST['CarAssignPhysicalDamages']))
		{
			$model->attributes=$_POST['CarAssignPhysicalDamages'];
			$response=array(); 
			$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$fileName = "{$rnd}-{$uploadedFile}";
			$model->photo=$fileName;
			$model->created_at=date('Y-m-d h:i:s', time());
			if($model->save())
			if(!empty($uploadedFile)){
				$uploadedFile->saveAs(Yii::app()->basePath.'/../car_assign_physical_damage/'.$fileName);
			}
			echo 1; 
		}
	}
	
	public function actionsaveMechanicalIssues()
	{
		$model=new CarAssignMechanicalIssues;
		if(isset($_POST['CarAssignMechanicalIssues']))
		{
     		$model->attributes=$_POST['CarAssignMechanicalIssues'];
			$response=array(); 
			$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$fileName = "{$rnd}-{$uploadedFile}";
			$model->photo=$fileName;
			$model->created_at=date('Y-m-d h:i:s', time());
			if($model->save())
			if(!empty($uploadedFile)){
				$uploadedFile->saveAs(Yii::app()->basePath.'/../car_assign_mechanical_issues/'.$fileName);
			}
			echo 1; 
		}
	}
	
	
	public function actionCreate()
	{
		$model=new CarAssignment;
		if(isset($_POST['CarAssignment']))
		{
			$model->attributes=$_POST['CarAssignment'];
			$model->created_at=date('Y-m-d h:i:s', time());
			$CarsData=Cars::model()->findByPk($model->car_id);
			$UsersData=Users::model()->findByPk($model->user_id);
			if($model->save())
				Cars::model()->updateByPk($model->car_id,array('is_assigned'=>1));
				Users::model()->updateByPk($model->user_id,array('car_id'=>$model->car_id));
			 	echo $model->no_physical_damages." ".$model->no_mechanical_issues." ".$model->getLastRecordID();
				//$this->redirect(array('view','id'=>$model->id));
		}
		
		if(!isset($_POST['CarAssignment'])){
			$this->render('create',array(
				'model'=>$model,
			));
		}
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

		if(isset($_POST['CarAssignment']))
		{
			$model->attributes=$_POST['CarAssignment'];
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
	public function actionDelete($id,$car_id)
	{
		Cars::model()->updateByPk($car_id,array('is_assigned'=>0));
		// update users to the default car for the user who had this car.
		$CarAssignment=CarAssignment::model()->findByPk($id);
		$default_car=Cars::model()->findByAttributes(array('is_default'=>1,'status'=>1)); 
		$default_car_id=$default_car->id;
		Users::model()->updateByPk(intval($CarAssignment->user_id),array('car_id'=>$default_car_id));
				
				
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
		$model=new CarAssignment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CarAssignment']))
			$model->attributes=$_GET['CarAssignment'];

			if(isset($model->attributes)){
				$_SESSION['current_search_CarAssignment']=$model->attributes;		
			}
			$_SESSION['current_search_CarAssignment_model']=$model;
			
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CarAssignment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CarAssignment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CarAssignment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='car-assignment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
