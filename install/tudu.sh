#!/bin/bash
PATH=/bin:/sbin:/usr/local/bin:/usr/local/sbin:/usr/bin:/usr/sbin:~/bin
export PATH

tmp_dir="/tmp/tudu_install"
ver=`uname -m`
user_name="tuduweb"
install_dir=
file_dir=`dirname`

autoconf_dl="http://mirrors.ustc.edu.cn/gnu/autoconf/autoconf-2.64.tar.gz"
automake_dl="http://mirrors.ustc.edu.cn/gnu/automake/automake-1.12.tar.gz"
libtool_dl="http://mirror.bjtu.edu.cn/gnu/libtool/libtool-2.4.2.tar.gz"
pcre_dl="ftp://ftp.csx.cam.ac.uk/pub/software/programming/pcre/pcre-8.21.tar.gz"
nginx_dl="http://nginx.org/download/nginx-0.8.55.tar.gz"
php_dl="http://www.php.net/get/php-5.3.20.tar.gz/from/cn2.php.net/mirror"
php_memcache_dl="http://pecl.php.net/get/memcache-2.2.6.tgz"
php_eaccelerator_dl="https://github.com/eaccelerator/eaccelerator/tarball/master"
freetds_dl="http://ibiblio.org/pub/Linux/ALPHA/freetds/stable/freetds-stable.tgz"
httpsqs_dl="http://httpsqs.googlecode.com/files/httpsqs-1.7.tar.gz"
libevent_dl="https://github.com/downloads/libevent/libevent/libevent-2.0.21-stable.tar.gz"
tokyocabinet_dl="http://fallabs.com/tokyocabinet/tokyocabinet-1.4.41.tar.gz"
tokyotyrant_dl="http://fallabs.com/tokyotyrant/tokyotyrant-1.1.39.tar.gz"
sphinx_dl="http://mirrors.orayer.com:8080/database/sphinx/coreseek-3.2.14.tar.gz"
tudu_dl="https://github.com/OrayDev/tudu-web/archive/master.zip"

# Check if user is root
if [ $(id -u) != "0" ]; then
    echo "Error: You must be root to run this script, please use root to install Tudu"
    exit 1
fi

clear
echo "========================================================================="
echo "Tudu V0.1 for CentOS/RedHat Linux by Oray"
echo "========================================================================="
echo "A tool for auto-compiling & installing Nginx+MySQL+PHP+Tudu on Linux "
echo ""
echo "For more information please visit http://www.oray.com/"
echo "========================================================================="

#set main domain name

domain="tudu.com"
echo "Please input your domain:"
read -p "(Default domain: tudu.com):" domain
if [ "$domain" = "" ]; then
	domain="tudu.com"
fi
	
#set mysql root password
echo "==========================="
while [ 1 ]
do
	mysql_root_pwd=
	echo "Please input the root password of mysql:"
	read -p "( Default password: root ):" mysql_root_pwd
	if [ "$mysql_root_pwd" = "" ]; then
		mysql_root_pwd="root"
	
	fi
	mrpconfirm=
	echo "mysql root password is $mysql_root_pwd"
	read -p "(Confirm please input: y ,if not please press the enter button):" mrpconfirm
	case "$mrpconfirm" in
	y|Y|Yes|YES|yes|yES|yEs|YeS|yeS)
	break
	mrpconfirm=""
	;;
	n|N|No|NO|no|nO)
	continue
	;;
	*)
	continue
	esac
done

#add web user & tmp floder
if [ ! -d $tmp_dir ]; then
	mkdir -p $tmp_dir
fi
cd $tmp_dir || exit 1

user_exit=`id -u $user_name`
if [ -z "$user_exit" ]; then
	/usr/sbin/groupadd $user_name
	/usr/sbin/useradd -g $user_name -s /sbin/nologin $user_name
fi

while [ 1 ]
do
	echo "Please input a path for web server installtion:"
	read -p "( Default installtion path:/usr/local ):" install_dir
	if [ "$install_dir" = "" ]; then
		install_dir="/usr/local"
	fi

	echo "Please input a path for web file location:"
	read -p "( Default file path:/web ):" file_dir
	if [ "$file_dir" = "" ]; then
		file_dir="/web"
	fi
	
	sysconfirm=
	echo "Web user is $user_name"
	echo "Installtion path is $install_dir"
	echo "Web file path is $install_dir"
	read -p "(Confirm please input: y ,if not please press the enter button):" sysconfirm
	
	case "$sysconfirm" in
	y|Y|Yes|YES|yes|yES|yEs|YeS|yeS)
	mkdir -p $install_dir
	mkdir -p $file_dir
	break
		;;
	n|N|No|NO|no|nO)
	continue
	;;
	*)
	continue
	esac
