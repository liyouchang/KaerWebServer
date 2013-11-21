<?php

class Socket_model extends CI_Model {

	 public $center_ip ;
	 public $center_port;

	 protected $socket;
	 function __construct() {
	 	parent::__construct();
	 	//$this->center_ip = "218.56.11.182";
	 	//$this->center_ip = "192.168.0.8";
	 	$this->center_ip = $this->config->item('center_server_ip');
	 	$this->center_port=22616;
	 }
	 
	 protected $requestMsgFromat = array(
	 		 "setcretKey"=>"H4II",
	 		"login"=>"H4IIIa8a8a16",
	 		"heartbeat"=>"H4IIC"
	 		);
	 protected $respondMsgFromat = array(
	 		"setcretKey"=>"H4head/Ilen/IclientID/a8secretKey",
	 		"login"=>"H4head/Ilen/IclientID/IuserLevel/H2respMsg",
	 		"heartbeat"=>"H4head/Ilen/IclientID/H2respMsg"
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
	 
	 /**
	  * @function connect to server
	  * @throws Exception
	  */
	 public function connectServer()
	 {
	  	$this->socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	 	if ($this->socket === FALSE )
	 	{
	 		throw new Exception("socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
	 	}
	 	
	 	socket_set_nonblock($this->socket);
	 	@socket_connect($this->socket,$this->center_ip, $this->center_port);
	 	socket_set_block($this->socket);
	 	switch(socket_select($r = array($this->socket), $w = array($this->socket), $f = array($this->socket), 5))
	 	{
	 		case 2:
	 			throw new Exception("[-] Connection Refused\n");
	 			break;
	 		case 1:
	 			//echo "[+] Connected\n";
	 			break;
	 		case 0:
	 			throw new Exception("[-] Timeout\n");
	 			break;
	 	}
	 	 
	 	socket_set_option($this->socket,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>2, "usec"=>0 ) );
	 	socket_set_option($this->socket,SOL_SOCKET,SO_SNDTIMEO,array("sec"=>3, "usec"=>0 ) );
	 	//下面的方法在连接失败时会等待很久
	 	//$connection = socket_connect($this->socket, $this->center_ip, $this->center_port);    //连接服务器端socket
	 	//if($connection === FALSE)
	 	//{
	 	//	throw new Exception("socket_connect() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
	 	//}
	 	$this->session->set_userdata(array('socket'=>$this->socket));
	 	
	 	
	 }
	 public function PConnectServer()
	 {
	 	$this->socket = stream_socket_client("tcp://$this->center_ip:$this->center_port", 
	 			$errno, $errstr,30,STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT);
	 	//$this->socket = pfsockopen("tcp://$this->center_ip",$this->center_port, $errno, $errstr);
	 	if (!$this->socket )
	 	{
	 		throw new Exception("stream_socket_client() failed: reason: $errstr ($errno)\n");
	 	}
	 	stream_set_timeout($this->socket,3);
	 	
	 	$this->session->set_userdata(array('socket'=>$this->socket));
	 	
	 }
	 public function PCloseServer()
	 {
	 	$this->socket = stream_socket_client("tcp://$this->center_ip:$this->center_port",
	 			$errno, $errstr,30,STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT);
	 	//$this->socket = $this->session->userdata('socket');
	 	fclose($this->socket);
	 }
	 /**
	  * 登陆服务器
	  * userName: string 用户名
	  * passWord: string 密码
	  * return: string 登陆信息
	  */
	 public function login($userName,$passWord)
	 {	
		try {
			$this->PCloseServer();
			$this->PConnectServer();
			//$this->connectServer();
			$sendMsg = pack($this->requestMsgFromat['setcretKey'],"FFD0","10","0");				
			$recvMsg = $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['setcretKey'],$recvMsg);
			//获取 密钥
			$secretKey = $outArray['secretKey'];
			//生成16位加密数据(md5 加密）
			$usrkeypwd = pack("a8a8a8",$userName,$secretKey,$passWord);
			$secretData= md5($usrkeypwd,TRUE);
			
			
			$sendMsg = pack($this->requestMsgFromat['login'],"FF80","46","0","0",$userName,"",$secretData);
			$recvMsg =  $this->writeAndRead($sendMsg);
			$outArray = unpack($this->respondMsgFromat['login'],$recvMsg);
				
			$this->session->set_userdata(array('clientID'=>$outArray['clientID']));
			
			$client_id = $this->session->userdata('clientID');
			
			$sendMsg = pack($this->requestMsgFromat['heartbeat'],"FF82","11",$client_id,"0");
			$recvMsg = $this->writeAndRead($sendMsg);
			
		} catch (Exception $e) {
			log_message('error',$e->getMessage());
			//var_dump($e->getMessage());
			return "00";
		}	
	 //	var_dump($outArray);
	 	//socket_close($this->socket);
	 	//fclose($this->socket);
	 	
	 	return $outArray['respMsg']; 
	 }
	 public function HeartBeat()
	 {
	 	try {
	 		//$this->socket = $client_id = $this->session->userdata('socket');
	 		$this->PConnectServer();
	 			 		
	 		$client_id = $this->session->userdata('clientID');
	 			 		
	 		$sendMsg = pack($this->requestMsgFromat['heartbeat'],"FF82","11",$client_id,"0");
	 		$recvMsg = $this->writeAndRead($sendMsg);
	 		$outArray = unpack($this->respondMsgFromat['heartbeat'],$recvMsg);
	 		//获取 密钥
	 		$respMsg = $outArray['respMsg'];
	 		
	 	} catch (Exception $e) {
	 		log_message('error',$e->getMessage());
	 		//var_dump($e->getMessage());
	 		return "00";
	 	}
	 	//	var_dump($outArray);
	 	//socket_close($this->socket);
	 	 
	 	return $respMsg;
	 	
	 }
	
	 
}
