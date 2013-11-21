#!/usr/bin/env python
# -*- coding: cp936 -*-
"""this module is used to config the web sever config file and start httpd server
"""
import ApacheConfig
import subprocess

def chgHttpdConf(confFile,svrPath,svrPort,svrIp):
    "change httpd.conf file"
    ApacheConfig.ApacheConfig.with_comment = True
    root = ApacheConfig.ApacheConfig.parse_file(confFile)
    tmp = root.find("ServerRoot")
    tmp.values = [svrPath+"/KaerWebServer/Apache24"]

    tmp = root.findall("LoadModule")
    for el in tmp:
        if(el.values[0] == "php5_module"):
            el.values[1] = svrPath+"/KaerWebServer/PHP54/php5apache2_4.dll"
            break
    tmp = root.find("PHPIniDir")
    tmp.values[0] = svrPath +"/KaerWebServer/PHP54"

    tmp = root.find("DocumentRoot")
    tmp.values = [svrPath+"/KaerWebServer/KaerCamWebClient"]

    tmp = root.findall("Directory")
    tmp[1].values[0] = svrPath + "/KaerWebServer/KaerCamWebClient"
    tmp[2].values[0] =  svrPath + "/KaerWebServer/Apache24/cgi-bin"

    tmp = root.find("IfModule/ScriptAlias")
    tmp.values[1] = svrPath + "/KaerWebServer/Apache24/cgi-bin"

    tmp = root.find("Listen")
    tmp.values[0] = svrPort

    tmp = root.find("ServerName")
    tmp.values[0] = svrIp + ":" + svrPort
    root.save_file(confFile)

def chgCodeigniterConf(confFile,svrIp):
    "�޸�codeigniter config �ļ�"
    root = ApacheConfig.CodeigniterConfig.parse_file(confFile)
    tmp = root.find("$config['center_server_ip']")
    tmp.values[0] = "'" + svrIp + "'"
    root.save_file(confFile)


def httpdCmd(svrPath,param):
    command = svrPath+'/KaerWebServer/Apache24/bin/httpd -k '+ param
    try:
        p = subprocess.check_output(command,stderr=subprocess.STDOUT,shell=True)
        print p
    except subprocess.CalledProcessError,x:
        print x.output
        return x.returncode
    return 0

def main():
    svrPath = raw_input("������KaerWebServer���õ�λ��:")
    svrPath = svrPath.strip("/")
    svrPort = raw_input("������Web�����˿ں�:")
    svrIp = raw_input("�����������ip��")
    httpdConf = svrPath + "/KaerWebServer/Apache24/conf/httpd.conf"
    phpConf = svrPath +"/KaerWebServer/KaerCamWebClient/application/config/myconfig.php"
    try:
        print "�޸�"+httpdConf+"�ļ�"
        chgHttpdConf(httpdConf,svrPath,svrPort,svrIp)
        print "�޸�"+phpConf+"�ļ�"
        chgCodeigniterConf(phpConf,svrIp)
        
        print "��װhttpd����"
        httpdCmd(svrPath,'install')
        print "����httpd����"
        httpdCmd(svrPath,'restart')
    except Exception ,e:
        print e
        
if __name__=='__main__':
   main()
   raw_input("���س��ر�")

    
    

