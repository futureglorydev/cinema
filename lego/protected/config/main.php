<?php

	setlocale(LC_ALL, 'ru_RU.UTF-8');
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');


// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'API Cinema',
	'sourceLanguage' => 'en',
 	'language' => 'ru',


	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*', // yii image
		'application.components.behaviors.*',
	),


	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'511587',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','109.225.1.54',/*'194.143.150.135'*/),
			'generatorPaths'=>array(
			                'bootstrap.gii',
			),
		),
	),


	// application components
	'components'=>array(
		/*'cache'=>array(
      		'class'=>'CDbCache',
		),*/

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'WebUser',
		),
		/*'authManager'=>array(
			'class'=>'application.modules.srbac.components.SDbAuthManager',
			'connectionID'=>'db',
			'itemTable'=>'yii_auth_item',
			'itemChildTable'=>'yii_auth_item_child',
			'assignmentTable'=>'yii_auth_assignment',
			'defaultRoles'       =>  array('guest')
		),*/
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
			'rules'=>array(
				'gii'=>'gii',
				'gii/<controller:\w+>'=>'gii/<controller>',
				'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<param:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<param:\w+>/<param2:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		//uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=cinema',
			'emulatePrepare' => true,
			'username' => 'cinema',
			'password' => '123',
			'charset' => 'utf8',
			'tablePrefix' => 'yii_',
			'pdoClass' => 'NestedPDO', // вложенные  транзакции
			#'enableParamLogging'=>true,
			'enableProfiling'=>false,
			#'schemaCachingDuration'=>3600,
		),
			// session
		'session'=>array(
				'class'=>'system.web.CDbHttpSession',
				'connectionID'=>'db',
				'autoCreateSessionTable'=> false,
				'sessionTableName' => 'yii_sessions',
				'sessionName' => 'sessid',
				'timeout' => 24*3600*30, //  30 days
		),

    	/*'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),*/
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CEmailLogRoute',
					'levels'=>'error, warning',
					//'emails'=>'',
				),

				// uncomment the following to show log messages on web pages
				array(
					'class'=>'CWebLogRoute',
					'categories'=>'system.db.*',
				//	'except'=>'system.db.ar.*', // показываем всё, что касается базы данных, но не касается AR
					'enabled'=>false
				),
				array( // -- CProfileLogRoute -----------------------
					'class'=>'CProfileLogRoute',
					'levels'=>'profile',
					'enabled'=>false,
				),
			),
		),

		'console'=>array(
			'class'=>'application.extensions.EConsole',
		),

	),



	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(

	),
);
