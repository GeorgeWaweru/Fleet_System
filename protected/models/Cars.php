<?php

/**
 * This is the model class for table "tbl_cars".
 *
 * The followings are the available columns in table 'tbl_cars':
 * @property integer $id
 * @property integer $company_id
 * @property integer $make_id
 * @property integer $model_id
 * @property integer $body_type_id
 * @property string $number_plate
 * @property string $photo
 * @property integer $service_millage
 * @property integer $year_id
 * @property integer $consumption
 * @property string $fuel_type
 * @property string $chasis_number
 * @property integer $engine_id
 * @property string $millage
 * @property string $country
 * @property integer $tyre_id
 * @property string $last_service_date
 * @property string $last_service_millage
 * @property string $insurance_exp_date
 * @property integer $spare_tire
 * @property integer $fire_extinguisher
 * @property integer $jerk
 * @property integer $wheel_spanner
 * @property string $physical_damages
 * @property integer $no_physical_damages
 * @property string $mechanical_issues
 * @property integer $no_mechanical_issues
 * @property integer $is_assigned
 * @property integer $status
 * @property integer $car_taken_status
 * @property integer $is_default
 * @property string $created_at
 *
 * The followings are the available model relations:
 * @property TblCarAssignment[] $tblCarAssignments
 * @property TblCarMechanicalIssues[] $tblCarMechanicalIssues
 * @property TblCarPhysicalDamages[] $tblCarPhysicalDamages
 * @property TblCompanies $company
 * @property TblBodyType $bodyType
 * @property TblCarMake $make
 * @property TblCarModels $model
 * @property TblEngines $engine
 * @property TblCarYears $year
 * @property TblTyres $tyre
 * @property TblRequests[] $tblRequests
 * @property TblUsers[] $tblUsers
 */
