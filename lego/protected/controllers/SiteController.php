<?php

class SiteController extends Controller
{
	public function actionIndex()
	{
		$this->pageTitle = Yii::app()->name.'';

		$this->render('index');
	}


	public function actionLogin()
	{
	    $this->redirect('/user/login');
	}




}