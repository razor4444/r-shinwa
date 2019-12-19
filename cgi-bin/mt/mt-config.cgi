## Movable Type Configuration File
##
## This file defines system-wide
## settings for Movable Type. In 
## total, there are over a hundred 
## options, but only those 
## critical for everyone are listed 
## below.
##
## Information on all others can be 
## found at:
##  http://www.movabletype.jp/documentation/config

#======== REQUIRED SETTINGS ==========

CGIPath        /cgi-bin/mt/
StaticWebPath  /cgi-bin/mt/mt-static/
StaticFilePath /home/thumbsup/www/r-shinwa.jp/cgi-bin/mt/mt-static

#======== DATABASE SETTINGS ==========

ObjectDriver DBI::mysql
Database thumbsup_r-shinwa
DBUser thumbsup
DBPassword shinwakensetsu1
DBHost mysql423.db.sakura.ne.jp

#======== MAIL =======================

MailTransfer sendmail
SendMailPath /usr/lib/sendmail
