<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    private $action = "";
    private $_assetsBase;
    public $items = array();

    public function getAssetsBase() {
        if ($this->_assetsBase === null) {
            $this->_assetsBase = Yii::app()->assetManager->publish(
                    Yii::getPathOfAlias('application.assets'), false, -1, defined('YII_DEBUG') && YII_DEBUG
            );
        }
        return $this->_assetsBase;
    }

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    private function getControllerName($url) {
        $temp = explode("/", $url);
        $controller_name = $temp[count($temp) - 1];
        if (
                $controller_name == '' || $controller_name == 'index' || $controller_name != 'regist' || $controller_name != 'registconfirm' || $controller_name != 'edit' || $controller_name != 'editconfirm' || $controller_name != 'add' || $controller_name != 'addconfirm' || $controller_name != 'confirm' || $controller_name != 'download' || $controller_name != 'downloadedit'
        ) {
            $controller_name = $temp[count($temp) - 2];
            if (
                    $controller_name == 'index' || $controller_name != 'regist' || $controller_name != 'registconfirm' || $controller_name != 'edit' || $controller_name != 'editconfirm' || $controller_name != 'add' || $controller_name != 'addconfirm' || $controller_name != 'confirm' || $controller_name != 'download' || $controller_name != 'downloadedit'
            ) {
                $controller_name = $temp[count($temp) - 3];
            }
        }
        return $controller_name;
    }

    protected function afterRender($view, &$output) {

        $beforeUrl = Yii::app()->request->urlReferrer;
        $task = 'not';
        if ($beforeUrl == NULL) {//type url that is not home page
            $task = 'not';
        } else {//ctrl+click link or right click link or type url that is home page
            $controller_name = $this->getControllerName($beforeUrl);

            if (
                    $controller_name == 'admin' || $controller_name == 'asobi' || $controller_name == 'majime'
            ) {
                $task = 'not';
            } else {
                if (substr($controller_name, 0, 6) == 'majime') {
                    $task = substr($controller_name, 6, strlen($controller_name) - 6);
                } else if (substr($controller_name, 0, 5) == 'admin' || substr($controller_name, 0, 5) == 'asobi') {
                    $task = substr($controller_name, 5, strlen($controller_name) - 5);
                }
            }
        }




        $action = Yii::app()->getController()->getAction()->getId();

        if (
                $action != 'regist' && $action != 'registconfirm' && $action != 'edit' && $action != 'editconfirm' && $action != 'add' && $action != 'addconfirm' && $action != 'confirm' && $action != 'download' && $action != 'downloadedit'
        ) {

            $cookie_collection = Yii::app()->request->cookies;
            $key_array = $cookie_collection->getKeys();

            for ($i = 0, $n = count($key_array); $i < $n; $i++) {
                $key = $key_array[$i];
                if (substr($key, 0, 4) == 'file' && strpos($key, 'hobby_new') == FALSE && strpos($key, "office") == FALSE && strpos($key, "user") == FALSE && strpos($key, $task) != FALSE) {

//                    if (Yii::app()->request->cookies[$key] != "" && Yii::app()->request->cookies[$key] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
//                        unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
//                        $temp = explode(".", Yii::app()->request->cookies[$key]->value);
//                        $new_thumnail_file_path = $temp[0];
//                        for ($j = 1, $m = count($temp) - 1; $j < $m; $j++) {
//                            $new_thumnail_file_path.='.' . $temp[$j];
//                        }
//                        $new_thumnail_file_path.='_widget' . '.' . $temp[count($temp) - 1];
//                        if (file_exists(Yii::getPathOfAlias('webroot') . $new_thumnail_file_path)) {
//                            unlink(Yii::getPathOfAlias('webroot') . $new_thumnail_file_path);
//                        }
//                    }
//                    unset(Yii::app()->request->cookies[$key]);
                }
            }
        }
        $action = Yii::app()->getController()->getAction()->getId();
        if ($action == 'index') {
            $cookie_array = $_COOKIE;
            if (is_array($cookie_array) && count($cookie_array) > 0) {
                foreach ($cookie_array as $key => $value) {
                    if ($key != 'id' && $key != "PHPSESSID" && $key != 'beforelink' && $key != "passwd" && $key != "page") {
//                        unset(Yii::app()->request->cookies[$key]);
                    }
                }
            }
        }
    }

    public function accessRules() {
        $userId = Yii::app()->request->cookies->contains('id') ? Yii::app()->request->cookies['id']->value : '';
        if (!empty($userId)) {
            $controller1 = Yii::app()->controller->id;
            $isAdmin = substr($controller1, 0, 5);
            if ($isAdmin == "admin") {
                $controller = substr($controller1, 5, strlen($controller1));
            } else {
                $controller = substr($controller1, 6, strlen($controller1));
            }
            $action = "";
            if (isset(Yii::app()->controller->action->id)) {
                $action = Yii::app()->controller->action->id;
            }
            $userModel = User::model()->findByPk($userId);
            $role_id = $userModel->role_id;
            $connection = Yii::app()->db;
            $command = $connection->createCommand();
            $command->select('baserole_id');
            $command->from('functions f');
            $command->join('role_management r', 'f.id=r.function_id');
            $command->where("f.controller='$controller' AND r.role_id='$role_id'");
            $role = $command->queryAll();
            $arrDeny = array("index", "detail", "regist", "delete", "edit", "categories");
            $arr = array("logout", 'login');
            $arradmin = array("logout", 'login');
            $arrpost = array();
            if ($controller1 == "adminprofile") {
                $role[0]['baserole_id'] = Constants::$baserole['admin'];
            }
            if ($controller1 == "majimetopics") {
                $role[0]['baserole_id'] = Constants::$baserole['view'];
                $role[1]['baserole_id'] = Constants::$baserole['post'];
            }
            if ($controller1 == "admin") {
                $role[0]['baserole_id'] = Constants::$baserole['admin'];
            }
            if ($controller1 == "majime") {
                $arr[] = 'index';
            }
            if (!empty($role)) {
                foreach ($role as $val) {
                    if ($val['baserole_id'] == Constants::$baserole['view']) {
                        $arr[] = 'index';
                        $arr[] = 'detail';
                        if ($controller1 == "adminto_officer") {
                            $arradmin[] = "index";
                            $arradmin[] = "detail";
                        }
                        //$arradmin[]="index";
                        //$arradmin[]="detail";
                    }
                    if ($val['baserole_id'] == Constants::$baserole['post']) {
                        $arr[] = 'regist';
                        $arr[] = 'edit';
                        $arradmin[] = "regist";
                        $arradmin[] = "index";
                        $arradmin[] = "detail";
                        $arradmin[] = "edit";
                        $arradmin[] = 'delete';
                    }
                    if ($val['baserole_id'] == Constants::$baserole['admin']) {
                        $arradmin[] = 'index';
                        $arradmin[] = 'regist';
                        $arradmin[] = 'edit';
                        $arradmin[] = 'detail';
                        $arradmin[] = 'delete';
                        $arradmin[] = 'categories';
                    }
                }
                if ($controller1 == "majimebounty") {
                    $arr[] = 'delete';
                }
                if ($isAdmin == "majim") {
                    if (!in_array($action, $arr) && in_array($action, $arrDeny)) {
                        Yii::app()->setComponents(array('errorHandler' => array('errorAction' => 'general/error')));
                    }

                    return array(
                        array('allow',
                            'actions' => $arr,
                            'users' => array('*'),
                        ),
                        array('deny', // deny all users
                            'actions' => array('regist', 'index', 'detail', 'edit', 'delete'),
                            'users' => array('*'),
                        ),
                    );
                } else if ($isAdmin == "admin") {
                    if (!in_array($action, $arradmin) && $action != "index" && in_array($action, $arrDeny)) {
                        Yii::app()->user->setFlash('deny', Lang::MSG_0092);
                        $this->redirect(array($controller1 . '/'));
                    }

                    return array(
                        array('allow',
                            'actions' => $arradmin,
                            'users' => array('*'),
                        ),
                        array('deny',
                            'actions' => array('regist', 'index', 'detail', 'edit', 'delete'),
                            'users' => array('*'),
                        ),
                    );
                } else {
                    return array(
                        array('allow',
                            'actions' => array('logout', 'login'),
                            'users' => array('*'),
                        ),
                    );
                }
            } else {
                if ($controller1 != "majime" && $isAdmin == "majim" && $controller != "report") {
                    Yii::app()->user->setFlash('deny', Lang::MSG_0092);
                    $this->redirect(array('majime/'));
                } else {
                    Yii::app()->setComponents(array('errorHandler' => array('errorAction' => 'general/error')));
                }
                return array(
                    array('allow',
                        'users' => array('*'),
                    ),
                    array('deny', // deny all users
                        'actions' => array('regist', 'index', 'detail', 'edit', 'delete'),
                        'users' => array('*'),
                    ),
                );
            }
        }
        return array(
            array('allow',
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'actions' => array('regist', 'index', 'detail', 'edit', 'delete'),
                'users' => array('*'),
            ),
        );
    }

}