done	
	
#set timezone
timezone=
echo "Do you want to change local timezone to Shanghai/China?"
read -p "(Default no,if you want please input: y ,if not please press the enter button):" timezone

	case "$timezone" in
	y|Y|Yes|YES|yes|yES|yEs|YeS|yeS)
	echo "Local timezone has changed to Shanghai/China."
	timezone="y"
	;;
	n|N|No|NO|no|nO)
	echo "Local timezone not changed!"
	timezone="n"
	;;
	*)
	echo "Local timezone not changed!"
	timezone="n"
	esac

if [[ $time == y ]]; then
	rm -rf /etc/localtime
	ln -s /usr/share/zoneinfo/Asia/Shanghai /etc/localtime

	yum install -y ntp
	ntpdate -u pool.ntp.org
	date
fi

echo "====================="
echo "Install list:"
echo "====================="
echo "mysql"
echo "freetds"
echo "nginx"
echo "php"
echo "php_memcache"
echo "php_eaccelerator"
echo "ttserver"
echo "httpsqs"
echo "sphinx"
echo "====================="

read -n 1 -p "Press any key to start installtion..."

#init system
echo "Install system component..."
sleep 5
yum update -y
yum install gcc g++ gcc-* gcc-c++* autoconf automake libtool imake libicu-devel libxml2-devel expat-devel libmcrypt-devel curl-devel libjpeg-devel libpng-devel freetype-devel bzip2-devel -y

