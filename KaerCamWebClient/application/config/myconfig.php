<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//$config['center_server_ip']	= '222.174.213.185';
$config['center_server_ip'] = '123.167.6.52';
//$config['center_server_ip'] = '192.168.0.7';
//$config['center_server_ip'] = '127.0.0.1';
$config['center_server_port'] = '22616';
/*
|--------------------------------------------------------------------------
| 服务器类型
|--------------------------------------------------------------------------
|
| 支持服务器为P2P服务器 —— 1
08 服务器 —— 2
|
*/
$config['center_server_type'] = 2;

$config['plugin_file_path'] = 'plugin/KeWebCamSetup.zip';

//共享设备是否有云台等权限，1--有，0--无。调试时可以设成1.
$config['share_permission'] = 0;
