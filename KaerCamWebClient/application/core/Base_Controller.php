<?php
/*
 * class: My_Controller
 * filename: MY_Controller.php
 * description :继承于CI_Controller 重写_remap() 方法，实现在url中隐藏控制器中index方法
 * author :zhanghui rabbitzhang52@gmail.com
 * create :2012年3月26日19:34:32
 */
	class Base_Controller extends CI_Controller {

		function __construct() {
			parent::__construct();
			// 初始化配置文件		
		}

		
		/**
		 * @param $sign 当为TRUE时需要登录，当为FALSE是需要不登陆
		 */
		function _require_login($sign = TRUE) {
			if($sign && $this->session->userdata('type') == 'guest') {
				if(!$this->input->get('jump')) {
					$jump = substr(uri_string(), 1);
					redirect('index/login?jump=' . $jump);
				} else {
					redirect('index/login');
				}
			} elseif(!$sign && $this->session->userdata('type') != 'guest') {
				redirect();
			}
		}
		
		function _remap($method, $params = array()) {
			if (method_exists($this, $method)){
				return call_user_func_array(array($this, $method), $params);
			} else {
				array_unshift($params, $method);
				return call_user_func_array(array($this, 'index'), $params);
			}
		}
		
		function _require_ajax($return = FALSE) {
			if(!$this->input->post('ajax')) {
				if($return)
					return FALSE;
				else 
					static_view('未定义操作');
			}
			return TRUE;
		}
		
	
	}