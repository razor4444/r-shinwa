#!/usr/local/bin/perl
################################################################################
# ���@�\�A�N�Z�X���CGI Professional�� �i�Ǘ��җp�j
# Ver 4.9
# Copyright(C) futomi 2001 - 2005
# http://www.futomi.com/
###############################################################################
use strict;
use lib './lib';
use CGI;
use CGI::Carp qw(fatalsToBrowser);
my $q = new CGI;
$| = 1;
#CGI�̐ݒ�
my $FREE_SERVER_NAME = '\.tok2\.com|\.infoseek\.co\.jp|\.xrea\.com';

my $COPYRIGHT = '<a href="http://www.futomi.com/" target="_blank">futomi\'s CGI Cafe</a>';
my $COOKIE_NAME = 'accadminpass';
my $RESTRICT_COOKIE_NAME = 'accrestrict';
my $CONF_DATA = './data/config.cgi';
my $HELP_DATA = './data/help.dat';
my $SETPASS_TMPL = './template/admin.setpass.html';
my $COMPLETE_TMPL = './template/admin.complete.html';
my $CONF_TMPL = './template/admin.conf.html';
my $AUTH_TMPL = './template/admin.auth.html';
my $HELP_TMPL = './template/admin.help.html';
my $SYSCHECK_TMPL = './template/admin.syscheck.html';
my $LOGINFO_TMPL = './template/admin.loginfo.html';
my $RESTRICT1_TMPL = './template/admin.restrict1.html';
my $RESTRICT2_TMPL = './template/admin.restrict2.html';

my @CONF_KEYS = (
	'ADMINPASS',		#�Ǘ��җp�p�X���[�h
	'IMAGE_URL',		#�C���[�W�f�B���N�g���� URL
	'AUTHFLAG',		#�A�N�Z�X�����@�\
	'PASSWORD',		#�p�X���[�h
	'URL2PATH_FLAG',	#URL�}�b�s���O�@�\
	'URL2PATH_URL',		#URL�}�b�s���O�iURL�j
	'URL2PATH_PATH',	#URL�}�b�s���O�i�p�X�j
	'TIMEDIFF',		#�����̒���
	'GRAPHMAXLENGTH',	#�_�O���t�̒���
	'ROW',			#�\�������L���O��
	'LOTATION',		#���[�e�[�V�����ݒ�
	'LOTATION_SIZE',	#���[�e�[�V�����T�C�Y
	'LOTATION_SAVE',	#�ߋ����O�ۑ��@�\
	'MY_SITE_URLs',		#�����N�����OURL
	'REJECT_HOSTS',		#���M���O���O�z�X�g
	'DIRECTORYINDEX',	#�f�B���N�g���C���f�b�N�X
	'URLHANDLE',		#�A�N�Z�X�y�[�W URL �̈���
	'USECOOKIE',		#Cookie�̗��p�ݒ�
	'EXPIREDAYS',		#Cookie�̗L������
	'INTERVAL',		#�Z�b�V�����C���^�[�o��
	'LOCK_FLAG',		#���O�t�@�C���̃��b�N����
	'CIRCLE_GLAPH',		#�~�O���t�̕���
	'IMAGE_TYPE'		#��̓^�O�̕\���摜�`��
);

my $err_status = '<font color="RED">NG</font>';
my $ok_status = '<font color="GREEN">OK</font>';

#���O�i�[�f�B���N�g��
my $LOGDIR = './logs';

#�ݒ�f�[�^�擾
my %CONF = &GetConf($CONF_DATA);

#�������e�̎擾
my $action = $q->param('action');
my $setpass_flag = $q->param('setpass');

#�p�X���[�h�ݒ�t���O���u1�v�Ȃ�A�p�X���[�h�ݒ菈��
if($setpass_flag) {
	&SetPass;
	%CONF = &GetConf($CONF_DATA);
}
#�p�X���[�h���ݒ肳��Ă��Ȃ���΁A�p�X���[�h�ݒ��ʂ�\��
unless($CONF{'ADMINPASS'}) {
	&PrintTemplate($SETPASS_TMPL);
	exit;
}
#�F��
unless($setpass_flag) {
	unless(&Auth) {
		&ErrorPrint("�p�X���[�h���Ⴂ�܂��B");
	}
}
#��������
if($action eq 'conf') {
	&PrintConf($CONF_TMPL);
} elsif($action eq 'setconf') {
	&SetConf;
	&PrintTemplate($COMPLETE_TMPL, '�ݒ芮�����܂����B', 'admin.cgi?action=conf');
} elsif($action eq 'system') {
	&PrintSysCheck($SYSCHECK_TMPL);
} elsif($action eq 'syscheck') {
	&SysCheck;
} elsif($action eq 'help') {
	my $item = $q->param('item');
	&PrintHelp($item);
} elsif($action eq 'log') {
	&PrintLogInfo;
} elsif($action eq 'logdel') {
	my $file = $q->param('file');
	my $log = "$LOGDIR/$file";
	&DeleteLogFile($log);
	&PrintLogInfo;
} elsif($action eq 'download') {
	my $file = $q->param('file');
	&DownloadFile($file);
} elsif($action eq 'restrict') {
	&PrintRestrictForm;
} elsif($action eq 'restrictset') {
	&SetRestrictCookie;
} elsif($action eq 'restrictclear') {
	&ClearRestrictCookie;
} else {
	&PrintSysCheck($SYSCHECK_TMPL);
}

exit;
my($title, $result, $status);


format STDOUT =
@<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< : @<<<<<<<<<<<<<<<<<<<<<<< : @<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
$title,$result,$status
.


sub ClearRestrictCookie {
	my $html;
	$html .= "<html><head>\n";
	$html .= "<meta http-equiv=\"Content-Language\" content=\"ja\">\n";
	$html .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=shift_jis\">\n";
	$html .= "\$COOKIE\$\n";
	$html .= "<title> </title>\n";
	$html .= "</head>\n";
	$html .= "<body bgcolor=\"#FFFFFF\">\n";
	$html .= "<center>\n";
	$html .= "<div style=\"font-size: 12px\">�ݒ���������܂����B</div>\n";
	$html .= "</center>\n";
	$html .= "</body></html>\n";

	if($ENV{'SERVER_NAME'} =~ /($FREE_SERVER_NAME)/) {
		$html =~ s/\$COOKIE\$/<META HTTP-EQUIV='Set-Cookie' CONTENT='$RESTRICT_COOKIE_NAME=clear;expires=Thu, 01-Jan-1970 00:00:00 GMT;'>/;
	} else {
		$html =~ s/\$COOKIE\$//;
		my $CookieHeaderString = &ClearCookie($RESTRICT_COOKIE_NAME);
		print "P3P: CP=\"NOI TAIa\"\n";
		print "$CookieHeaderString\n";
	}
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$html\n";
	exit;
}

