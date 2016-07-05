<?php
/**
 * This is the model class for table "tbl_bookings".
 *
 * The followings are the available columns in table 'tbl_bookings':
 * @property integer $id
 * @property integer $request_id
 * @property integer $supplier_id
 * @property integer $company_id
 * @property string $request_type
 * @property string $created_at
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblRequests $request
 * @property TblSuppliers $supplier
 * @property TblCompanies $company
 */
class Bookings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_bookings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_id, supplier_id, company_id, request_type, created_at', 'required'),
			array('request_id, supplier_id, company_id, status', 'numerical', 'integerOnly'=>true),
			array('request_type', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, request_id, supplier_id, company_id, request_type, created_at, status', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Suppliers', 'supplier_id'),
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
			'request_id' => 'Request',
			'supplier_id' => 'Supplier',
			'company_id' => 'Company',
			'request_type' => 'Request Type',
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
	 
	 public function requestNarrative($request_id)
	 {
		$Requests=Requests::model()->findByPk($request_id);
		$Cars=Cars::model()->findByPk($Requests->car_id);
		$CarMake=CarMake::model()->findByPk($Cars->make_id);
		$CarModels=CarModels::model()->findByPk($Cars->model_id);
		$System=System::model()->findByPk($Requests->system_id);
		$SubSystem=SubSystem::model()->findByPk($Requests->subsystem_id);
		$text = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.") -".$System->title." / ".$SubSystem->title;
		echo $text;
	 }
	 
	 
	 public function fomartDate($date)
	 { 
		$Day= date("d", strtotime($date));
		$Month= date("M", strtotime($date));
		$Year= date("Y", strtotime($date));
		return $Day."-".$Month."-".$Year;
	 }
	 
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND']:'';
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('request_id',$this->request_id);
		
		if($LOGGED_IN_USER_KIND=='supplier')
		{
			$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']):0;
			$criteria->compare('supplier_id',$LOGGED_IN_USER_ID);
		}else{
			$criteria->compare('supplier_id',$this->supplier_id);
		}
		
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('request_type',$this->request_type,true);
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
	 * @return Bookings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
