<?php

/**
 * This is the model class for table "tbl_cars".
 *
 * The followings are the available columns in table 'tbl_cars':
 * @property integer $id
 * @property integer $company_id
 * @property integer $make_id
 * @property integer $model_id
 * @property string $number_plate
 * @property string $photo
 * @property integer $service_millage
 * @property string $car_year
 * @property integer $status
 * @property integer $car_taken_status
 * @property integer $is_default
 *
 * The followings are the available model relations:
 * @property TblCarDriversHistory[] $tblCarDriversHistories
 * @property TblCarMake $make
 * @property TblCarModels $model
 * @property TblCompanies $company
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
			array('company_id, make_id, model_id, number_plate, photo, service_millage, car_year', 'required'),
			array('company_id, make_id, model_id, service_millage, status, car_taken_status, is_default', 'numerical', 'integerOnly'=>true),
			array('number_plate, photo', 'length', 'max'=>50),
			array('car_year', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, make_id, model_id, number_plate, photo, service_millage, car_year, status, car_taken_status, is_default', 'safe', 'on'=>'search'),
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
			'CarDriversHistories' => array(self::HAS_MANY, 'CarDriversHistory', 'car_id'),
			'company' => array(self::BELONGS_TO, 'Companies', 'company_id'),
			'make' => array(self::BELONGS_TO, 'CarMake', 'make_id'),
			'model' => array(self::BELONGS_TO, 'CarModels', 'model_id'),
			'Drivers' => array(self::HAS_MANY, 'Drivers', 'car_id'),
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
			'number_plate' => 'Number Plate',
			'photo' => 'Photo',
			'service_millage' => 'Service Millage',
			'car_year' => 'Car Year',
			'status' => 'Status',
			'car_taken_status' => 'Car Taken Status',
			'is_default' => 'Is Default',
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		if($LOGGED_IN_COMPANY>0){
			$criteria->compare('company_id',$LOGGED_IN_COMPANY);
		}else{
			$criteria->compare('company_id',$this->company_id);
		}
		$criteria->compare('make_id',$this->make_id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('number_plate',$this->number_plate,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('service_millage',$this->service_millage);
		$criteria->compare('car_year',$this->car_year,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('car_taken_status',$this->car_taken_status);
		$criteria->compare('is_default',0);

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
