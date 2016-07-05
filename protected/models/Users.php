<?php

/**
 * This is the model class for table "tbl_users".
 *
 * The followings are the available columns in table 'tbl_users':
 * @property integer $id
 * @property integer $role_id
 * @property integer $company_id
 * @property integer $car_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone_number
 * @property string $dl_number
 * @property string $photo
 * @property string $dl_photo
 * @property string $dl_expiry
 * @property integer $qualified_status
 * @property string $raw_password
 * @property string $password
 * @property integer $changed_initial_password
 * @property string $password_reset_token
 * @property string $created_at
 * @property integer $is_default
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblBookingComments[] $tblBookingComments
 * @property TblCarAssignment[] $tblCarAssignments
 * @property TblRequestComments[] $tblRequestComments
 * @property TblRequests[] $tblRequests
 * @property TblRequests[] $tblRequests1
 * @property TblCars $car
 * @property TblCompanies $company
 * @property TblRoles $role
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, company_id, car_id, first_name, last_name, email, phone_number, qualified_status, raw_password, password, created_at', 'required'),
			array('role_id, company_id, car_id, qualified_status, changed_initial_password, is_default, status', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, email, phone_number, dl_number, photo, dl_photo', 'length', 'max'=>50),
			array('raw_password, password, password_reset_token', 'length', 'max'=>100),
			array('dl_expiry', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, role_id, company_id, car_id, first_name, last_name, email, phone_number, dl_number, photo, dl_photo, dl_expiry, qualified_status, raw_password, password, changed_initial_password, password_reset_token, created_at, is_default, status', 'safe', 'on'=>'search'),
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
			'BookingComments' => array(self::HAS_MANY, 'BookingComments', 'user_id'),
			'CarAssignments' => array(self::HAS_MANY, 'CarAssignment', 'user_id'),
			'RequestComments' => array(self::HAS_MANY, 'RequestComments', 'user_id'),
			'Requests' => array(self::HAS_MANY, 'Requests', 'user_id'),
			'Requests1' => array(self::HAS_MANY, 'Requests', 'request_raised_user_id'),
			'car' => array(self::BELONGS_TO, 'Cars', 'car_id'),
			'company' => array(self::BELONGS_TO, 'Companies', 'company_id'),
			'role' => array(self::BELONGS_TO, 'Roles', 'role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role_id' => 'Role',
			'company_id' => 'Company',
			'car_id' => 'Car',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'phone_number' => 'Phone Number',
			'dl_number' => 'Dl Number',
			'photo' => 'Photo',
			'dl_photo' => 'Dl Photo',
			'dl_expiry' => 'Dl Expiry',
			'qualified_status' => 'Qualified Status',
			'raw_password' => 'Raw Password',
			'password' => 'Password',
			'changed_initial_password' => 'Changed Initial Password',
			'password_reset_token' => 'Password Reset Token',
			'created_at' => 'Created At',
			'is_default' => 'Is Default',
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
	 
	 
	   public function deleteRecord($id,$photo,$dl_photo)
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
		
	public function DisplayBanner($banner_name,$name,$last_name)
	 {
		$name=$first_name." ".$last_name;
		$name='Car';
		echo CHtml::image(Yii::app()->request->baseUrl.'/users/'.$banner_name,$name,array("class"=>"banner_class","width"=>"100px"));
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
		 $site_path=Yii::app()->params['site_path'];
		 echo "<img src='".$site_path.$path."/".$banner_name."' width='80' height='80'>";
	 }
	 
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('role_id',$this->role_id);
		if($LOGGED_IN_COMPANY>0){
			$criteria->compare('company_id',$LOGGED_IN_COMPANY);
		}else{
			$criteria->compare('company_id',$this->company_id);
		}
		$criteria->compare('car_id',$this->car_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('dl_number',$this->dl_number,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('dl_photo',$this->dl_photo,true);
		$criteria->compare('dl_expiry',$this->dl_expiry,true);
		$criteria->compare('qualified_status',$this->qualified_status);
		$criteria->compare('raw_password',$this->raw_password,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('changed_initial_password',$this->changed_initial_password);
		$criteria->compare('password_reset_token',$this->password_reset_token,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('is_default',0);
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
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
