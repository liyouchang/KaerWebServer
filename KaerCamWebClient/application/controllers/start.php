
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Start extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		if (!$this->session->userdata('name')) {
			log_message('error', 'login failed!');				
			header('Location: '.base_url().'login');
		}
		date_default_timezone_set('Asia/Shanghai');
		$this->data['userName'] = $this->session->userdata('name');
		$this->data['centerSvrIp']=$this->config->item('center_server_ip');
		$this->data['pluginFilePath'] = base_url("plugin/KeWebCamSetup.zip");
		$this->data['centerSvrType']=$this->config->item('center_server_type');
		$this->data['sharePermission']=$this->config->item('share_permission');
	}
	public $data ;
	 
	public function index()
	{
		$this->data['title'] = '登录';
		//$this->data['pluginFilePath'] = base_url("plugin/KeWebCamSetup.zip");
		$this->load->view('login_view',$this->data);
	}
	public function home()
	{
		$this->data['title'] = '功能列表';
		$this->load->view('home',$this->data);
	}
	public function monitoring()
	{
		$this->data['title'] = '实时监控';
		$this->load->view('monitoring',$this->data);
	}
	public function sys_config()
	{
		$this->data['title'] = '系统配置';
		$this->load->view('sys_config',$this->data);
	}
	public function snap_gallery()
	{
		$this->data['title'] = '快照查询';
		$this->load->view('snap_gallery',$this->data);
	}
	public function record_view()
	{
		$this->data['title'] = '录像播放';
		$this->load->view('record_view',$this->data);
	}
	public function alarms_query()
	{
		$this->data['title'] = '告警查询';
		$this->load->view('alarms_query',$this->data);
	}
	public function my_camera()
	{
		$this->data['title'] = '我的摄像机';		
		$this->load->view('home',$this->data);
	}
}

/* End of file login.php */
/* Location: ./application/controll */