sub SetRestrictCookie {
	my $html;
	$html .= "<html><head>\n";
	$html .= "<meta http-equiv=\"Content-Language\" content=\"ja\">\n";
	$html .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=shift_jis\">\n";
	$html .= "\$COOKIE\$\n";
	$html .= "<title> </title>\n";
	$html .= "</head>\n";
	$html .= "<body bgcolor=\"#FFFFFF\">\n";
	$html .= "<center>\n";
	$html .= "<div style=\"font-size: 12px\">�ݒ芮�����܂����B</div>\n";
	$html .= "</center>\n";
	$html .= "</body></html>\n";
	my $expire = time + 315360000;	#10�N��
	my $CookieHeaderString = &SetCookie($RESTRICT_COOKIE_NAME, '1', $expire);
	if($ENV{'SERVER_NAME'} =~ /($FREE_SERVER_NAME)/) {
		my $content_str = $CookieHeaderString;
		$content_str =~ s/^Set-Cookie: //;
		$html =~ s/\$COOKIE\$/<META HTTP-EQUIV='Set-Cookie' CONTENT='$content_str'>/;
	} else {
		$html =~ s/\$COOKIE\$//;
		print "P3P: CP=\"NOI TAIa\"\n";
		print "$CookieHeaderString\n";
	}
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$html\n";
	exit;
}

sub PrintRestrictForm {
	my %cookie = &GetCookie;
	my $template;
	if($cookie{$RESTRICT_COOKIE_NAME}) {
		$template = $RESTRICT2_TMPL;
	} else {
		$template = $RESTRICT1_TMPL;
	}
	my $html = &ReadTemplate($template);
	if($ENV{'SERVER_NAME'} =~ /($FREE_SERVER_NAME)/) {
		$html =~ s/\$COOKIE\$/<META HTTP-EQUIV='Set-Cookie' CONTENT='$COOKIE_NAME=$CONF{'ADMINPASS'};'>/;
	} else {
		$html =~ s/\$COOKIE\$//;
		my $CookieHeaderString = &SetCookie($COOKIE_NAME, $CONF{'ADMINPASS'});
		print "P3P: CP=\"NOI TAIa\"\n";
		print "$CookieHeaderString\n";
	}
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$html\n";
	exit;
}


sub DownloadFile {
	my($file) = @_;
	my $log = "$LOGDIR/$file";
	my $ua = $ENV{'HTTP_USER_AGENT'};
	my $rc = "\x0A";	#LF
	if($ua =~ /Windows|Win32|Win 9x/) {
		$rc = "\x0D\x0A";	#CRLF
	} elsif($ua =~ /Macintosh|Mac_/) {
		$rc = "\x0D";	#CR
	}
	my $size = -s $log;
	open(LOG, "$log") || &ErrorPrint("���O�t�@�C�� <tt>$log</tt> ���I�[�v���ł��܂���ł����B : $!");
	my $contents;
	sysread(LOG, $contents, $size);
	close(LOG);
	$contents =~ s/\n/$rc/g;
	#print "Content-Type: application/octet-stream\n";
	print "Content-Disposition: attachment; filename=$file\n";
	print "Content-length: $size\n";
	print "\n";
	print "$contents";
	exit;
}

sub DeleteLogFile {
	my($log) = @_;
	unless(unlink($log)) {
		&ErrorPrint("���O�t�@�C�� $log ���폜�ł��܂���ł����B : $!");
	}
}

sub PrintLogInfo {
	opendir(DIR, "$LOGDIR") || &ErrorPrint("���O�i�[�f�B���N�g���u$LOGDIR�v���I�[�v���ł��܂���ł����B");
	my @files = readdir(DIR);
	closedir(DIR);
	my @logs = ();
	for my $file (@files) {
		if($file =~ /^access_log/) {
			push(@logs, $file);
		}
	}
	my(%size_list, %mtime_list);
	for my $file (@logs) {
		my @stat = stat("$LOGDIR/$file");
		$size_list{$file} = $stat[7];
		$mtime_list{$file} = $stat[9];
	}
	my $list;
	foreach my $file (ValueSort(\%mtime_list)) {
		my $date = &ConvEpoc2Date($mtime_list{$file});
		my $dsp_size = &CommaFormat($size_list{$file});
		$list .= "  <tr>\n";
		$list .= "    <td class=\"ListHeader4\">$file</td>\n";	#�t�@�C����
		$list .= "    <td class=\"ListHeader4\" align=\"right\">$dsp_size byte</td>\n";	#�T�C�Y
		$list .= "    <td class=\"ListHeader4\">$date</td>\n";	#�ŏI�X�V����
		$list .= "    <td class=\"ListHeader4\" align=\"center\"><a href=\"admin.cgi?action=download&file=$file\">Download</a></td>\n";	#�_�E�����[�h
		$list .= "    <td class=\"ListHeader4\" align=\"center\"><a href=\"javascript:delConfirm('$file')\">�폜</a></td>\n";	#�폜
		$list .= "  </tr>\n";
	}
	my $html = &ReadTemplate($LOGINFO_TMPL);
	$html =~ s/\$LIST\$/$list/;
	if($ENV{'SERVER_NAME'} =~ /($FREE_SERVER_NAME)/) {
		$html =~ s/\$COOKIE\$/<META HTTP-EQUIV='Set-Cookie' CONTENT='$COOKIE_NAME=$CONF{'ADMINPASS'};'>/;
	} else {
		$html =~ s/\$COOKIE\$//;
		my $CookieHeaderString = &SetCookie($COOKIE_NAME, $CONF{'ADMINPASS'});
		print "P3P: CP=\"NOI TAIa\"\n";
		print "$CookieHeaderString\n";
	}
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$html\n";
	exit;
}

