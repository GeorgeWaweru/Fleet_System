<?php

/**
 * This is the model class for table "tbl_request_sub_details".
 *
 * The followings are the available columns in table 'tbl_request_sub_details':
 * @property integer $id
 * @property integer $request_id
 * @property string $photo
 * @property string $description
 * @property string $created_at
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblRequests $request
 */
class RequestSubDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_request_sub_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_id, photo, description, created_at, status', 'required'),
			array('request_id, status', 'numerical', 'integerOnly'=>true),
			array('photo', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, request_id, photo, description, created_at, status', 'safe', 'on'=>'search'),
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
			'request' => array(self::BELONGS_TO, 'Requests', 'request_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'request_id' => 'Request',
			'photo' => 'Photo',
			'description' => 'Description',
			'created_at' => 'Created At',
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
	public function DisplayBanner($banner_name)
	{
		$name='Car';
		echo CHtml::image(Yii::app()->request->baseUrl.'/requests/'.$banner_name,$name,array("class"=>"banner_class","width"=>"100px"));
	}
	
	
	public function deleteRecord($id,$type)
	{
		$delete_img=CHtml::image('images/delete.png');
		$edit_img=CHtml::image('images/update.png');
		$edit_controller=Yii::app()->controller->createUrl('update')."&id=".$id."&type=".$type;
		$edit="<a href='$edit_controller' class='edit_btn'>$edit_img</a>";
		$delete="<a href='javascript:void(0);' class='delete_confirm delete_btn' id='$id'>$delete_img</a>";
		$output=$edit."      ".$delete;
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
	

	 public function fomartDate($date)
	 { 
		$Day= date("d", strtotime($date));
		$Month= date("M", strtotime($date));
		$Year= date("Y", strtotime($date));
		return $Day."-".$Month."-".$Year;
	 }
	 
	
	public function requestNarative($id)
	 { 
		$RequestsData=Requests::model()->findByPk($id);
		$CarsData=Cars::model()->findByPk($RequestsData->car_id);
		$UsersData=Users::model()->findByPk($RequestsData->user_id);
		$created_at=$this->fomartDate($RequestsData->created_at);
		$SystemData=System::model()->findByPk($RequestsData->system_id);
		$SubSystemData=SubSystem::model()->findByPk($RequestsData->subsystem_id);
		$narrative=$SystemData->title." - ".$SubSystemData->title." (".$CarsData->number_plate.")"." Requested by ".$UsersData->first_name." ".$UsersData->last_name." on ".$created_at;
		echo $narrative;
	 }


	public function parnetRecords()
	{
		$type=isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
		$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
		$data=array();
		if(!empty($type))
		{
			$requests=Requests::model()->findAllByAttributes(array('request_type'=>$type,'user_id'=>$LOGGED_IN_USER_ID));
		}else{
			$requests=Requests::model()->findAllByAttributes(array('user_id'=>$LOGGED_IN_USER_ID));
		}
		foreach($requests as $item)
		{
			$data[]=$item->id;
		}
		return $data;
	}
	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
		$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
		$id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		
		if($id>0){
			$criteria->compare('request_id',$id);
		}else{
			if($COMPANY_SUB_USER_ROLE=='Driver'){
				 $criteria->compare("request_id", $this->parnetRecords());
			}else{
				 $criteria->compare('request_id',$this->id);
			}
		}
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_at',$this->created_at,true);
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
	 * @return RequestSubDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
