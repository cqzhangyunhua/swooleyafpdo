<?php

use Illuminate\Database\Capsule\Manager as Capsule;
//use application\models\testMode as Test;

/**
 * @name IndexController
 * @author {&$AUTHOR&}
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class TestController extends Yaf_Controller_Abstract
{
    /**
     * 默认初始化方法，如果不需要，可以删除掉这个方法
     * 如果这个方法被定义，那么在Controller被构造以后，Yaf会调用这个方法
     */
    public function init()
    {
        $this->getView()->assign("header", "Yaf Example");
    }

    /**
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/{&$APP_NAME&}/index/index/index/name/{&$AUTHOR&} 的时候, 你就会发现不同
     */
    public function indexAction($name = "Stranger")
    {
        /*
        
        	'host'      => '192.168.0.247',
				'database'  => 'test',
				'username'  => 'admin',
				'password'  => 'g7bPlR/32Xs3w',
				'charset'   => 'utf8',
				'collation' => 'utf8_unicode_ci',
        */
        try {
            $db =  Db_DAOPDO::getInstance("192.168.0.247", "admin", "g7bPlR/32Xs3w", "test", "utf8");
            $rs = $db->query("SELECT * FROM test");
            var_dump($rs);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        exit;
        Capsule::enableQueryLog();
        $test =  new TestModel();
        var_dump($test->find(1));
        exit;
        //Capsule::beginTransaction();

        $users = Capsule::table('test2')->first();
        var_dump($users);
        exit;
        //Capsule::commit();
        var_dump($users);
        echo print_r(Capsule::getQueryLog(), 1);
        exit;
        $a = TestModel::find(1);
        var_dump($a->tel);
        $a->tel = "133333";
        var_dump($a->tel);
        $a->save();
        var_dump($a->tel);
        //  var_dump($a->tel);
        exit;
        $article = Capsule::table('test2')->first();
        var_dump($article->str);
        exit;
        $skey = $this->getRequest()->getQuery("k", "");
        var_dump($skey);
        exit;
        $str = file_get_contents('http://192.168.0.249:8080?service=search_user_business', false);
        $str_json = json_decode($str, true);
        if (isset($str_json["code"]) && $str_json["code"] == 200) {
            $url = $str_json["data"] . "/v1/searchbusiness/index?k=" . urlencode($skey);
            $rs = json_decode(file_get_contents($url, false), true);
            if ($rs) {
                $rep = ["code" => 200, "data" => $rs];
                echo json_encode($rep);
            } else {
                echo json_encode(["code" => 500, "msg" => $rs]);
            }
        } else {
            echo $str;
        }
    }
}