sub PrintSysCheck {
	my($file) = @_;
	my $size = -s $file;
	if(!open(IN, "$file")) {
		&ErrorPrint("�e���v���[�g�t�@�C�� <tt>$file</tt> ���I�[�v���ł��܂���ł����B : $!");
		exit;
	}
	binmode(IN);
	my $filestr;
	sysread(IN, $filestr, $size);
	close(IN);
	my $key;
	$filestr =~ s/\$COPYRIGHT\$/$COPYRIGHT/g;
	if($ENV{'SERVER_NAME'} =~ /($FREE_SERVER_NAME)/) {
		$filestr =~ s/\$COOKIE\$/<META HTTP-EQUIV='Set-Cookie' CONTENT='$COOKIE_NAME=$CONF{'ADMINPASS'};'>/;
	} else {
		$filestr =~ s/\$COOKIE\$//;
		my $CookieHeaderString = &SetCookie($COOKIE_NAME, $CONF{'ADMINPASS'});
		print "P3P: CP=\"NOI TAIa\"\n";
		print "$CookieHeaderString\n";
	}
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$filestr\n";
	exit;
}


sub SysCheckError {
	my($str) = @_;
	my $err = "<blockquote>\n";
	$err .= "<table border=\"0\" width=\"500\"><tr><td>\n";
	$err .= "<div><font color=\"RED\"><tt>\n";
	$err .= "$str\n";
	$err .= "</tt></font></div>\n";
	$err .= "</td></tr></table>\n";
	$err .= "</blockquote>\n";
	return $err;
}

sub SysCheck {
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "<html>\n";
	print "<head>\n";
	print "  <meta http-equiv=\"Content-Language\" content=\"ja\">\n";
	print "  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=shift_jis\">\n";
	print "  <style type=\"text/css\">\n";
	print "    div {font-size: 12px;}\n";
	print "  </style>\n";
	print "  <title>futomi's CGI Cafe - ���@�\�A�N�Z�X��� CGI Professional Edition</title>\n";
	print "</head>\n\n";
	print "<body bgcolor=\"#FFFFFF\">\n";
	print "<br>\n";
	print "<br>\n";

	print "<div>�V�X�e���f�f���J�n���܂��B��肪����ꍇ�ɂ́A�Ԏ��ŕ\\������܂��B�f�f����������܂ł��΂炭���҂����������B</div>\n";
	print "<hr>\n";

	print "<div>\n";
	print "<pre><tt>\n";
	sleep 1;

	my $ex_uid = $>;
	my @stats = stat("./admin.cgi");
	my $owner_uid = $stats[4];
	my $executer;
	if($ex_uid eq $owner_uid) {
		$executer = 'owner';
	} else {
		$executer = 'other';
	}
	$title = "�� CGI �̎��s����";
	$result = "$executer";
	$status = "";
	write();

	print "\n";

	my $rc = &GetReturnCode("./admin.cgi");
	$title = "�� CGI �t�@�C�� ./admin.cgi �̉��s�R�[�h";
	$result = "$rc";
	$status = "";
	write();

	my $perl_path = &GetPerlPath("./admin.cgi");
	$title = "�� CGI �t�@�C�� ./admin.cgi �� Perl �p�X";
	$result = "$perl_path";
	$status = "";
	write();

	my $permission = sprintf("%o",(stat("./admin.cgi"))[2] & 0777);
	$title = "�� CGI �t�@�C�� ./admin.cgi �̃p�[�~�b�V����";
	$result = "$permission";
	$status = "";
	write();
	print "\n";

	&ExistCheck('./acclog.cgi', 'CGI �t�@�C��');
	&ReturnCodeCheck('./acclog.cgi', 'CGI �t�@�C��', $rc);
	&PerlPathCheck('./acclog.cgi', $perl_path);
	&PermissionCheck('./acclog.cgi', $executer, $permission);
	print "\n";

	&ExistCheck('./acc.cgi', 'CGI �t�@�C��');
	&ReturnCodeCheck('./acc.cgi', 'CGI �t�@�C��', $rc);
	&PerlPathCheck('./acc.cgi', $perl_path);
	&PermissionCheck('./acc.cgi', $executer, $permission);
	print "\n";

	&ExistCheck('./acclogo.gif', '��͎��\���p�摜�t�@�C��');
	&ExistCheck('./acclogo.png', '��͎��\���p�摜�t�@�C��');
	&ExistCheck('./acclogo.jpg', '��͎��\���p�摜�t�@�C��');
	print "\n";

	&DirExistCheck('./logs', '���O�i�[�f�B���N�g��');
	&DirWriteCheck('./logs', '���O�i�[�f�B���N�g��');
	print "\n";

	&DirExistCheck('./data', '�e��f�[�^�i�[�f�B���N�g��');
	&ExistCheck('./data/config.cgi', 'CGI �ݒ�t�@�C��');
	&ReturnCodeCheck('./data/config.cgi', 'CGI �ݒ�t�@�C��', $rc);
	&WriteCheck('./data/config.cgi', 'CGI �ݒ�t�@�C��');
	&ExistCheck('./data/country_code.dat', '���R�[�h��`�t�@�C��');
	&ReturnCodeCheck('./data/country_code.dat', '���R�[�h��`�t�@�C��', $rc);
	&ExistCheck('./data/help.dat', '�w���v�t�@�C��');
	&ReturnCodeCheck('./data/help.dat', '�w���v�t�@�C��', $rc);
	&ExistCheck('./data/language.dat', '�����`�t�@�C��');
	&ReturnCodeCheck('./data/language.dat', '�����`�t�@�C��', $rc);
	&ExistCheck('./data/organization.dat', '�g�D����`�t�@�C��');
	&ReturnCodeCheck('./data/organization.dat', '�g�D����`�t�@�C��', $rc);
	&ExistCheck('./data/pref.dat', '�s���{����`�t�@�C��');
	&ReturnCodeCheck('./data/pref.dat', '�s���{����`�t�@�C��', $rc);
	&ExistCheck('./data/site.dat', '�T�C�g����`�t�@�C��');
	&ReturnCodeCheck('./data/site.dat', '�T�C�g����`�t�@�C��', $rc);
	&ExistCheck('./data/ipaddr.dat', 'IP�A�h���X��`�t�@�C��');
	&ReturnCodeCheck('./data/ipaddr.dat', 'IP�A�h���X��`�t�@�C��', $rc);
	&ExistCheck('./data/title.dat', '�^�C�g����`�t�@�C��');
	&ReturnCodeCheck('./data/title.dat', '�^�C�g����`�t�@�C��', $rc);
	print "\n";

	&DirExistCheck('./lib', '���C�u�����[�i�[�f�B���N�g��');
	&ExistCheck('./lib/jcode.pl', 'jcode.pl');
	&ReturnCodeCheck('./lib/jcode.pl', 'jcode.pl', $rc);
	&ExistCheck('./lib/Jcode.pm', 'Jcode.pm');
	&ReturnCodeCheck('./lib/Jcode.pm', 'Jcode.pm', $rc);
	&DirExistCheck('./lib/Jcode', 'Jcode.pm�i�[�f�B���N�g��');
	&ExistCheck('./lib/CGI.pm', 'CGI.pm');
	&ReturnCodeCheck('./lib/CGI.pm', 'CGI.pm', $rc);
	&DirExistCheck('./lib/CGI', 'CGI.pm�i�[�f�B���N�g��');
	&DirExistCheck('./lib/File', 'File���W���[���i�[�f�B���N�g��');
	&ExistCheck('./lib/File/Spec.pm', 'File::Spec���W���[��');
	&ReturnCodeCheck('./lib/File/Spec.pm', 'File::Spec���W���[��', $rc);
	&DirExistCheck('./lib/File/Spec', 'File::Spec���W���[���i�[�f�B���N�g��');

	print "\n";

	&DirExistCheck('./template', '�e���v���[�g�t�@�C���i�[�f�B���N�g��');
	&ExistCheck('./template/admin.auth.html');
	&ExistCheck('./template/admin.complete.html');
	&ExistCheck('./template/admin.conf.html');
	&ExistCheck('./template/admin.help.html');
	&ExistCheck('./template/admin.loginfo.html');
	&ExistCheck('./template/admin.restrict1.html');
	&ExistCheck('./template/admin.restrict2.html');
	&ExistCheck('./template/admin.setpass.html');
	&ExistCheck('./template/admin.syscheck.html');
	&ExistCheck('./template/loginfo.html');
	&ExistCheck('./template/logon.html');
	&ExistCheck('./template/mainframe.html');
	&ExistCheck('./template/menuframe.html');
	&ExistCheck('./template/menuframe_ie.html');
	&ExistCheck('./template/result.html');
	&ExistCheck('./template/search.html');
	print $q->hr;
	print "�f�f����<br>\n";
	print "</tt></pre>\n";
	print "</body>\n";
	print "</html>\n\n";
}