wget -N "$tudu_dl"
unzip -o master ||exit 1
mv tudu-web-master/* $file_dir

wget -N "$autoconf_dl"
echo "$autoconf_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi
./configure || exit 1
make || exit 1
make install || exit 1
cd ../

wget -N "$automake_dl"
echo "$automake_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi
./configure || exit 1
make || exit 1
make install || exit 1
cd ../

wget -N "$libtool_dl"
echo "$libtool_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi
./configure || exit 1
make || exit 1
make install || exit 1
if [ ! `grep '/usr/local/lib' /etc/ld.so.conf` ];then
	echo "/usr/local/lib" >>/etc/ld.so.conf
fi
/sbin/ldconfig
cd ../

#install mysql
echo "Installing mysql..."
sleep 5
if [ `rpm -qa|grep mysql-server` ];then
	/etc/init.d/mysqld stop
	yum erase mysql-server -y
	rm -rf /var/lib/mysql
fi
yum install mysql mysql-server mysql-devel -y
service mysqld start

#init database
echo "Initializing database..."
sleep 5
mysqladmin -u root password "$mysql_root_pwd"
mysql -uroot -p$mysql_root_pwd <<EOF
create database \`tudu-db\`  character set utf8;
create user tudu identified by 'tudu.com';
grant all on \`tudu-db\`.* to tudu identified by 'tudu.com';
flush privileges;
use tudu-db;
source $file_dir/install/sql/1.sql;
source $file_dir/install/sql/2.sql;
source $file_dir/install/sql/3.sql;
source $file_dir/install/sql/4.sql;
source $file_dir/install/sql/5.sql;
source $file_dir/install/sql/6.sql;
EOF

#install freetds
echo "Installing freetds..."
sleep 5
wget -N "$freetds_dl"
echo "$freetds_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi
./configure --prefix=$install_dir/freetds --with-tdsver=8.0 --enable-msdblib --with-gnu-ld --enable-shared --enable-static || exit 1
make || exit 1
make install || exit 1
cd ../
touch $install_dir/freetds/include/tds.h
touch $install_dir/freetds/lib/libtds.a
if [ ! `grep "$install_dir/freetds/lib" /etc/ld.so.conf` ];then
	echo "$install_dir/freetds/lib" >>/etc/ld.so.conf
fi
/sbin/ldconfig

cat > $install_dir/freetds/etc/freetds.conf  <<EOF
[global]
        client charset = UTF-8
        tds version = 8.0
	
;       dump file = /tmp/freetds.log
;       debug flags = 0xffff

	port = 1433
        text size = 64512

[egServer50]
        host = symachine.domain.com
        port = 5000
        tds version = 5.0

[egServer70]
        host = ntmachine.domain.com
        port = 1433
        tds version = 7.0
EOF

#install nginx
echo "Install pcre...."
sleep 5
wget -N "$pcre_dl"
echo "$pcre_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi
./configure ||exit 1
make ||exit 1 
make install ||exit 1
cd ../

echo "Install nginx...."
sleep 5
wget -N "$nginx_dl"
echo "$nginx_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi
./configure --user=$user_name --group=$user_name --prefix=$install_dir/nginx --with-http_stub_status_module --with-http_ssl_module ||exit 1 
make ||exit 1 
make install ||exit 1
cd ../
if [ ! `grep "$install_dir/nginx/sbin/nginx" /etc/rc.local` ];then
	echo "$install_dir/nginx/sbin/nginx" >>/etc/rc.local 
fi

cp $file_dir/install/nginx/nginx.conf $install_dir/nginx/conf/

cat > $install_dir/nginx/conf/nginx-tudu.conf<<EOF
server {
	listen		8080;
	server_name	$domain;
	index			index.php;
	root			$file_dir/htdocs/www.tudu.com/public/ ;

	location /
	{
		index index.php;

		if (!-f \$request_filename) {
			rewrite ^/(.+)$ /index.php?\$1& last;
		}
	}

	location ~*^.+\.(js|ico|gif|jpg|jpeg|png|pdf|css)$
	{
		access_log off;
		expires 7d;
	}

	location ~.*\.(php)?$
	{
		fastcgi_pass 127.0.0.1:9000;
		fastcgi_index index.php;
		include fastcgi.conf;
	}
}

server {
	listen		80;
	server_name $domain;
	index			index.php;
	root			$file_dir/htdocs/www.tudu.com/public/ ;
	location /
	{
		index index.php;

		if (!-f \$request_filename) {
			rewrite ^/(.+)$ /index.php?\$1& last;
		}
	}

	location ~*^.+\.(js|ico|gif|jpg|jpeg|png|pdf|css)$
	{
		access_log off;
		expires 7d;
	}
    
	location ~.*\.(php)?$
	{
		fastcgi_pass 127.0.0.1:9000;
		fastcgi_index index.php;
		include fastcgi.conf;
	}

	location ^~ /admin/{
		proxy_pass http://$domain:8080/;
		proxy_set_header X-Real_IP \$remote_addr;
	}
}
EOF


#install php
echo "Install php...."
sleep 5
wget -N "$php_dl"
tar zxvf php-5.3.20.tar.gz||exit 1
cd $tmp_dir/php-5.3.20
if [ "$ver" = "x86_64" ]; then
	LDFLAGS="-L/usr/lib64/mysql" ./configure --prefix=$install_dir/php --with-mysql --with-gd --with-jpeg-dir --with-freetype-dir --with-zlib --with-config-file-path=$install_dir/php/etc --with-png-dir --with-libxml-dir --enable-short-tags --enable-mbstring --disable-debug --with-mssql=$install_dir/freetds --with-mcrypt --with-openssl --with-mhash --enable-sockets --with-curl --with-curlwrappers --enable-mbregex --enable-force-cgi-redirect --enable-xml --disable-rpath --enable-discard-path --enable-safe-mode --enable-bcmath --enable-shmop --enable-sysvsem --enable-soap --enable-pdo --with-pdo-mysql --with-pdo-dblib=$install_dir/freetds --enable-fpm 
else
	./configure --prefix=$install_dir/php --with-mysql --with-gd --with-jpeg-dir --with-freetype-dir --with-zlib --with-config-file-path=$install_dir/php/etc --with-png-dir --with-libxml-dir --enable-short-tags --enable-mbstring --disable-debug --with-mssql=$install_dir/freetds --with-mcrypt --with-openssl --with-mhash --enable-sockets --with-curl --with-curlwrappers --enable-mbregex --enable-force-cgi-redirect --enable-xml --disable-rpath --enable-discard-path --enable-safe-mode --enable-bcmath --enable-shmop --enable-sysvsem --enable-soap --enable-pdo --with-pdo-mysql --with-pdo-dblib=$install_dir/freetds --enable-fpm
fi
make || exit 1
make install ||exit 1
/bin/cp sapi/fpm/init.d.php-fpm /etc/rc.d/init.d/php-fpm
chmod 755 /etc/rc.d/init.d/php-fpm
chkconfig --add php-fpm
chkconfig --level 345 php-fpm on
cd ../
mkdir -p $install_dir/php/logs/

cat > $install_dir/php/etc/php-fpm.conf <<EOF
[global]
pid = run/php-fpm.pid
error_log = $install_dir/php/logs/php-fpm.log
log_level = notice
rlimit_files = 65535
rlimit_core = 0
[www]
user = tuduweb
group = tuduweb
listen = 127.0.0.1:9000
pm = static
pm.max_children = 128
pm.start_servers =20
pm.min_spare_servers = 5
pm.max_spare_servers = 35
;pm.process_idle_timeout = 120s;
pm.max_requests = 102400
;access.log = $install_dir/php/logs/$pool.access.log
;access.format = %R - %u %t "%m %r%Q%q"  [%s]  %f %{mili}d %{kilo}M %C%%
slowlog = $install_dir/php/logs/$pool.log.slow
request_slowlog_timeout = 0
request_terminate_timeout = 0
env[ORACLE_HOME] = \$ORACLE_HOME
env[NLS_LANG] = \$NLS_LANG
EOF

cat > $install_dir/php/etc/php.ini <<EOF
[PHP]
engine = On
zend.ze1_compatibility_mode = Off
short_open_tag = Off
asp_tags = Off
precision    =  14
y2k_compliance = On
output_buffering = 4096
zlib.output_compression = Off
implicit_flush = Off
unserialize_callback_func=
serialize_precision = 100
allow_call_time_pass_reference = Off
safe_mode = Off
safe_mode_gid = Off
safe_mode_include_dir =
safe_mode_exec_dir =
safe_mode_allowed_env_vars = PHP_
safe_mode_protected_env_vars = LD_LIBRARY_PATH
disable_functions =
disable_classes =
expose_php = Off
max_execution_time = 180     ; Maximum execution time of each script, in seconds
max_input_time = 60     ; Maximum amount of time each script may spend parsing request data
memory_limit = 256M      ; Maximum amount of memory a script may consume (128MB)
error_reporting = E_ALL & ~E_NOTICE
display_errors = On
display_startup_errors = Off
log_errors = On
log_errors_max_len = 1024
ignore_repeated_errors = Off
ignore_repeated_source = Off
report_memleaks = On
track_errors = Off
error_log=/www/logs/error.log 
variables_order = "GPCS"
register_globals = Off
register_argc_argv = Off
auto_globals_jit = On
post_max_size = 8M
magic_quotes_gpc = Off
magic_quotes_runtime = Off
magic_quotes_sybase = Off
auto_prepend_file =
auto_append_file =
include_path = "/www/library:."
doc_root =
user_dir =
enable_dl = On
cgi.fix_pathinfo=0
file_uploads = On
upload_max_filesize = 2M
allow_url_fopen = On
allow_url_include = Off
default_socket_timeout = 60
[Date]
date.timezone = Asia/Shanghai
[Syslog]
define_syslog_variables  = Off
[mail function]
SMTP = localhost
smtp_port = 25
[SQL]
sql.safe_mode = Off
[ODBC]
odbc.allow_persistent = On
odbc.check_persistent = On
odbc.max_persistent = -1
odbc.max_links = -1
odbc.defaultlrl = 4096
odbc.defaultbinmode = 1
[MySQL]
mysql.allow_persistent = On
mysql.max_persistent = -1
mysql.max_links = -1
mysql.default_port =
mysql.default_socket =
mysql.default_host =
mysql.default_user =
mysql.default_password =
mysql.connect_timeout = 60
mysql.trace_mode = Off
[MySQLi]
mysqli.max_links = -1
mysqli.default_port = 3306
mysqli.default_socket =
mysqli.default_host =
mysqli.default_user =
mysqli.default_pw =
mysqli.reconnect = Off
[mSQL]
msql.allow_persistent = On
msql.max_persistent = -1
msql.max_links = -1
[OCI8]
[PostgresSQL]
pgsql.allow_persistent = On
pgsql.auto_reset_persistent = Off
pgsql.max_persistent = -1
pgsql.max_links = -1
pgsql.ignore_notice = 0
pgsql.log_notice = 0
[Sybase]
sybase.allow_persistent = On
sybase.max_persistent = -1
sybase.max_links = -1
sybase.min_error_severity = 10
sybase.min_message_severity = 10
sybase.compatability_mode = Off
[Sybase-CT]
sybct.allow_persistent = On
sybct.max_persistent = -1
sybct.max_links = -1
sybct.min_server_severity = 10
sybct.min_client_severity = 10
[bcmath]
bcmath.scale = 0
[Informix]
ifx.default_host =
ifx.default_user =
ifx.default_password =
ifx.allow_persistent = On
ifx.max_persistent = -1
ifx.max_links = -1
ifx.textasvarchar = 0
ifx.byteasvarchar = 0
ifx.charasvarchar = 0
ifx.blobinfile = 0
ifx.nullformat = 0
[Session]
session.use_cookies = 1
session.name = PHPSESSID
session.auto_start = 0
session.cookie_lifetime = 0
session.cookie_path = /
session.cookie_domain =
session.cookie_httponly = 
session.serialize_handler = php
session.gc_probability = 1
session.gc_divisor     = 1000
session.gc_maxlifetime = 1440
session.bug_compat_42 = 0
session.bug_compat_warn = 1
session.referer_check =
session.entropy_length = 0
session.entropy_file =
session.cache_limiter = nocache
session.cache_expire = 180
session.use_trans_sid = 0
session.hash_function = 0
session.hash_bits_per_character = 5
url_rewriter.tags = "a=href,area=href,frame=src,input=src,form=fakeentry"
[MSSQL]
mssql.allow_persistent = On
mssql.max_persistent = -1
mssql.max_links = -1
mssql.min_error_severity = 10
mssql.min_message_severity = 10
mssql.compatability_mode = Off
mssql.connect_timeout = 20
mssql.datetimeconvert = Off
mssql.secure_connection = Off
mssql.charset = "GBK"
[Tidy]
tidy.clean_output = Off
[soap]
soap.wsdl_cache_enabled=1
soap.wsdl_cache_dir="/tmp"
soap.wsdl_cache_ttl=86400
extension_dir = "$install_dir/php/lib/php/extensions/no-debug-non-zts-20090626"
extension=memcache.so
memcache.default_timeout_ms=5000
[eaccelerator]
zend_extension="$install_dir/php/lib/php/extensions/no-debug-non-zts-20090626/eaccelerator.so"
eaccelerator.shm_size="64"
eaccelerator.cache_dir="$install_dir/eaccelerator_cache"
eaccelerator.enable="1"
eaccelerator.optimizer="1"
eaccelerator.check_mtime="1"
eaccelerator.debug="0"
eaccelerator.filter=""
eaccelerator.shm_max="0"
eaccelerator.shm_ttl="3600"
eaccelerator.shm_prune_period="3600"
eaccelerator.shm_only="0"
eaccelerator.compress="1"
eaccelerator.compress_level="9"
EOF

wget -N "$php_memcache_dl"
echo "$php_memcache_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
		cd $tmp_dir/$path
fi
$install_dir/php/bin/phpize
chmod 755 configure 
./configure --with-php-config=$install_dir/php/bin/php-config || exit 1
make  || exit 1
make install  || exit 1
cd ../

wget -N "$php_eaccelerator_dl"
tar zxvf master >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi
$install_dir/php/bin/phpize
chmod 755 configure 
./configure --enable-eaccelerator=shared --with-php-config=$install_dir/php/bin/php-config || exit 1
make || exit 1
make install || exit 1
cd ../
mkdir -p $install_dir/eaccelerator_cache


if [ ! `grep '/etc/init.d/php-fpm start' /etc/rc.local` ];then
echo "/etc/init.d/php-fpm start" >>/etc/rc.local 
fi

/etc/init.d/php-fpm start

#install ttserver
echo "Install Ttserver...."
sleep 5
wget -N "$libevent_dl"
echo "$libevent_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi
./configure --prefix=$install_dir/libevent ||exit 1
make ||exit 1 
make install ||exit 1 
cd ..
if [ ! `grep "$install_dir/libevent/lib" /etc/ld.so.conf` ];then
	echo "$install_dir/libevent/lib" >>/etc/ld.so.conf
fi
/sbin/ldconfig

wget -N "$tokyocabinet_dl"
echo "$tokyocabinet_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi

if [ "$ver" = "x86_64" ]; then
	./configure --prefix=$install_dir/tokyocabinet || exit 1
else
	./configure --enable-off64 --prefix=$install_dir/tokyocabinet || exit 1
fi
make || exit 1
make install || exit 1
cd ../
if [ ! `grep "$install_dir/tokyocabinet/lib" /etc/ld.so.conf` ];then
	echo "$install_dir/tokyocabinet/lib" >>/etc/ld.so.conf
fi
/sbin/ldconfig
		
wget -N "$tokyotyrant_dl"
echo "$tokyotyrant_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi
./configure --with-tc=$install_dir/tokyocabinet/ || exit 1
make || exit 1
make install || exit 1
cd ../
mkdir -p /ttserver

if [ ! `grep 'rm -rf /ttserver/ttserver.pid' /etc/rc.local` ];then
	echo "rm -rf /ttserver/ttserver.pid" >>/etc/rc.local
	echo "/usr/local/bin/ttserver -host 0.0.0.0 -port 11211  -thnum 4 -dmn -pid /ttserver/ttserver.pid -log /ttserver/ttserver.log -le -ulog /ttserver/ -ulim 128m -sid 1 -rts /ttserver/ttserver.rts /ttserver/database.tcb" >>/etc/rc.local
fi

#install httpsqs
echo "Install Httpsqs...."
sleep 5
wget -N "$httpsqs_dl"
echo "$httpsqs_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi
sed -i 's/libevent-2.0.12-stable/libevent/g' Makefile
sed -i 's/tokyocabinet-1.4.47/tokyocabinet/g' Makefile
make||exit 1
make install || exit 1
cd ../
if [ ! `grep 'httpsqs -p 12181 -x /tmp/httpsqs -d' /etc/rc.local` ]; then
	echo "httpsqs -p 12181 -x /tmp/httpsqs -d" >>/etc/rc.local 
fi 

#install sphinx
echo "Install sphinx...."
sleep 5
wget -N "$sphinx_dl"
echo "$sphinx_dl" |sed 's#^.*/##g'|awk '{printf "tar zxvf %s\n",$1}'|bash >$tmp_dir/code.log||exit 1
if [ ! -s "$tmp_dir/code.log" ]; then
	echo "error $tmp_dir/code.log"
	exit 1
