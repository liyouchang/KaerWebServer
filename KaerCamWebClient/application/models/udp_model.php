<?php

class UDP_Model extends CI_Model {

	public $center_ip ;
	public $center_port;

	protected $socket;
	function __construct() {
		parent::__construct();
		//$this->center_ip = "218.56.11.182";
		//$this->center_ip = "192.168.0.8";
		$this->center_ip = $this->config->item('center_server_ip');
		$this->center_port=$this->config->item('center_server_port');
	}

	protected $requestMsgFromat = array(
			"Head"=>"H4II",
			"login"=>"H4IIa*",
			"heartbeat"=>"H4II",
			"devList"=>"H4II",
			"register"=>"H4IICIa*",
			"refindPwd"=>"H4IICa*",
			"addCam"=>"H4IICa*",
			"logout"=>"H4II",
			"delCam"=>"H4IICI",
			"shrCam"=>"H4IICIa*",
			"chkShrUser"=>"H4III",
			"CancelShr"=>"H4IICII",
			"QueryRecord"=>"H4IIICH4IIICH12H12CC",
			"SetDevRecord"=>"H4IIICCCC",
			"GetDevRecord"=>"H4IIICC",
			"ChgUserPwd"=>"H4IICa40",
			"ChgDevName"=>"H4IICa*",
	);
	protected $respondMsgFromat = array(
			"setcretKey"=>"H4head/Ilen/IclientID/a8secretKey",
			"login"=>"H4head/Ilen/IclientID/H2respMsg",
			"heartbeat"=>"H4head/Ilen/IclientID",
			"devList"=>"H4head/Ilen/IclientID/a*data",
			"register"=>"H4head/Ilen/IclientID/Ctype/ItmpID/H2respMsg",
			"refindPwd"=>"H4head/Ilen/IclientID/Ctype/H2respMsg",
			"addCam"=>"H4head/Ilen/IclientID/Ctype/IdevID/H2respMsg",
			"delCam"=>"H4head/Ilen/IclientID/Ctype/IdevID/H2respMsg",
			"shrCam"=>"H4head/Ilen/IclientID/Ctype/ItmpID/H2respMsg",
			"chkShrUser"=>"H4head/Ilen/IclientID/a*data",
			"CancelShr"=>"H4head/Ilen/IclientID/Ctype/IdevID/IuserShr/H2respMsg",
			"QueryRecord"=>"H20udpData/H4head/ImsgLen/IdevID/IclientID/CchnlNo/H2respMsg/IfileNo/H12startTime/H12endTime/IfileSize/a*fileData",
			"SetDevRecord"=>"H4head/Ilen/IclientID/IdevID/CchannelNo/Ctype/H2respMsg",
			"GetDevRecord"=>"H4head/Ilen/IclientID/IdevID/CchannelNo/Ctype/Cstatus",
			"ChgUserPwd"=>"H4head/Ilen/IclientID/Ctype/H2respMsg",
			"ChgDevName"=>"H4head/Ilen/IclientID/Ctype/H2respMsg",
	);
	
	/**
	 * @function write and read from socket
	 * @param socket $socket
	 * @param string $writeStr
	 * @param number $readLen
	 * return the read string
	*/
	public function writeAndRead($writeStr,$readLen=2048)
	{
		//$sent = socket_write($this->socket, $writeStr);
		$sent = fwrite($this->socket, $writeStr);
		if($sent === FALSE)
		{
			throw new Exception("socket_write() failed: reason: " . socket_strerror(socket_last_error()));
		}
		//$out = socket_read($this->socket, $readLen);
		$out = fread($this->socket, $readLen);
		if($out === FALSE)
		{
			throw new Exception("socket_read() failed: reason: " . socket_strerror(socket_last_error()));
		}
		if(strlen($out) == 0 )
		{
			throw new Exception("socket_read() read 0 message" );

		}
		return $out;
	}