sub PermissionCheck {
	my($file, , $executer, $permission) = @_;
	my $permission2 = sprintf("%o",(stat("$file"))[2] & 0777);
	$title = "�� CGI �t�@�C�� $file �� �p�[�~�b�V����";
	$result = "$permission2";
	my $err_str;
	my $err_flag = 0;
	if($permission2 eq '0' || $permission2 eq '') {
		$result = "�f�f�s��";
		$status = "";
	} elsif($permission eq $permission2) {
		$status = $ok_status;
	} else {
		if($executer eq 'owner') {
			unless($permission2 =~ /^(7|5)/) {
				$err_str = &SysCheckError("$file �� $executer �Ɏ��s����������܂���B�p�[�~�b�V������ $permission �̂悤�� $executer �Ɏ��s����^����悤�ɐݒ肵�Ă��������B");
				$status = $err_status;
				$err_flag = 1;
			} else {
				$status = $ok_status;
			}
		} elsif($executer eq 'other') {
			unless($permission2 =~ /(7|5)$/) {
				$err_str = &SysCheckError("$file �� $executer �Ɏ��s����������܂���B�p�[�~�b�V������ $permission �̂悤�� $executer �Ɏ��s����^����悤�ɐݒ肵�Ă��������B");
				$status = $err_status;
				$err_flag = 1;
			} else {
				$status = $ok_status;
			}
		}
	}
	write();
	if($err_flag) {
		print "$err_str\n";
	}
}

sub PerlPathCheck {
	my($file, $perl_path) = @_;
	my $perl_path2 = &GetPerlPath("$file");
	$title = "�� CGI �t�@�C�� $file �� Perl �p�X�ݒ�";
	$result = "$perl_path2";
	my $err_flag = 0;
	my $err_str;
	if($perl_path eq '' || $perl_path2 eq '') {
		$result = "�f�f�s��";
		$status = "";
	} elsif($perl_path2 eq $perl_path) {
		$status = $ok_status;
	} else {
		$err_str = &SysCheckError("$file �� Perl �p�X���������ݒ肳��Ă��܂���B$file �� 1 �s�ڂ��u$perl_path�v�ɏ��������Ă��������B");
		$err_flag = 1;
		$status = $err_status;
	}
	write();
	if($err_flag) {
		print "$err_str\n";
	}
}

sub WriteCheck {
	my($file, $str) = @_;
	$title = "�� $str $file �ւ̏����݃`�F�b�N";
	$result = "";
	my $err_flag = 0;
	my $err_str;
	if(open(FILE, ">>$file")) {
		$status = $ok_status;
		close(FILE);
	} else {
		$status = $err_status;
		$err_flag = 1;
		$err_str = &SysCheckError("$file �̃p�[�~�b�V����������������܂���B606 �������� 666 �ɕύX���Ă��������B");
	}
	write();
	if($err_flag) {
		print "$err_str\n";
	}
}

sub DirWriteCheck {
	my($dir, $str) = @_;
	my $test_file = "$dir/check.txt";
	$title = "�� $str $dir ���̃t�@�C�������݃`�F�b�N";
	$result = sprintf("%o",(stat("$dir"))[2] & 0777);
	my $err_flag = 0;
	my $err_str;
	if(-e "$dir") {
		if(open(TEST, ">$test_file")) {
			$status = $ok_status;
			close(TEST);
			unlink("$test_file");
		} else {
			$status = $err_status;
			$err_str = &SysCheckError("�f�B���N�g�� $dir �̃p�[�~�b�V����������������܂���B707 �������� 777 �ɕύX���Ă��������B");
			$err_flag = 1;
		}
		write();
		if($err_flag) {
			print "$err_str\n";
		}
	} else {
		$result = "�f�f�s��";
		$status = "";
		write();
	}
}

