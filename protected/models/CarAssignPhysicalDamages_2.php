<?php

/**
 * This is the model class for table "tbl_car_assign_physical_damages".
 *
 * The followings are the available columns in table 'tbl_car_assign_physical_damages':
 * @property integer $id
 * @property integer $car_assignment_id
 * @property string $photo
 * @property string $description
 * @property string $created_at
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblCarAssignment $carAssignment
 */
class CarAssignPhysicalDamages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_car_assign_physical_damages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, car_assignment_id, photo, description', 'required'),
			array('id, car_assignment_id, status', 'numerical', 'integerOnly'=>true),
			array('photo', 'length', 'max'=>50),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, car_assignment_id, photo, description, created_at, status', 'safe', 'on'=>'search'),
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
			'carAssignment' => array(self::BELONGS_TO, 'CarAssignment', 'car_assignment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'car_assignment_id' => 'Car Assignment',
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
	
	public function Status($status)
	{
		if($status==0){
		$text="<font color='#FF0000'>Inactive</font>";
		}else{
		$text="<font color='#000099'>Active</font>";
		}
		echo $text;
	}

	 
	 
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('car_assignment_id',$this->car_assignment_id);
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
	 * @return CarAssignPhysicalDamages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
