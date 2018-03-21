<?php

/**
 * This is the model class for table "{{use_summary}}".
 *
 * The followings are the available columns in table '{{use_summary}}':
 * @property integer $id
 * @property integer $gh_type
 * @property string $gh_amount
 * @property string $m_p_water
 * @property string $m_u_water
 * @property string $m_p_cement
 * @property string $m_u_cement
 * @property string $m_p_ash
 * @property string $m_u_ash
 * @property string $m_p_gravel
 * @property string $m_u_gravel
 * @property string $m_p_sand
 * @property string $m_u_sand
 * @property string $m_p_river_sand
 * @property string $m_u_river_sand
 * @property string $m_p_additive
 * @property string $m_u_additive
 * @property string $capacity
 * @property string $add_time
 * @property string $update_time
 * @property string $s_number
 */
class UseSummary extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UseSummary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{use_summary}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gh_type', 'numerical', 'integerOnly'=>true),
			array('gh_amount', 'length', 'max'=>10),
			array('m_p_water, m_u_water, m_p_cement, m_u_cement, m_p_ash, m_u_ash, m_p_gravel, m_u_gravel, m_p_sand, m_u_sand, m_p_river_sand, m_u_river_sand, m_p_additive, m_u_additive, capacity', 'length', 'max'=>15),
			array('s_number', 'length', 'max'=>255),
			array('add_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, gh_type, gh_amount, m_p_water, m_u_water, m_p_cement, m_u_cement, m_p_ash, m_u_ash, m_p_gravel, m_u_gravel, m_p_sand, m_u_sand, m_p_river_sand, m_u_river_sand, m_p_additive, m_u_additive, capacity, add_time, update_time, s_number', 'safe', 'on'=>'search'),
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
			'gh_type' => 'Gh Type',
			'gh_amount' => 'Gh Amount',
			'm_p_water' => 'M P Water',
			'm_u_water' => 'M U Water',
			'm_p_cement' => 'M P Cement',
			'm_u_cement' => 'M U Cement',
			'm_p_ash' => 'M P Ash',
			'm_u_ash' => 'M U Ash',
			'm_p_gravel' => 'M P Gravel',
			'm_u_gravel' => 'M U Gravel',
			'm_p_sand' => 'M P Sand',
			'm_u_sand' => 'M U Sand',
			'm_p_river_sand' => 'M P River Sand',
			'm_u_river_sand' => 'M U River Sand',
			'm_p_additive' => 'M P Additive',
			'm_u_additive' => 'M U Additive',
			'capacity' => 'Capacity',
			'add_time' => 'Add Time',
			'update_time' => 'Update Time',
			's_number' => 'S Number',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('gh_type',$this->gh_type);
		$criteria->compare('gh_amount',$this->gh_amount,true);
		$criteria->compare('m_p_water',$this->m_p_water,true);
		$criteria->compare('m_u_water',$this->m_u_water,true);
		$criteria->compare('m_p_cement',$this->m_p_cement,true);
		$criteria->compare('m_u_cement',$this->m_u_cement,true);
		$criteria->compare('m_p_ash',$this->m_p_ash,true);
		$criteria->compare('m_u_ash',$this->m_u_ash,true);
		$criteria->compare('m_p_gravel',$this->m_p_gravel,true);
		$criteria->compare('m_u_gravel',$this->m_u_gravel,true);
		$criteria->compare('m_p_sand',$this->m_p_sand,true);
		$criteria->compare('m_u_sand',$this->m_u_sand,true);
		$criteria->compare('m_p_river_sand',$this->m_p_river_sand,true);
		$criteria->compare('m_u_river_sand',$this->m_u_river_sand,true);
		$criteria->compare('m_p_additive',$this->m_p_additive,true);
		$criteria->compare('m_u_additive',$this->m_u_additive,true);
		$criteria->compare('capacity',$this->capacity,true);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('s_number',$this->s_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}