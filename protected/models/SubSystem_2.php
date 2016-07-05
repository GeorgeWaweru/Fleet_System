<?php

/**
 * This is the model class for table "tbl_sub_system".
 *
 * The followings are the available columns in table 'tbl_sub_system':
 * @property integer $id
 * @property integer $system_id
 * @property string $title
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblSpare[] $tblSpares
 * @property TblSystem $system
 */
class SubSystem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_sub_system';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('system_id, title', 'required'),
			array('system_id, status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, system_id, title, status', 'safe', 'on'=>'search'),
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
			'Spares' => array(self::HAS_MANY, 'Spare', 'sub_system_id'),
			'system' => array(self::BELONGS_TO, 'System', 'system_id'),
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
			'title' => 'Title',
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
		
	public function DisplayBanner($banner_name,$name)
	 {
		echo CHtml::image(Yii::app()->request->baseUrl.'/../candidates/'.$banner_name,$name,array("class"=>"banner_class","width"=>"100px"));
	 }
	 
	 
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('system_id',$this->system_id);
		$criteria->compare('title',$this->title,true);
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
	 * @return SubSystem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
