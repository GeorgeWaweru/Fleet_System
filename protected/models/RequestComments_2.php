<?php

/**
 * This is the model class for table "tbl_request_comments".
 *
 * The followings are the available columns in table 'tbl_request_comments':
 * @property integer $id
 * @property integer $request_id
 * @property integer $user_id
 * @property integer $no_photo
 * @property string $photo
 * @property string $description
 * @property integer $no_description
 * @property string $created_at
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblUsers $user
 * @property TblRequests $request
 */
class RequestComments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_request_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_id, user_id, created_at', 'required'),
			array('request_id, user_id, no_photo, no_description, status', 'numerical', 'integerOnly'=>true),
			array('photo', 'length', 'max'=>100),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, request_id, user_id, no_photo, photo, description, no_description, created_at, status', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
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
			'user_id' => 'User',
			'no_photo' => 'No Photo',
			'photo' => 'Photo',
			'description' => 'Description',
			'no_description' => 'No Description',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('no_photo',$this->no_photo);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('no_description',$this->no_description);
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
	 * @return RequestComments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