class Cars extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_cars';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, make_id, model_id, body_type_id, number_plate, photo, service_millage, year_id, consumption, fuel_type, chasis_number, engine_id, millage, country, tyre_id, spare_tire, fire_extinguisher, jerk, wheel_spanner, created_at', 'required'),
			array('company_id, make_id, model_id, body_type_id, service_millage, year_id, consumption, engine_id, tyre_id, spare_tire, fire_extinguisher, jerk, wheel_spanner, no_physical_damages, no_mechanical_issues, is_assigned, status, car_taken_status, is_default', 'numerical', 'integerOnly'=>true),
			array('number_plate, photo, fuel_type, chasis_number, millage, country, last_service_millage', 'length', 'max'=>50),
			array('last_service_date, insurance_exp_date, physical_damages, mechanical_issues', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, make_id, model_id, body_type_id, number_plate, photo, service_millage, year_id, consumption, fuel_type, chasis_number, engine_id, millage, country, tyre_id, last_service_date, last_service_millage, insurance_exp_date, spare_tire, fire_extinguisher, jerk, wheel_spanner, physical_damages, no_physical_damages, mechanical_issues, no_mechanical_issues, is_assigned, status, car_taken_status, is_default, created_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'CarAssignments' => array(self::HAS_MANY, 'CarAssignment', 'car_id'),
			'CarMechanicalIssues' => array(self::HAS_MANY, 'CarMechanicalIssues', 'car_id'),
			'CarPhysicalDamages' => array(self::HAS_MANY, 'CarPhysicalDamages', 'car_id'),
			'company' => array(self::BELONGS_TO, 'Companies', 'company_id'),
			'bodyType' => array(self::BELONGS_TO, 'BodyType', 'body_type_id'),
			'make' => array(self::BELONGS_TO, 'CarMake', 'make_id'),
			'model' => array(self::BELONGS_TO, 'CarModels', 'model_id'),
			'engine' => array(self::BELONGS_TO, 'Engines', 'engine_id'),
			'year' => array(self::BELONGS_TO, 'CarYears', 'year_id'),
			'tyre' => array(self::BELONGS_TO, 'Tyres', 'tyre_id'),
			'Requests' => array(self::HAS_MANY, 'Requests', 'car_id'),
			'Users' => array(self::HAS_MANY, 'Users', 'car_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_id' => 'Company',
			'make_id' => 'Make',
			'model_id' => 'Model',
			'body_type_id' => 'Body Type',
			'number_plate' => 'Number Plate',
			'photo' => 'Photo',
			'service_millage' => 'Service Millage',
			'year_id' => 'Year',
			'consumption' => 'Consumption',
			'fuel_type' => 'Fuel Type',
			'chasis_number' => 'Chasis Number',
			'engine_id' => 'Engine',
			'millage' => 'Millage',
			'country' => 'Country',
			'tyre_id' => 'Tyre',
			'last_service_date' => 'Last Service Date',
			'last_service_millage' => 'Last Service Millage',
			'insurance_exp_date' => 'Insurance Exp Date',
			'spare_tire' => 'Spare Tire',
			'fire_extinguisher' => 'Fire Extinguisher',
			'jerk' => 'Jerk',
			'wheel_spanner' => 'Wheel Spanner',
			'physical_damages' => 'Physical Damages',
			'no_physical_damages' => 'No Physical Damages',
			'mechanical_issues' => 'Mechanical Issues',
			'no_mechanical_issues' => 'No Mechanical Issues',
			'is_assigned' => 'Is Assigned',
			'status' => 'Status',
			'car_taken_status' => 'Car Taken Status',
			'is_default' => 'Is Default',
			'created_at' => 'Created At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	 
	 
	 	 public function DisplayBanner($banner_name)
	{
		$name='Car';
		echo CHtml::image(Yii::app()->request->baseUrl.'/cars/'.$banner_name,$name,array("class"=>"banner_class","width"=>"100px"));
	}
	
	
	public function deleteRecord($id)
	{
		$delete_img=CHtml::image('images/delete.png');
		$edit_img=CHtml::image('images/update.png');
		$edit_controller=Yii::app()->controller->createUrl('update')."&id=".$id;
		$edit="<a href='$edit_controller' class='edit_btn'>$edit_img</a>";
		$delete="<a href='javascript:void(0);' class='delete_confirm delete_btn' id='$id'>$delete_img</a>";
		$output=$edit."      ".$delete;
		echo $output;
	}
	
	
	public function deleteChildRecord($id,$car_id,$childRecord)
	{
		$delete_img=CHtml::image('images/delete.png');
		$edit_img=CHtml::image('images/update.png');
		if($childRecord=='Mechanical')
		{
			$edit_controller=Yii::app()->controller->createUrl('CarMechanicalIssues/update')."&id=".$id;
			$delete_controller=1;
		}else if($childRecord=='Physical')
		{
			$edit_controller=Yii::app()->controller->createUrl('CarPhysicalDamages/update')."&id=".$id;
			$delete_controller=2;
		}
		$edit="<a href='$edit_controller' target='_blank' class='edit_btn'>$edit_img</a>";
		$delete="<a href='javascript:void(0);' onClick='DeleteRecord($delete_controller,$id,$car_id)' class='delete_confirm delete_btn'>$delete_img</a>";
		$output=$edit."     ".$delete;
		echo $output;
	}
	
	public function Status($status)
	{
		if($status==0){
		$text="<font color='#FF0000'>Inactive</font>";
		}else{
		$text="<font color='#000099'>Active</font>";
		}
		echo $text;
	}
	
	
	 protected function afterSave()
     {
         return $this->id;
     }
	 
 	 public function getLastRecordID()
 	 {
	  	return intval($this->afterSave());
  	 }
	 
	 
	 public function physicalDamages($id,$no_physical_damages)
	 {
		$add_controller=Yii::app()->controller->createUrl('CarPhysicalDamages/create')."&id=".$id;
		$view_controller=Yii::app()->controller->createUrl('CarPhysicalDamages/admin')."&id=".$id;
		$add_img=CHtml::image('images/add.png','alt=Add Physical Damage');
		$view_img=CHtml::image('images/view.png','alt=View Physical Damages');
		
		
		if($no_physical_damages==0)
		{
			$add="<a href='$add_controller' target='_blank' class='sub_details_add'>$add_img</a>";
		}else{
			
			$add="<span class='sub_details_view'>N/A</span>";
		}
		
		
		if($no_physical_damages==0){
			$CarPhysicalDamages=CarPhysicalDamages::model()->findAllByAttributes(array('car_id'=>$id)); 
			if(count($CarPhysicalDamages)>0)
			{
				$view="<a href='$view_controller' target='_blank' class='sub_details_view'>$view_img</a>";
			}else{
				$view="<span class='sub_details_view'>N/A</span>";
			}
		}else{
			$view="<span class='sub_details_view'>N/A</span>";
		}
		$output=$add."     ".$view;
		echo $output;
	 }
	 
	 
	 
	 public function MechanicalIssues($id,$no_mechanical_issues)
	 {
		$add_controller=Yii::app()->controller->createUrl('CarMechanicalIssues/create')."&id=".$id;
		$view_controller=Yii::app()->controller->createUrl('CarMechanicalIssues/admin')."&id=".$id;
		$add_img=CHtml::image('images/add.png','alt=Add Mechanical Issue');
		
		$view_img=CHtml::image('images/view.png','alt=View Mechanical Issue');
		
		if($no_mechanical_issues==0)
		{
			$add="<a href='$add_controller' target='_blank' class='sub_details_add'>$add_img</a>";
		}else{
			$add="N/A";
		}
		
		
		
		if($no_mechanical_issues==0)
		{
			$CarMechanicalIssues=CarMechanicalIssues::model()->findAllByAttributes(array('car_id'=>$id)); 
			if(count($CarMechanicalIssues)>0)
			{
				$view="<a href='$view_controller' target='_blank' class='sub_details_view'>$view_img</a>";
			}else{
				$view="N/A";
			}
		}else{
				$view="N/A";
		}
		$output=$add."     ".$view;
		echo $output;
	 }
	 
	 
	 public function ReportImage($banner_name,$path)
	 {
		 $site_path=Yii::app()->params['site_path'];
		 echo "<img src='".$site_path.$path."/".$banner_name."' width='80' height='80'>";
	 }
	 
	 public function ExportData($id)
	 { 
		$controller=Yii::app()->controller->createUrl('Cars/ExportData')."&id=".$id;
		$exportLink="<a href='".$controller."' target='_blank' class='sub_details_add'>Export</a>";
		echo $exportLink;
	 }

	public function DateFormart($Date)
	{
		$Day= date("d", strtotime($Date));
		$Month= date("M", strtotime($Date));
		$Year= date("Y", strtotime($Date));
		echo $Day."-".$Month."-".$Year;
	}



	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		if($LOGGED_IN_COMPANY>0){
			$criteria->compare('company_id',$LOGGED_IN_COMPANY);
		}else{
			$criteria->compare('company_id',$this->company_id);
		}
		$criteria->compare('make_id',$this->make_id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('body_type_id',$this->body_type_id);
		$criteria->compare('number_plate',$this->number_plate,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('service_millage',$this->service_millage);
		$criteria->compare('year_id',$this->year_id);
		$criteria->compare('consumption',$this->consumption);
		$criteria->compare('fuel_type',$this->fuel_type,true);
		$criteria->compare('chasis_number',$this->chasis_number,true);
		$criteria->compare('engine_id',$this->engine_id);
		$criteria->compare('millage',$this->millage,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('tyre_id',$this->tyre_id);
		$criteria->compare('last_service_date',$this->last_service_date,true);
		$criteria->compare('last_service_millage',$this->last_service_millage,true);
		$criteria->compare('insurance_exp_date',$this->insurance_exp_date,true);
		$criteria->compare('spare_tire',$this->spare_tire);
		$criteria->compare('fire_extinguisher',$this->fire_extinguisher);
		$criteria->compare('jerk',$this->jerk);
		$criteria->compare('wheel_spanner',$this->wheel_spanner);
		$criteria->compare('physical_damages',$this->physical_damages,true);
		$criteria->compare('no_physical_damages',$this->no_physical_damages);
		$criteria->compare('mechanical_issues',$this->mechanical_issues,true);
		$criteria->compare('no_mechanical_issues',$this->no_mechanical_issues);
		$criteria->compare('is_assigned',$this->is_assigned);
		$criteria->compare('status',$this->status);
		$criteria->compare('car_taken_status',$this->car_taken_status);
		$criteria->compare('is_default',0);
		$criteria->compare('created_at',$this->created_at,true);

		$criteria->order='id DESC';
		return new CActiveDataProvider(get_class($this), array(
		'pagination'=>array(
        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    	),
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cars the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