sub DirExistCheck {
	my($dir, $str) = @_;
	$title = "�� $str $dir �̑���";
	$result = "";
	my $err_flag = 0;
	my $err_str;

	if(opendir(DIR, "$dir")) {
		$status = $ok_status;
		closedir(DIR);
	} else {
		$status = $err_status;
		$err_flag = 1;
		$err_str = &SysCheckError("�f�B���N�g�� $dir ������܂���B�T�[�o��� $dir ���쐬���Ă��������B");
	}
	write();
	if($err_flag) {
		print "$err_str\n";
	}
}

sub ExistCheck {
	my($file, $str) = @_;
	$title = "�� $str $file �̑���";
	$result = "";
	my $err_flag = 0;
	my $err_str;
	if(-e "$file") {
		$status = $ok_status;
	} else {
		$err_flag = 1;
		$status = $err_status;
		$err_str = &SysCheckError("$file ������܂���B�T�[�o�� $file �� �A�b�v���[�h���Ă��������B");
	}
	write();
	if($err_flag) {
		print "$err_str\n";
	}
}

sub ReturnCodeCheck {
	my($file, $str, $rc) = @_;
	my $rc2 = &GetReturnCode("$file");
	$title = "�� $str $file �̉��s�R�[�h";
	$result = "$rc2";
	my $err_flag = 0;
	my $err_str;
	if($rc2 eq '' || $rc eq '') {
		$result = "�f�f�s��";
		$status = "";
	} elsif($rc2 eq $rc) {
		$status = $ok_status;
	} else {
		$status = $err_status;
		$err_flag = 1;
		$err_str = &SysCheckError("$file �̉��s�R�[�h������������܂���B$file �� ASCII ���[�h�ŏ㏑���A�b�v���[�h���Ă��������B");
	}
	write();
	if($err_flag) {
		print "$err_str\n";
	}
}

sub GetPerlPath {
	my($file) = @_;
	if(open(FILE, "$file")) {
		my @lines = <FILE>;
		my $perl_path = shift @lines;
		chop $perl_path;
		close(FILE);
		return $perl_path;
	} else {
		return '';
	}
}

sub PrintHelp {
	my($item) = @_;

	my $size = -s $HELP_DATA;
	if(!open(IN, "$HELP_DATA")) {
		&ErrorPrint("�w���v�t�@�C�� <tt>$HELP_DATA</tt> ���I�[�v���ł��܂���ł����B : $!");
		exit;
	}
	binmode(IN);
	my $helpstr;
	sysread(IN, $helpstr, $size);
	close(IN);
	$helpstr = &UnifyReturnCode($helpstr);
	my @help_parts = split(/<-- delimiter -->/, $helpstr);
	my %help = ();
	my %itemname = ();
	my $part;
	for $part (@help_parts) {
		$part =~ s/^(\n|\s)+//;
		my @lines = split(/\n/, $part);
		my $key = shift(@lines);
		my $keyname = shift(@lines);
		my $help_str = join("\n", @lines);
		$help{$key} = $help_str;
		$itemname{$key} = $keyname;
	}

	$size = -s $HELP_TMPL;
	if(!open(IN, "$HELP_TMPL")) {
		&ErrorPrint("�e���v���[�g�t�@�C�� <tt>$HELP_TMPL</tt> ���I�[�v���ł��܂���ł����B : $!");
		exit;
	}
	binmode(IN);
	my $filestr;
	sysread(IN, $filestr, $size);
	close(IN);
	$filestr =~ s/\$HELP\$/$help{$item}/g;
	$filestr =~ s/\$ITEM\$/$itemname{$item}/g;
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$filestr\n";
	exit;
}


