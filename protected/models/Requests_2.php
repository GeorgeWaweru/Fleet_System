<?php

/**
 * This is the model class for table "tbl_requests".
 *
 * The followings are the available columns in table 'tbl_requests':
 * @property integer $id
 * @property integer $user_id
 * @property integer $car_id
 * @property integer $company_id
 * @property string $request_type
 * @property integer $system_id
 * @property integer $subsystem_id
 * @property string $previous_millage
 * @property string $current_millage
 * @property string $consumption
 * @property string $description
 * @property integer $no_description
 * @property integer $on_behalf
 * @property integer $request_raised_user_id
 * @property string $created_at
 * @property integer $email_sent
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblRequestSubDetails[] $tblRequestSubDetails
 * @property TblSystem $system
 * @property TblSubSystem $subsystem
 * @property TblCars $car
 * @property TblUsers $user
 * @property TblUsers $requestRaisedUser
 * @property TblCompanies $company
 */
class Requests extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_requests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, car_id, company_id, request_type, system_id, subsystem_id, request_raised_user_id, created_at', 'required'),
			array('user_id, car_id, company_id, system_id, subsystem_id, no_description, on_behalf, request_raised_user_id, email_sent, status', 'numerical', 'integerOnly'=>true),
			array('request_type', 'length', 'max'=>100),
			array('previous_millage, current_millage, consumption', 'length', 'max'=>50),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, car_id, company_id, request_type, system_id, subsystem_id, previous_millage, current_millage, consumption, description, no_description, on_behalf, request_raised_user_id, created_at, email_sent, status', 'safe', 'on'=>'search'),
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
			'RequestSubDetails' => array(self::HAS_MANY, 'RequestSubDetails', 'request_id'),
			'system' => array(self::BELONGS_TO, 'System', 'system_id'),
			'subsystem' => array(self::BELONGS_TO, 'SubSystem', 'subsystem_id'),
			'car' => array(self::BELONGS_TO, 'Cars', 'car_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'requestRaisedUser' => array(self::BELONGS_TO, 'Users', 'request_raised_user_id'),
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
			'user_id' => 'User',
			'car_id' => 'Car',
			'company_id' => 'Company',
			'request_type' => 'Request Type',
			'system_id' => 'System',
			'subsystem_id' => 'Subsystem',
			'previous_millage' => 'Previous Millage',
			'current_millage' => 'Current Millage',
			'consumption' => 'Consumption',
			'description' => 'Description',
			'no_description' => 'No Description',
			'on_behalf' => 'On Behalf',
			'request_raised_user_id' => 'Request Raised User',
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
	 
	 	 protected function afterSave()
     {
         return $this->id;
     }
	 
 	 public function getLastRecordID()
 	 {
	  	return intval($this->afterSave());
  	 }
	 
	 
	 public function DisplayBanner($banner_name)
	 {
		$name='Car';
		echo CHtml::image(Yii::app()->request->baseUrl.'/cars/'.$banner_name,$name,array("class"=>"banner_class","width"=>"100px"));
	 }
	
	
	public function deleteRecord($id,$type)
	{
		$delete_img=CHtml::image('images/delete.png');
		$edit_img=CHtml::image('images/update.png');
		if($type=='service'){
			$edit_controller=Yii::app()->controller->createUrl('ServiceUpdate')."&id=".$id;
		}else if($type=='repair'){
			$edit_controller=Yii::app()->controller->createUrl('RepairUpdate')."&id=".$id;
		}else if($type=='fuel'){
			$edit_controller=Yii::app()->controller->createUrl('FuelUpdate')."&id=".$id;
		}
		$edit="<a href='$edit_controller' class='edit_btn'>$edit_img</a>";
		$delete="<a href='javascript:void(0);' class='delete_confirm delete_btn' id='$id'>$delete_img</a>";
		$output=$edit."      ".$delete;
		echo $output;
	}
	
	
	public function deleteChildRecord($id,$request_id,$type)
	{
		$delete_img=CHtml::image('images/delete.png');
		$edit_img=CHtml::image('images/update.png');
		$edit_controller=Yii::app()->controller->createUrl('RequestSubDetails/update')."&id=".$id."&type=".$type;
		$edit="<a href='$edit_controller' target='_blank' class='edit_btn'>$edit_img</a>";
		$delete="<a href='javascript:void(0);' onClick='DeleteRecord($id,$request_id)' class='delete_confirm delete_btn'>$delete_img</a>";
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
	
	public function requestUser($first_name,$last_name)
	{
		echo $first_name."  ".$last_name;
	}
	
	
	 public function RequestSubDetails($id,$no_description,$type)
	 {
		$add_controller=Yii::app()->controller->createUrl('RequestSubDetails/create')."&id=".$id."&type=".$type;
		$view_controller=Yii::app()->controller->createUrl('RequestSubDetails/admin')."&id=".$id."&type=".$type;
		$add_img=CHtml::image('images/add.png','alt=Add Request Detail');
		$view_img=CHtml::image('images/view.png','alt=View Request Details');
		$add="<a href='$add_controller' target='_blank' class='sub_details_add'>$add_img</a>";
		if($no_description==0){
			$view="<a href='$view_controller' target='_blank' class='sub_details_view'>$view_img</a>";
		}else{
			$view="";
		}
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
	 
	 public function requestNarative($id,$on_behalf,$user_id,$request_raised_user_id)
	 {
		$Cars=Cars::model()->findByPk($id);
		$CarMake=CarMake::model()->findByPk($Cars->make_id);
		$CarModels=CarModels::model()->findByPk($Cars->model_id);
		if($on_behalf==1){
		$Requester=Users::model()->findByPk($request_raised_user_id);
		$User=Users::model()->findByPk($user_id);
		$raised_by="<b>".$Requester->first_name." ".$Requester->last_name."</b>";
		$on_behalf_of="<b>".$User->first_name." ".$User->last_name."</b>";	
		$narrative=$Carsdata[$item->id] = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.")" .
		" Raised by ".$raised_by." on behalf of " .$on_behalf_of; 
		}else{
			$narrative=$Carsdata[$item->id] = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.")"; 
		}
			echo $narrative;
	 }
	 
	 
	 
	 public function requestNarativeReport($id,$on_behalf,$user_id,$request_raised_user_id)
	 {
		$Cars=Cars::model()->findByPk($id);
		$CarMake=CarMake::model()->findByPk($Cars->make_id);
		$CarModels=CarModels::model()->findByPk($Cars->model_id);
		if($on_behalf==1){
		$Requester=Users::model()->findByPk($request_raised_user_id);
		$User=Users::model()->findByPk($user_id);
		$raised_by="<b>".$Requester->first_name." ".$Requester->last_name."</b>";
		$on_behalf_of="<b>".$User->first_name." ".$User->last_name."</b>";	
		$narrative=$Carsdata[$item->id] = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.")" .
		" Raised by ".$raised_by." on behalf of " .$on_behalf_of; 
		}else{
			$narrative=$Carsdata[$item->id] = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.")"; 
		}
			return $narrative;
	 }
	 
	 public function ReportImage($banner_name,$path)
	 {
		 $BASE_URL=Yii::app()->user->getState('pageSize',Yii::app()->params['BASE_URL']);
		 echo $BASE_URL.$path."/".$banner_name."' width='80' height='80'>";
	 }
	 
	 public function ExportData($id,$type)
	 { 
		$controller=Yii::app()->controller->createUrl('Requests/ExportData')."&id=".$id."&type=".$type;
		$exportLink="<a href='".$controller."' target='_blank' class='sub_details_add'>Export</a>";
		echo $exportLink;
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
	
	
	
	public function search($request_type,$role,$user_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		if($role=='Driver')
		{
			$criteria->compare('user_id',$user_id);
		}else{
			$criteria->compare('user_id',$this->user_id);
		}
		$criteria->compare('car_id',$this->car_id);
		$criteria->compare('company_id',$this->company_id);
		if($request_type=='service' || $request_type=='repair' || $request_type=='fuel')
		{
			$criteria->compare('request_type',$request_type,true);
		}else{
			$criteria->compare('request_type',$this->request_type,true);
		}
		
		$criteria->compare('system_id',$this->system_id);
		$criteria->compare('subsystem_id',$this->subsystem_id);
		$criteria->compare('previous_millage',$this->previous_millage,true);
		$criteria->compare('current_millage',$this->current_millage,true);
		$criteria->compare('consumption',$this->consumption,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('no_description',$this->no_description);
		$criteria->compare('on_behalf',$this->on_behalf);
		$criteria->compare('request_raised_user_id',$this->request_raised_user_id);
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
	 * @return Requests the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
