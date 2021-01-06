<?php
//禁用错误报告
ini_set("display_errors", "On");
error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE);
########################
define('APPLICATION_PATH', dirname(__FILE__) . "/..");
$application;
$http = new Swoole\Http\Server("0.0.0.0", 9501);
$http->on('WorkerStart', function ($serv, $worker_id) {
	global $argv, $application;
	if ($worker_id >= $serv->setting['worker_num']) {
		swoole_set_process_name("php {$argv[0]} task worker");
	} else {
		swoole_set_process_name("php {$argv[0]} event worker");
	}
	$application  = new Yaf_Application(APPLICATION_PATH . "/conf/application.ini");
});
$http->on('request', function ($request, $response) {
	global $application;

	$request_uri = str_replace("/index.php", "", $request->server['request_uri']);
	$yaf_request = new Yaf_Request_Http($request_uri);
	$application->getDispatcher()->setRequest($yaf_request);

	Yaf_Registry::set('swoole_req', $request);
	Yaf_Registry::set('swoole_res', $response);

	// yaf 会自动输出脚本内容，因此这里使用缓存区接受交给swoole response 对象返回
	ob_start();
	$application->getDispatcher()->disableView();
	$application->bootstrap()->run();
	$data = ob_get_clean();
	$response->end($data);
});

$http->start();