sub SetConf {
	my $IMAGE_URL = $q->param('IMAGE_URL');
	if($IMAGE_URL) {
		if($IMAGE_URL =~ /\/$/) {
			&ErrorPrint("�C���[�W�f�B���N�g���� URL �̍Ō�ɃX���b�V���͓���Ȃ��ŉ������B");
		}
		$CONF{'IMAGE_URL'} = $IMAGE_URL;
	} else {
		&ErrorPrint("�C���[�W�f�B���N�g���� URL ���w�肵�ĉ������B");
	}

	my $AUTHFLAG = $q->param('AUTHFLAG');
	my $PASSWORD = $q->param('PASSWORD');
	$CONF{'AUTHFLAG'} = $AUTHFLAG;
	if($AUTHFLAG) {
		if($PASSWORD eq "") {
			&ErrorPrint("�p�X���[�h���w�肵�ĉ������B");
		} else {
			if($PASSWORD =~ /[^a-zA-Z0-9\-\_]/) {
				&ErrorPrint("�p�X���[�h�́A���p�p�����A���p�n�C�t���A���p�A���_�[�X�R�A�݂̂Ŏw�肵�ĉ������B");
			}
			$CONF{'PASSWORD'} = $PASSWORD;
		}
	}

	my $URL2PATH_FLAG = $q->param('URL2PATH_FLAG');
	my $URL2PATH_URL = $q->param('URL2PATH_URL');
	my $URL2PATH_PATH = $q->param('URL2PATH_PATH');
	$CONF{'URL2PATH_FLAG'} = $URL2PATH_FLAG;
	if($URL2PATH_FLAG) {
		if($URL2PATH_URL eq "") {
			&ErrorPrint("URL �}�b�s���O�@�\\���g���ꍇ�ɂ́A�}�b�s���O���ƂȂ� URL ���w�肵�ĉ������B");
		}
		if($URL2PATH_PATH eq "") {
			&ErrorPrint("URL �}�b�s���O�@�\\���g���ꍇ�ɂ́A�}�b�s���O��ƂȂ� �p�X ���w�肵�ĉ������B");
		}
		unless($URL2PATH_URL =~ /\/$/) {
			&ErrorPrint("URL �}�b�s���O�̎w��ł́A�Ō�ɃX���b�V�������Ă��������B");
		}
		unless($URL2PATH_PATH =~ /\/$/) {
			&ErrorPrint("URL �}�b�s���O�̎w��ł́A�Ō�ɃX���b�V�������Ă��������B");
		}
		if(opendir(DIR, "$URL2PATH_PATH")) {
			closedir(DIR);
		} else {
			&ErrorPrint("URL �}�b�s���O�̐ݒ�ɂ����āA�}�b�s���O��̃p�X�͑��݂��܂���B: $!");
		}
		$CONF{'URL2PATH_URL'} = $URL2PATH_URL;
		$CONF{'URL2PATH_PATH'} = $URL2PATH_PATH;
	}

	my $TIMEDIFF = $q->param('TIMEDIFF');
	unless($TIMEDIFF =~ /^\-*[0-9]+$/) {
		&ErrorPrint("�����̒����́A���p�����݂̂Ŏw�肵�ĉ������B");
	}
	$TIMEDIFF =~ s/^0*//;
	if($TIMEDIFF eq "") {
		$TIMEDIFF = 0;
	}
	$CONF{'TIMEDIFF'} = $TIMEDIFF;

	my $GRAPHMAXLENGTH = $q->param('GRAPHMAXLENGTH');
	if($GRAPHMAXLENGTH =~ /[^0-9]/) {
		&ErrorPrint("�_�O���t�̒����́A���p�����݂̂Ŏw�肵�ĉ������B");
	}
	$GRAPHMAXLENGTH =~ s/^0*//;
	if($GRAPHMAXLENGTH eq "") {
		$GRAPHMAXLENGTH = 0;
	}
	$CONF{'GRAPHMAXLENGTH'} = $GRAPHMAXLENGTH;

	my $ROW = $q->param('ROW');
	if($ROW =~ /[^0-9]/) {
		&ErrorPrint("�����L���O�\�����́A���p�����݂̂Ŏw�肵�ĉ������B");
	}
	$ROW =~ s/^0*//;
	if($ROW eq "") {
		$ROW = 0;
	}
	$CONF{'ROW'} = $ROW;

	my $LOTATION = $q->param('LOTATION');
	my $LOTATION_SIZE = $q->param('LOTATION_SIZE');
	my $LOTATION_SAVE = $q->param('LOTATION_SAVE');
	$CONF{'LOTATION'} = $LOTATION;
	if($LOTATION eq "1") {
		my $LOTATION_SIZE = $q->param('LOTATION_SIZE');
		if($LOTATION_SIZE eq "") {
			&ErrorPrint("���[�e�[�V�����T�C�Y���w�肵�ĉ������B");
		}
		if($LOTATION_SIZE =~ /[^0-9]/) {
			&ErrorPrint("���[�e�[�V�����T�C�Y�́A���p�����݂̂Ŏw�肵�ĉ������B");
		}
		$LOTATION_SIZE =~ s/^0*//;
		if($LOTATION_SIZE <= 0) {
			&ErrorPrint("���[�e�[�V�����T�C�Y�� 0 �ȉ��͎w��ł��܂���B");
		}
		$CONF{'LOTATION_SIZE'} = $LOTATION_SIZE;
	}
	if($LOTATION > 0) {
		$CONF{'LOTATION_SAVE'} = $LOTATION_SAVE;
	}

	my $MY_SITE_URLs = $q->param('MY_SITE_URLs');
	$MY_SITE_URLs = &UnifyReturnCode($MY_SITE_URLs);
	my @sites = split(/\n/, $MY_SITE_URLs);
	my $site;
	for $site (@sites) {
		unless($site =~ /https*:\/\//) {
			&ErrorPrint("�����N����� ���O URL �̎w��́A<tt>http://</tt> ����w�肵�ĉ������B : <tt>$site</tt>");
		}
		if($site =~ /[^a-zA-Z0-9\-\_\.\%\:\/\~\&\=\?]/) {
			&ErrorPrint("���O�z�X�g�̎w��ŁA�s�K�؂ȕ������܂܂�Ă��܂��B : <tt>$site</tt>");
		}
	}
	$MY_SITE_URLs =~ s/\n/,/g;
	$CONF{'MY_SITE_URLs'} = $MY_SITE_URLs;

	my $REJECT_HOSTS = $q->param('REJECT_HOSTS');
	$REJECT_HOSTS = &UnifyReturnCode($REJECT_HOSTS);
	my @hosts = split(/\n/, $REJECT_HOSTS);
	my $host;
	for $host (@hosts) {
		if($host =~ /https*:\/\//) {
			&ErrorPrint("���O�z�X�g�̎w��ł́A<tt>http://</tt> ����w��ł��܂���B: <tt>$host</tt>");
		}
		if($host =~ /[^a-zA-Z0-9\-\_\.]/) {
			&ErrorPrint("���O�z�X�g�̎w��ŁA�s�K�؂ȕ������܂܂�Ă��܂��B : <tt>$host</tt>");
		}
	}
	$REJECT_HOSTS =~ s/\n/,/g;
	$CONF{'REJECT_HOSTS'} = $REJECT_HOSTS;

	my $DIRECTORYINDEX = $q->param('DIRECTORYINDEX');
	$DIRECTORYINDEX = &UnifyReturnCode($DIRECTORYINDEX);
	$DIRECTORYINDEX =~ s/\n/,/g;
	$CONF{'DIRECTORYINDEX'} = $DIRECTORYINDEX;

	$CONF{'URLHANDLE'} = $q->param('URLHANDLE');

	my $USECOOKIE = $q->param('USECOOKIE');
	my $EXPIREDAYS = $q->param('EXPIREDAYS');
	$CONF{'USECOOKIE'} = $USECOOKIE;
	if($USECOOKIE) {
		if($EXPIREDAYS eq "") {
			&ErrorPrint("Cookie �L���������w�肵�ĉ������B");
		}
		if($EXPIREDAYS =~ /[^0-9]/) {
			&ErrorPrint("Cookie �L�������́A���p�����݂̂Ŏw�肵�ĉ������B");
		}
		$EXPIREDAYS =~ s/^0*//;
		if($EXPIREDAYS <= 0) {
			&ErrorPrint("Cookie �L�������� 0 �ȉ��͎w��ł��܂���B");
		}
		$CONF{'EXPIREDAYS'} = $EXPIREDAYS;
	}

	my $INTERVAL = $q->param('INTERVAL');
	if($INTERVAL eq "") {
		&ErrorPrint("�Z�b�V�����C���^�[�o�����w�肵�ĉ������B");
	}
	if($INTERVAL =~ /[^0-9]/) {
		&ErrorPrint("�Z�b�V�����C���^�[�o���́A���p�����݂̂Ŏw�肵�ĉ������B");
	}
	$INTERVAL =~ s/^0*//;
	if($INTERVAL <= 0) {
		&ErrorPrint("�Z�b�V�����C���^�[�o���� 0 �ȉ��͎w��ł��܂���B");
	}
	$CONF{'INTERVAL'} = $INTERVAL;
	$CONF{'LOCK_FLAG'} = $q->param('LOCK_FLAG');
	$CONF{'CIRCLE_GLAPH'} = $q->param('CIRCLE_GLAPH');
	$CONF{'IMAGE_TYPE'} = $q->param('IMAGE_TYPE');
	&WriteConfData;
}

