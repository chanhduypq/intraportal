<?php
	require_once('config.php');

	// This is the configuration for yiic console application.
	return array(
	 'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	 'name'=>'basenews',
	 'name'=>'pickup',
	 'name'=>'blogtwitter',

		 // autoloading model and component classes
	 'import'=>array(
	  'application.models.*',
	  'application.components.*',
	 ),

		 // application components
	 'components'=>array(

	  'db'=>array(
	   'connectionString' => 'mysql:host='.Config::HOST_DATA.';dbname='.Config::DB_NAME,
	   'emulatePrepare' => true,
	   'username' => Config::LOGIN_DATA,
	   'password' => Config::PASS_DATA,
	   'charset' => 'utf8',
	  ),

		//send mailer
		'mail' => array(
			'class' => 'ext.yii-mail.YiiMail',
			'transportType'=>'smtp',
			'transportOptions'=>array(
			'host'=>Config::EMAIL_HOST,
			'username'=>Config::EMAIL_USERNAME,
			'password'=>Config::EMAIL_PASS,
			'port'=>Config::EMAIL_PORT,
//			'encryption'=>'ssl',
			),
		),

  ),
);

