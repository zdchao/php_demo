#!/bin/sh
#
#	restart mail process 
#
/home/fansd/master/bin/daemon -l /var/run/cdnbest-mail.pid -q
/home/fansd/master/bin/daemon -l /var/run/cdnbest-mail.pid -o /var/log/cdnbest-mail.log:100m /home/fansd/master/bin/cdnbest-mail
#
#	restart check ns process 
#	tube(check_ns)
#
/home/fansd/master/bin/daemon -l /var/run/dnsdun_check_ns.pid -q
chmod 700 /home/ftp/d/dnsdun/wwwroot/framework/auto_check_ns.php
/home/fansd/master/bin/daemon -l /var/run/dnsdun_check_ns.pid -o /var/log/dnsdun_check_ns.log:100m -- /home/ftp/d/dnsdun/wwwroot/framework/auto_check_ns.php
#
#	restart notice process
#	tube(notice)
#
/home/fansd/master/bin/daemon -l /var/run/dnsdun-attack-event.pid -q
chmod 700 /home/ftp/d/dnsdun/wwwroot/framework/auto_attack_event.php
/home/fansd/master/bin/daemon -l /var/run/dnsdun-attack-event.pid -o /var/log/dnsdun-attack-event.log:100m -- /home/ftp/d/dnsdun/wwwroot/framework/auto_attack_event.php
#
#	restart send sms process
#	tube(send_sms)
#
/home/fansd/master/bin/daemon -l /var/run/notice.pid
chmod 700 /home/ftp/n/notice/wwwroot/framework/auto_send.php
/home/fansd/master/bin/daemon -l /var/run/notice.pid -o /var/log/notice.log -- /home/ftp/n/notice/wwwroot/framework/auto_send.php
