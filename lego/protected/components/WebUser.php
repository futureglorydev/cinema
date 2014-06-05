<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Stas Panyukov
 * Date: 19.09.13
 * Time: 14:36
 * To change this template use File | Settings | File Templates.
 *  реализуем получение роли из БД при использовании Yii::app()->user->role
 */

	class WebUser extends CWebUser {
	    private $_model = null;

	    function getName() {
	        if($user = $this->getModel()){
	            // в таблице User есть поле role
	            return $user->name.' '.$user->surname;
	        }
	    }

		function getEmail() {
		  if($user = $this->getModel()){
			  // в таблице User есть поле role
			  return $user->email;
		  }
		}

		function getStatus() {
		  if($user = $this->getModel()){
			  // в таблице User есть поле status
			  return $user->status;
		  }
		}

	    private function getModel(){
	        if (!$this->isGuest && $this->_model === null){
	            $this->_model = User::model()->findByPk($this->id);
	        }
	        return $this->_model;
	    }
	}