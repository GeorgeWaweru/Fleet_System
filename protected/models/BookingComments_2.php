<?php

/**
 * This is the model class for table "tbl_booking_comments".
 *
 * The followings are the available columns in table 'tbl_booking_comments':
 * @property integer $id
 * @property integer $booking_id
 * @property integer $supplier_id
 * @property integer $user_id
 * @property string $comment
 * @property string $created_at
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblBookings $booking
 * @property TblSuppliers $supplier
 * @property TblUsers $user
 * @property TblBookingSpares[] $tblBookingSpares
 */
class BookingComments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_booking_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('booking_id, supplier_id, user_id, created_at, status', 'required'),
			array('booking_id, supplier_id, user_id, status', 'numerical', 'integerOnly'=>true),
			array('comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, booking_id, supplier_id, user_id, comment, created_at, status', 'safe', 'on'=>'search'),
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
			'booking' => array(self::BELONGS_TO, 'Bookings', 'booking_id'),
			'supplier' => array(self::BELONGS_TO, 'Suppliers', 'supplier_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'BookingSpares' => array(self::HAS_MANY, 'BookingSpares', 'booking_comment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'booking_id' => 'Booking',
			'supplier_id' => 'Supplier',
			'user_id' => 'User',
			'comment' => 'Comment',
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
	 
	 protected function afterSave()
     {
         return $this->id;
     }
	 
 	 public function getLastRecordID()
 	 {
	  	return intval($this->afterSave());
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('booking_id',$this->booking_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('comment',$this->comment,true);
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
	 * @return BookingComments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
