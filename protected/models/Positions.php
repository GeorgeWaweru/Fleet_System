<?php

/**
 * This is the model class for table "tbl_positions".
 *
 * The followings are the available columns in table 'tbl_positions':
 * @property integer $id
 * @property string $title
 * @property string $created_at
 * @property integer $exclude_all
 * @property integer $is_president
 * @property integer $is_governor
 * @property integer $is_senator
 * @property integer $is_women_rep
 * @property integer $is_mp
 * @property integer $is_mca
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property TblCandidates[] $tblCandidates
 * @property TblFaqs[] $tblFaqs
 * @property TblVotes[] $tblVotes
 */
class Positions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_positions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, created_at', 'required'),
			array('exclude_all, is_president, is_governor, is_senator, is_women_rep, is_mp, is_mca, status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, created_at, exclude_all, is_president, is_governor, is_senator, is_women_rep, is_mp, is_mca, status', 'safe', 'on'=>'search'),
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
			'Candidates' => array(self::HAS_MANY, 'Candidates', 'position_id'),
			'Faqs' => array(self::HAS_MANY, 'Faqs', 'position_id'),
			'Votes' => array(self::HAS_MANY, 'Votes', 'position_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'created_at' => 'Created At',
			'exclude_all' => 'Exclude All',
			'is_president' => 'Is President',
			'is_governor' => 'Is Governor',
			'is_senator' => 'Is Senator',
			'is_women_rep' => 'Is Women Rep',
			'is_mp' => 'Is Mp',
			'is_mca' => 'Is Mca',
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
	
	public function Exclude($value)
	{
		if($value==0){
			$text="<font color='#000099'>No</font>";
		}else{
			$text="<font color='#FF0000'>Yes</font>";
		}
		echo $text;
	}
	
	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('exclude_all',$this->exclude_all);
		$criteria->compare('is_president',$this->is_president);
		$criteria->compare('is_governor',$this->is_governor);
		$criteria->compare('is_senator',$this->is_senator);
		$criteria->compare('is_women_rep',$this->is_women_rep);
		$criteria->compare('is_mp',$this->is_mp);
		$criteria->compare('is_mca',$this->is_mca);
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
	 * @return Positions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
