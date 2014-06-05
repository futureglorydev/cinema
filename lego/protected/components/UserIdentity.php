<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
 	private $name;
 	private $isAuthenticated = false;
 	private $states = array();
	public $admin = false;

	public function authenticate()
	{
		if($this->admin)
		{
			if( Yii::app()->user->checkAccess('root') || Yii::app()->user->checkAccess('manager') )
			{
				$record = User::model()->findByAttributes(array('email'=>$this->username));
				if($record === null){
					$this->errorCode = self::ERROR_USERNAME_INVALID;
				}elseif($record->password !== $this->password){
					$this->errorCode = self::ERROR_PASSWORD_INVALID;
				}else{
					$this->_id = $record->id;
					$this->errorCode = self::ERROR_NONE;
				}
			}
			else
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		else
		{
			$record = User::model()->findByAttributes(array('email'=>$this->username));
			if($record === null){
				$this->errorCode = self::ERROR_USERNAME_INVALID;
			}elseif($record->password !== User::hashPassword($this->password)){
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			}elseif($record->status == 'BANNED'){
				$this->errorCode = 999;
			}else{
				$this->_id = $record->id;
				$this->errorCode = self::ERROR_NONE;
			}
		}

		return !$this->errorCode;

	}

    public function getId(){
        return $this->_id;
    }

	public function getIsAuthenticated()
	 {
		 return $this->isAuthenticated;
	 }

	 public function getName()
	 {
		 return $this->name;
	 }

	 public function getPersistentStates()
	 {
		 return $this->states;
	 }
}