	public function PConnectServer()
	{
		
		$this->socket = stream_socket_client("udp://$this->center_ip:$this->center_port",
				$errno, $errstr,30,STREAM_CLIENT_CONNECT);
				//$this->socket = pfsockopen("tcp://$this->center_ip",$this->center_port, $errno, $errstr);
		if (!$this->socket )
		{
			throw new Exception("fsockopen() failed: reason: $errstr ($errno)\n");
		}
		stream_set_timeout($this->socket,3);
		 
		$this->session->set_userdata(array('socket'=>$this->socket));
		 
	}
	public function PCloseServer()
	{
		$this->socket = stream_socket_client("tcp://$this->center_ip:$this->center_port",
				$errno, $errstr,30,STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT);
		fclose($this->socket);
	}
	/**
	 * 登陆服务器
	 * userName: string 用户名
	 * passWord: string 密码
	 * return: string 登陆信息
	 */
	public function login($userName,$passWord,$mac)
	{
		try {
			$this->PConnectServer();
			//生成32位加密数据(md5 加密）
			$secretData= md5($passWord);
			$data = "<?xml version='1.0' encoding='utf-8'?>".
			"<Login><Info U=\"$userName\" P=\"$secretData\" M=\"$mac\" /></Login>\n";
			$sendLen = strlen($data) + 10;
			$sendMsg = pack($this->requestMsgFromat['login'],"FF01",$sendLen,"0",$data);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['login'],$recvMsg);
			$this->session->set_userdata(array('clientID'=>$outArray['clientID']));
			$client_id = $this->session->userdata('clientID');
				
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			//var_dump($e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['respMsg'];
	}
	public function user_register($userName,$passWord,$email,$xcode="")
	{
		try {
			$this->PConnectServer();
			//生成16位加密数据(md5 加密）
			$secretData= md5($passWord);
			$data = "<?xml version='1.0' encoding='utf-8'?>".
					"<Reg><Info U=\"$userName\" P=\"$secretData\" E=\"$email\" X=\"$xcode\"/></Reg>\n";
			$client_id = $this->session->userdata('clientID');
			$sendLen = strlen($data) + 15;
			$sendMsg = pack($this->requestMsgFromat['register'],"FF00",$sendLen,$client_id,7,0,$data);
			
			$recvMsg =  $this->writeAndRead($sendMsg);
							
			$outArray = unpack($this->respondMsgFromat['register'],$recvMsg);
			$this->session->set_userdata(array('clientID'=>$outArray['clientID']));
				
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}		
		fclose($this->socket);
		return $outArray['respMsg'];
	}
	
	
	public function HeartBeat()
	{
		try {
			$this->PConnectServer();
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['heartbeat'],"FF02","10",$client_id);
			$recvMsg = $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['devList'],$recvMsg);
			
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return "0d";
	}
	public function ShrDeviceList()
	{
		try {
			$this->PConnectServer();
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['Head'],"FF18","10",$client_id);
			$recvMsg = $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['devList'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['data'];
	}
	public function OwnDeviceList()
	{
		try {
			$this->PConnectServer();
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['Head'],"FF03","10",$client_id);
			$recvMsg = $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['devList'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['data'];
	}
	public function RefindPwd($userName,$email)
	{
		try {
			$this->PConnectServer();
			$data = "<?xml version='1.0' encoding='utf-8'?>".
					"<Reg><Info U=\"$userName\" E=\"$email\"/></Reg>\n";
			$sendLen = strlen($data) + 11;
			$sendMsg = pack($this->requestMsgFromat['refindPwd'],"FF20",$sendLen,0,0,$data);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['refindPwd'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['respMsg'];
	}
	public function AddCamera($camID,$devName)
	{
		try {
			$this->PConnectServer();
			$data = "<?xml version='1.0' encoding='utf-8'?>".
					"<AddDevice><Info D=\"$camID\" N=\"$devName\"/></AddDevice>\n";
			$sendLen = strlen($data) + 11;
			$client_id = $this->session->userdata('clientID');
				
			$sendMsg = pack($this->requestMsgFromat['addCam'],"FF09",$sendLen,$client_id,6,$data);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['addCam'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['respMsg'];
	}
	public function Logout()
	{
		$this->PConnectServer();
		$client_id = $this->session->userdata('clientID');		
		$sendMsg = pack($this->requestMsgFromat['logout'],"FF14",10,$client_id);
		fwrite($this->socket, $sendMsg);
		
	}
	public function DelCamera($camID,$delType)
	{
		try {
			$this->PConnectServer();
			$sendLen = 15;
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['delCam'],"FF05",$sendLen,$client_id,$delType,$camID);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['delCam'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['respMsg'];
	}
	public function ShrCamera($camID,$userName)
	{
		try {
			$this->PConnectServer();
			$data = "<?xml version='1.0' encoding='utf-8'?>".
					"<AddDeviceShare><Info D=\"$camID\" U=\"$userName\"/></AddDeviceShare>\n";
			$sendLen = strlen($data) + 15;
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['shrCam'],"FF10",$sendLen,$client_id,8,0,$data);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['shrCam'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['respMsg'];
	}
	public function ChkShrUser($devID)
	{
		try {
			$this->PConnectServer();
			$sendLen = 14;
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['chkShrUser'],"FF15",$sendLen,$client_id,$devID);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['chkShrUser'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['data'];
	}
	public function CancelShare($devID,$shrUserID)
	{
		try {
			$this->PConnectServer();
			$sendLen = 19;
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['CancelShr'],"FF17",$sendLen,$client_id,16,$devID,$shrUserID);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['CancelShr'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['respMsg'];
	}
	public function QueryRecordFile($devID,$hexStartTime,$hexEndTime)
	{
		try {
			$this->PConnectServer();
			$dataLen = 15+14;
			$sendLen = 15+$dataLen;
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['QueryRecord'],"FF23",$sendLen,$client_id,$devID,1,
					"FF53",$dataLen,$devID,$client_id,1,$hexStartTime,$hexStartTime,1,1);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['CancelShr'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['respMsg'];
	}
	public function GetDevRecord($devID,$type)
	{
		try {
			$this->PConnectServer();
			$sendLen = 16;
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['GetDevRecord'],"FF25",$sendLen,$client_id,$devID,1,$type);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['GetDevRecord'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['status'];
	}

	public function SetDevRecord($devID,$type,$start)
	{
		try {
			$this->PConnectServer();
			$sendLen = 18;
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['SetDevRecord'],"FF24",$sendLen,$client_id,$devID,1,$type,0,$start);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['SetDevRecord'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['respMsg'];
	}
	public function ChangeUserPwd($newPwd)
	{
		try {
			$this->PConnectServer();
			$sendLen = 51;
			$secretData= md5($newPwd);
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['ChgUserPwd'],"FF11",$sendLen,$client_id,14,$secretData);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['ChgUserPwd'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['respMsg'];
	}
	public function ChangeDeviceName($devID,$devName)
	{
		try {
			$this->PConnectServer();
			$data = "<?xml version='1.0' encoding='utf-8'?>".
					"<ModifyDevice><Info D=\"$devID\" U=\"$devName\"/></ModifyDevice>\n";
			$sendLen = strlen($data) + 11;
			$client_id = $this->session->userdata('clientID');
			$sendMsg = pack($this->requestMsgFromat['ChgDevName'],"FF12",$sendLen,$client_id,15,$data);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['ChgDevName'],$recvMsg);
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			return "00";
		}
		fclose($this->socket);
		return $outArray['respMsg'];
	}
}