<?php

/**
 * This is the model class for table "tbl_systemusers".
 *
 * The followings are the available columns in table 'tbl_systemusers':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $password_reset_token
 * @property integer $status
 */
class Systemusers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_systemusers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, email, password, password_reset_token', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, email, password', 'length', 'max'=>50),
			array('password_reset_token', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, last_name, email, password, password_reset_token, status', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'password' => 'Password',
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
	 
	 	public function Status($status)
	{
		if($status==0){
			$text="<font color='#FF0000'>Inactive</font>";
		}else{
			$text="<font color='#000099'>Active</font>";
		}
		echo $text;
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
	
	public function validateToken($reset_type,$password_token)
	{
		if($reset_type==1){
			$Companies=Companies::model()->findByAttributes(array('password_reset_token'=>$password_token));
			if(count($Companies)>0)
			{
				$_SESSION['pass_reset_record']=$Companies->id;
				$_SESSION['pass_reset_email']=$Companies->email;
				$_SESSION['pass_reset_names']=$Companies->contact_person;
				$_SESSION['pass_reset_record_type']=$reset_type;
				return 1;
			}else{
				return 0;
			}
		}else if($reset_type==2){
			$Users=Users::model()->findByAttributes(array('password_reset_token'=>$password_token));
			if(count($Users)>0)
			{
				$_SESSION['pass_reset_record']=$Users->id;
				$_SESSION['pass_reset_email']=$Users->email;
				$_SESSION['pass_reset_names']=$Users->first_name." ".$Users->last_name;
				$_SESSION['pass_reset_record_type']=$reset_type;
				return 1;
			}else{
				return 0;
			}
		}else if($reset_type==3){
			$Systemusers=Systemusers::model()->findByAttributes(array('password_reset_token'=>$password_token));
			if(count($Systemusers)>0)
			{
				$_SESSION['pass_reset_record']=$Systemusers->id;
				$_SESSION['pass_reset_email']=$Systemusers->email;
				$_SESSION['pass_reset_names']=$Systemusers->first_name." ".$Systemusers->last_name;
				$_SESSION['pass_reset_record_type']=$reset_type;
				return 1;
			}else{
				return 0;
			}
			
		}else if($reset_type==4){
			$Suppliers=Suppliers::model()->findByAttributes(array('password_reset_token'=>$password_token));
			if(count($Suppliers)>0)
			{
				$_SESSION['pass_reset_record']=$Suppliers->id;
				$_SESSION['pass_reset_email']=$Suppliers->email;
				$_SESSION['pass_reset_names']=$Suppliers->contact_person;
				$_SESSION['pass_reset_record_type']=$reset_type;
				return 1;
			}else{
				return 0;
			}
			
		}else{
			return 0;
		}
	}
	
	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('password_reset_token',$this->password_reset_token,true);
		$criteria->compare('status',$this->status);

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
	 * @return Systemusers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
