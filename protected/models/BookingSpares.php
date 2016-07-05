<?php

/**
 * This is the model class for table "tbl_booking_spares".
 *
 * The followings are the available columns in table 'tbl_booking_spares':
 * @property integer $id
 * @property integer $booking_comment_id
 * @property integer $spare_id
 * @property string $spare_cost
 * @property string $spare_photo
 * @property integer $is_more_spare_part
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblBookingComments $bookingComment
 * @property TblSpare $spare
 */
class BookingSpares extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_booking_spares';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('booking_comment_id, spare_id', 'required'),
			array('booking_comment_id, spare_id, is_more_spare_part, status', 'numerical', 'integerOnly'=>true),
			array('spare_cost, spare_photo', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, booking_comment_id, spare_id, spare_cost, spare_photo, is_more_spare_part, status', 'safe', 'on'=>'search'),
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
			'bookingComment' => array(self::BELONGS_TO, 'BookingComments', 'booking_comment_id'),
			'spare' => array(self::BELONGS_TO, 'Spare', 'spare_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'booking_comment_id' => 'Booking Comment',
			'spare_id' => 'Spare',
			'spare_cost' => 'Spare Cost',
			'spare_photo' => 'Spare Photo',
			'is_more_spare_part' => 'Is More Spare Part',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('booking_comment_id',$this->booking_comment_id);
		$criteria->compare('spare_id',$this->spare_id);
		$criteria->compare('spare_cost',$this->spare_cost,true);
		$criteria->compare('spare_photo',$this->spare_photo,true);
		$criteria->compare('is_more_spare_part',$this->is_more_spare_part);
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
	 * @return BookingSpares the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