else
	path=`cat $tmp_dir/code.log|awk -F/ '/\//{print $1}'|sort -u`
	if [ ! -d "$tmp_dir/$path" ]; then
		echo "$tmp_dir/$path is not dir"
		exit 1
	fi
	cd $tmp_dir/$path
fi
cd mmseg-3.2.14
./bootstrap
./configure --prefix=$install_dir/mmseg3
make ||exit 1
make install ||exit 1
cd ..
cd csft-3.2.14
sh buildconf.sh
./configure --prefix=$install_dir/coreseek  --without-unixodbc --with-mmseg --with-mmseg-includes=$install_dir/mmseg3/include/mmseg/ --with-mmseg-libs=$install_dir/mmseg3/lib/ --with-mysql
make ||exit 1
make install ||exit 1
cd ..
cd $install_dir/mmseg3/etc/
wget http://www.wapm.cn/uploads/csft/3.2/dict/default/thesaurus.lib
cd -
mkdir -p $install_dir/coreseek/index
mkdir -p $install_dir/coreseek/shell

cat > $install_dir/coreseek/etc/tudu.conf <<EOF
#############################################################################
## data source definition
#############################################################################
 
source chat_main
{
	# mysql
	type = mysql
 
	# database server
	sql_host = 127.0.0.1
	sql_user = $mysql_user
	sql_pass = $mysql_user_pwd
	sql_db   = oray-tudu-ts
	sql_port = 3306
 
	# can connect by unix socket file
	# sql_sock = /tmp/mysql.sock
 
	mysql_connect_flags = 32
 
	# for mysql utf8 encoding
	sql_query_pre = SET NAMES utf8
	sql_query_pre = REPLACE INTO sph_index_label SELECT 'chat',MAX(order_num) FROM im_chat_log
 
	sql_query_range = SELECT 1, max_id FROM sph_index_label WHERE \`index_id\` = 'chat'
	# source query
	sql_query = SELECT DISTINCT(l.order_num), UNIX_TIMESTAMP(l.create_time) AS create_time, CONCAT(u.owner_id, '+', u.other_id) AS users, REPLACE(g.group_id, '-', '') AS groupid, l.content \\
					FROM im_chat_log l \\
					LEFT JOIN im_chat_user u ON l.chat_log_id = u.chat_log_id \\
					LEFT JOIN im_chat_group g ON l.chat_log_id = g.chat_log_id \\
					WHERE l.order_num >= $start AND l.order_num < \$end \\
						AND order_num <= (select max_id from sph_index_label where index_id = 'chat') \\
					GROUP BY l.order_num
 
	#attributes
	sql_attr_timestamp   = create_time
 

	sql_range_step  = 10000
	sql_ranged_throttle = 0
}
 
source chat_inc : chat_main
{
	# mysql
	type = mysql
 
	# database server
	sql_host = 127.0.0.1
	sql_user = $mysql_user
	sql_pass = $mysql_user_pwd
	sql_db   = oray-tudu-ts
	sql_port = 3306
 
	# can connect by unix socket file
	#sql_sock = /tmp/mysql.sock
 
	mysql_connect_flags = 32
 
	# for mysql utf8 encoding
	sql_query_pre = SET NAMES utf8
 
	sql_query_range = SELECT 1,1
	sql_range_step = 0
	# source query
	sql_query = SELECT DISTINCT(l.order_num), UNIX_TIMESTAMP(l.create_time) AS create_time, CONCAT(u.owner_id, '+', u.other_id) AS users, REPLACE(g.group_id, '-', '') AS groupid, l.content \\
					FROM im_chat_log l \\
					LEFT JOIN im_chat_user u ON l.chat_log_id = u.chat_log_id \\
					LEFT JOIN im_chat_group g ON l.chat_log_id = g.chat_log_id \\
					WHERE l.order_num > (SELECT max_id FROM sph_index_label WHERE \`index_id\` = 'chat') \\
					AND $start = 1 AND $end = 1 \\
					GROUP BY l.order_num
 
	#attributes
	sql_attr_timestamp   = create_time
 
}
 
 
#############################################################################
## index definition
#############################################################################
 
# local index example
#
# this is an index which is stored locally in the filesystem
#
# all indexing-time options (such as morphology and charsets)
# are configured per local index
index chat_main
{
	# srouce
	source = chat_main
 
	path = $install_dir/coreseek/index/chat_main
 
	# index file save pattern
	docinfo = extern
 
	mlock = 0
 
	min_word_len = 1;
 
	# strip html tags
	html_strip = 1
 
	# for chinese utf8
	charset_type = zh_cn.utf-8
 
	# chinese dict
	charset_dictpath = $install_dir/mmseg3/etc/
 
	ngram_len = 1
}
 
index chat_inc : chat_main
{
	# srouce
	source = chat_inc
 
	path = $install_dir/coreseek/index/chat_inc
 
	# index file save pattern
	docinfo = extern
 
	mlock = 0
 
	min_word_len = 1;
 
	# strip html tags
	html_strip = 1
 
	# for chinese utf8
	charset_type = zh_cn.utf-8
 
	# chinese dict
	charset_dictpath = $install_dir/mmseg3/etc/
 
	ngram_len = 1
}
 
## indexer settings
#############################################################################
 
indexer
{
	# memory limit, in bytes, kiloytes (16384K) or megabytes (256M)
	# optional, default is 32M, max is 2047M, recommended is 256M to 1024M
	mem_limit			= 512M
 
	# maximum IO calls per second (for I/O throttling)
	# optional, default is 0 (unlimited)
	#
	max_iops			= 0
 
 
	# maximum IO call size, bytes (for I/O throttling)
	# optional, default is 0 (unlimited)
	#
	max_iosize		= 0
 
 
	# maximum xmlpipe2 field length, bytes
	# optional, default is 2M
	#
	# max_xmlpipe2_field	= 4M
 
 
	# write buffer size, bytes
	# several (currently up to 4) buffers will be allocated
	# write buffers are allocated in addition to mem_limit
	# optional, default is 1M
	#
	# write_buffer		= 1M
}
 
#############################################################################
## searchd settings
#############################################################################
 
searchd
{
	# hostname, port, or hostname:port, or /unix/socket/path to listen on
	# multi-value, multiple listen points are allowed
	# optional, default is 0.0.0.0:9312 (listen on all interfaces, port 9312)
	#
	# listen				= 127.0.0.1
	# listen				= 192.168.0.1:9312
	# listen				= 9312
	# listen				= /var/run/searchd.sock
 
 
	# log file, searchd run info is logged here
	# optional, default is 'searchd.log'
	log					= $install_dir/coreseek/var/log/searchd.log
 
	# query log file, all search queries are logged here
	# optional, default is empty (do not log queries)
	query_log				= $install_dir/coreseek/var/log/query.log
 
	# client read timeout, seconds
	# optional, default is 5
	read_timeout		= 5
 
	# request timeout, seconds
	# optional, default is 5 minutes
	client_timeout		= 300
 
	# maximum amount of children to fork (concurrent searches to run)
	# optional, default is 0 (unlimited)
	max_children		= 0
 
	# PID file, searchd process ID file name
	# mandatory
	pid_file			= $install_dir/coreseek/var/log/searchd.pid
 
	# max amount of matches the daemon ever keeps in RAM, per-index
	# WARNING, THERE'S ALSO PER-QUERY LIMIT, SEE SetLimits() API CALL
	# default is 1000 (just like Google)
	max_matches			= 1000
 
	# seamless rotate, prevents rotate stalls if precaching huge datasets
	# optional, default is 1
	seamless_rotate		= 1
 
	# whether to forcibly preopen all indexes on startup
	# optional, default is 0 (do not preopen)
	preopen_indexes		= 1
 
	# whether to unlink .old index copies on succesful rotation.
	# optional, default is 1 (do unlink)
	unlink_old			= 1
 
	# attribute updates periodic flush timeout, seconds
	# updates will be automatically dumped to disk this frequently
	# optional, default is 0 (disable periodic flush)
	#
	# attr_flush_period	= 900
 
 
	# instance-wide ondisk_dict defaults (per-index value take precedence)
	# optional, default is 0 (precache all dictionaries in RAM)
	#
	# ondisk_dict_default	= 1
 
 
	# MVA updates pool size
	# shared between all instances of searchd, disables attr flushes!
	# optional, default size is 1M
	mva_updates_pool	= 1M
 
	# max allowed network packet size
	# limits both query packets from clients, and responses from agents
	# optional, default size is 8M
	max_packet_size		= 8M
 
	# crash log path
	# searchd will (try to) log crashed query to 'crash_log_path.PID' file
	# optional, default is empty (do not create crash logs)
	#
	crash_log_path		= $install_dir/coreseek/var/log/crash.log
 
 
	# max allowed per-query filter count
	# optional, default is 256
	max_filters			= 256
 
	# max allowed per-filter values count
	# optional, default is 4096
	max_filter_values	= 4096
 
 
	# socket listen queue length
	# optional, default is 5
	#
	# listen_backlog		= 5
 
 
	# per-keyword read buffer size
	# optional, default is 256K
	#
	# read_buffer			= 256K
 
 
	# unhinted read size (currently used when reading hits)
	# optional, default is 32K
	#
	# read_unhinted		= 32K
}
EOF

cat > $install_dir/coreseek/shell/index_rebuild.sh <<EOF
#!/bin/bash
 
source ~/.bash_profile
 
while [ 1 ]
do
	[ `ps -ef | grep indexer | grep -v 'grep' -c` -ne 0 ]  && {
		echo 'Some other indexer is running....'
		sleep 5
		continue
	}
        echo `date`
        $install_dir/coreseek/bin/indexer -c $install_dir/coreseek/etc/tudu.conf --all --rotate
	[ $? -eq 0 ] && exit
done
EOF
chmod u+x $install_dir/coreseek/shell/index_rebuild.sh

cat > $install_dir/coreseek/shell/index_inc.sh  <<EOF
#!/bin/bash
 
source ~/.bash_profile
 
while [ 1 ]
do
	[ `ps -ef | grep indexer | grep -v 'grep' -c` -ne 0 ]  && {
		echo 'Some other indexer is running....'
		sleep 5
		continue
	}
        echo `date`	
	$install_dir/coreseek/bin/indexer -c $install_dir/coreseek/etc/tudu.conf chat_inc --rotate
	[ $? -eq 0 ] && exit
done
EOF
chmod u+x $install_dir/coreseek/shell/index_inc.sh

if [ ! `grep "# Tudu crontab #" /var/spool/cron/root` ];then
cat >> /var/spool/cron/root  <<EOF
# Tudu crontab #
01 04 * * * $install_dir/coreseek/shell/index_rebuild.sh >> $install_dir/coreseek/var/log/index_rebuild.log 2>&1
*/5 * * * * $install_dir/coreseek/shell/index_inc.sh >> $install_dir/coreseek/var/log/index_inc.log 2>&1
EOF
fi
$install_dir/coreseek/shell/index_rebuild.sh 
$install_dir/coreseek/bin/searchd -c  $install_dir/coreseek/etc/tudu.conf &

$install_dir/nginx/sbin/nginx
/usr/local/bin/ttserver -host 0.0.0.0 -port 11211  -thnum 4 -dmn -pid /ttserver/ttserver.pid -log /ttserver/ttserver.log -le -ulog /ttserver/ -ulim 128m -sid 1 -rts /ttserver/ttserver.rts /ttserver/database.tcb
httpsqs -p 12181 -x /tmp/httpsqs -d

cat > $file_dir/install/<<EOF
[tudu]
domain = $domain

[mysql]
host = 127.0.0.1
port = 3306
user = tudu
password = tudu.com
database = tudu-db

[httpsqs]
host = 127.0.0.1
port = 12181

[memcache]
host = 127.0.0.1
port = 11211
EOF