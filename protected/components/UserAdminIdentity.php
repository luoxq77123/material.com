<?php
/**
 * User: lxq
 * Date: 16-4-11
 * Time: 下午1:24
 */
class UserAdminIdentity extends CUserIdentity
{
    private $_id;
    private $_user;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */


    public function authenticate()
    {
        $record = UserAdmin::model()->findByAttributes(array('account' => $this->username));
        if ($record === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        else if ($record->password !== $this->setPassword()) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        else {
            $this->_id = $record->id;
            $this->_user = $record->account;
            $this->setState('account', $record->account);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

    //设置保存值
    public function getPersistentStates()
    {
        return array(
            $this->_user => array(
                "a" => 123,
                "b" => 223
            )
        );
    }

    public function setPassword()
    {
        return md5($this->password);
    }
}