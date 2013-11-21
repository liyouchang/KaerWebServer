<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
		//$this->load->model("Socket_model");
		date_default_timezone_set('Asia/Shanghai');
		$this->data['pluginFilePath'] = base_url("plugin/KeWebCamSetup.zip");
		$this->data['androidFilePath'] = base_url("plugin/MobileVideo.apk");
		$this->data['centerSvrIp'] =$this->config->item('center_server_ip');
		$this->data['centerSvrType']=$this->config->item('center_server_type');
		$this->data['sharePermission']=$this->config->item('share_permission');
	}
	public $data = array("title"=> '登录');
	public function index()
	{
		$this->load->view('login_view',$this->data);
	}
	public function login()
	{
		$this->data['title'] = '登录';
		$this->load->view('login_view',$this->data);
		
	}
	public function register()
	{
		
		$this->data['title'] = '用户注册';
		$this->load->view('user_register',$this->data);
		
	}
	
	public function logout()
	{
		//$this->Socket_model->PCloseServer();
		$this->load->model("udp_model");
		$this->udp_model->Logout();
		$this->session->sess_destroy();
		header('Location: '.base_url().'login');
	}
	public function forget_pwd()
	{
		$this->data['title'] = '忘记密码';
		$this->load->view('forget_pwd_view',$this->data);
	}
	public function heart_beat()
	{
		$out = $this->udp_model->HeartBeat();
		//usleep(10000);
		$outArray = array("errorCode"=>"$out");
		echo json_encode($outArray);
	}
	
	
	
	
}