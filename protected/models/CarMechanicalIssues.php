<?php

/**
 * This is the model class for table "tbl_car_mechanical_issues".
 *
 * The followings are the available columns in table 'tbl_car_mechanical_issues':
 * @property integer $id
 * @property integer $car_id
 * @property integer $company_id
 * @property string $photo
 * @property string $description
 * @property string $created_at
 * @property integer $deleted_status
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblCars $car
 * @property TblCompanies $company
 */
class CarMechanicalIssues extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_car_mechanical_issues';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('car_id, company_id, photo, description, created_at', 'required'),
			array('car_id, company_id, deleted_status, status', 'numerical', 'integerOnly'=>true),
			array('photo', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, car_id, company_id, photo, description, created_at, deleted_status, status', 'safe', 'on'=>'search'),
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
			'car' => array(self::BELONGS_TO, 'Cars', 'car_id'),
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
			'company_id' => 'Company',
			'photo' => 'Photo',
			'description' => 'Description',
			'created_at' => 'Created At',
			'deleted_status' => 'Deleted Status',
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
		echo CHtml::image(Yii::app()->request->baseUrl.'/car_mechanical_issues/'.$banner_name,$name,array("class"=>"banner_class","width"=>"100px"));
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
		$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
		$id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		if($id>0){
			$criteria->compare('car_id',$id);
		}else{
			$criteria->compare('car_id',$this->car_id);
		}
		if($LOGGED_IN_COMPANY>0){
			$criteria->compare('company_id',$LOGGED_IN_COMPANY);
		}else{
			$criteria->compare('company_id',$this->company_id);
		}
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('deleted_status',$this->deleted_status);
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
	 * @return CarMechanicalIssues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
