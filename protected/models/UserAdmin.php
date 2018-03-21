<?php

/**
 * This is the model class for table "{{user_admin}}".
 *
 * The followings are the available columns in table '{{user_admin}}':
 * @property integer $id
 * @property string $account
 * @property string $password
 * @property integer $create_time
 * @property integer $last_time
 * @property string $last_ip
 */
class UserAdmin extends CActiveRecord
{
    const LOGIN = 'login';
    const CREATE = 'create';

    private $_identity;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserAdmin the static model class
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
		return '{{user_admin}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, last_time', 'numerical', 'integerOnly'=>true),
			array('account,password, last_ip', 'length', 'max'=>255),
            array('password', 'authenticate', 'on' => self::LOGIN),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, account, password, create_time, last_time, last_ip', 'safe', 'on'=>'search'),
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
			'account' => '账号',
			'password' => '密码',
			'create_time' => '创建时间',
			'last_time' => '最后登录时间',
			'last_ip' => '最后登录IP',
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
		$criteria->compare('account',$this->account,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('last_time',$this->last_time);
		$criteria->compare('last_ip',$this->last_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function authenticate()
    {
        $this->_identity= new UserAdminIdentity($this->account, $this->password);
        //var_dump($identity);exit;
        if(!$this->_identity->authenticate()){
            $this->addError('myError', '登录失败!');
        }
    }

    public function getIdentity()
    {
        return $this->_identity;
    }


}