sub PrintConf {
	my($file) = @_;
	my $size = -s $file;
	if(!open(IN, "$file")) {
		&ErrorPrint("�e���v���[�g�t�@�C�� <tt>$file</tt> ���I�[�v���ł��܂���ł����B : $!");
		exit;
	}
	binmode(IN);
	my $filestr;
	sysread(IN, $filestr, $size);
	close(IN);
	my $key;
	for $key (@CONF_KEYS) {
		if($key =~ /^(AUTHFLAG|URL2PATH_FLAG|LOTATION|LOTATION_SAVE|USECOOKIE|URLHANDLE|LOCK_FLAG|CIRCLE_GLAPH|IMAGE_TYPE)$/) {
			$filestr =~ s/\$$key$CONF{$key}\$/selected/g;
			$filestr =~ s/\$$key[0-9]+\$//g;
		} elsif($key =~ /^(MY_SITE_URLs|REJECT_HOSTS|DIRECTORYINDEX)$/) {
			my @items = split(/,/, $CONF{$key});
			my $tmp = join("\n", @items);
			$filestr =~ s/\$$key\$/$tmp/g;
		} else {
			$filestr =~ s/\$$key\$/$CONF{$key}/g;
		}
	}
	$filestr =~ s/\$COPYRIGHT\$/$COPYRIGHT/g;
	if($ENV{'SERVER_NAME'} =~ /($FREE_SERVER_NAME)/) {
		$filestr =~ s/\$COOKIE\$/<META HTTP-EQUIV='Set-Cookie' CONTENT='$COOKIE_NAME=$CONF{'ADMINPASS'};'>/;
	} else {
		$filestr =~ s/\$COOKIE\$//;
		my $CookieHeaderString = &SetCookie($COOKIE_NAME, $CONF{'ADMINPASS'});
		print "P3P: CP=\"NOI TAIa\"\n";
		print "$CookieHeaderString\n";
	}
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$filestr\n";
	exit;
}

sub Auth {
	my %cookie = &GetCookie;
	my $cookie_pass = $cookie{$COOKIE_NAME};
	my $in_pass = $q->param('pass');
	my($pass);
	if($cookie_pass) {
		$pass = $cookie_pass;
	} elsif($in_pass) {
		my $salt;
		if($CONF{'ADMINPASS'} =~ /^\$1\$([^\$]+)\$/) {
			$salt = $1;
		} else {
			$salt = substr($CONF{'ADMINPASS'}, 0, 2);
		}
		$pass = crypt($in_pass, $salt);
	} else {
		&PrintTemplate($AUTH_TMPL);
	}
	if($pass eq $CONF{'ADMINPASS'}) {
		return 1;
	} else {
		return 0;
	}
}

sub SetPass {
	my $pass1 = $q->param('PASSWORD1');
	my $pass2 = $q->param('PASSWORD2');
	unless($pass1 && $pass2) {
		&ErrorPrint("�p�X���[�h���w�肵�Ă��������B");
	}
	unless($pass1 eq $pass2) {
		&ErrorPrint("�p�X���[�h�ē��͂��Ԉ���Ă��܂��B�ēx���ӂ��ē��͂��Ă��������B");
	}
	if($pass1 =~ /[^a-zA-Z0-9\-\_]/) {
		&ErrorPrint("�p�X���[�h�ɕs���ȕ������܂܂�Ă��܂��B�w��ł��镶���́A���p�̉p���A�n�C�t���A�A���_�[�X�R�A�ł��B");
	}
	my $enc_pass = &EncryptPasswd($pass1);
	$CONF{'ADMINPASS'} = "$enc_pass";
	&WriteConfData;
}

sub PrintTemplate {
	my($file, $message, $back_link) = @_;
	my $size = -s $file;
	if(!open(IN, "$file")) {
		&ErrorPrint("�e���v���[�g�t�@�C�� <tt>$file</tt> ���I�[�v���ł��܂���ł����B : $!");
		exit;
	}
	binmode(IN);
	my $filestr;
	sysread(IN, $filestr, $size);
	close(IN);
	my $key;
	for $key (keys %CONF) {
		$filestr =~ s/\$$key\$/$CONF{$key}/g;
	}
	$filestr =~ s/\$BACK\$/$back_link/g;
	$filestr =~ s/\$MESSAGE\$/$message/g;
	$filestr =~ s/\$COPYRIGHT\$/$COPYRIGHT/g;
	$filestr =~ s/\$ACTION\$/$action/g;
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$filestr\n";
	exit;
}

sub GetConf {
	my($file) = @_;
	my %data = ();
	open(FILE, "$file") || &ErrorPrint("�ݒ�t�@�C�� <tt>$file</tt> ���I�[�v���ł��܂���ł����B: $!");
	while(<FILE>) {
		chop;
		if(/^([a-zA-Z0-9\_\-]+)\=(.+)$/) {
			my $key = $1;
			my $value = $2;
			unless($key) {next;}
			$key =~ s/^[\s\t]*//;
			$key =~ s/[\s\t]*$//;
			$value =~ s/^[\s\t]*//;
			$value =~ s/[\s\t]*$//;
			$data{$key} = $value;
		}
	}
	close(FILE);
	return %data;
}

sub ErrorPrint {
	my($message) = @_;
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "<html>\n";
	print "<head>\n";
	print "<meta http-equiv=\"Content-Language\" content=\"ja\">\n";
	print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=shift_jis\">\n";
	print "<STYLE TYPE=\"text/css\">\n";
	print "  div	{ font-size: 12px; }\n";
	print "  table	{ font-size: 12px; }\n";
	print "</STYLE>\n";
	print "<center><div>$message</div></center>\n";
	print "</body>\n";
	print "</html>\n";
	exit;
}

