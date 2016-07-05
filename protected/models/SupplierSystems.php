<?php

/**
 * This is the model class for table "tbl_supplier_systems".
 *
 * The followings are the available columns in table 'tbl_supplier_systems':
 * @property integer $id
 * @property integer $system_id
 * @property integer $supplier_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblSystem $system
 * @property TblSuppliers $supplier
 */
class SupplierSystems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_supplier_systems';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('system_id, supplier_id, status', 'required'),
			array('system_id, supplier_id, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, system_id, supplier_id, status', 'safe', 'on'=>'search'),
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
			'system' => array(self::BELONGS_TO, 'System', 'system_id'),
			'supplier' => array(self::BELONGS_TO, 'Suppliers', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'system_id' => 'System',
			'supplier_id' => 'Supplier',
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
		//$output=$edit."      ".$delete;
		$output=$delete;
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
		$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : 0;
		$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
		
		$criteria=new CDbCriteria;
		
		$criteria->compare('id',$this->id);
		$criteria->compare('system_id',$this->system_id);
		
		if($LOGGED_IN_USER_KIND=='supplier' && $LOGGED_IN_USER_ID>0){
			$criteria->compare('supplier_id',$LOGGED_IN_USER_ID);
		}else{
			$criteria->compare('supplier_id',$this->supplier_id);
		}
		
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
	 * @return SupplierSystems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
