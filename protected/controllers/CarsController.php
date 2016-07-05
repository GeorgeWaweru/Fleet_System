<?php
session_start();
error_reporting(0);
class CarsController extends Controller
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
		}else if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
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
				'actions'=>array('create','update','admin','delete','getModels','savePhysicalProblems','saveMechanicalIssues','getPhysicalDamages','getMechanicalIssues','ExportExcell','ExportData','Servicerequest','Repairrequest','Fuelrequest'),
				'users'=>array('*'),
			),
		);	
		}else if($EnableRoutes==2){
			return array(
			array('deny',
				'actions'=>array('create','update','delete','savePhysicalProblems','saveMechanicalIssues','getPhysicalDamages','getMechanicalIssues','Servicerequest','Repairrequest','Fuelrequest'),
				'users'=>array('*'),
			),
		);	
		}else{
			return array(
			array('deny',
				'actions'=>array('create','update','admin','delete','getModels','savePhysicalProblems','saveMechanicalIssues','getPhysicalDamages','getMechanicalIssues','ExportExcell','ExportData','Servicerequest','Repairrequest','Fuelrequest'),
				'users'=>array('*'),
			),
		);

		}
	}
	

public function actionExportData()
	{	
		$id=$_REQUEST['id'] ? intval($_REQUEST['id']):0;
		$Cars=Cars::model()->findByPk($id);	
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
		$current_search_Cars_model=$_SESSION['current_search_Cars_model'];
		$sql_header="SELECT c.*,comp.title AS Company, make.title AS car_make,model.title AS car_model,b.title AS body_type,cy.title AS Car_year,"."
					 e.title AS Engine_model,t.title AS car_Tyre FROM tbl_cars c JOIN tbl_car_make make ON c.make_id=make.id JOIN tbl_car_models"."
					 model ON c.model_id=model.id JOIN tbl_body_type b ON c.body_type_id=b.id JOIN tbl_car_years cy ON cy.id=c.year_id JOIN"."
					 tbl_engines e ON e.id=c.engine_id JOIN tbl_tyres t ON t.id=c.tyre_id JOIN tbl_companies comp ON comp.id=c.company_id";
		$loop_counter=0;
		$total_records=count(array_filter($_SESSION['current_search_Cars'],create_function('$a','return trim($a)!=="";')));
		if($total_records>0){
			foreach(array_filter($_SESSION['current_search_Cars'],create_function('$a','return trim($a)!=="";')) as $key => $value) {
					if($loop_counter==0){
						 $sql_body.=" WHERE c.".$key." LIKE '%".$_SESSION['current_search_Cars_model'][$key]."%' AND c.is_default=0";
					}else{
					    $sql_body.=" AND c.".$key." LIKE '%".$_SESSION['current_search_Cars_model'][$key]."%' AND c.is_default=0";
				}
			$loop_counter++;	
			}
			$sql=$sql_header.$sql_body;
		}else{
			$sql=$sql_header." WHERE c.is_default=0";
		}
		
		if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND!='admin_user'){
			$sql=$sql." AND c.company_id=".$LOGGED_IN_COMPANY." ORDER BY c.id DESC";
		}else{
			$sql=$sql." ORDER BY c.id DESC";
		}
		
		$model= Yii::app()->db->createCommand($sql)->queryAll();
		Yii::app()->request->sendFile("Cars Report- ".date('YmdHis').'.xls',
			$this->renderPartial('report', array(
				'model'=>$model
			), true)
		);
	}


	public function actiongetModels()
	{
		$make_id=isset($_REQUEST['make_id']) ? intval($_REQUEST['make_id']) :0;
		$Data=CarModels::model()->findAllByAttributes(array('make_id'=>$make_id,'status'=>1,'is_default'=>0));
		if(count($Data)>0)
		{	
			$data_array=array();
			foreach($Data as $item)
			{
			   $id= $item->id;
			   $title=$item->title;
			   $data_array[$id]=$title;
			}
			echo json_encode($data_array);
		}
	}
	
	
	public function actiongetPhysicalDamages()
	{
		$model=new Cars;
		$car_id=isset($_REQUEST['car_id']) ? intval($_REQUEST['car_id']) :0;
		$Data=CarPhysicalDamages::model()->findAllByAttributes(array('car_id'=>$car_id,'status'=>1));
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
			<?php echo CHtml::image(Yii::app()->request->baseUrl.'/car_physical_damage/'.$item->photo,$name,array("class"=>"banner_class","width"=>"100px"));?>
			</td>
			<td><?php echo $item->description;?></td>
			<td><?php echo $model->deleteChildRecord($item->id,$item->car_id,'Physical');?></td>
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
		$model=new Cars;
		$car_id=isset($_REQUEST['car_id']) ? intval($_REQUEST['car_id']) :0;
		$Data=CarMechanicalIssues::model()->findAllByAttributes(array('car_id'=>$car_id,'status'=>1));
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
            <?php echo CHtml::image(Yii::app()->request->baseUrl.'/car_mechanical_issues/'.$item->photo,$name,array("class"=>"banner_class","width"=>"100px"));?>
            </td>
            <td><?php echo $item->description;?></td>
            <td><?php echo $model->deleteChildRecord($item->id,$item->car_id,'Mechanical');?></td>
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
		$model=new CarPhysicalDamages;
		if(isset($_POST['CarPhysicalDamages']))
		{
			$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
			$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
			$model->attributes=$_POST['CarPhysicalDamages'];
			$response=array(); 
			$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$fileName = "{$rnd}-{$uploadedFile}";
			$model->photo=$fileName;
			$model->company_id=$LOGGED_IN_COMPANY;
			$model->created_at=date('Y-m-d h:i:s', time());
			if($model->save())
			if(!empty($uploadedFile)){
				$uploadedFile->saveAs(Yii::app()->basePath.'/../car_physical_damage/'.$fileName);
			}
			echo 1; 
		}
	}
	
	public function actionsaveMechanicalIssues()
	{
		$model=new CarMechanicalIssues;
		if(isset($_POST['CarMechanicalIssues']))
		{
			$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
			$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
     		$model->attributes=$_POST['CarMechanicalIssues'];
			$response=array(); 
			$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$fileName = "{$rnd}-{$uploadedFile}";
			$model->photo=$fileName;
			$model->company_id=$LOGGED_IN_COMPANY;
			$model->created_at=date('Y-m-d h:i:s', time());
			if($model->save())
			if(!empty($uploadedFile)){
				$uploadedFile->saveAs(Yii::app()->basePath.'/../car_mechanical_issues/'.$fileName);
			}
			echo 1; 
		}
	}
	
	public function actionCreate()
	{
		$model=new Cars;
		if(isset($_POST['Cars']))
		{
			 $model->attributes=$_POST['Cars'];
			 $response=array(); 
     		 $rnd = rand(0,9999);
			 $uploadedFile=CUploadedFile::getInstance($model,'photo');
			 $fileName = "{$rnd}-{$uploadedFile}";

			  $plate_exists=Cars::model()->findAllByAttributes(array('number_plate'=>$model->number_plate));
			  if(count($plate_exists)>0){
					$response['field']='Cars_number_plate';
					$response['error_div']='number_plate_error';
					$response['error']='The car number plate already exists.';
					echo json_encode($response);
					exit;
				}

			$model->photo=$fileName;
			$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
			$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
			$model->company_id=$LOGGED_IN_COMPANY;
			$model->created_at=date('Y-m-d h:i:s', time());
			
			if($model->save())
			if(!empty($uploadedFile)){
						$uploadedFile->saveAs(Yii::app()->basePath.'/../cars/'.$fileName);
					}
		    echo $model->no_physical_damages." ".$model->no_mechanical_issues." ".$model->getLastRecordID();
					
				//$this->redirect(array('admin'));
		}

		if(!isset($_POST['Cars'])){
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
	public function actionUpdate()
	{	
		if(isset($_REQUEST['id'])){
			$id=$_REQUEST['id'];
		}else{
			$id=$_REQUEST['id']=intval($_REQUEST['Cars']['id']);
		}
		
		$model=$this->loadModel($id);
		if(isset($_POST['Cars']))
		{
			$response=array();
			$cars_hidden=isset($_REQUEST['cars_hidden']) ? $_REQUEST['cars_hidden']:"";
			$rnd = rand(0,9999);
			$uploadedFile=CUploadedFile::getInstance($model,'photo');
			$fileName = "{$rnd}-{$uploadedFile}";
			
			$model->attributes=$_POST['Cars'];
			
			if($uploadedFile=="" && $cars_hidden!="")
			{
				$model->photo=$cars_hidden;
			}else if($uploadedFile!="" && $cars_hidden=="")
			{
				$model->photo=$fileName;
			}else{
				$model->photo=$fileName;
			}
		    //$plateExists=Cars::model()->findAllByAttributes(array('number_plate'=>$model->number_plate));
			
			if($model->save())
			
			if(!empty($uploadedFile)){
				if(file_exists(Yii::app()->basePath.'/../cars/'.$cars_hidden))
				{
					unlink(Yii::app()->basePath.'/../cars/'.$cars_hidden);
				}
				     $uploadedFile->saveAs(Yii::app()->basePath.'/../cars/'.$fileName);
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
		$Cars=Cars::model()->findByPk($id);
		$photo=$Cars->photo;
		if(file_exists(Yii::app()->basePath.'/../cars/'.$photo)){
			unlink(Yii::app()->basePath.'/../cars/'.$photo);
		}

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
		 
		$model=new Cars('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cars']))
			$model->attributes=$_GET['Cars'];
			
			if(isset($model->attributes)){
				$_SESSION['current_search_Cars']=$model->attributes;		
			}
			$_SESSION['current_search_Cars_model']=$model;
			
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cars the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cars::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cars $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cars-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
