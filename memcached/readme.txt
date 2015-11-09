c:\memcached\memcached.exe -d install
* Replace c:\memcached\memcached.exe with the actual path of your installation.

Then, start or stop the memcached service with the following command:
c:\memcached\memcached.exe -d start
c:\memcached\memcached.exe -d stop

To change the configuration of memcached, run regedit.exe and navigate to the key "HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Services\memcached". Suppose you wish to increase the memory limit of memcached, edit the value of ImagePath to the following:
"c:\memcached\memcached.exe" -d runservice -m 512
* Besides '-m 512', you may also append other memcached parameters to the path. Run "c:\memcached\memcached.exe -h" to view the list of available parameters.

Meanwhile, to uninstall the memcached serivce, run the following command:
c:\memcached\memcached.exe -d uninstall