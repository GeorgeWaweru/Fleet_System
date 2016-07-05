<?php

/**
 * This is the model class for table "tbl_car_assignment".
 *
 * The followings are the available columns in table 'tbl_car_assignment':
 * @property integer $id
 * @property integer $car_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $spare_tire
 * @property integer $fire_extinguisher
 * @property integer $jerk
 * @property integer $wheel_spanner
 * @property string $physical_damages
 * @property integer $no_physical_damages
 * @property string $mechanical_issues
 * @property integer $no_mechanical_issues
 * @property string $created_at
 * @property integer $email_sent
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblCarAssignMechanicalIssues[] $tblCarAssignMechanicalIssues
 * @property TblCarAssignPhysicalDamages[] $tblCarAssignPhysicalDamages
 * @property TblCars $car
 * @property TblUsers $user
 * @property TblCompanies $company
 */
class CarAssignment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_car_assignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('car_id, user_id, company_id, created_at', 'required'),
			array('car_id, user_id, company_id, spare_tire, fire_extinguisher, jerk, wheel_spanner, no_physical_damages, no_mechanical_issues, email_sent, status', 'numerical', 'integerOnly'=>true),
			array('physical_damages, mechanical_issues', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, car_id, user_id, company_id, spare_tire, fire_extinguisher, jerk, wheel_spanner, physical_damages, no_physical_damages, mechanical_issues, no_mechanical_issues, created_at, email_sent, status', 'safe', 'on'=>'search'),
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
			'CarAssignMechanicalIssues' => array(self::HAS_MANY, 'CarAssignMechanicalIssues', 'car_assignment_id'),
			'CarAssignPhysicalDamages' => array(self::HAS_MANY, 'CarAssignPhysicalDamages', 'car_assignment_id'),
			'car' => array(self::BELONGS_TO, 'Cars', 'car_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'company' => array(self::BELONGS_TO, 'Companies', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'car_id' => 'Car',
			'user_id' => 'User',
			'company_id' => 'Company',
			'spare_tire' => 'Spare Tire',
			'fire_extinguisher' => 'Fire Extinguisher',
			'jerk' => 'Jerk',
			'wheel_spanner' => 'Wheel Spanner',
			'physical_damages' => 'Physical Damages',
			'no_physical_damages' => 'No Physical Damages',
			'mechanical_issues' => 'Mechanical Issues',
			'no_mechanical_issues' => 'No Mechanical Issues',
			'created_at' => 'Created At',
			'email_sent' => 'Email Sent',
			'status' => 'Status',
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
	 
	 	public function deleteRecord($id,$car_id)
	{
		$final_id_value=$id."#".$car_id;
		$delete_img=CHtml::image('images/delete.png');
		$edit_img=CHtml::image('images/update.png');
		$edit_controller=Yii::app()->controller->createUrl('update')."&id=".$id;
		$edit="<a href='$edit_controller' class='edit_btn'>$edit_img</a>";
		$delete="<a href='javascript:void(0);' class='delete_confirm delete_btn' id=".$final_id_value.">".$delete_img."</a>";
		$output=$edit."      ".$delete;
		echo $output;
	}
	
	
	public function deleteChildRecord($id,$car_id,$childRecord)
	{
		$delete_img=CHtml::image('images/delete.png');
		$edit_img=CHtml::image('images/update.png');
		if($childRecord=='Mechanical')
		{
			$edit_controller=Yii::app()->controller->createUrl('CarAssignMechanicalIssues/update')."&id=".$id;
			$delete_controller=1;
		}else if($childRecord=='Physical')
		{
			$edit_controller=Yii::app()->controller->createUrl('CarAssignPhysicalDamages/update')."&id=".$id;
			$delete_controller=2;
		}
		$edit="<a href='$edit_controller' target='_blank' class='edit_btn'>$edit_img</a>";
		$delete="<a href='javascript:void(0);' onClick='DeleteRecord($delete_controller,$id,$car_id)' class='delete_confirm delete_btn'>$delete_img</a>";
		$output=$edit."     ".$delete;
		echo $output;
	}
	
	
	public function UserNames($fist_name,$last_name)
	{
		echo $fist_name." ".$last_name;
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
	
	
	public function SendEmail($email_sent,$id)
	{
		if($email_sent==0){
		$text="<a href='javascript:void(0);' class='send_email_btn' onClick='sendEmail(".$id.")'>Send Email</a>";
		}else{
		//$text="<font color='#000099'>Email Sent</font>";
		$text="<a href='javascript:void(0);' class='send_email_btn' onClick='sendEmail(".$id.")'>Send Email</a>";
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
		$add_controller=Yii::app()->controller->createUrl('CarAssignPhysicalDamages/create')."&id=".$id;
		$view_controller=Yii::app()->controller->createUrl('CarAssignPhysicalDamages/admin')."&id=".$id;
		$add_img=CHtml::image('images/add.png','alt=Add Physical Damage');
		$view_img=CHtml::image('images/view.png','alt=View Physical Damages');
		$add="<a href='$add_controller' target='_blank' class='sub_details_add'>$add_img</a>";
		$view="<a href='$view_controller' target='_blank' class='sub_details_view'>$view_img</a>";
		$output=$add."     ".$view;
		echo $output;
	 }
	 
	 public function MechanicalIssues($id,$no_mechanical_issues)
	 {
		$add_controller=Yii::app()->controller->createUrl('CarAssignMechanicalIssues/create')."&id=".$id;
		$view_controller=Yii::app()->controller->createUrl('CarAssignMechanicalIssues/admin')."&id=".$id;
		$add_img=CHtml::image('images/add.png','alt=Add Mechanical Issue');
		$view_img=CHtml::image('images/view.png','alt=View Mechanical Issue');
		$add="<a href='$add_controller' target='_blank' class='sub_details_add'>$add_img</a>";
		$view="<a href='$view_controller' target='_blank' class='sub_details_view'>$view_img</a>";
		$output=$add."     ".$view;
		echo $output;
	 }
	 
	 public function fomartDate($date)
	 { 
		$Day= date("d", strtotime($date));
		$Month= date("M", strtotime($date));
		$Year= date("Y", strtotime($date));
		return $Day."-".$Month."-".$Year;
	 }
	 
	 public function carNarative($id)
	 {
		$Cars=Cars::model()->findByPk($id);
		$CarMake=CarMake::model()->findByPk($Cars->make_id);
		$CarModels=CarModels::model()->findByPk($Cars->model_id);
		echo $Carsdata[$item->id] = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.")"; 
	 }
	 
	 public function ExportData($id)
	 { 
		$controller=Yii::app()->controller->createUrl('CarAssignment/ExportData')."&id=".$id."&type=".$type;
		$exportLink="<a href='".$controller."' target='_blank' class='sub_details_add'>Export</a>";
		echo $exportLink;
	 }
	 
	  public function ReportImage($banner_name,$path)
	 {
		 $BASE_URL=Yii::app()->user->getState('pageSize',Yii::app()->params['BASE_URL']);
		 echo $BASE_URL.$path."/".$banner_name."' width='80' height='80'>";
	 }
	 
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('car_id',$this->car_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('spare_tire',$this->spare_tire);
		$criteria->compare('fire_extinguisher',$this->fire_extinguisher);
		$criteria->compare('jerk',$this->jerk);
		$criteria->compare('wheel_spanner',$this->wheel_spanner);
		$criteria->compare('physical_damages',$this->physical_damages,true);
		$criteria->compare('no_physical_damages',$this->no_physical_damages);
		$criteria->compare('mechanical_issues',$this->mechanical_issues,true);
		$criteria->compare('no_mechanical_issues',$this->no_mechanical_issues);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('email_sent',$this->email_sent);
		$criteria->compare('status',$this->status);

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
	 * @return CarAssignment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
