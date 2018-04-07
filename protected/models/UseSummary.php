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
 * @property string $create_time
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
			array('add_time, update_time, create_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, gh_type, gh_amount, m_p_water, m_u_water, m_p_cement, m_u_cement, m_p_ash, m_u_ash, m_p_gravel, m_u_gravel, m_p_sand, m_u_sand, m_p_river_sand, m_u_river_sand, m_p_additive, m_u_additive, capacity, create_time, add_time, update_time, s_number', 'safe', 'on'=>'search'),
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
			'create_time' => 'Create Time',
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
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('s_number',$this->s_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * 添加记录
     * @param $data
     * @param string $batch
     */
    public static function putData($data)
    {
        if (!empty($data['t'])) {

            $batch = date("YmdHis");
            $dateTime = date("Y-m-d H:i:s");

            $connection = Yii::app()->db;

            $transaction = $connection->beginTransaction();

            try {
                foreach ($data['t'] as $val) {
                    $gh_type = $val['gh_type'];//缸号类型
                    $gh_amount = $val['gh_amount'];//方量
                    $m_p_water = $val['m_p_water'];//水(配比)
                    $m_p_cement = $val['m_p_cement'];//水泥(配比)
                    $m_p_ash = $val['m_p_ash'];//火山灰(配比)
                    $m_p_gravel = $val['m_p_gravel'];//碎石(配比)
                    $m_p_sand = $val['m_p_sand'];//机制砂(配比)
                    $m_p_river_sand = $val['m_p_river_sand'];//河沙(配比)
                    $m_p_additive = $val['m_p_additive'];//外加剂(配比)

                    if(!is_numeric($gh_type) || !is_numeric($gh_amount) || !is_numeric($m_p_water) || !is_numeric($m_p_cement) || !is_numeric($m_p_ash) || !is_numeric($m_p_gravel) || !is_numeric($m_p_sand) || !is_numeric($m_p_river_sand) || !is_numeric($m_p_additive)){
                        continue;
                    }
                    $capacity = $m_p_water + $m_p_cement + $m_p_ash + $m_p_gravel + $m_p_sand + $m_p_river_sand + $m_p_additive;
                    $connection->createCommand()->insert('ml_use_summary', array(
                        'gh_type' => $gh_type,
                        'gh_amount' => $gh_amount,
                        'm_p_water' => $m_p_water,
                        'm_u_water' => $m_p_water * $gh_amount,
                        'm_p_cement' => $m_p_cement,
                        'm_u_cement' => $m_p_cement * $gh_amount,
                        'm_p_ash' => $m_p_ash,
                        'm_u_ash' => $m_p_ash * $gh_amount,
                        'm_p_gravel' => $m_p_gravel,
                        'm_u_gravel' => $m_p_gravel * $gh_amount,
                        'm_p_sand' => $m_p_sand,
                        'm_u_sand' => $m_p_sand * $gh_amount,
                        'm_p_river_sand' => $m_p_river_sand,
                        'm_u_river_sand' => $m_p_river_sand * $gh_amount,
                        'm_p_additive' => $m_p_additive,
                        'm_u_additive' => $m_p_additive * $gh_amount,
                        'capacity' => $capacity,
                        'add_time' => $data['add_time'],
                        'create_time' => $dateTime,
                        'update_time' => $dateTime,
                        's_number' => $batch,
                    ));
                }

                $transaction->commit();

            } catch (Exception $e)  {
                $transaction->rollBack();
            }

        }

    }

    /**
     * 获取所有记录
     * @param null $page
     * @param null $limit
     * @return mixed
     */
    public static function getData($page=null,$limit=null)
    {
        if($page===null && $limit===null){
            $sql = "select count(*) from ml_use_summary";
            return Yii::app()->db->createCommand($sql)->queryScalar();
        }else{
            $sql = "select * from ml_use_summary order by id  desc limit :offset,:limit ";
            $offset = ($page - 1) * $limit;
            $data = Yii::app()->db->createCommand($sql)
                ->bindValue(':offset',$offset)
                ->bindValue(':limit',$limit)
                ->order(" id desc")->queryAll();
            return $data;
        }
    }

    /**
     * 获取单条记录
     */
    public static function getDataId($id)
    {
        $sql = "select * from ml_use_summary where id=:id limit 1";
        $data = Yii::app()->db->createCommand($sql)->bindValue(":id",$id)->queryRow();
        return $data;
    }

    /**
     * 修改单条记录
     */
    public static function editRow($data)
    {
        if (!empty($data)) {
            $batch = date("YmdHis");
            $dateTime = date("Y-m-d H:i:s");
            $connection = Yii::app()->db;
            try {
                    $gh_type = $data['gh_type']; //缸号类型
                    $gh_amount = $data['gh_amount']; //方量
                    $m_p_water = $data['m_p_water']; //水(配比)
                    $m_p_cement = $data['m_p_cement']; //水泥(配比)
                    $m_p_ash = $data['m_p_ash']; //火山灰(配比)
                    $m_p_gravel = $data['m_p_gravel']; //碎石(配比)
                    $m_p_sand = $data['m_p_sand']; //机制砂(配比)
                    $m_p_river_sand = $data['m_p_river_sand']; //河沙(配比)
                    $m_p_additive = $data['m_p_additive']; //外加剂(配比)

                    if (!is_numeric($gh_type) || !is_numeric($gh_amount) || !is_numeric($m_p_water) || !is_numeric($m_p_cement) || !is_numeric($m_p_ash) || !is_numeric($m_p_gravel) || !is_numeric($m_p_sand) || !is_numeric($m_p_river_sand) || !is_numeric($m_p_additive)) {
                       return false;
                    }
                    $capacity = $m_p_water + $m_p_cement + $m_p_ash + $m_p_gravel + $m_p_sand + $m_p_river_sand + $m_p_additive;
                    $connection->createCommand()->update('ml_use_summary', array(
                        'gh_type' => $gh_type,
                        'gh_amount' => $gh_amount,
                        'm_p_water' => $m_p_water,
                        'm_u_water' => $m_p_water * $gh_amount,
                        'm_p_cement' => $m_p_cement,
                        'm_u_cement' => $m_p_cement * $gh_amount,
                        'm_p_ash' => $m_p_ash,
                        'm_u_ash' => $m_p_ash * $gh_amount,
                        'm_p_gravel' => $m_p_gravel,
                        'm_u_gravel' => $m_p_gravel * $gh_amount,
                        'm_p_sand' => $m_p_sand,
                        'm_u_sand' => $m_p_sand * $gh_amount,
                        'm_p_river_sand' => $m_p_river_sand,
                        'm_u_river_sand' => $m_p_river_sand * $gh_amount,
                        'm_p_additive' => $m_p_additive,
                        'm_u_additive' => $m_p_additive * $gh_amount,
                        'capacity' => $capacity,
                        'add_time' => $data['add_time'],
                        'update_time' => date("Y-m-d H:i:s"),
                    ),"id=:id",[":id"=>$data['id']]);
            }
            catch (Exception $e) {

            }

        }
    }


    public static function getExportData($start)
    {
        $sql = <<<sql
        select
        sum(m_u_cement) as cement,
        sum(m_u_ash) as ash,
        sum(m_u_gravel) as gravel,
        sum(m_u_sand) as sand,
        sum(m_u_river_sand) as river_sand,
        sum(m_u_additive) as additive

        from ml_use_summary where add_time <= :start order by id desc
sql;


        $data = Yii::app()->db->createCommand($sql)
            ->bindValue(':start',$start)
            ->order(" id desc")->queryAll();
        return $data;

    }

    //获取时间段使用量
    public static function getRangeData($start,$end)
    {
        $sql = "select * from ml_use_summary where add_time>=:start and add_time<=:end order by id desc";

        $data = Yii::app()->db->createCommand($sql)
            ->bindValue(':start', $start)
            ->bindValue(':end', date("Y-m-d 23:59:59", strtotime($end)))
            ->order(" id desc")->queryAll();
        return $data;
    }
}