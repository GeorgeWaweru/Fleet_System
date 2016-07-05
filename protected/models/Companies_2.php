<?php

/**
 * This is the model class for table "tbl_companies".
 *
 * The followings are the available columns in table 'tbl_companies':
 * @property integer $id
 * @property integer $industry_id
 * @property string $title
 * @property string $photo
 * @property string $contact_person
 * @property string $email
 * @property string $phone_number
 * @property string $location
 * @property integer $no_employees
 * @property integer $no_vehicles
 * @property string $raw_password
 * @property string $password
 * @property integer $changed_initial_password
 * @property string $password_reset_token
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblCarMechanicalIssues[] $tblCarMechanicalIssues
 * @property TblCarPhysicalDamages[] $tblCarPhysicalDamages
 * @property TblCars[] $tblCars
 * @property TblIndustries $industry
 * @property TblSuppliers[] $tblSuppliers
 * @property TblUsers[] $tblUsers
 */
class Companies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_companies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('industry_id, title, photo, contact_person, email, phone_number, location, no_employees, no_vehicles, raw_password, password', 'required'),
			array('industry_id, no_employees, no_vehicles, changed_initial_password, status', 'numerical', 'integerOnly'=>true),
			array('title, photo, contact_person, email, phone_number, raw_password, password', 'length', 'max'=>50),
			array('password_reset_token', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, industry_id, title, photo, contact_person, email, phone_number, location, no_employees, no_vehicles, raw_password, password, changed_initial_password, password_reset_token, status', 'safe', 'on'=>'search'),
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
			'CarMechanicalIssues' => array(self::HAS_MANY, 'CarMechanicalIssues', 'company_id'),
			'CarPhysicalDamages' => array(self::HAS_MANY, 'CarPhysicalDamages', 'company_id'),
			'Cars' => array(self::HAS_MANY, 'Cars', 'company_id'),
			'industry' => array(self::BELONGS_TO, 'Industries', 'industry_id'),
			'Suppliers' => array(self::HAS_MANY, 'Suppliers', 'company_id'),
			'Users' => array(self::HAS_MANY, 'Users', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'industry_id' => 'Industry',
			'title' => 'Title',
			'photo' => 'Photo',
			'contact_person' => 'Contact Person',
			'email' => 'Email',
			'phone_number' => 'Phone Number',
			'location' => 'Location',
			'no_employees' => 'No Employees',
			'no_vehicles' => 'No Vehicles',
			'raw_password' => 'Raw Password',
			'password' => 'Password',
			'changed_initial_password' => 'Changed Initial Password',
			'password_reset_token' => 'Password Reset Token',
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
		$name='Company';
		echo CHtml::image(Yii::app()->request->baseUrl.'/companies/'.$banner_name,$name,array("class"=>"banner_class","width"=>"100px"));
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


public function getRandomString($length = 6) {
        $validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";
        $validCharNumber = strlen($validCharacters);
        $result = "";
        for ($i = 0; $i < $length; $i++) {

            $index = mt_rand(0, $validCharNumber - 1);

            $result .= $validCharacters[$index];
		}
        return $result;
    }
	

	public	function getRandomNumber($length = 4) {
        $validCharacters = "123456789";
        $validCharNumber = strlen($validCharacters);
        $result = "";
        for ($i = 0; $i < $length; $i++) {

            $index = rand(0, $validCharNumber - 1);

            $result .= $validCharacters[$index];
		}
        return $result;
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
		$criteria->compare('industry_id',$this->industry_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('contact_person',$this->contact_person,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('no_employees',$this->no_employees);
		$criteria->compare('no_vehicles',$this->no_vehicles);
		$criteria->compare('raw_password',$this->raw_password,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('changed_initial_password',$this->changed_initial_password);
		$criteria->compare('password_reset_token',$this->password_reset_token,true);
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
	 * @return Companies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
