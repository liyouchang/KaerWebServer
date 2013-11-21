# -*- coding: cp936 -*-
import subprocess
import shutil

pwd = subprocess.check_output("cd",stderr=subprocess.STDOUT,shell=True)
pwd = pwd.strip('\r\n')
pyFile = pwd + '\SvrConfig.py'
exeFile = "D:\pyinstaller-2.0\SvrConfig\dist\SvrConfig.exe"
command = 'd: & cd d:\pyinstaller-2.0 & python pyinstaller.py -F '+pyFile
try:
    print("pyintalling ......\n")
    p = subprocess.check_output(command,stderr=subprocess.STDOUT,shell=True)
    print p
    svrDir = subprocess.check_output("cd .. & cd",stderr=subprocess.STDOUT,shell=True)
    svrDir = svrDir.strip('\r\n')
    print "copy file "+exeFile+" to "+svrDir
    shutil.copy(exeFile,svrDir)
except subprocess.CalledProcessError,e:
    print e.output
    print e.returncode
except Exception,e:
    print e
    
raw_input("按回车关闭")