sub SetCookie {
	my($CookieName, $CookieValue, $ExpireTime, $Domain, $Path) = @_;
	# URL�G���R�[�h
	$CookieValue =~ s/([^\w\=\& ])/'%' . unpack("H2", $1)/eg;
	$CookieValue =~ tr/ /+/;
	my($CookieHeaderString);
	$CookieHeaderString .= "Set-Cookie: $CookieName=$CookieValue\;";
	if($ExpireTime) {
		my(@MonthString) = ('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
					'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
		my(@WeekString) = ('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
		my($sec, $min, $hour, $monthday, $month, $year, $weekday) = gmtime($ExpireTime);
		$year += 1900;
		$month = $MonthString[$month];
		if($monthday < 10) {$monthday = '0'.$monthday;}
		if($sec < 10) {$sec = '0'.$sec;}
		if($min < 10) {$min = '0'.$min;}
		if($hour < 10) {$hour = '0'.$hour;}
		my($GmtString) = "$WeekString[$weekday], $monthday-$month-$year $hour:$min:$sec GMT";
 		$CookieHeaderString .= " expires=$GmtString\;";
	}
	if($Domain) {
		$CookieHeaderString .= " domain=$Domain;";
	}
	if($Path) {
		$CookieHeaderString .= " path=$Path;";
	}
	return $CookieHeaderString;
}

sub GetCookie {
	my(@CookieList) = split(/\; /, $ENV{'HTTP_COOKIE'});
	my(%Cookie) = ();
	my($key, $CookieName, $CookieValue);
	for $key (@CookieList) {
		($CookieName, $CookieValue) = split(/=/, $key);
		$CookieValue =~ s/\+/ /g;
		$CookieValue =~ s/%([0-9a-fA-F][0-9a-fA-F])/pack("C",hex($1))/eg;
		$Cookie{$CookieName} = $CookieValue;
	}
	return %Cookie;
}

sub ClearCookie {
	my($CookieName) = @_;
	my($CookieHeaderString);
	my($ExpiresTimeString) = 'Thu, 01-Jan-1970 00:00:00 GMT';
	$CookieHeaderString .= "Set-Cookie: $CookieName=clear\; expires=$ExpiresTimeString\;";
	return $CookieHeaderString;
}

sub EncryptPasswd {
	my($pass)=@_;
	my(@salt_set)=('a'..'z','A'..'Z','0'..'9','.','/');
	srand;
	my($seed1) = int(rand(64));
	my($seed2) = int(rand(64));
	my($salt) = $salt_set[$seed1] . $salt_set[$seed2];
	return crypt($pass,$salt);
}

sub UnifyReturnCode {
	my($String) = @_;
	$String =~ s/\x0D\x0A/\n/g;
	$String =~ s/\x0D/\n/g;
	$String =~ s/\x0A/\n/g;
	return $String;
}

sub WriteConfData {
	my $err;
	$err .= "<table border=\"0\"><tr><td nowrap>\n";
	$err .= "�ݒ�t�@�C�� <tt>$CONF_DATA</tt> ���I�[�v���ł��܂���ł����B: $!<br>\n";
	$err .= "�ȉ��̓_�����m�F���������B<br>\n";
	$err .= "<ul>\n";
	$err .= "  <li>�f�B���N�g�� <tt>data</tt> �̃p�[�~�b�V������ 707 �������� 777 �ɕύX���Ă݂Ă��������B</li>\n";
	$err .= "  <li>�f�B���N�g�� <tt>data</tt> ���� <tt>config.cgi</tt> �̃p�[�~�b�V������ 606 �������� 666 �ɕύX���Ă݂Ă��������B</tt>\n";
	$err .= "</ul>\n";
	$err .= "</td></tr></table>\n";
	open(CONF, ">$CONF_DATA") || &ErrorPrint("$err");
	my $key;
	for $key (@CONF_KEYS) {
		print CONF "$key=$CONF{$key}\n";
	}
	close(CONF);
}

sub GetReturnCode {
	my($file) = @_;

	my $size = -s "$file";
	my $str;
	if(open(FILE, "$file")) {
		sysread(FILE, $str, $size);
		close(FILE);
	} else {
		return '';
	}

	my $return_code;
	if($str =~ /\x0D\x0A/) {
		$return_code = 'CRLF';
	} elsif($str =~ /\x0D/) {
		$return_code = 'CR';
	} elsif($str =~ /\x0A/) {
		$return_code = 'LF';
	}
	return $return_code;
}

sub CommaFormat {
	my($num) = @_;
	if($num =~ /[^0-9\.]/) {return $num;}
	my($int, $decimal) = split(/\./, $num);
	my $figure = length $int;
	my $commaformat;
	for(my $i=1;$i<=$figure;$i++) {
		my $n = substr($int, $figure-$i, 1);
		if(($i-1) % 3 == 0 && $i != 1) {
			$commaformat = "$n,$commaformat";
		} else {
			$commaformat = "$n$commaformat";
		}
	}
	if($decimal) {
		$commaformat .= "\.$decimal";
	}
	return $commaformat;
}

sub ReadTemplate {
	my($file) = @_;
	unless(-e $file) {
		&ErrorPrint("�e���v���[�g�t�@�C�� $file ������܂���B: $!");
	}
	my $size = -s $file;
	if(!open(FILE, "$file")) {
		&ErrorPrint("�e���v���[�g�t�@�C�� <tt>$file</tt> ���I�[�v���ł��܂���ł����B : $!");
		exit;
	}
	binmode(FILE);
	my $html;
	sysread(FILE, $html, $size);
	close(FILE);
	$html =~ s/\$COPYRIGHT\$/$COPYRIGHT/g;
	return $html;
}

# �A�z�z���l�ivalue�j�Ń\�[�g�����A�z�z���Ԃ�
sub ValueSort {
	my $x = shift;
	my %array=%$x;
	return sort {$array{$b} <=> $array{$a};} keys %array;
}

sub ConvEpoc2Date {
	my($epoc) = @_;
	my($s, $m, $h, $D, $M, $Y) = localtime($epoc + $CONF{'TIMEDIFF'}*3600);
	$Y += 1900;
	$M += 1;
	$M = sprintf("%02d", $M);
	$D = sprintf("%02d", $D);
	$h = sprintf("%02d", $h);
	$m = sprintf("%02d", $m);
	$s = sprintf("%02d", $s);
	return "$Y/$M/$D $h:$m:$s";
}


