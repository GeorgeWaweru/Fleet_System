<?php
/**
 * This is the model class for table "tbl_suppliers".
 *
 * The followings are the available columns in table 'tbl_suppliers':
 * @property integer $id
 * @property integer $company_id
 * @property string $title
 * @property string $reg_no
 * @property string $contact_person
 * @property string $email
 * @property string $raw_password
 * @property string $password
 * @property integer $changed_initial_password
 * @property string $password_reset_token
 * @property string $created_at
 * @property integer $is_default
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblCompanySuppliers[] $tblCompanySuppliers
 * @property TblRequestComments[] $tblRequestComments
 * @property TblSupplierSystems[] $tblSupplierSystems
 * @property TblCompanies $company
 */
class Suppliers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_suppliers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, title, reg_no, contact_person, email, raw_password, password, created_at', 'required'),
			array('company_id, changed_initial_password, is_default, status', 'numerical', 'integerOnly'=>true),
			array('title, reg_no', 'length', 'max'=>50),
			array('contact_person, email, raw_password, password, password_reset_token', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, title, reg_no, contact_person, email, raw_password, password, changed_initial_password, password_reset_token, created_at, is_default, status', 'safe', 'on'=>'search'),
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
			'CompanySuppliers' => array(self::HAS_MANY, 'CompanySuppliers', 'supplier_id'),
			'RequestComments' => array(self::HAS_MANY, 'RequestComments', 'supplier_id'),
			'SupplierSystems' => array(self::HAS_MANY, 'SupplierSystems', 'supplier_id'),
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
			'company_id' => 'Company',
			'title' => 'Title',
			'reg_no' => 'Reg No',
			'contact_person' => 'Contact Person',
			'email' => 'Email',
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
		
		
	protected function afterSave()
     {
         return $this->id;
     }
	 
 	 public function getLastRecordID()
 	 {
	  	return intval($this->afterSave());
  	 }
	 
	 
	 public function associateSupplier($id)
	 {
		$company_id=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
		$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
		$CompanySuppliers=CompanySuppliers::model()->findAllByAttributes(array('supplier_id'=>$id,'company_id'=>$LOGGED_IN_COMPANY)); 
		if(count($CompanySuppliers)==0)
		{
			
			$output="<a href='javascript:void(0);' onClick='Associate($id,1)' class='action_links'>Associate</a>";
			
		}else{
			$output="<a href='javascript:void(0);' onClick='Associate($id,0)' class='action_links'>Disassociate</a>";
		}
		echo $output;
	 }
	 
	 public function dealsIn($supplier_id)
	 {
		 $CompanySuppliers=SupplierSystems::model()->findAllByAttributes(array('supplier_id'=>$supplier_id)); 
		 if(count($CompanySuppliers)>0)
		 {
			 $deals_in="";
			 foreach($CompanySuppliers as $item)
			 {
				 	$System=System::model()->findByPk($item->system_id);
					$deals_in="<div class='rowTextdiv'>".$deals_in."- ".$System->title."</div>";
			 }
		 }
		 echo $deals_in;
	 }
	 
	public function DateFormart($Date)
	{
		$Day= date("d", strtotime($Date));
		$Month= date("M", strtotime($Date));
		$Year= date("Y", strtotime($Date));
		echo $Day."-".$Month."-".$Year;
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('reg_no',$this->reg_no,true);
		$criteria->compare('contact_person',$this->contact_person,true);
		$criteria->compare('email',$this->email,true);
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
	 * @return Suppliers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
