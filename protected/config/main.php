<?php
require_once(dirname(__FILE__) . '/../config/config.php');
require_once(dirname(__FILE__) . '/../components/Lang.php');
require_once(dirname(__FILE__) . '/../components/FunctionCommon.php');
require_once(dirname(__FILE__) . '/../components/Constants.php');
require_once(dirname(__FILE__) . '/../components/Lang.php');
require_once(dirname(__FILE__) . '/../components/simple_html_dom.php');


// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ニューギンスクエア',
	'defaultController' => 'newgin',
	//'theme'=>'majime',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.modules.user.models.*',
		'application.components.*',
		'application.forms.*',
		'extensions mail',
		'ext.yii-mail.YiiMailMessage',               
	),
	
        

	'modules'=>array(
		// uncomment the following to enable the Gii tool
        
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
		
	),
	
	// application components
	'components'=>array(
		'simpleImage'=>array(
                        'class' => 'application.extensions.CSimpleImage',
                ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'errorHandler'=>array(
			'errorAction' => 'general/error',
		),
		'image'=>array(    
			'class'=>'application.extensions.image.CImageComponent',           
			'driver'=>'GD',
		),


		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
		'urlFormat'=>'path',
		'showScriptName'=>false,	
		'caseSensitive'=>false,
		'rules'=>array(
				'<controller:\w+>/<action:\w+>/page/<page:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>', 				
				),
			
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
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host='.Config::HOST_DATA.';dbname='.Config::DB_NAME,
			'emulatePrepare' => true,
			'username' => Config::LOGIN_DATA,
			'password' => Config::PASS_DATA,
			'charset' => 'utf8',
			
		),
		
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class' => 'CFileLogRoute',
                    'levels'=>'trace,info,error,warning',
                    'categories'=>'system.*',
					// 'logFile'=>'sql.log',
					'filter' => array(
										'class' => 'CLogFilter',
										'prefixSession' => true,
										'prefixUser' => true,
										'logUser' => true,
										'logVars' => array(),
									 ),

						),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail' => Config::EMAIL_USERNAME,
		'listPerPage'=> Config::LIMIT_ROW,
		'subjectPw'	 => Config::EMAIL_SUB,
		'adminReminderEmailTo'	 => Config::PWDREMINDER_EMAIL_FROM,
		'adminInquiryEmailTo'	 => Config::$INQUIRY_EMAIL_TO,
        'attachment1_error'      => '添付ファイルの容量は'.Config::MAX_FILE_SIZE.'MBを超えています。',
        'attachment2_error'      => '添付ファイルの容量は'.Config::MAX_FILE_SIZE.'MBを超えています。',
        'attachment3_error'      => '添付ファイルの容量は'.Config::MAX_FILE_SIZE.'MBを超えています。',
        'attachment4_error'      => '添付ファイルの容量は'.Config::MAX_FILE_SIZE.'MBを超えています。',
                
	),
	
	'language'=>'jp'
);

