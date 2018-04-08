<?php

/**
 * This is the model class for table "{{materials}}".
 *
 * The followings are the available columns in table '{{materials}}':
 * @property integer $id
 * @property string $ml_id
 * @property integer $su_id
 * @property string $ml_no
 * @property string $ku_nums
 * @property string $num
 * @property integer $user_cl
 * @property string $remarks
 * @property string $create_time
 * @property string $update_time
 * @property string $add_time
 * @property string $batch
 */
class Materials extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Materials the static model class
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
		return '{{materials}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ml_id', 'required'),
			array('su_id, user_cl', 'numerical', 'integerOnly'=>true),
			array('ml_id, ml_no, ku_nums, remarks, batch', 'length', 'max'=>255),
			array('num', 'length', 'max'=>15),
			array('create_time, update_time, add_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ml_id, su_id, ml_no, ku_nums, num, user_cl, remarks, create_time, update_time, add_time, batch', 'safe', 'on'=>'search'),
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
			'ml_id' => 'Ml',
			'su_id' => 'Su',
			'ml_no' => 'Ml No',
			'ku_nums' => 'Ku Nums',
			'num' => 'Num',
			'user_cl' => 'User Cl',
			'remarks' => 'Remarks',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'add_time' => 'Add Time',
			'batch' => 'Batch',
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
		$criteria->compare('ml_id',$this->ml_id,true);
		$criteria->compare('su_id',$this->su_id);
		$criteria->compare('ml_no',$this->ml_no,true);
		$criteria->compare('ku_nums',$this->ku_nums,true);
		$criteria->compare('num',$this->num,true);
		$criteria->compare('user_cl',$this->user_cl);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('add_time',$this->add_time,true);
		$criteria->compare('batch',$this->batch,true);

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
        //var_dump($data);exit;
        if (!empty($data['t'])) {

            $batch = date("YmdHis");
            $dateTime = date("Y-m-d H:i:s");
            $insert = <<<sql
                INSERT INTO ml_materials (ml_id,su_id,ml_no,ku_nums,num,user_cl,remarks,create_time,update_time,add_time,batch) 
                VALUES(:ml_id,:su_id,:ml_no,:ku_nums,:num,:user_cl,:remarks,:create_time,:update_time,:add_time,:batch)
sql;
            $connection = Yii::app()->db;
            $command = $connection->createCommand("$insert");

            $transaction = $connection->beginTransaction();

            try {
                foreach ($data['t'] as $val) {
                    $num = is_numeric($val['num']) ? $val['num'] * 1000 : 0;
                    if (empty($num)) {
                        continue;
                    }
                    $command->bindValue(":ml_id", $val['ml_id']);
                    $command->bindValue(":su_id", $val['su_id']);
                    $command->bindValue(":ml_no", $val['ml_no']);
                    $command->bindValue(":ku_nums", $val['ku_nums']);
                    $command->bindValue(":num", $num);
                    $command->bindValue(":user_cl", $val['user_cl']);
                    $command->bindValue(":remarks", $val['remarks']);
                    $command->bindValue(":create_time", $dateTime);
                    $command->bindValue(":update_time", $dateTime);
                    $command->bindValue(":add_time", $val['add_time']);
                    $command->bindValue(":batch", $batch);
                    $command->execute();
                }

                $transaction->commit();

            } catch (Exception $e)  {
                var_dump($e->getMessage());exit;
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
            $sql = "select count(*) from ml_materials";
            return Yii::app()->db->createCommand($sql)->queryScalar();
        }else{
            $sql = "select * from ml_materials order by id  desc limit :offset,:limit";
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
        $sql = "select * from ml_materials where id=:id limit 1";
        $data = Yii::app()->db->createCommand($sql)->bindValue(":id",$id)->queryRow();
        return $data;
    }

    /**
     * 修改单条记录
     */
    public static function editRow($data)
    {
        $num = is_numeric($data['num']) ? $data['num'] * 1000 : 0;
        $columns=[
            'add_time'=>$data['add_time'],
            'su_id'=>$data['su_id'],
            'ml_no'=>$data['ml_no'],
            'ku_nums'=>$data['ku_nums'],
            'num'=>$num,
            'user_cl'=>$data['user_cl'],
            'remarks'=>$data['remarks'],
            'update_time'=>date("Y-m-d H:i:s")
        ];
        Yii::app()->db->createCommand()->update('ml_materials',$columns,"id=:id",[":id"=>$data['id']]);
    }

    /**
     * 获取时间段内存储量
     */
    public static function getStorageData($start)
    {
        $sql = <<<sql
        select sum(num) nums,ml_id from ml_materials where add_time<=:start
        group by ml_id
sql;

        $data = Yii::app()->db->createCommand($sql)
            ->bindValue(':start',$start)
            ->queryAll();
        if(empty($data)){
            return [];
        }
        return array_column($data,'nums','ml_id');


    }

    //获取时间段库存量
    public static function getRangeData($start,$end)
    {
        $sql = "select * from ml_materials where add_time>=:start and add_time<=:end order by id desc";

        $data = Yii::app()->db->createCommand($sql)
            ->bindValue(':start', $start)
            ->bindValue(':end', date("Y-m-d 23:59:59", strtotime($end)))
            ->order(" id desc")->queryAll();
        return $data;
    }


}