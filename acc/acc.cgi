#!/usr/local/bin/perl
################################################################################
# ���@�\�A�N�Z�X���CGI Professional�� �i��͌��ʕ\���p�j
# Ver 4.9
# Copyright(C) futomi 2001 - 2005
# http://www.futomi.com/
###############################################################################
use strict;
use lib './lib';
use Time::Local;
use CGI;
use CGI::Carp qw(fatalsToBrowser);
use Jcode;
require './lib/jcode.pl';
my $q = new CGI;
$| = 1;

######################################################################
#  �O���[�o���ϐ��̒�`
######################################################################

#�o�[�W�������
my $CGI_VERSION = '4.9';

#�t���[�T�[�o�̃h���C�����X�g�i���K�\���j
my $FREE_SERVER_NAME = '\.tok2\.com|\.infoseek\.co\.jp|\.xrea\.com';

#�ݒ�l���擾
my %CONF = &GetConf('./data/config.cgi');
my %URL2PATH = ();
$URL2PATH{$CONF{'URL2PATH_URL'}} = $CONF{'URL2PATH_PATH'};
my @MY_SITE_URLs = split(/,/, $CONF{'MY_SITE_URLs'});
my @REJECT_HOSTS = split(/,/, $CONF{'REJECT_HOSTS'});
my @DIRECTORYINDEX = split(/,/, $CONF{'DIRECTORYINDEX'});

#�f�B���N�g���̒�`
my $TEMPLATEDIR = './template';
my $LOGDIR = './logs';
my $PRE_LOGNAME = 'access_log';

#���쌠�\���̒�`
my $COPYRIGHT = "futomi's CGI Cafe - ���@�\\�A�N�Z�X���CGI Professional $CGI_VERSION";
my $COPYRIGHT2 = "<a href=\"http://www.futomi.com\" target=\"_blank\"><img src=\"$CONF{'IMAGE_URL'}/futomilogo.gif\" width=\"80\" height=\"33\" border=\"0\"></a>";
my $COPYRIGHT3 = "<a href=\"http://www.futomi.com\" target=\"_blank\">futomi's CGI Cafe</a>";
my $COPYRIGHT4 = "<a href=\"http://www.futomi.com\" target=\"_blank\">$COPYRIGHT</a>";

#���̓p�����[�^�̎擾
my $MODE = $q->param('MODE');
my $ANA_MONTH = $q->param('MONTH');
my $ANA_DAY = $q->param('DAY');
my $TARGET_FRAME = $q->param('FRAME');
my $ITEM = $q->param('ITEM');
my $TARGET_VISITOR = $q->param('VISITOR');

# ����CGI��URL
my $CGI_URL = 'acc.cgi';

# ��͑Ώۂ̃��O�t�@�C���������
my $TARGET_LOGNAME = &SpecifyLogFileName;

######################################################################
#  ���C�����[�`��
######################################################################

# �p�X���[�h�F��
if($CONF{'AUTHFLAG'}) {&Auth;}

# ���N�G�X�g��redirect�L�[���[�h������΁A�w��URL�֓]��
if($q->param('REDIRECT')) {
	&RedirectPage($q->param('REDIRECT'));
}

# �^�[�Q�b�g�t���[���̎w�肪�Ȃ���΁A�e�t���[�����o�͂���B
if($TARGET_FRAME eq 'menu') {
	&PrintMenuFrame;
} elsif($TARGET_FRAME eq 'result') {
	&PrintResultFrame;
} else {
	&PrintMainFrame;
}

exit;


######################################################################
#  �T�u���[�`��
######################################################################

sub PrintMainFrame {
	my $menu_url = "$CGI_URL?FRAME=menu";
	my $result_url = "$CGI_URL?FRAME=result";
	if($TARGET_LOGNAME) {
		$menu_url .= "\&LOG=$TARGET_LOGNAME";
		$result_url .= "\&LOG=$TARGET_LOGNAME";
	}
	if($ANA_MONTH) {
		$menu_url .= "\&MONTH=$ANA_MONTH";
		$result_url .= "\&MONTH=$ANA_MONTH";
		if($ANA_DAY) {
			$menu_url .= "\&DAY=$ANA_DAY";
			$result_url .= "\&DAY=$ANA_DAY";
		}
	} else {
		if($ANA_DAY) {
			&ErrorPrint("�����w�肷��ꍇ�ɂ́A�����w�肵�ĉ������B");
		}
	}
	my $html = &ReadTemplate("$TEMPLATEDIR/mainframe.html");
	$html =~ s/<!--MENUURL-->/$menu_url/;
	$html =~ s/<!--RESULTURL-->/$result_url/;
	if($ENV{'SERVER_NAME'} =~ /($FREE_SERVER_NAME)/) {
		$html =~ s/<!--COOKIE-->/<META HTTP-EQUIV='Set-Cookie' CONTENT=PASS=$CONF{'PASSWORD'};'>/;
	} else {
		$html =~ s/<!--COOKIE-->//;
	}
	&HtmlHeader;
	print "$html\n";
}

sub PrintMenuFrame {
	my(@DateList) = &GetLogDateList("$LOGDIR/$TARGET_LOGNAME");
	my $Today = &GetToday;
	my $MaxDate = pop @DateList;
	my $MinDate = $MaxDate;
	if(scalar(@DateList) >= 1) {
		$MinDate = shift @DateList;
	}

	my $TargetMonth;
	if($ANA_MONTH) {
		$TargetMonth = $ANA_MONTH;
	} elsif($MaxDate) {
		$TargetMonth = substr($MaxDate, 0, 6);
	} else {
		$TargetMonth = substr($Today, 0, 6);
	}

	my $DspYear = substr($TargetMonth, 0, 4);
	my $DspMonth = substr($TargetMonth, 4, 2);
	my $y = $DspYear;	$y =~ s/^0//;
	my $m = $DspMonth;	$m =~ s/^0//;
	my $LastMonth = &GetLastMonth($TargetMonth);
	my $NextMonth = &GetNextMonth($TargetMonth);
	
	my $ThisMonthTag = "<a href=\"$CGI_URL?LOG=$TARGET_LOGNAME&MONTH=$DspYear$DspMonth\" target=\"_top\">$DspYear�N $DspMonth��</a>";
	my $LastMonthTag;
	if($LastMonth >= substr($MinDate, 0, 6)) {
		$LastMonthTag = "<a href=\"$CGI_URL?LOG=$TARGET_LOGNAME&MONTH=$LastMonth\" target=\"_top\"><img src=\"$CONF{'IMAGE_URL'}/left.gif\" border=\"0\" width=\"17\" height=\"17\"></a>\n";
	} else {
		$LastMonthTag = "<img src=\"$CONF{'IMAGE_URL'}/left_g.gif\" border=\"0\" width=\"17\" height=\"17\">\n";
	}
	my $NextMonthTag;
	if($NextMonth <= substr($MaxDate, 0, 6)) {
		$NextMonthTag = "<a href=\"$CGI_URL?LOG=$TARGET_LOGNAME&MONTH=$NextMonth\" target=\"_top\"><img src=\"$CONF{'IMAGE_URL'}/right.gif\" border=\"0\" width=\"17\" height=\"17\"></a>\n";
	} else {
		$NextMonthTag = "<img src=\"$CONF{'IMAGE_URL'}/right_g.gif\" border=\"0\" width=\"17\" height=\"17\">\n";
	}

	my $LastDay = &LastDay($DspYear, $DspMonth);
	my $StartWeekNo = &Youbi($DspYear, $DspMonth, "01");
	my $flag = 1;
	my $WeekNo = 0;
	my $day = 1;
	my ($i, $DateBuff, $DspDay, $CalendarTag);
	while($flag) {
		$CalendarTag .= "<tr>\n";
		for($i=0;$i<7;$i++) {
			if($WeekNo < 1 && $i < $StartWeekNo) {
				$CalendarTag .= "  <td align=\"right\" bgcolor=\"#EAEAEA\">&nbsp;</td>\n";
			} elsif($day > $LastDay) {
				$CalendarTag .= "  <td align=\"right\" bgcolor=\"#EAEAEA\">&nbsp;</td>\n";
				$day ++;
			} else {
				$DateBuff = $DspYear . $DspMonth;
				if($day < 10) {
					$DateBuff .= "0$day";
				} else {
					$DateBuff .= "$day";
				}
				if($DateBuff == $Today) {
					$DspDay = "<strong>$day</strong>";
				} else {
					$DspDay = "$day";
				}
				if($i == 0) {
					$DspDay = "<font color=\"#FF0000\">$DspDay</font>";
				} elsif(&CheckHoliday($y, $m, $day)) {
					$DspDay = "<font color=\"#FF0000\">$DspDay</font>";
				} elsif($i == 6) {
					$DspDay = "<font color=\"#0000FF\">$DspDay</font>";
				}
				if($DateBuff >= $MinDate && $DateBuff <= $MaxDate) {
					$CalendarTag .= "  <td align=\"right\" bgcolor=\"\#FFFFCC\"><a href=\"$CGI_URL?LOG=$TARGET_LOGNAME&MONTH=$DspYear$DspMonth&DAY=$day\" target=\"_top\">$DspDay</a></td>\n";
				} else {
					$CalendarTag .= "  <td align=\"right\">$DspDay</td>\n";
				}
				$day ++;
			}
		}
		$CalendarTag .= "</tr>\n";
		$WeekNo ++;
		if($day > $LastDay) {
			$flag = 0;
		}
	}

	my $LogListTag = "<form action=\"$CGI_URL\" method=\"POST\" target=\"_top\">\n";
	$LogListTag .= "  <select size=\"1\" name=\"LOG\">\n";
	opendir(LOGDIR, "$LOGDIR") || &ErrorPrint("���O�i�[�f�B���N�g���u$LOGDIR�v���I�[�v���ł��܂���ł����B : $!");
	my @files = readdir(LOGDIR);
	closedir(LOGDIR);
	for my $file (sort @files) {
		if($file =~ /^$PRE_LOGNAME/) {
			if($file eq $TARGET_LOGNAME) {
				$LogListTag .= "    <option value=\"$file\" selected>$file</option>\n";
			} else {
				$LogListTag .= "    <option value=\"$file\">$file</option>\n";
			}
		}
	}
	$LogListTag .= "  </select><br>\n";
	$LogListTag .= "  <input type=\"submit\" name=\"LOGSELECT\" value=\"���O�ؑ�\">\n";
	$LogListTag .= "</form>\n";


	my $AccModeTag;
	if($ANA_DAY) {
		$AccModeTag = "���w��<br>".substr($ANA_MONTH, 0, 4)."/".substr($ANA_MONTH, 4, 2)."/$ANA_DAY";
	} elsif($ANA_MONTH) {
		$AccModeTag = "���w��<br>".substr($ANA_MONTH, 0, 4)."/".substr($ANA_MONTH, 4, 2);
	} else {
		$AccModeTag = "�S�w��";
	}

	my $CgiUrl = "$CGI_URL\?FRAME=result\&LOG=$TARGET_LOGNAME";
	if($ANA_MONTH) {
		$CgiUrl .= "&MONTH=$ANA_MONTH";
		if($ANA_DAY) {
			$CgiUrl .= "&DAY=$ANA_DAY";
		}
	}

	my $AllAccUrl = "$CGI_URL\?LOG=$TARGET_LOGNAME";

	my $template;
	if($ENV{'HTTP_USER_AGENT'} =~ /Opera/i) {
		$template = "$TEMPLATEDIR/menuframe.html";
	}elsif($ENV{'HTTP_USER_AGENT'} =~ /MSIE/i) {
		$template = "$TEMPLATEDIR/menuframe_ie.html";
	} else {
		$template = "$TEMPLATEDIR/menuframe.html";
	}
	my $html = &ReadTemplate($template);
	$html =~ s/<!--LastMonth-->/$LastMonthTag/;
	$html =~ s/<!--ThisMonth-->/$ThisMonthTag/;
	$html =~ s/<!--NextMonth-->/$NextMonthTag/;
	$html =~ s/<!--ALLACCURL-->/$AllAccUrl/;
	$html =~ s/<!--calendar-->/$CalendarTag/;
	$html =~ s/<!--loglist-->/$LogListTag/;
	$html =~ s/<!--ACCMODE-->/$AccModeTag/;
	$html =~ s/<!--MYURL-->/$CGI_URL/;
	$html =~ s/<!--CGIURL-->/$CgiUrl/g;
	$html =~ s/<!--IMAGEDIR-->/$CONF{'IMAGE_URL'}/g;
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$html\n";
}

sub IsInDate {
	my($date_check) = @_;
	my($date_check_mon, $date_check_day) = $date_check =~ /^(\d{6})(\d{2})/;
	$date_check_day =~ s/^0//;
	if($ANA_MONTH) {
		unless($date_check_mon eq $ANA_MONTH) {
			return 0;
		}
		if($ANA_DAY) {
			unless($date_check_day eq $ANA_DAY) {
				return 0;
			}
		}
	}
	return 1;
}

sub PrintResultFrame {
	if($ITEM eq '') {
		&GeneralStatistics;
	} elsif($ITEM eq 'AccessLogInformation') {
		&AccessLogInformation;
	} elsif($ITEM eq 'LogSearch') {
		&LogSearchForm;
	} elsif($ITEM eq 'LogSearchGo') {
		&LogSearchGo;
	} elsif($ITEM eq 'TopVisitors') {
		&TopVisitors;
	} elsif($ITEM eq 'MostActiveCountries') {
		&MostActiveCountries;
	} elsif($ITEM eq 'MostActivePrefecture') {
		&MostActivePrefecture;
	} elsif($ITEM eq 'MostActiveOrganization') {
		&MostActiveOrganization;
	} elsif($ITEM eq 'NewVsReturningVisitors') {
		&NewVsReturningVisitors;
	} elsif($ITEM eq 'TopPagesByViews') {
		&TopPagesByViews;
	} elsif($ITEM eq 'TopPagesByVisits') {
		&TopPagesByVisits;
	} elsif($ITEM eq 'TopPagesByVisitors') {
		&TopPagesByVisitors;
	} elsif($ITEM eq 'VisitorTrace') {
		&VisitorTrace;
	} elsif($ITEM eq 'ActivityByDayOfTheMonth') {
		&ActivityByDayOfTheMonth;
	} elsif($ITEM eq 'ActivityByDayOfTheWeek') {
		&ActivityByDayOfTheWeek;
	} elsif($ITEM eq 'ActivityByHourOfTheDay') {
		&ActivityByHourOfTheDay;
	} elsif($ITEM eq 'TopReferringSites') {
		&TopReferringSites;
	} elsif($ITEM eq 'TopReferringURLs') {
		&TopReferringURLs;
	} elsif($ITEM eq 'TopSearchKeywords') {
		&TopSearchKeywords;
	} elsif($ITEM eq 'TopSearchEngines') {
		&TopSearchEngines;
	} elsif($ITEM eq 'TopBrowsers') {
		&TopBrowsers;
	} elsif($ITEM eq 'TopPlatforms') {
		&TopPlatforms;
	} elsif($ITEM eq 'TopAcceptLanguage') {
		&TopAcceptLanguage;
	} elsif($ITEM eq 'TopResolution') {
		&TopResolution;
	} elsif($ITEM eq 'TopColorDepth') {
		&TopColorDepth;
	} elsif($ITEM eq 'TopVideoMemorySize') {
		&TopVideoMemorySize;
	} else {
		&ErrorPrint("�s���ȃ��N�G�X�g�ł��B");
	}
}

sub GeneralStatistics {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my $min_date = 99999999999999;
	my $max_date = 0;
	my(%all_date, %date, %remote_host, %cookies, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$cookies{$i} = $cookie_part;
		$max_date = $date_part;
		if($i == 0) {$min_date = $date_part;}
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);
	my $PageViewNum = $i;

	# ���Z�b�V�������𒲂ׂ�
	my $AllSessionNum = &GetSessionNum(\@LogNoList, \%date, \%remote_host, \%cookies);
	# �����j�[�N���[�U�[���𒲂ׂ�B
	my $AllUniqueUserNum = &GetUniqueUserNum(\@LogNoList, \%remote_host, \%cookies);
	my $PVperUser = 0;
	if($AllUniqueUserNum > 0) {
		$PVperUser = sprintf("%.2f", $PageViewNum / $AllUniqueUserNum);
	}
	# �����̃��O�ԍ����擾����
	my $Today = &GetToday;
	my @TodayLogNoList = ();
	for my $i (keys %date) {
		if($date{$i} =~ /^$Today/) {
			push(@TodayLogNoList, $i);
		}
	}
	my $TodayPV = @TodayLogNoList;
	my $TodaySessionNum = &GetSessionNum(\@TodayLogNoList, \%date, \%remote_host, \%cookies);
	my $TodayUniqueUserNum = &GetUniqueUserNum(\@TodayLogNoList, \%remote_host, \%cookies);
	my $TodayPVperUser;
	if($TodayUniqueUserNum > 0) {
		$TodayPVperUser = sprintf("%.2f", $TodayPV / $TodayUniqueUserNum);
	} else {
		$TodayPVperUser = 0;
	}
	my($min_year, $min_mon, $min_mday, $min_hour, $min_min, $min_sec);
	if($min_date != 99999999999999) {
		($min_year, $min_mon, $min_mday, $min_hour, $min_min, $min_sec) = $min_date =~ /^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/;
	}
	my($max_year, $max_mon, $max_mday, $max_hour, $max_min, $max_sec) = $max_date =~ /^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/;
	my @Keys = (
		'��͑Ώۊ���',
		'�y�[�W�r���[',
		'�Z�b�V������',
		'���j�[�N���[�U�[��',
		'��l������̃y�[�W�r���['
	);
	my %Data = (
		'��͑Ώۊ���' => "$min_year/$min_mon/$min_mday $min_hour:$min_min:$min_sec �` $max_year/$max_mon/$max_mday $max_hour:$max_min:$max_sec",
		'�y�[�W�r���[' => $PageViewNum,
		'�Z�b�V������' => $AllSessionNum,
		'���j�[�N���[�U�[��' => $AllUniqueUserNum,
		'��l������̃y�[�W�r���[' => $PVperUser
	);
	my $Str;
	$Str .= &MakeTable(\@Keys, \%Data);
	$Str .= "<hr>\n";
	$Str .= "<div>�{���̃A�N�Z�X��</div><br>\n";
	@Keys = (
		'�y�[�W�r���[',
		'�Z�b�V������',
		'���j�[�N���[�U�[��',
		'��l������̃y�[�W�r���['
	);
	%Data = (
		'�y�[�W�r���[' => $TodayPV,
		'�Z�b�V������' => $TodaySessionNum,
		'���j�[�N���[�U�[��' => $TodayUniqueUserNum,
		'��l������̃y�[�W�r���[' => $TodayPVperUser
	);
	$Str .= &MakeTable(\@Keys, \%Data);
	my $Title = '���v�T�v';
	&PrintResult($Title, $Str);
}


sub AccessLogInformation {
	# �ߋ����O���X�g���擾����
	my %LogList = ();
	unless($LOGDIR) {$LOGDIR = '.';}
	opendir(LOGDIR, "$LOGDIR") || &ErrorPrint("���O�i�[�f�B���N�g���u$LOGDIR�v���I�[�v���ł��܂���ł����B");
	my @log_namaes = readdir(LOGDIR);
	closedir(LOGDIR);
	my($key);
	for $key (@log_namaes) {
		if($key =~ /^$PRE_LOGNAME/) {
			$LogList{$key} = "$LOGDIR\/$key";
		}
	}

	my($Str);
	$Str .= "<form action=\"$CGI_URL\" method=\"POST\" target=\"_top\">\n";
	# ���O�t�@�C����
	my($LogListStr);
	$LogListStr .= "<select name=\"LOG\">\n";;
	for $key (sort(keys(%LogList))) {
		if($key eq $TARGET_LOGNAME) {
			$LogListStr .= "<option value=\"$key\" selected>$key</option>\n";
		} else {
			$LogListStr .= "<option value=\"$key\">$key</option>\n";
		}
	}
	$LogListStr .= "</select>\n";
	$LogListStr .= "<input type=\"submit\" VALUE=\"���O�ؑ�\" NAME=\"LOGSELECT\">\n";


	# ���O�t�@�C���T�C�Y��
	my $LogSize = &AnalyzeLogfileSize("$LOGDIR/$TARGET_LOGNAME");
	my $LogSizeStr = &CommaFormat($LogSize);
	$LogSizeStr .= " �o�C�g";

	# ���O���[�e�[�V�����T�C�Y��
	my $LogLotationStr;
	if($CONF{'LOTATION'} eq '0' || $CONF{'LOTATION'} eq '') {
		$LogLotationStr = '���[�e�[�V�������Ȃ�';
	} elsif($CONF{'LOTATION'} eq '1') {
		my $LogSizeRate = int($LogSize * 1000 / $CONF{'LOTATION_SIZE'}) / 10;
		if($LogSizeRate > 100) {$LogSizeRate = 100;}
		my $LogSizeGraphMaxLen = 150;	#�s�N�Z��
		my $LogSizeGraphLen = int($LogSizeGraphMaxLen * $LogSizeRate / 100);	#�s�N�Z��
		my $dsp_lotation_size = &CommaFormat($CONF{'LOTATION_SIZE'});
		$LogLotationStr .= "$dsp_lotation_size byte �Ń��[�e�[�V����<br>\n";
		$LogLotationStr .= "�i�g�p�� $LogSizeRate%�j\n";
		$LogLotationStr .= "<table border=\"0\" width=\"$LogSizeGraphMaxLen\" cellpadding=\"0\"><tr><td CLASS=ListHeader2 align=\"left\">\n";
		$LogLotationStr .= "<table border=\"0\" width=\"$LogSizeGraphLen\" cellpadding=\"0\"><tr><td CLASS=ListHeader3>&nbsp;</td></tr></table>\n";
		$LogLotationStr .= "</td></tr></table>\n";

		# �Ώۃ��O�̒����J�n���ƒ����I�����𒲂ׂ�
		if(-e "$LOGDIR/$TARGET_LOGNAME") {
			open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
		} else {
			&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
		}
		my $min_date = 99999999999999;
		my $max_date = 0;
		my $i = 0;
		while(<LOGFILE>) {
			chop;
			my($date_part);
			if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
				$date_part = $1;
			} else {
				next;
			}
			next if($date_part eq '');
			$max_date = $date_part;
			if($i == 0) {$min_date = $date_part;}
			$i ++;
		}
		close(LOGFILE);
		if($i) {
			my $RangeSec = &GetRangeSecond($min_date, $max_date);	# ���Ԃ�b�ɕϊ�
			my $RemainSec = int( ($CONF{'LOTATION_SIZE'} - $LogSize) * $RangeSec / $LogSize );
			my @DateParts = localtime(time + $CONF{'TIMEDIFF'}*60*60 + $RemainSec);
			$DateParts[5] += 1900;
			$DateParts[4] ++;
			for (my $i=0;$i<=5;$i++) {
				if($DateParts[$i] < 10) {$DateParts[$i] = "0$DateParts[$i]";}
			}
			my $DispRemainSec = &CommaFormat($RemainSec);
			$LogLotationStr .= "���[�e�[�V�����������<br>\n";
			$LogLotationStr .= "$DateParts[5]�N$DateParts[4]��$DateParts[3]�� $DateParts[2]:$DateParts[1]:$DateParts[0] �i���� $DispRemainSec �b�j";
		} else {
			$LogLotationStr .= '';
		}
	} elsif($CONF{'LOTATION'} eq '2') {
		$LogLotationStr = '�����ƂɃ��[�e�[�V����';
	} elsif($CONF{'LOTATION'} eq '3') {
		$LogLotationStr = '�����ƂɃ��[�e�[�V����';
	} elsif($CONF{'LOTATION'} eq '4') {
		$LogLotationStr = '�T���ƂɃ��[�e�[�V����';
	}

	#���O�ꗗ
	my(%size_list, %mtime_list);
	for my $file (sort keys %LogList) {
		my @stat = stat("$LOGDIR/$file");
		$size_list{$file} = $stat[7];
		$mtime_list{$file} = $stat[9];
	}
	my $LogAllListStr;
	foreach my $file (ValueSort(\%mtime_list)) {
		my $date = &ConvEpoc2Date($mtime_list{$file});
		my $dsp_size = &CommaFormat($size_list{$file});
		$LogAllListStr .= "  <tr>\n";
		$LogAllListStr .= "    <td class=\"ListHeader4\">$file</td>\n";	#�t�@�C����
		$LogAllListStr .= "    <td class=\"ListHeader4\" align=\"right\">$dsp_size byte</td>\n";	#�T�C�Y
		$LogAllListStr .= "    <td class=\"ListHeader4\">$date</td>\n";	#�ŏI�X�V����
		if($file eq $TARGET_LOGNAME) {
			$LogAllListStr .= "    <td class=\"ListHeader4\" align=\"center\">�I��</td>\n";		#���O�ؑ�
		} else {
			$LogAllListStr .= "    <td class=\"ListHeader4\" align=\"center\"><a href=\"$CGI_URL?LOG=$file\" target=\"_top\">���</a></td>\n";		#���O�ؑ�
		}
		$LogAllListStr .= "  </tr>\n";
	}

	my $html = &ReadTemplate("./template/loginfo.html");
	$html =~ s/\$CGIURL\$/$CGI_URL/;
	$html =~ s/\$LOGFILE\$/$LogListStr/;
	$html =~ s/\$LOGSIZE\$/$LogSizeStr/;
	$html =~ s/\$LOGLOTATION\$/$LogLotationStr/;
	$html =~ s/\$LOGALLLIST\$/$LogAllListStr/;
	print "Content-type: text/html; charset=Shift_JIS\n\n";
	print "$html\n";
	exit;
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

sub LogSearchForm {
	my $html = &ReadTemplate("$TEMPLATEDIR/search.html");
	my $log = $q->param('LOG');
	my $hidden;
	$hidden .= "<input type=\"hidden\" name=\"LOG\" value=\"$log\">\n";
	$hidden .= "<input type=\"hidden\" name=\"ITEM\" value=\"LogSearchGo\">\n";
	$hidden .= "<input type=\"hidden\" name=\"FRAME\" value=\"result\">\n";
	$html =~ s/\$CGI_URL\$/$CGI_URL/;
	$html =~ s/\$HIDDEN\$/$hidden/;
	$html =~ s/\$MODE1\$/checked/;
	$html =~ s/\$MODE2\$//;
	$html =~ s/\$DATE0\$/checked/;
	$html =~ s/\$DATE1\$//;
	$html =~ s/\$(S|E)(YEAR|MON|DAY)\$//g;
	$html =~ s/\$QSTRING\$//;
	$html =~ s/\$DISPNUM\$/20/;
	$html =~ s/\$HITNUM\$//g;
	$html =~ s/\$DISP_MODE0\$//;
	$html =~ s/\$DISP_MODE1\$/checked/;
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$html\n";
	exit;
}

sub  LogSearchGo {
	my $mode = $q->param('MODE');
	my $date_opt = $q->param('DATE');
	my $syear = $q->param('SYEAR');
	my $eyear = $q->param('EYEAR');
	my $smon = $q->param('SMON');
	my $emon = $q->param('EMON');
	my $sday = $q->param('SDAY');
	my $eday = $q->param('EDAY');
	my $qstring = $q->param('QSTRING');
	my $disp_mode = $q->param('DISP_MODE');
	my $dispnum = $q->param('DISPNUM');
	my $next = $q->param('NEXT');
	unless($next) {$next = 1;}
	if($mode eq '') {
		$mode = '1';
	} elsif($mode !~ /^(1|2)$/) {
		&ErrorPrint("�s���ȃA�N�Z�X�ł��B");
	}
	if($date_opt) {
		unless($syear && $smon && $sday) {
			&ErrorPrint("���t���w�肵�ĉ������B");
		}
	}
	my @date_nums = ($syear, $smon, $sday, $eyear, $emon, $eday);
	my @conv = ();
	for my $num (@date_nums) {
		&jcode::tr(\$num, '�O-�X', '0-9');
		if($num =~ /[^0-9]/) {
			&ErrorPrint("���t�͐����Ŏw�肵�ĉ������B");
		}
		$num =~ s/^0+//;
		if($num eq '') {$num = "0";}
		if($num < 10) {$num = "0$num";}
		push(@conv, $num);
	}
	my $start = "$conv[0]$conv[1]$conv[2]";
	my $end = "$conv[3]$conv[4]$conv[5]";
	if($disp_mode eq '') {
		$disp_mode = '1';
	}
	if($disp_mode !~ /^(0|1)$/) {
		&ErrorPrint("�s���ȃA�N�Z�X�ł��B");
	}

	&jcode::tr(\$dispnum, '�O-�X', '0-9');
	if($dispnum =~ /[^0-9]/) {
		&ErrorPrint("�\�������͐����Ŏw�肵�ĉ������B");
	}
	unless($dispnum) {$dispnum = 100;}
	if($next eq '') {$next = 0;}
	if($date_opt) {$end = $start;}
	if($start > $end) {
		&ErrorPrint("�����J�n���́A�����I�������O�̓����w�肵�ĉ������B");
	}
	my $qstring_secure = &SecureHtml($qstring);
	$qstring =~ s/([\+\.\[\]\(\)\$\@\?\\\-\^\|\*\{\}\/])/\\$1/g;
	$qstring =~ s/\s+/ /g;
	$qstring =~ s/^\s//;
	$qstring =~ s/\s$//;
	my @q_parts = split(/\s/, $qstring);
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my @search_list = ();
	my $hitnum = 0;

	if($mode eq '1') {
		#���߂̃��O�����������\������
		while(<LOGFILE>) {
			chop;
			my $line = $_;
			if($date_opt) {
				$line =~ m/^(\S+)\s/;
				my $access_date = $1;
				$access_date = substr($access_date, 0, 8);
				unless($access_date >= $start && $access_date <= $end) {next;}
			}
			my $q_flag = 1;
			if(@q_parts) {
				for my $key (@q_parts) {
					unless($line =~ /$key/i) {
						$q_flag = 0;
					}
				}
			}
			unless($q_flag) {next;}
			$hitnum ++;
			my $array_num = scalar @search_list;
			if($array_num >= $dispnum) {
				shift @search_list;
			}
			push(@search_list, $line);
		}
		close(LOGFILE);
	} else {
		#���O�̐擪���珇�������\������
		while(<LOGFILE>) {
			chop;
			my $line = $_;
			if($date_opt) {
				$line =~ m/^(\S+)\s/;
				my $access_date = $1;
				$access_date = substr($access_date, 0, 8);
				unless($access_date >= $start && $access_date <= $end) {next;}
			}
			my $q_flag = 1;
			if(@q_parts) {
				for my $key (@q_parts) {
					unless($line =~ /$key/i) {
						$q_flag = 0;
					}
				}
			}
			unless($q_flag) {next;}
			$hitnum ++;
			if($hitnum < $next) {next;}
			my $array_num = scalar @search_list;
			if($array_num >= $dispnum) {
				next;
			}
			push(@search_list, $line);
		}
		close(LOGFILE);
	}
	my $html_all = &ReadTemplate("$TEMPLATEDIR/search.html");
	my($html) = split(/<!-- delimiter -->/, $html_all);
	my $log = $q->param('LOG');
	my $hidden;
	$hidden .= "<input type=\"hidden\" name=\"LOG\" value=\"$log\">\n";
	$hidden .= "<input type=\"hidden\" name=\"ITEM\" value=\"LogSearchGo\">\n";
	$hidden .= "<input type=\"hidden\" name=\"FRAME\" value=\"result\">\n";
	$html =~ s/\$CGI_URL\$/$CGI_URL/;
	$html =~ s/\$HIDDEN\$/$hidden/;
	$html =~ s/\$MODE$mode\$/checked/;
	$html =~ s/\$MODE[0-9]+$//g;
	$html =~ s/\$DATE$date_opt\$/checked/;
	$html =~ s/\$DATE[0-9]+$//g;
	$html =~ s/\$SYEAR\$/$syear/;
	$html =~ s/\$EYEAR\$/$eyear/;
	$html =~ s/\$SMON\$/$smon/;
	$html =~ s/\$EMON\$/$emon/;
	$html =~ s/\$SDAY\$/$sday/;
	$html =~ s/\$EDAY\$/$eday/;
	$html =~ s/\$DISPNUM\$/$dispnum/;
	$html =~ s/\$DISP_MODE${disp_mode}\$/checked/;
	$html =~ s/\$DISP_MODE[0-9]+\$//g;
	$html =~ s/\$QSTRING\$/$qstring_secure/;
	$html =~ s/\$HITNUM\$/�������� �F$hitnum ��/g;
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$html\n";
	my $n;
	if($mode eq '1') {
		$n = $hitnum - $dispnum + 1;
		if($n <= 0) {$n = 1;}
	} else {
		$n = $next;
	}
	for my $line (@search_list) {
		&jcode::convert(\$line, 'sjis');
		if($n % 2) {
			print "<div class=\"style1\">";
		} else {
			print "<div class=\"style2\">";
		}
		if($disp_mode) {
			my @parts = $line =~ /^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/;
			my $date    = $parts[0];
			my $host    = $parts[1];
			my $cookie  = $parts[2];
			my $req     = $parts[4];
			my $ref     = $parts[5];
			my $ua      = $parts[6];
			my $lang    = $parts[7];
			my $display = $parts[8];
			#���t�𐮌`
			my $date_Y = substr($date,  0, 4);
			my $date_M = substr($date,  4, 2);
			my $date_D = substr($date,  6, 2);
			my $date_h = substr($date,  8, 2);
			my $date_m = substr($date, 10 ,2);
			my $date_s = substr($date, 12, 2);
			#�f�B�X�v���[�𑜓x�𐮌`
			my($display_w, $display_h, $display_d) = split(/\s/, $display);
			#HTTP_USER_AGENT���T�j�^�C�W���O
			$ua = &SecureHtml($ua);
			#���ʏo��
			print "<div style=\"font-weight:bold\">$n</div>\n";
			print "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\">\n";
			print "<tr><td valign=\"top\">�A�N�Z�X����</td><td width=\"20\" align=\"center\" valign=\"top\">:</td><td><tt>${date_Y}/${date_M}/${date_D} ${date_h}:${date_m}:${date_s}</tt></td></tr>\n";
			print "<tr><td valign=\"top\">�z�X�g��</td><td width=\"20\" align=\"center\" valign=\"top\">:</td><td><tt>${host}</tt></td></tr>\n";
			print "<tr><td valign=\"top\">���j�[�N�L�[</td><td width=\"20\" align=\"center\" valign=\"top\">:</td><td><tt>${cookie}</tt></td></tr>\n";
			print "<tr><td valign=\"top\">�A�N�Z�X�y�[�W</td><td width=\"20\" align=\"center\" valign=\"top\">:</td><td><tt>${req}</tt></td></tr>\n";
			print "<tr><td valign=\"top\">�����N��URL</td><td width=\"20\" align=\"center\" valign=\"top\">:</td><td><tt>${ref}</tt></td></tr>\n";
			print "<tr><td valign=\"top\">USER_AGENT</td><td width=\"20\" align=\"center\" valign=\"top\">:</td><td><tt>${ua}</tt></td></tr>\n";
			print "<tr><td valign=\"top\">ACCEPT_LANGUAGE</td><td width=\"20\" align=\"center\" valign=\"top\">:</td><td><tt>${lang}</tt></td></tr>\n";
			print "<tr><td valign=\"top\">�f�B�X�v���[�𑜓x</td><td width=\"20\" align=\"center\" valign=\"top\">:</td><td><tt>${display_w} x ${display_h} x ${display_d}</tt></td></tr>\n";
			print "</table>\n";
		} else {
			$line = &SecureHtml($line);
			print "<b>$n :</b> <tt>$line</tt>";
		}
		print "</div>\n";
		$n ++;
	}
	if($mode eq '2') {
		print "<HR>\n";
		my $next_tag_num = $n;
		my $prev_tag_num = $next - $dispnum;
		print "<table border=\"0\" width=\"100%\"><tr>\n";
		print "  <td align=\"left\">";
		if($prev_tag_num > 0) {
			#�O�ւ�\��
			print "<a href=\"$CGI_URL\?LOG=$log&ITEM=LogSearchGo&FRAME=result&MODE=${mode}&DATE=${date_opt}&SYEAR=${syear}&EYEAR=${eyear}&SMON=${smon}&EMON=${emon}&SDAY=${sday}&EDAY=${eday}&QSTRING=${qstring_secure}&DISPNUM=${dispnum}&DISP_MODE=${disp_mode}&NEXT=${prev_tag_num}\">&lt;&lt;�O��</a>\n";
		}
		print "  </td>\n";
		print "  <td align=\"right\">";
		if($next_tag_num <= $hitnum) {
			#���ւ�\��
			print "<a href=\"$CGI_URL\?LOG=$log&ITEM=LogSearchGo&FRAME=result&MODE=${mode}&DATE=${date_opt}&SYEAR=${syear}&EYEAR=${eyear}&SMON=${smon}&EMON=${emon}&SDAY=${sday}&EDAY=${eday}&QSTRING=${qstring_secure}&DISPNUM=${dispnum}&DISP_MODE=${disp_mode}&NEXT=${next_tag_num}\">����&gt;&gt;</a>\n";
		}
		print "  </td>\n";
		print "</tr></table>\n";
	}

	print "</BODY></HTML>\n";
	exit;
}

sub TopVisitors {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%all_date, %date, %remote_host, %cookies, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %HostLogNoList = ();	
	for my $i (keys(%remote_host)) {
		$HostLogNoList{$remote_host{$i}} .= "$i,";
	}
	my($HostName, @NoList, $Views, $Sessions, $KeyStr);
	my %SessionNumList = ();
	my %PageViewNumList = ();
	for $HostName (keys(%HostLogNoList)) {
		$KeyStr = "<a href=\"$CGI_URL?FRAME=result&ITEM=VisitorTrace&LOG=$TARGET_LOGNAME&VISITOR=$HostName";
		if($ANA_MONTH) {
			$KeyStr .= "&MONTH=$ANA_MONTH";
			if($ANA_DAY) {
				$KeyStr .= "&DAY=$ANA_DAY";
			}
		}
		$KeyStr .= "\">";
		$KeyStr .= "$HostName";
		$KeyStr .= "</a>";
		$HostLogNoList{$HostName} =~ s/,$//;
		@NoList = split(/,/, $HostLogNoList{$HostName});
		$Views = @NoList;
		$PageViewNumList{$KeyStr} = $Views;
		$Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$KeyStr} = $Sessions;
	}
	my($Str);
	$Str .= "�y�[�W�r���[<br>\n";
	my @Titles = ('����', '�A�N�Z�X���z�X�g��', '�y�[�W�r���[', '�O���t');
	$Str .= &MakeGraph(\%PageViewNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
	@Titles = ('����', '�A�N�Z�X���z�X�g��', '�K�␔', '�O���t');
	$Str .= &MakeGraph(\%SessionNumList, \@Titles);
	my $Title = '�A�N�Z�X���z�X�g�������L���O';
	&PrintResult($Title, $Str);
}


sub MostActiveCountries {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%all_date, %date, %remote_host, %cookies, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %CountryLogNoList = ();
	my %IpList = &ReadIpList;
	for my $i (keys %remote_host) {
		my $domain;
		if($remote_host{$i} =~ /[^0-9\.]/) {
			$domain = $remote_host{$i};
		} else {
			$domain = &GetDomainByAddr($remote_host{$i}, \%IpList);
		}
		if($domain) {
			my @parts = split(/\./, $domain);
			my $tl = pop @parts;
			$tl = lc $tl;
		  	$CountryLogNoList{$tl} .= "$i,";
		} else {
			$CountryLogNoList{'?'} .= "$i,";
		}
	}
	my(@NoList, $Views, $Sessions, $Unique);
	my %SessionNumList = ();
	my %PageViewNumList = ();
	my %UniqueNumList = ();
	my $tld;
	for $tld (keys %CountryLogNoList) {
		$CountryLogNoList{$tld} =~ s/,$//;
		@NoList = split(/,/, $CountryLogNoList{$tld});
		$Views = @NoList;
		$PageViewNumList{$tld} = $Views;
		$Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$tld} = $Sessions;
		$Unique = &GetUniqueUserNum(\@NoList, \%remote_host, \%cookies);
		$UniqueNumList{$tld} = $Unique;
	}
	my $Str;
	my %TldList = &ReadDef('./data/country_code.dat');
	$Str .= "�y�[�W�r���[<br>\n";
	$Str .= &MakeCircleGraph(\%PageViewNumList);
	$Str .= "<br>\n";
	my @Titles = ('����', 'TLD', '����', '�y�[�W�r���[', '�O���t');
	$Str .= &MakeGraph2(\%PageViewNumList, \@Titles, \%TldList);
	$Str .= "<hr>\n";
	$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
	$Str .= &MakeCircleGraph(\%SessionNumList);
	$Str .= "<br>\n";
	@Titles = ('����', 'TLD', '����', '�K�␔', '�O���t');
	$Str .= &MakeGraph2(\%SessionNumList, \@Titles, \%TldList);
	$Str .= "<hr>\n";
	$Str .= "�K��Ґ��i���j�[�N���[�U�[���j<br>\n";
	$Str .= &MakeCircleGraph(\%UniqueNumList);
	$Str .= "<br>\n";
	@Titles = ('����', 'TLD', '����', '�K��Ґ�', '�O���t');
	$Str .= &MakeGraph2(\%UniqueNumList, \@Titles, \%TldList);
	my $Title = '�A�N�Z�X�������iTLD�j�����L���O';
	&PrintResult($Title, $Str);
}

sub GetPrefCodeMap {
	my %pref_code_map;
	open(MAP, "./data/pref_code.dat") || &ErrorPrint("./data/pref_code.dat �̓ǂݎ��Ɏ��s���܂����B: $!");
	while(<MAP>) {
		if(/^([^\t]+)\t(.+)/) {
			$pref_code_map{$1} = $2;
		}
	}
	close(MAP);
	return %pref_code_map;
}

sub GetPrefList {
	my %pref_list;
	open(LIST, "./data/pref.dat") || &ErrorPrint("./data/pref.dat �̓ǂݎ��Ɏ��s���܂����B: $!");
	while(<LIST>) {
		if(/^([^\t]+)\t(.+)/) {
			$pref_list{$1} = $2;
		}
	}
	close(LIST);
	return %pref_list;
}

sub MostActivePrefecture {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my %pref_code_map = &GetPrefCodeMap;
	my $i = 0;
	my(%all_date, %date, %remote_host, %cookies, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %OrgList = &ReadDef('./data/organization.dat');
	my %PrefList = &GetPrefList;
	my %IpList = &ReadIpList;

	my %PrefLogNoList = ();
	my($Str1, $Str2, $GetPref);
	for my $i (keys %remote_host) {
		$GetPref = '';
		my $host = lc $remote_host{$i};
		if($host =~ /[^0-9\.]/) {
			my $PrefKeyword = &GetPrefKeyword($host);
			if($PrefKeyword) {
				my $code = $PrefList{$PrefKeyword};
				$GetPref = $pref_code_map{$code};
			} else {
				$host =~ m/([\w\-]+\.[\w\-]+\.[\w\-]+)$/;
				my $domain = $1;
				($Str1, $Str2, $GetPref) = split(/,/, $OrgList{$domain});
				unless($GetPref) {
					$host =~ m/([\w\-]+\.[\w\-]+)$/;
					($Str1, $Str2, $GetPref) = split(/,/, $OrgList{$domain});
				}
			}
			unless($GetPref) {next;}
			$PrefLogNoList{$GetPref} .= "$i,";
		} else {
			my $domain = &GetDomainByAddr($host, \%IpList);
			($Str1, $Str2, $GetPref) = split(/,/, $OrgList{$domain});
			unless($GetPref) {next;}
			$PrefLogNoList{$GetPref} .= "$i,";
		}
	}
	my($Pref, @NoList, $Views, $Sessions, $Unique);
	my %SessionNumList = ();
	my %PageViewNumList = ();
	my %UniqueNumList = ();
	for $Pref (keys %PrefLogNoList) {
		$PrefLogNoList{$Pref} =~ s/,$//;
		@NoList = split(/,/, $PrefLogNoList{$Pref});
		$Views = @NoList;
		$PageViewNumList{$Pref} = $Views;
		$Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$Pref} = $Sessions;
		$Unique = &GetUniqueUserNum(\@NoList, \%remote_host, \%cookies);
		$UniqueNumList{$Pref} = $Unique;
	}
	my $Str = '';
	$Str .= "�y�[�W�r���[<br>\n";
	$Str .= &MakeCircleGraph(\%PageViewNumList);
	$Str .= "<br>\n";
	my @Titles = ('����', '�s���{����', '�y�[�W�r���[', '�O���t');
	$Str .= &MakeGraph(\%PageViewNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
	$Str .= &MakeCircleGraph(\%SessionNumList);
	$Str .= "<br>\n";
	@Titles = ('����', '�s���{����', '�K�␔', '�O���t');
	$Str .= &MakeGraph(\%SessionNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K��Ґ��i���j�[�N���[�U�[���j<br>\n";
	$Str .= &MakeCircleGraph(\%UniqueNumList);
	$Str .= "<br>\n";
	@Titles = ('����', '�s���{����', '�K��Ґ�', '�O���t');
	$Str .= &MakeGraph(\%UniqueNumList, \@Titles);
	my $Title = '�A�N�Z�X���s���{�������L���O';
	&PrintResult($Title, $Str);
}


sub MostActiveOrganization {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%all_date, %date, %remote_host, %cookies, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);
	my %OrgLogNoList = ();
	my %IpList = &ReadIpList;
	for my $i (keys %remote_host) {
		my $host = lc $remote_host{$i};
		if($host =~ /[^0-9\.]/) {
			my $org_domain = &GetDomainByHostname($host);
			$OrgLogNoList{"$org_domain"} .= "$i,";
		} else {
			my $domain = &GetDomainByAddr($host, \%IpList);
			$OrgLogNoList{$domain} .= "$i,";
		}
	}
	my($Org, @NoList, $Views, $Sessions, $Unique);
	my %SessionNumList = ();
	my %PageViewNumList = ();
	my %UniqueNumList = ();
	for $Org (keys %OrgLogNoList) {
		$OrgLogNoList{$Org} =~ s/,$//;
		@NoList = split(/,/, $OrgLogNoList{$Org});
		$Views = @NoList;
		$PageViewNumList{$Org} = $Views;
		$Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$Org} = $Sessions;
		$Unique = &GetUniqueUserNum(\@NoList, \%remote_host, \%cookies);
		$UniqueNumList{$Org} = $Unique;
	}
	my %OrgList = &ReadDef('./data/organization.dat');
	my($Str1, $Str2, $Domain);
	for $Domain (keys %OrgList) {
		($Str1, $Str2) = split(/,/, $OrgList{$Domain});
		if($Str2) {
			$OrgList{$Domain} = "$Str1<br><div class=\"size2\">�i$Str2�j";
		} else {
			$OrgList{$Domain} = "$Str1";
		}
	}
	my $Str = '';
	$Str .= "�y�[�W�r���[<br>\n";
	my @Titles = ('����', '�h���C����', '�g�D��', '�y�[�W�r���[', '�O���t');
	$Str .= &MakeGraph2(\%PageViewNumList, \@Titles, \%OrgList);
	$Str .= "<hr>\n";
	$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
	@Titles = ('����', '�h���C����', '�g�D��', '�K�␔', '�O���t');
	$Str .= &MakeGraph2(\%SessionNumList, \@Titles, \%OrgList);
	$Str .= "<hr>\n";
	$Str .= "�K��Ґ��i���j�[�N���[�U�[���j<br>\n";
	@Titles = ('����', '�h���C����', '�g�D��', '�K��Ґ�', '�O���t');
	$Str .= &MakeGraph2(\%UniqueNumList, \@Titles, \%OrgList);
	my $Title = '�A�N�Z�X���g�D�������L���O';
	&PrintResult($Title, $Str);
}

sub GetDomainByAddr {
	my($addr, $list_ref) = @_;
	$addr =~ m/^([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)$/;
	my $bin = unpack("B32", pack("c4", $1, $2, $3, $4));
	my $flag = 0;
	for my $mask_bin (keys %$list_ref) {
		if($bin =~ /^$mask_bin/) {
			return $$list_ref{$mask_bin};
			last;
		} else {
			next;
		}
	}
	return '?';
}

sub ReadIpList {
	open(IP, './data/ipaddr.dat') || &ErrorPrint("IP�A�h���X�f�[�^�t�@�C�� ipaddr.dat ���I�[�v���ł��܂���ł����B : $!");
	my %ip_list;
	while(<IP>) {
		chop;
		if(/^([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)(\/([0-9]+))*\=(.+)$/) {
			my $ip1 = $1;
			my $ip2 = $2;
			my $ip3 = $3;
			my $ip4 = $4;
			my $mask = $6;
			my $domain = $7;
			my $bin = unpack("B32", pack("c4", $ip1, $ip2, $ip3, $ip4));
			unless($mask) {
				if($ip4 eq '0') {
					$mask = '24';
				} else {
					$mask = 32;
				}
			}
			my $mask_bin = substr($bin, 0, $mask);
			$ip_list{$mask_bin} = $domain;
		} else {
			next;
		}
	}
	close(IP);
	return %ip_list;
}

sub NewVsReturningVisitors {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my $min_date = 99999999999999;
	my $max_date = 0;
	my(%remote_host, %cookies, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
		} else {
			next;
		}
		next if($date_part eq '');
		next unless(&IsInDate($date_part));
		$remote_host{$i} = $host_part;
		$cookies{$i} = $cookie_part;
		$max_date = $date_part;
		if($i == 0) {$min_date = $date_part;}
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %RepeaterCookies = ();
	my(@CookieParts, $AccessDate, $Sec, $Min, $Hour, $Day, $Mon, $Year);
	for my $i (keys %cookies) {
		@CookieParts = split(/\./, $cookies{$i});
		($Sec, $Min, $Hour, $Day, $Mon, $Year) = localtime($CookieParts[4] + $CONF{'TIMEDIFF'}*60*60);
		$Year += 1900;
		$Mon ++;
		if($Mon < 10) {$Mon = "0$Mon";}
		if($Day < 10) {$Day = "0$Day";}
		if($Hour < 10) {$Hour = "0$Hour";}
		if($Min < 10) {$Min = "0$Min";}
		if($Sec < 10) {$Sec = "0$Sec";}
		$AccessDate = $Year.$Mon.$Day.$Hour.$Min.$Sec;
		if($AccessDate < $min_date) {
			$RepeaterCookies{$cookies{$i}} ++;
		}
	}

    # �����j�[�N���[�U�[���𒲂ׂ�B
    my $AllUniqueUserNum = &GetUniqueUserNum(\@LogNoList, \%remote_host, \%cookies);
	my($RepeaterUserNum);
	$RepeaterUserNum = scalar keys %RepeaterCookies;

	my @Keys = (
		'���߂Ă̖K��Ґ�',
		'���s�[�^�[�K��Ґ�',
		'���K��Ґ�'
	);
	my %Data = (
		'���߂Ă̖K��Ґ�' => $AllUniqueUserNum - $RepeaterUserNum,
		'���s�[�^�[�K��Ґ�' => $RepeaterUserNum,
		'���K��Ґ�' => $AllUniqueUserNum
	);
	my($Str);
	$Str .= &MakeTable(\@Keys, \%Data);
	$Str .= "<hr>\n";

	%Data = ('���߂Ă̖K���'=>$AllUniqueUserNum - $RepeaterUserNum, '���s�[�^�['=>$RepeaterUserNum);
	$Str .= &MakeCircleGraph(\%Data);
	my $Title = '���s�[�^�[�䗦����';
	&PrintResult($Title, $Str);
}

sub TopPagesByViews {
	&AnalyzeRequestResource('view');
} 

sub TopPagesByVisits {
	&AnalyzeRequestResource('session');
} 

sub TopPagesByVisitors {
	&AnalyzeRequestResource('unique');
}
	
sub AnalyzeRequestResource {
	my($MODE) = @_;
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%all_date, %date, %remote_host, %cookies, %request, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part, $request_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
			$request_part = $5;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		if($request_part =~ /^http:\/\/[^\/]+$/) {
			$request_part .= '/';
		}
		$request_part =~ s/\%7E/\~/ig;
		if($CONF{'URLHANDLE'}) {
			$request_part =~ s/\?.*$//;
		}
		$request{$i} = $request_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %LogNoListBuff = ();	
	for my $i (keys %request) {
		my($HtmlFilePath, $Index, $HitFlag, $FileTest, $uri, $RequestPath);
		if($request{$i} eq '' || $request{$i} eq '-') {next;}
		if($request{$i} =~ /\/$/) {
			unless($request{$i}) {next;}
			$_ = $request{$i};
			m|https*://[^/]+/(.*)|;
			$RequestPath = '/'.$1;
			if($CONF{'URL2PATH_FLAG'}) {
				my $key;
				for $key (keys %URL2PATH) {
					if($request{$i} =~ /^$key/) {
						$HtmlFilePath = $request{$i};
						$HtmlFilePath =~ s/^$key/$URL2PATH{$key}/;
						last;
					}
				}
			} else {
				$HtmlFilePath = $ENV{'DOCUMENT_ROOT'}.$RequestPath;
			}

			$HitFlag = 0;
			for $Index (@DIRECTORYINDEX) {
				$FileTest = $HtmlFilePath.$Index;
				if(-e $FileTest) {
					$uri = $request{$i}.$Index;
					$HitFlag = 1;
					last;
				}
			}
			unless($HitFlag) {$uri = $request{$i};}
		} else {
		    $uri = $request{$i};
		}
		$LogNoListBuff{$uri} .= "$i,";
	}
	my($HtmlTitle);
	my %LogNoList = ();
	my %ManualTitle = &ReadTitleDat;
	for my $uri (keys %LogNoListBuff) {
		my $HtmlTitle = $ManualTitle{$uri};
		unless($HtmlTitle) {
			$HtmlTitle = &GetHtmlTitle("$uri");
		}
		unless($HtmlTitle) {$HtmlTitle = '<i>�s��</i>'}
		my $disp_uri = $uri;
		if(length($disp_uri) > 70) {
			$disp_uri = substr($disp_uri, 0, 70);
			$disp_uri .= '...';
		}
		$LogNoList{"$HtmlTitle<br><div class=\"size2\"><a href=\"$uri\" target=\"blank\">$disp_uri</a></div>"} = $LogNoListBuff{$uri};
	}
	my(@NoList, $Views, $Sessions, $Unique);
	my %SessionNumList = ();
	my %PageViewNumList = ();
	my %UniqueNumList = ();
	for my $Path (keys %LogNoList) {
		$LogNoList{$Path} =~ s/,$//;
		@NoList = split(/,/, $LogNoList{$Path});
		if($MODE eq 'view') {
			$Views = @NoList;
			$PageViewNumList{$Path} = $Views;
		} elsif($MODE eq 'session') {
			$Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
			$SessionNumList{$Path} = $Sessions;
		} elsif($MODE eq 'unique') {
			$Unique = &GetUniqueUserNum(\@NoList, \%remote_host, \%cookies);
			$UniqueNumList{$Path} = $Unique;
		}
	}
	my($Str, $Title);
	if($MODE eq 'view') {
		$Str .= "�y�[�W�r���[<br>\n";
		my(@Titles) = ('����', '�y�[�W', '�y�[�W�r���[', '�O���t');
		$Str .= &MakeGraph(\%PageViewNumList, \@Titles);
		$Title = '�A�N�Z�X�y�[�W�����L���O�i�y�[�W�r���[��́j';
	} elsif($MODE eq 'session') {
		$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
		my(@Titles) = ('����', '�y�[�W', '�K�␔', '�O���t');
		$Str .= &MakeGraph(\%SessionNumList, \@Titles);
		$Title = '�A�N�Z�X�y�[�W�����L���O�i�Z�b�V��������́j';
	} elsif($MODE eq 'unique') {
		$Str .= "�K��Ґ��i���j�[�N���[�U�[���j<br>\n";
		my(@Titles) = ('����', '�y�[�W', '�K��Ґ�', '�O���t');
		$Str .= &MakeGraph(\%UniqueNumList, \@Titles);
		$Title = '�A�N�Z�X�y�[�W�����L���O�i�K��Ґ���́j';
	}

	&PrintResult($Title, $Str);
}

sub VisitorTrace {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%all_date, %date, %remote_host, %request, %referer, %user_agent, %screen, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $request_part, $referer_part, $ua_part, $accept_lang_part, $screen_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$request_part = $5;
			$referer_part = $6;
			$ua_part = $7;
			$accept_lang_part = $8;
			$screen_part = $9;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		if($TARGET_VISITOR) {
			if($host_part eq $TARGET_VISITOR) {
				$request{$i} = $request_part;
				$referer{$i} = $referer_part;
				$user_agent{$i} = $ua_part;
				$screen{$i} = $screen_part;
			}
		}
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my $TraceDomain = $q->param('TRACEDOMAIN');
	my %VisitorList = ();
	for my $i (keys(%remote_host)) {
		$VisitorList{$remote_host{$i}} ++;
	}
	my($PrintStr);
	$PrintStr .= "<form action=\"$CGI_URL\" method=\"POST\" target=\"_self\">\n";
	$PrintStr .= "<input type=\"hidden\" name=\"FRAME\" value=\"result\">\n";
	$PrintStr .= "<input type=\"hidden\" name=\"ITEM\" value=\"VisitorTrace\">\n";
	$PrintStr .= "<input type=\"hidden\" name=\"LOG\" value=\"$TARGET_LOGNAME\">\n";
	$PrintStr .= "<input type=\"hidden\" name=\"TRACEDOMAIN\" value=\"$TraceDomain\">\n";
	if($ANA_MONTH) {
		$PrintStr .= "<input type=\"hidden\" name=\"MONTH\" value=\"$ANA_MONTH\">\n";
		if($ANA_DAY) {
			$PrintStr .= "<input type=\"hidden\" name=\"DAY\" value=\"$ANA_DAY\">\n";
		}
	}

	$PrintStr .= "<select size=\"1\" name=\"VISITOR\">\n";
	$PrintStr .= "<option value=\"\">�z�X�g��I�����ĉ�����</option>\n";
	my $visitor;
	foreach $visitor (ValueSort(\%VisitorList)) {
		if($TraceDomain) {
			unless($visitor =~ /$TraceDomain/) {next;}
		}
		$PrintStr .= "<option value=\"$visitor\"";
		if($visitor eq $TARGET_VISITOR) {
			$PrintStr .= " selected";
		}
		$PrintStr .= ">$visitor ($VisitorList{$visitor})</option>\n";
	}
	$PrintStr .= "</select>\n";
	$PrintStr .= "<input type=\"submit\" value=\"�ǐ�\" name=\"B1\">\n";
	$PrintStr .= "</form>\n";

	$PrintStr .= "<form action=\"$CGI_URL\" method=\"POST\" target=\"_self\">\n";
	$PrintStr .= "<input type=\"hidden\" name=\"FRAME\" value=\"result\">\n";
	$PrintStr .= "<input type=\"hidden\" name=\"ITEM\" value=\"VisitorTrace\">\n";
	$PrintStr .= "<input type=\"hidden\" name=\"LOG\" value=\"$TARGET_LOGNAME\">\n";
	if($ANA_MONTH) {
		$PrintStr .= "<input type=\"hidden\" name=\"MONTH\" value=\"$ANA_MONTH\">\n";
		if($ANA_DAY) {
			$PrintStr .= "<input type=\"hidden\" name=\"DAY\" value=\"$ANA_DAY\">\n";
		}
	}
	$PrintStr .= "<table border=\"0\"><tr>\n";
	$PrintStr .= "<td>�h���C��������i���݌���</td>\n";
	$PrintStr .= "<td><input type=\"text\" name=\"TRACEDOMAIN\" value=\"$TraceDomain\"></td>\n";
	$PrintStr .= "<td><input type=\"submit\" value=\"����\"></td>\n";
	$PrintStr .= "</tr></table>\n";
	$PrintStr .= "</form>\n";

	if($TARGET_VISITOR) {
		$PrintStr .= "<hr>\n";
		$PrintStr .= "�� �K��ҏ��<br>\n";
		my($i, $UserAgent, $ScreenInfo, $FirstNo);
		my $FirstFlag = 0;
		for $i (sort{$a <=> $b} keys %request) {
			unless($FirstFlag) {
				$FirstNo = $i;
				$FirstFlag = 1;
			}
			$UserAgent = $user_agent{$i};
			$ScreenInfo = $screen{$i};
			unless($ScreenInfo) {
				$ScreenInfo = '&nbsp;';
			} else {
				$ScreenInfo =~ s/ /�~/g;
			}
		}
		my $ReferUrl = $referer{$FirstNo};

		#OS,�u���E�U�[�����
		my ($OS, $OS_V, $BR, $BR_V) = &User_Agent($UserAgent);
		unless($OS) {$OS = '&nbsp;';}
		unless($OS_V) {$OS_V = '&nbsp;';}
		unless($BR) {$BR = '&nbsp;';}
		unless($BR_V) {$BR_V = '&nbsp;';}

		my @HostParts = split(/\./, $TARGET_VISITOR);
		my $Part1 = lc pop(@HostParts);
		my $Part2 = lc pop(@HostParts);
		my $Part3 = lc pop(@HostParts);

		#�A�N�Z�X�������iTLD�j�̓���
		my $CountryStr;
		unless($Part1 =~ /[0-9]/) {
			my %TldList = &ReadDef('./data/country_code.dat');
			$CountryStr = $TldList{$Part1}.'('.$Part1.')';
			undef %TldList;
		}
		unless($CountryStr) {$CountryStr = '&nbsp;';}

		#�A�N�Z�X���s���{�����A�g�D���̓���
		my %OrgList = &ReadDef('./data/organization.dat');
		my ($GetPref, $DomainTmp, $Str1, $Str2);

		if(length($Part1) >= 3) {
			$DomainTmp = "$Part2.$Part1";
		} elsif($Part1 eq 'jp') {
			my @AreaList = ('hokkaido', 'aomori', 'iwate', 'miyagi', 'akita', 'yamagata', 'fukushima',
				'ibaraki', 'tochigi', 'gunma', 'saitama', 'chiba', 'tokyo', 'kanagawa',
				'niigata', 'toyama', 'ishikawa', 'fukui', 'yamanashi', 'nagano', 'gifu',
				'shizuoka', 'aichi', 'mie', 'shiga', 'kyoto', 'osaka', 'hyogo', 'nara',
				'wakayama', 'tottori', 'shimane', 'okayama', 'hiroshima', 'yamaguchi',
				'tokushima', 'kagawa', 'ehime', 'kochi', 'fukuoka', 'saga', 'nagasaki',
				'kumamoto', 'oita', 'miyazaki', 'kagoshima', 'okinawa', 'sapporo',
				'sendai', 'chiba', 'yokohama', 'kawasaki', 'nagoya', 'kyoto', 'osaka',
				'kobe', 'hiroshima', 'fukuoka', 'kitakyushu');

			if(length($Part2) ==2 || grep(/^$Part2$/, @AreaList)) {
				$DomainTmp = "$Part3.$Part2.$Part1";
			} else {
				$DomainTmp = "$Part2.$Part1";
			}
		} else {
			$DomainTmp = "$Part2.$Part1";
		}

		($Str1, $Str2, $GetPref) = split(/,/, $OrgList{$DomainTmp});
		undef %OrgList;
		my $Organization = "$Str1";
		unless($Organization) {$Organization = '&nbsp;';}
		if($Str2) {
			$Organization .= "<div class=\"size2\">($Str2)</div>";
		}
		unless($GetPref) {
			my %pref_code_map = &GetPrefCodeMap;
			my %PrefList = &GetPrefList;
			my $host = lc $TARGET_VISITOR;
			my $PrefKeyword = &GetPrefKeyword($host);
			my $pref_code = $PrefList{$PrefKeyword};
			$GetPref = $pref_code_map{$pref_code};
			undef %PrefList;
		}
		unless($GetPref) {$GetPref = '&nbsp;';}

		my @Keys = (
			'�z�X�g��',
			'���iTLD�j',
			'�s���{��',
			'�g�D��',
			'HTTP_USER_AGENT',
			'�v���b�g�t�H�[��',
			'�u���E�U',
			'��ʉ𑜓x���',
		);
		&jcode::convert(\$UserAgent, 'sjis');
		my %Data = (
			'�z�X�g��' => $TARGET_VISITOR,
			'���iTLD�j' => $CountryStr,
			'�s���{��' => $GetPref,
			'�g�D��', => $Organization,
			'HTTP_USER_AGENT' => $UserAgent,
			'�v���b�g�t�H�[��' => "$OS $OS_V",
			'�u���E�U' => "$BR $BR_V",
			'��ʉ𑜓x���' => $ScreenInfo
		);
		$PrintStr .= &MakeTable(\@Keys, \%Data);
		$PrintStr .= "<hr>\n";
		my $SessionNo = 1;
		my $DspReferUrl = $ReferUrl;
		if(length($ReferUrl) > 50) {
			$DspReferUrl = substr($ReferUrl, 0, 50) . '...';
		}
		$PrintStr .= "�� �{���y�[�W�ǐ�<br>\n";
		$PrintStr .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
		$PrintStr .= "<tr><td colspan=\"3\" bgcolor=\"#3A6EA5\" CLASS=\"ListHeader\">�Z�b�V���� $SessionNo</td></tr>\n";
		$PrintStr .= "<tr bgcolor=\"#EAEAEA\"><td><img src=\"$CONF{'IMAGE_URL'}/refer.gif\" width=\"17\" height=\"17\"></td><td> �����N��</td><td>";
		if($ReferUrl eq '-' || $ReferUrl eq '') {
			$PrintStr .= "$DspReferUrl";
		} else {
			$PrintStr .= "<a href=\"$ReferUrl\" target=\"_blank\">$DspReferUrl</a>";
		}
		$PrintStr .= "</td></tr>\n";
		my($IntervalSec, $PreNo, $DspDate, $DspRequestUrl);
		my %ManualTitle = &ReadTitleDat;
		for $i (sort{$a <=> $b} keys %request) {
			unless($i == $FirstNo) {
				$IntervalSec = &GetRangeSecond($date{$PreNo}, $date{$i});
				if($IntervalSec <= $CONF{'INTERVAL'}) {
					$PrintStr .= "<tr bgcolor=\"#E6EAF3\"><td colspan=\"3\" align=\"right\">$IntervalSec�b <img src=\"$CONF{'IMAGE_URL'}/timer.gif\" width=\"17\" height=\"17\"></td></tr>\n";
				} else {
					$PrintStr .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>\n";
					$PrintStr .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>\n";
					$SessionNo ++;
					$PrintStr .= "<tr><td colspan=\"3\" bgcolor=\"#3A6EA5\" CLASS=\"ListHeader\">�Z�b�V���� $SessionNo</td></tr>\n";
					$DspReferUrl = $referer{$i};
					if(length($referer{$i}) > 50) {
						$DspReferUrl = substr($referer{$i}, 0, 50) . '...';
					}
					$PrintStr .= "<tr bgcolor=\"#EAEAEA\"><td><img src=\"$CONF{'IMAGE_URL'}/refer.gif\" width=\"17\" height=\"17\"></td><td> �����N��</td><td>";
					if($referer{$i} eq '-' || $referer{$i} eq '') {
						$PrintStr .= "$DspReferUrl";
					} else {
						$PrintStr .= "<a href=\"$referer{$i}\" target=\"_blank\">$DspReferUrl</a>";
					}
					$PrintStr .= "</td></tr>\n";
				}
			}
			$DspDate = &ConvDspDate($date{$i});
			if(length($request{$i}) > 50) {
				$DspRequestUrl = substr($request{$i}, 0, 50) . '...';
			} else {
				$DspRequestUrl = $request{$i};
			}
			$PrintStr .= "<tr bgcolor=\"#EBE1E2\">\n";
			$PrintStr .= "  <td><img src=\"$CONF{'IMAGE_URL'}/file.gif\" width=\"17\" height=\"17\"></td>\n";
			$PrintStr .= "  <td> $DspDate</td>\n";
			if($request{$i} eq '-' || $request{$i} eq '') {
				$PrintStr .= "  <td> $DspRequestUrl</td>\n";
			} else {
				$PrintStr .= "  <td> <a href=\"$request{$i}\" target=\"_blank\">$DspRequestUrl</a></td>\n";
			}
			$PrintStr .= "</tr>\n";
			$PreNo = $i;
		}
		$PrintStr .= "</table>\n";
	}
	my $Title = "�K��Ғǐ�";
	&PrintResult($Title, $PrintStr);

}


sub ActivityByDayOfTheMonth {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%all_date, %date, %remote_host, %cookies, @LogNoList, $lastdate);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$lastdate = $date_part;
		$remote_host{$i} = $host_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my($ThisYear, $ThisMonth) = $lastdate =~ /^(\d{4})(\d{2})/;
	my($Y, $M, $D, @DateBuff);
	my %LogNoList = ();	
	for my $i (keys %date) {
		unless($date{$i}) {next;}
		if($date{$i} eq '-') {next;}
		unless($ANA_MONTH) {
			unless($date{$i} =~ /^$ThisYear$ThisMonth/) {next;}
		}
		($Y, $M, $D) = $date{$i} =~ /^(\d{4})(\d{2})(\d{2})/;
		$D =~ s/^0//;
		$LogNoList{$D} .= "$i,";
	}
	my($WeekNum, $DateStr, $Date, @NoList, $Views, $Sessions, $Unique);
	my $LastDayOfThisMonth = &LastDay($ThisYear, $ThisMonth);
	my %SessionNumList = ();
	my %PageViewNumList = ();
	my %UniqueNumList = ();
	my @DateList = ();
	my @WeekMap = ('��', '��', '��', '��', '��', '��', '�y');
	for (my $i=0;$i<$LastDayOfThisMonth;$i++) {
		$Date = $i + 1;
		$LogNoList{$Date} =~ s/,$//;
		@NoList = split(/,/, $LogNoList{$Date});
		$Views = @NoList;
		$PageViewNumList{$i} = $Views;
		$Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$i} = $Sessions;
		$Unique = &GetUniqueUserNum(\@NoList, \%remote_host, \%cookies);
		$UniqueNumList{$i} = $Unique;
		$WeekNum = &Youbi($ThisYear, $ThisMonth, $Date);
		$DateStr = "$ThisYear�N$ThisMonth��$Date���i";
		if($WeekNum == 0) {
			$DateStr .= "<font color=\"#FF0000\">$WeekMap[$WeekNum]</font>�j";
		} elsif($WeekNum == 6) {
			$DateStr .= "<font color=\"#0000FF\">$WeekMap[$WeekNum]</font>�j";
		} else {
			$DateStr .= "$WeekMap[$WeekNum]�j";
		}
		push(@DateList, $DateStr);
	}
	my($Str);
	$Str .= "�y�[�W�r���[<br>\n";
	my @Titles = ('���t', '�y�[�W�r���[', '�O���t');
	$Str .= &MakeGraph3(\%PageViewNumList, \@Titles, \@DateList);
	$Str .= "<hr>\n";
	$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
	@Titles = ('���t', '�K�␔', '�O���t');
	$Str .= &MakeGraph3(\%SessionNumList, \@Titles, \@DateList);
	$Str .= "<hr>\n";
	$Str .= "�K��Ґ��i���j�[�N���[�U�[���j<br>\n";
	@Titles = ('���t', '�K��Ґ�', '�O���t');
	$Str .= &MakeGraph3(\%UniqueNumList, \@Titles, \@DateList);
	my $Title = '���ʃA�N�Z�X��';
	&PrintResult($Title, $Str);

}


sub ActivityByDayOfTheWeek {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%all_date, %date, %remote_host, %cookies, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %LogNoList = ();
	my($Y, $M, $D, @DateBuff);
	for my $i (keys %date) {
		unless($date{$i}) {next;}
		if($date{$i} eq '-') {next;}
		($Y, $M, $D) = $date{$i} =~ /^(\d{4})(\d{2})(\d{2})/;
		$M =~ s/^0//;
		$D =~ s/^0//;
		@DateBuff = localtime(timelocal(0, 0, 0, $D, $M - 1, $Y));
		$LogNoList{$DateBuff[6]} .= "$i,";
	}
	my(@NoList, $Views, $Sessions, $Unique);

	my %SessionNumList = ();
	my %PageViewNumList = ();
	my %UniqueNumList = ();
	for (my $Youbi=0;$Youbi<7;$Youbi++) {
		$LogNoList{$Youbi} =~ s/,$//;
		@NoList = split(/,/, $LogNoList{$Youbi});
		$Views = @NoList;
		$PageViewNumList{$Youbi} = $Views;
		$Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$Youbi} = $Sessions;
		$Unique = &GetUniqueUserNum(\@NoList, \%remote_host, \%cookies);
		$UniqueNumList{$Youbi} = $Unique;
	}
	my($Str);
	my @WeekMap = ('��', '��', '��', '��', '��', '��', '�y');
	$Str .= "�y�[�W�r���[<br>\n";
	my @Titles = ('�j��', '�y�[�W�r���[', '�O���t');
	$Str .= &MakeGraph3(\%PageViewNumList, \@Titles, \@WeekMap);
	$Str .= "<hr>\n";
	$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
	@Titles = ('�j��', '�K�␔', '�O���t');
	$Str .= &MakeGraph3(\%SessionNumList, \@Titles, \@WeekMap);
	$Str .= "<hr>\n";
	$Str .= "�K��Ґ��i���j�[�N���[�U�[���j<br>\n";
	@Titles = ('�j��', '�K��Ґ�', '�O���t');
	$Str .= &MakeGraph3(\%UniqueNumList, \@Titles, \@WeekMap);
	my $Title = '�j���ʃA�N�Z�X��';
	&PrintResult($Title, $Str);
}


sub ActivityByHourOfTheDay {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%all_date, %date, %remote_host, %cookies, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %LogNoList = ();
	my($H, @DateBuff);
	for my $i (keys %date) {
		unless($date{$i}) {next;}
		if($date{$i} eq '-') {next;}
		$H = substr($date{$i}, 8, 2);
		$H =~ s/^0//;
		$LogNoList{$H} .= "$i,";
	}
	my(@NoList, $Views, $Sessions, $Unique);

	my %SessionNumList = ();
	my %PageViewNumList = ();
	my %UniqueNumList = ();
	for (my $Hour=0;$Hour<24;$Hour++) {
		$LogNoList{$Hour} =~ s/,$//;
		@NoList = split(/,/, $LogNoList{$Hour});
		$Views = @NoList;
		$PageViewNumList{$Hour} = $Views;
		$Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$Hour} = $Sessions;
		$Unique = &GetUniqueUserNum(\@NoList, \%remote_host, \%cookies);
		$UniqueNumList{$Hour} = $Unique;
	}
	my($Str);
	$Str .= "�y�[�W�r���[<br>\n";
	my @Titles = ('����', '�y�[�W�r���[', '�O���t');
	$Str .= &MakeGraph3(\%PageViewNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
	@Titles = ('����', '�K�␔', '�O���t');
	$Str .= &MakeGraph3(\%SessionNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .=	"�K��Ґ��i���j�[�N���[�U�[���j<br>\n";
	@Titles = ('����', '�K��Ґ�', '�O���t');
	$Str .= &MakeGraph3(\%UniqueNumList, \@Titles);
	my $Title = '���ԕʃA�N�Z�X��';
	&PrintResult($Title, $Str);
}

sub TopReferringSites {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%all_date, %date, %remote_host, %cookies, %referer, $host_part, $cookie_part, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $referer_part, $host_part, $cookie_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$referer_part = $6;
			$host_part = $2;
			$cookie_part = $3;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$cookies{$i} = $cookie_part;
		$referer{$i} = $referer_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);
	my %LogNoListBuff = ();
	for my $i (keys %referer) {
		unless($referer{$i}) {next;}
		if($referer{$i} eq '-') {next;}
		my $Flag = 0;
		if(scalar @MY_SITE_URLs) {
			for my $ExceptUrl (@MY_SITE_URLs) {
				if($referer{$i} =~ /^$ExceptUrl/i) {
					$Flag = 1;
					last;
				}
			}
		}
		if($Flag) {next;}
		my $host = lc $referer{$i};
		my @UrlParts = split(/\//, $host);
		my $SiteUrl = "$UrlParts[0]//$UrlParts[2]/";
		$LogNoListBuff{$SiteUrl} .= "$i,";
	}

	my %LogNoList = ();
	my %SiteList = &ReadDef('./data/site.dat');
	for my $key (keys %LogNoListBuff) {
		my $KeyStr;
		my $SiteName = &GetSiteName(\%SiteList, $key, 1);
		my $EncodedUrl = &URL_Encode($key);
		my $LinkUrl = "${CGI_URL}?REDIRECT=$EncodedUrl";
		if($SiteName) {
			$KeyStr = "$SiteName<br>";
			$KeyStr .= "<div class=\"size2\"><a href=\"$LinkUrl\" target=\"_blank\">$key</a></div>";
		} else {
			$KeyStr .= "<a href=\"$LinkUrl\" target=\"_blank\">$key</a>";
		}
		$LogNoList{$KeyStr} = $LogNoListBuff{$key};
	}
	my %SessionNumList = ();
	for my $key (keys %LogNoList) {
		$LogNoList{$key} =~ s/,$//;
		my @NoList = split(/,/, $LogNoList{$key});
		my $Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$key} = $Sessions;
	}
	my @Titles = ('����', 'URL', '�K�␔', '�O���t');
	my $Str = &MakeGraph(\%SessionNumList, \@Titles);
	my $Title = '�����N���T�C�g�����L���O';
	&PrintResult($Title, $Str);
}

sub GetSiteName {
	my($site_hash_ref, $url, $site_flag) = @_;
	if($site_flag) {
		my @url_parts = split(/\//, $url);
		$url = $url_parts[2];
	}
	my $domain;
	my $hit_domain;
	for $domain (keys %$site_hash_ref) {
		if($site_flag) {
			if($domain =~ /\//) {next;}
		}
		if($url =~ /$domain/) {
			#my $site_name = $site_hash_ref->{$url};
			#return $site_name;
			#last;
			if(length($domain) > length($hit_domain)) {
				$hit_domain = $domain;
			}
		}
	}
	return $site_hash_ref->{$hit_domain};
}

sub TopReferringURLs {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%all_date, %date, %remote_host, %cookies, %referer, $host_part, $cookie_part, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $referer_part, $host_part, $cookie_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$referer_part = $6;
			$host_part = $2;
			$cookie_part = $3;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$cookies{$i} = $cookie_part;
		$referer{$i} = $referer_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %LogNoListBuff = ();
	for my $i (keys %referer) {
		unless($referer{$i}) {next;}
		if($referer{$i} eq '-') {next;}
		my $Flag = 0;
		if(scalar @MY_SITE_URLs) {
			my $ExceptUrl;
			for $ExceptUrl (@MY_SITE_URLs) {
				if($referer{$i} =~ /^$ExceptUrl/i) {
					$Flag = 1;
					last;
				}
			}
		}
		if($Flag) {next;}
		$LogNoListBuff{$referer{$i}} .= "$i,";
	}
	my %SiteList = &ReadDef('./data/site.dat');
	my %LogNoList = ();
	for my $key (keys %LogNoListBuff) {
		my $DspUrl;
		if(length($key) > 50) {
			$DspUrl = substr($key, 0, 50);
			$DspUrl .= '...';
		} else {
			$DspUrl = $key;
		}
		my $SiteName = &GetSiteName(\%SiteList, $key);
		my $KeyStr;
		my $EncodedUrl = &URL_Encode($key);
		my $LinkUrl = "${CGI_URL}?REDIRECT=$EncodedUrl";
		if($SiteName) {
			$KeyStr = "$SiteName<br>";
			$KeyStr .= "<div class=\"size2\"><a href=\"$LinkUrl\" target=\"_blank\">$DspUrl</a></div>";
		} else {
			$KeyStr .= "<a href=\"$LinkUrl\" target=\"_blank\">$DspUrl</a>";
		}
		$LogNoList{$KeyStr} = $LogNoListBuff{$key};	
	}
	my(@NoList, $Sessions);
	my %SessionNumList = ();
	for my $key (keys %LogNoList) {
		$LogNoList{$key} =~ s/,$//;
		@NoList = split(/,/, $LogNoList{$key});
		$Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$key} = $Sessions;
	}
	my @Titles = ('����', 'URL', '�K�␔', '�O���t');
	my $Str = &MakeGraph(\%SessionNumList, \@Titles);
	my $Title = '�����N��URL�����L���O';
	&PrintResult($Title, $Str);
}

sub TopSearchKeywords {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%referer, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $referer_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$referer_part = $6;
		} else {
			next;
		}
		next if($date_part eq '');
		next unless(&IsInDate($date_part));
		$referer{$i} = $referer_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);
	my %KeywordCount = ();	
	for my $i (keys %referer) {
		if($referer{$i} eq '' || $referer{$i} eq '-') {
			next;
		}
		#if($referer{$i} =~ /\?/) {
			my($keyword) = &GetSearchKeyword($referer{$i});
			if($keyword ne '') {
				$keyword =~ s/</&lt;/g;
				$keyword =~ s/>/&gt;/g;
				$KeywordCount{$keyword} ++;
			}
		#} else {
		#	next;
		#}
	}
	my @Titles = ('����', '�L�[���[�h', '�K�␔', '�O���t');
	my $Str = &MakeGraph(\%KeywordCount, \@Titles);
	my $Title = '�����L�[���[�h�����L���O';
	&PrintResult($Title, $Str);
}

sub TopSearchEngines {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%referer, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $referer_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$referer_part = $6;
		} else {
			next;
		}
		next if($date_part eq '');
		next unless(&IsInDate($date_part));
		$referer{$i} = $referer_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %engine_list = ();
	my %keyword_list = ();
	my %engine_urls = ();
	my $sum = 0;
	for my $i (keys %referer) {
		if($referer{$i} eq '' || $referer{$i} eq '-') {
			next;
		}
		#if($referer{$i} =~ /\?/) {
			my($keyword, $engine_name, $engine_url) = &GetSearchKeyword($referer{$i});
			if($keyword ne '') {
				$keyword =~ s/</&lt;/g;
				$keyword =~ s/>/&gt;/g;
				$engine_list{$engine_name} ++;
				$keyword_list{"$engine_name:$keyword"} ++;
				$engine_urls{$engine_name} = $engine_url;
				$sum ++;
			}
		#}
	}

	my $Str;
	$Str .= &MakeCircleGraph(\%engine_list);
	$Str .= "<br>\n";
	$Str .= "<TABLE BORDER=\"0\">\n";
	$Str .= "  <TR BGCOLOR=\"#3A6EA5\">\n";
	$Str .= "    <td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">����</FONT></td>\n";
	$Str .= "    <td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">�����G���W��</FONT></td>\n";
	$Str .= "    <td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">�K�␔</FONT></td>\n";
	$Str .= "    <td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">�O���t</FONT></td>\n";
	$Str .= "  </TR>\n";
	my $engine_order = 1;
	foreach my $key (ValueSort(\%engine_list)) {
		my $rate = int($engine_list{$key} * 10000 / $sum) / 100;
		my $GraphLength = int($CONF{'GRAPHMAXLENGTH'} * $rate / 100);
		$Str .= "  <TR BGCOLOR=\"#EAEAEA\" VALIGN=\"MIDDLE\">\n";
		$Str .= "    <TD ALIGN=\"CENTER\">$engine_order</TD>\n";
		$Str .= "    <TD><a href=\"$engine_urls{$key}\" target=\"_blank\">$key</a></TD>\n";
		$Str .= "    <TD ALIGN=\"RIGHT\">$engine_list{$key}</TD>\n";
		$Str .= "    <TD class=\"size2\">";
		if($rate < 1) {
			$Str .= "";
		} else {
			$Str .= "<IMG SRC=\"$CONF{'IMAGE_URL'}/graphbar\.gif\" WIDTH=\"$GraphLength\" HEIGHT=\"10\">";
		}
		$Str .= " ($rate%)</TD>\n";
		$Str .= "  </TR>\n";

		for my $key1 (ValueSort(\%keyword_list)) {
			my($name, $word) = split(/\:/, $key1);
			if($name eq $key) {
				my $rate2 = int($keyword_list{$key1} * 10000 / $sum) / 100;
				my $GraphLength2 = int($CONF{'GRAPHMAXLENGTH'} * $rate2 / 100);
				$Str .= "  <TR class=\"size2\">\n";
				$Str .= "    <TD></TD>\n";
				$Str .= "    <TD BGCOLOR=\"#B7B7B7\"><LI>$word</LI></TD>\n";
				$Str .= "    <TD BGCOLOR=\"#B7B7B7\" ALIGN=\"RIGHT\">$keyword_list{$key1}</TD>\n";
				$Str .= "    <TD BGCOLOR=\"#B7B7B7\">";
				if($rate2 < 1) {
					$Str .= "\&nbsp\;";
				} else {
					$Str .= "<IMG SRC=\"$CONF{'IMAGE_URL'}/graphbar2\.gif\" WIDTH=\"$GraphLength2\" HEIGHT=\"8\">";
				}
				$Str .= " ($rate2%)</TD>\n";
				$Str .= "  </TR>\n";
			}
		}
		$engine_order ++;
	}
	$Str .= "</TABLE>\n";
	$Str .= "<BR><BR>\n";

	my $Title = '�����G���W�������L���O';
	&PrintResult($Title, $Str);
}

sub GetSearchKeyword {
		my($requested_url) = @_;
		my ($url, $getstr) = split(/\?/, $requested_url);
		if($getstr eq '' && $url !~ /(a9\.com|\.excite\.com)/) {
			return '';
		}
		my @parts = split(/\&/, $getstr);
		my %variables = ();
		my $part;
		for $part (@parts) {
			my ($name, $value) = split(/=/, $part);
			$variables{$name} = $value;
		}
		my @url_parts = split(/\//, $url);
		my @url_parts2 = split(/\./, $url_parts[2]);
		my $tld = pop @url_parts2;
		my $word = '';
		my $engine_name = '';
		my $engine_url = '';

		if($url =~ /\.google\./) {
			if($url =~ /images\.google\./) {
				my $prev = $variables{'prev'};
				$prev = &URL_Decode($prev);
				if($prev =~ /q=([^&]+)&/) {
					$word = $1;
				}
			} elsif($variables{'q'}) {
				$word = $variables{'q'};
			} elsif($variables{'as_q'}) {
				$word = $variables{'as_q'};
			}
			$engine_name = "Google($tld)";
			my @tmp = split(/\.google\./, $url);
			my $suffix = pop @tmp;
			$engine_url = 'http://www.google.' . $suffix;
		} elsif($url =~ /\.yahoo\./) {
			$word = $variables{'p'};
			$engine_name = "Yahoo!($tld)";
			my @tmp = split(/\.yahoo\./, $url);
			my $suffix = pop @tmp;
			$engine_url = 'http://www.yahoo.' . $suffix;
		} elsif($url =~ /\.excite\./) {
			if($url =~ /odn\.excite\.co\.jp/) {
				$word = $variables{'search'};
				$engine_name = "ODN Search";
				$engine_url = 'http://www.odn.ne.jp/';
			} elsif($url =~ /dion\.excite\.co\.jp/) {
				$word = $variables{'search'};
				$engine_name = "DION Search";
				$engine_url = 'http://www.dion.ne.jp/';
			} else {
				if($variables{'search'}) {
					$word = $variables{'search'};
				} elsif($variables{'s'}) {
					$word = $variables{'s'};
				}
				$engine_name = "excite($tld)";
				my @tmp = split(/\.excite\./, $url);
				my $suffix = pop @tmp;
				$engine_url = 'http://www.excite.' . $suffix;
			}
		} elsif($url =~ /\.msn\./) {
			$word = $variables{'q'};
			$engine_name = "MSN($tld)";
			my @tmp = split(/\.msn\./, $url);
			my $suffix = pop @tmp;
			$engine_url = 'http://www.msn.' . $suffix;
		} elsif($url =~ /\.infoseek\./) {
			$word = $variables{'qt'};
			$engine_name = 'infoseek';
			$engine_url = 'http://www.infoseek.co.jp/';
		} elsif($url =~ /\.goo\.ne\.jp/) {
			$word = $variables{'MT'};
			$engine_name = 'goo';
			$engine_url = 'http://www.goo.ne.jp/';
		} elsif($url =~ /search\.livedoor\.com/) {
			$word = $variables{'q'};
			$engine_name = 'livedoor';
			$engine_url = 'http://www.livedoor.com/';
		} elsif($url =~ /ask\.[a-z]+\//) {
			$word = $variables{'q'};
			$engine_name = "Ask($tld)";
			$engine_url = 'http://ask.' . $tld;
		} elsif($url =~ /lycos/) {
			if($url =~ /wisenut/) {
				$word = $variables{'q'};
			} else {
				$word = $variables{'query'};
			}
			$engine_name = "Lycos($tld)";
			my @tmp = split(/\.lycos\./, $url);
			my $suffix = pop @tmp;
			$engine_url = 'http://www.lycos.' . $suffix;
		} elsif($url =~ /a9\.com\/([^\/]+)/) {
			$word = $1;
			if($word eq '-') {
				$word = '';
			}
			$engine_name = 'A9.com';
			$engine_url = 'http://a9.com/';
		} elsif($url =~ /\.fresheye\.com/) {
			$word = $variables{'kw'};
			$engine_name = '�t���b�V���A�C';
			$engine_url = 'http://www.fresheye.com/';
		} elsif($url =~ /search\.biglobe\.ne\.jp/) {
			$word = $variables{'q'};
			$engine_name = 'BIGLOBE�T�[�` attayo';
			$engine_url = 'http://search.biglobe.ne.jp/';
		} elsif($url =~ /search\.netscape\.com/) {
			$word = $variables{'query'};
			$engine_name = 'Netscape Search';
			$engine_url = 'http://www.netscape.com/';
		} elsif($url =~ /www\.overture\.com/) {
			$word = $variables{'Keywords'};
			$engine_name = 'overture';
			$engine_url = 'http://www.overture.com/';
		} elsif($url =~ /\.altavista\.com/) {
			$word = $variables{'q'};
			$engine_name = 'altavista';
			$engine_url = 'http://au.altavista.com/';
		} elsif($url =~ /search\.aol\.com/) {
			$word = $variables{'query'};
			$engine_name = 'AOL Search';
			$engine_url = 'http://search.aol.com/';
		} elsif($url =~ /\.looksmart\.com/) {
			$word = $variables{'qt'};
			$engine_name = 'looksmart';
			$engine_url = 'http://search.looksmart.com/';
		} elsif($url =~ /bach\.istc\.kobe\-u\.ac\.jp\/cgi\-bin\/metcha\.cgi/) {
			$word = $variables{'q'};
			$engine_name = 'Metcha Seearch';
			$engine_url = 'http://bach.scitec.kobe-u.ac.jp/metcha/';
		} elsif($url =~ /\.alltheweb\.com/) {
			$word = $variables{'q'};
			$engine_name = 'alltheweb';
			$engine_url = 'http://www.alltheweb.com/';
		} elsif($url =~ /\.blueglobus\.com\/cgi-bin\/search\/search\.cgi/) {
			$word = $variables{'keywords'};
			$engine_name = 'BlueGlobus.com';
			$engine_url = 'http://www.blueglobus.com/';
		} elsif($url =~ /\.alexa\.com\/search/) {
			$word = $variables{'q'};
			$engine_name = 'Alexa';
			$engine_url = 'http://www.alexa.com/';
		} elsif($url =~ /search\.naver\.com/) {
			$word = $variables{'query'};
			$engine_name = 'NEVER';
			$engine_url = 'http://www.naver.com/';
		} else {
			return '';
		}
		if($word eq '') {
			return '';
		}
		my $decode_str = &URL_Decode($word);
		&Jcode::convert(\$decode_str, "sjis");
		$decode_str =~ s/\x81\x40/ /g;
		$decode_str =~ s/\s+/ /g;
		$decode_str =~ s/^\s//;
		$decode_str =~ s/\s$//;
		my @engine_url_parts = split(/\//, $engine_url);
		$engine_url = "http://$engine_url_parts[2]/";
		return $decode_str, $engine_name, $engine_url;
}


sub TopBrowsers {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my $loglines = 0;
	my(%all_date, %date, %user_agent, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $ua_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$ua_part = $7;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$user_agent{$i} = $ua_part;
		push(@LogNoList, $i);
		$i ++;
		$loglines ++;
	}
	close(LOGFILE);
	my(%browser_list, %browser_v_list, %platform_list, %platform_v_list);
	for my $ua (keys %user_agent) {
		my($platform, $platform_v, $browser, $browser_v) = &User_Agent($user_agent{$ua});
		$browser_list{$browser} ++;
		$browser_v_list{"$browser:$browser_v"} ++;
		$platform_list{"$platform"} ++;
		$platform_v_list{"$platform:$platform_v"} ++;
	}

	my($Str);
	$Str .= &MakeCircleGraph(\%browser_list);
	$Str .= "<br>\n";
	$Str .= "<TABLE BORDER=\"0\">\n";
	$Str .= "<TR BGCOLOR=\"#3A6EA5\">\n";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">����</FONT></td>\n";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">�u���E�U�[</FONT></td>\n";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">���N�G�X�g��</FONT></td>\n";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">�O���t</FONT></td></TR>\n";
	my $browser_order = 1;
	foreach my $key (ValueSort(\%browser_list)) {
		my $rate = int($browser_list{$key} * 10000 / $loglines) / 100;
		my $GraphLength = int($CONF{'GRAPHMAXLENGTH'} * $rate / 100);
		$Str .= "<TR BGCOLOR=\"#EAEAEA\" VALIGN=\"MIDDLE\"><TD ALIGN=\"CENTER\">$browser_order</TD><TD>";
		if($key eq '') {
			$Str .= " �s��</TD><TD ALIGN=\"RIGHT\">$browser_list{$key}</TD><TD>";
		} else {
			$Str .= " $key</TD><TD ALIGN=\"RIGHT\">$browser_list{$key}</TD><TD class=\"size2\">";
		}
		if($rate < 1) {
			$Str .= "";
		} else {
			$Str .= "<IMG SRC=\"$CONF{'IMAGE_URL'}/graphbar\.gif\" WIDTH=\"$GraphLength\" HEIGHT=\"10\">";
		}
		$Str .= " ($rate%)</TD></TR>\n";

		for my $key1 (sort keys %browser_v_list) {
			if($key1 =~ /^$key:/) {
				my $rate2 = int($browser_v_list{$key1} * 10000 / $loglines) / 100;
				my $GraphLength2 = int($CONF{'GRAPHMAXLENGTH'} * $rate2 / 100);
				my $v = $key1;
				$v =~ s/^$key://;
				$Str .= "<TR class=\"size2\"><TD></TD><TD BGCOLOR=\"#B7B7B7\"><LI>$v</LI></TD><TD BGCOLOR=\"#B7B7B7\" ALIGN=\"RIGHT\">$browser_v_list{$key1}</TD>";
				$Str .= "<TD BGCOLOR=\"#B7B7B7\">";
				if($rate2 < 1) {
					$Str .= "\&nbsp\;";
				} else {
					$Str .= "<IMG SRC=\"$CONF{'IMAGE_URL'}/graphbar2\.gif\" WIDTH=\"$GraphLength2\" HEIGHT=\"8\">";
				}
				$Str .= " ($rate2%)</TD></TR>\n";
			}
		}
		$browser_order ++;
	}
	$Str .= "</TABLE>\n";
	$Str .= "<BR><BR>\n";

	my $Title = '�u���E�U�[�����L���O';
	&PrintResult($Title, $Str);
}


sub TopAcceptLanguage {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my(%all_date, %date, %remote_host, %cookies, %accept_language, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part, $accept_lang_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
			$accept_lang_part = $8;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$accept_language{$i} = $accept_lang_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my(%LogNoListBuff) = ();
	for my $i (keys %accept_language) {
		if($accept_language{$i} eq '-') {next;}
		unless($accept_language{$i}) {next;}
		my @buff = split(/,/, $accept_language{$i});
		my $max = 0;
		my($lang);
		for my $j (@buff) {
			my ($lang_tmp, $value_tmp) = split(/\;/, $j);
			$value_tmp =~ s/q=//;
			$value_tmp = 1 if($value_tmp eq '');
			if($max < $value_tmp) {
				$lang = $lang_tmp;
				$max = $value_tmp;
			}
		}
	  	$LogNoListBuff{"\L$lang"} .= "$i,";
	}
	my %LangCodeList = &ReadDef('./data/language.dat');
	my %LogNoList = ();
	for my $key (keys %LogNoListBuff) {
		$LogNoList{$LangCodeList{$key}} = $LogNoListBuff{$key};
	}
	my(@NoList, $Views, $Sessions, $Unique);
	my %SessionNumList = ();
	my %PageViewNumList = ();
	my %UniqueNumList = ();
	for my $key (keys %LogNoList) {
		$LogNoList{$key} =~ s/,$//;
		@NoList = split(/,/, $LogNoList{$key});
		$Views = @NoList;
		$PageViewNumList{$key} = $Views;
		$Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$key} = $Sessions;
		$Unique = &GetUniqueUserNum(\@NoList, \%remote_host, \%cookies);
		$UniqueNumList{$key} = $Unique;
	}
	my($Str);
	$Str .= "�y�[�W�r���[<br>\n";
	$Str .= &MakeCircleGraph(\%PageViewNumList);
	$Str .= "<br>\n";
	my @Titles = ('����', '����', '�y�[�W�r���[', '�O���t');
	$Str .=&MakeGraph(\%PageViewNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
	$Str .= &MakeCircleGraph(\%SessionNumList);
	$Str .= "<br>\n";
	@Titles = ('����', '����', '�K�␔', '�O���t');
	$Str .= &MakeGraph(\%SessionNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K��Ґ��i���j�[�N���[�U�[���j<br>\n";
	$Str .= &MakeCircleGraph(\%UniqueNumList);
	$Str .= "<br>\n";
	@Titles = ('����', '����', '�K��Ґ�', '�O���t');
	$Str .= &MakeGraph(\%UniqueNumList, \@Titles);
	my $Title = '�u���E�U�[�\�����ꃉ���L���O';
	&PrintResult($Title, $Str);
}

sub TopPlatforms {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my $loglines = 0;
	my(%all_date, %date, %user_agent, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $ua_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$ua_part = $7;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$user_agent{$i} = $ua_part;
		push(@LogNoList, $i);
		$i ++;
		$loglines ++;
	}
	close(LOGFILE);

	my(%browser_list, %browser_v_list, %platform_list, %platform_v_list);
	for my $ua (keys %user_agent) {
		my ($platform, $platform_v, $browser, $browser_v) = &User_Agent($user_agent{$ua});
		$browser_list{$browser} ++;
		$browser_v_list{"$browser:$browser_v"} ++;
		$platform_list{"$platform"} ++;
		$platform_v_list{"$platform:$platform_v"} ++;
	}

	my($Str);
	$Str .= &MakeCircleGraph(\%platform_list);
	$Str .= "<br>\n";
	$Str .= "<TABLE BORDER=\"0\">\n";
	$Str .= "<TR BGCOLOR=\"#3A6EA5\">\n";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">����</FONT></td>\n";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">Operating System</FONT></td>\n";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">�y�[�W�r���[</FONT></td>\n";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">�O���t</FONT></td></TR>\n";
	my $os_order = 1;
	foreach my $key (ValueSort(\%platform_list)) {
		my $rate = int($platform_list{$key} * 10000 / $loglines) / 100;
		my $GraphLength = int($CONF{'GRAPHMAXLENGTH'} * $rate / 100);

		$Str .= "<TR BGCOLOR=\"#EAEAEA\"><TD ALIGN=\"CENTER\">$os_order</TD><TD>";
		if($key eq '') {
			$Str .= " �s��</TD><TD ALIGN=\"RIGHT\">$platform_list{$key}</TD><TD>";
		} else {
			$Str .= " $key</TD><TD ALIGN=\"RIGHT\">$platform_list{$key}</TD><TD class=\"size2\">";
		}
		if($rate < 1) {
			$Str .= "";
		} else {
			$Str .= "<IMG SRC=\"$CONF{'IMAGE_URL'}/graphbar\.gif\" WIDTH=\"$GraphLength\" HEIGHT=\"10\">";
		}
		$Str .= " ($rate%)</TD></TR>\n";

		for my $key1 (sort keys %platform_v_list) {
			if($key1 =~ /^$key:/) {
				my $rate2 = int($platform_v_list{$key1} * 10000 / $loglines) / 100;
				my $GraphLength2 = int($CONF{'GRAPHMAXLENGTH'} * $rate2 / 100);
				my $v = $key1;
				$v =~ s/^$key://;
				$Str .= "<TR class=\"size2\">\n";
				$Str .= "<TD></TD><TD BGCOLOR=\"#B7B7B7\"><LI>$v</LI></TD>\n";
				$Str .= "<TD BGCOLOR=\"#B7B7B7\" ALIGN=\"RIGHT\">$platform_v_list{$key1}</TD>\n";
				$Str .= "<TD BGCOLOR=\"#B7B7B7\">";
				if($rate2 < 1) {
					$Str .= "\&nbsp\;";
				} else {
					$Str .= "<IMG SRC=\"$CONF{'IMAGE_URL'}/graphbar2\.gif\" WIDTH=\"$GraphLength2\" HEIGHT=\"8\">";
				}
				$Str .= " ($rate2%)</TD></TR>\n";
			}
		}

		$os_order ++;
	}
	$Str .= "</TABLE>\n";
	$Str .= "<BR><BR>\n";

	my $Title = '�n�r�����L���O';
	&PrintResult($Title, $Str);
}


sub TopResolution {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my $min_date = 99999999999999;
	my $max_date = 0;
	my(%all_date, %date, %cookies, %remote_host, %screen, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $cookie_part, $host_part, $screen_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
			$screen_part = $9;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$screen{$i} = $screen_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %LogNoList = ();
	for my $i (keys %screen) {
		if($screen{$i} eq '-') {next;}
		unless($screen{$i}) {next;}
		my($ScreenWidth, $ScreenHeight, $ColorDepth) = split(/\s/, $screen{$i});
	  	$LogNoList{"$ScreenWidth�~$ScreenHeight"} .= "$i,";
	}
	my %SessionNumList = ();
	my %PageViewNumList = ();
	my %UniqueNumList = ();
	for my $key (keys %LogNoList) {
		$LogNoList{$key} =~ s/,$//;
		my @NoList = split(/,/, $LogNoList{$key});
		my $Views = @NoList;
		$PageViewNumList{$key} = $Views;
		my $Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$key} = $Sessions;
		my $Unique = &GetUniqueUserNum(\@NoList, \%remote_host, \%cookies);
		$UniqueNumList{$key} = $Unique;
	}
	my($Str);
	$Str .= "�y�[�W�r���[<br>\n";
	$Str .= &MakeCircleGraph(\%PageViewNumList);
	$Str .= "<br>\n";
	my @Titles = ('����', '�𑜓x', '�y�[�W�r���[', '�O���t');
	$Str .=&MakeGraph(\%PageViewNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
	$Str .= &MakeCircleGraph(\%SessionNumList);
	$Str .= "<br>\n";
	@Titles = ('����', '�𑜓x', '�K�␔', '�O���t');
	$Str .= &MakeGraph(\%SessionNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K��Ґ��i���j�[�N���[�U�[���j<br>\n";
	$Str .= &MakeCircleGraph(\%UniqueNumList);
	$Str .= "<br>\n";
	@Titles = ('����', '�𑜓x', '�K��Ґ�', '�O���t');
	$Str .= &MakeGraph(\%UniqueNumList, \@Titles);
	my $Title = '�N���C�A���g��ʉ𑜓x�����L���O';
	&PrintResult($Title, $Str);
}


sub TopColorDepth {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my $min_date = 99999999999999;
	my $max_date = 0;
	my(%all_date, %date, %remote_host, %cookies, %screen, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part, $screen_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
			$screen_part = $9;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$screen{$i} = $screen_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %LogNoListBuff = ();
	for my $i (keys %screen) {
		if($screen{$i} eq '-') {next;}
		unless($screen{$i}) {next;}
		my ($ScreenWidth, $ScreenHeight, $ColorDepth) = split(/\s/, $screen{$i});
	  	$LogNoListBuff{$ColorDepth} .= "$i,";
	}
	my %LogNoList = ();
	for my $key (keys %LogNoListBuff) {
		my $KeyStr = 2**$key;
		$KeyStr .= '�F';
		$KeyStr .= "�i$key bit�j";
		$LogNoList{$KeyStr} = $LogNoListBuff{$key};	
	}
	my %SessionNumList = ();
	my %PageViewNumList = ();
	my %UniqueNumList = ();
	for my $key (keys %LogNoList) {
		$LogNoList{$key} =~ s/,$//;
		my @NoList = split(/,/, $LogNoList{$key});
		my $Views = scalar @NoList;
		$PageViewNumList{$key} = $Views;
		my $Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$key} = $Sessions;
		my $Unique = &GetUniqueUserNum(\@NoList, \%remote_host, \%cookies);
		$UniqueNumList{$key} = $Unique;
	}
	my($Str);
	$Str .= "�y�[�W�r���[<br>\n";
	$Str .= &MakeCircleGraph(\%PageViewNumList);
	$Str .= "<br>\n";
	my @Titles = ('����', '�F�[�x', '�y�[�W�r���[', '�O���t');
	$Str .= &MakeGraph(\%PageViewNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
	$Str .= &MakeCircleGraph(\%SessionNumList);
	$Str .= "<br>\n";
	@Titles = ('����', '�F�[�x', '�K�␔', '�O���t');
	$Str .= &MakeGraph(\%SessionNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K��Ґ��i���j�[�N���[�U�[���j<br>\n";
	$Str .= &MakeCircleGraph(\%UniqueNumList);
	$Str .= "<br>\n";
	@Titles = ('����', '�F�[�x', '�K��Ґ�', '�O���t');
	$Str .= &MakeGraph(\%UniqueNumList, \@Titles);
	my $Title = '�N���C�A���g��ʐF�[�x�����L���O';
	&PrintResult($Title, $Str);
}

sub TopVideoMemorySize {
	if(-e "$LOGDIR/$TARGET_LOGNAME") {
		open(LOGFILE, "$LOGDIR/$TARGET_LOGNAME") || &ErrorPrint("�A�N�Z�X���O�u$LOGDIR/$TARGET_LOGNAME�v���I�[�v���ł��܂���ł���");
	} else {
		&ErrorPrint("�A�N�Z�X���O�i$LOGDIR/$TARGET_LOGNAME�j������܂���B");
	}
	my $i = 0;
	my $min_date = 99999999999999;
	my $max_date = 0;
	my(%all_date, %date, %remote_host, %cookies, %screen, @LogNoList);
	while(<LOGFILE>) {
		chop;
		my($date_part, $host_part, $cookie_part, $screen_part);
		if(/^(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+(\S+)\s+\"([^\"]+)\"\s+\"([^\"]+)\"\s+\"([^\"]+)\"/) {
			$date_part = $1;
			$host_part = $2;
			$cookie_part = $3;
			$screen_part = $9;
		} else {
			next;
		}
		next if($date_part eq '');
		$all_date{$i} = $date_part;
		next unless(&IsInDate($date_part));
		$date{$i} = $date_part;
		$remote_host{$i} = $host_part;
		$screen{$i} = $screen_part;
		$cookies{$i} = $cookie_part;
		push(@LogNoList, $i);
		$i ++;
	}
	close(LOGFILE);

	my %LogNoList = ();
	for my $i (keys %screen) {
		if($screen{$i} eq '-') {next;}
		unless($screen{$i}) {next;}
		my($ScreenWidth, $ScreenHeight, $ColorDepth) = split(/\s/, $screen{$i});
		my $VideoMemorySize = (int($ScreenWidth * $ScreenHeight * $ColorDepth * 10 / 8 / 1024 / 1024)) / 10;
		unless( ($VideoMemorySize*10)%10 == 0) {
			$VideoMemorySize = int($VideoMemorySize) + 1;
		}
	  	$LogNoList{"$VideoMemorySize MB"} .= "$i,";
	}

	my %SessionNumList = ();
	my %PageViewNumList = ();
	my %UniqueNumList = ();
	for my $key (keys %LogNoList) {
		$LogNoList{$key} =~ s/,$//;
		my @NoList = split(/,/, $LogNoList{$key});
		my $Views = @NoList;
		$PageViewNumList{$key} = $Views;
		my $Sessions = &GetSessionNum(\@NoList, \%date, \%remote_host, \%cookies);
		$SessionNumList{$key} = $Sessions;
		my $Unique = &GetUniqueUserNum(\@NoList, \%remote_host, \%cookies);
		$UniqueNumList{$key} = $Unique;
	}
	my($Str);
	$Str .= "�y�[�W�r���[<br>\n";
	$Str .= &MakeCircleGraph(\%PageViewNumList);
	$Str .= "<br>\n";
	my @Titles = ('����', '�T�C�Y', '�y�[�W�r���[', '�O���t');
	$Str .= &MakeGraph(\%PageViewNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K�␔�i�Z�b�V�������j<br>\n";
	$Str .= &MakeCircleGraph(\%SessionNumList);
	$Str .= "<br>\n";
	@Titles = ('����', '�T�C�Y', '�K�␔', '�O���t');
	$Str .= &MakeGraph(\%SessionNumList, \@Titles);
	$Str .= "<hr>\n";
	$Str .= "�K��Ґ��i���j�[�N���[�U�[���j<br>\n";
	$Str .= &MakeCircleGraph(\%UniqueNumList);
	$Str .= "<br>\n";
	@Titles = ('����', '�T�C�Y', '�K��Ґ�', '�O���t');
	$Str .= &MakeGraph(\%UniqueNumList, \@Titles);
	my $Title = '�N���C�A���g��ʃr�f�I�������[�����L���O';
	&PrintResult($Title, $Str);
}


sub MakeTable {
	my($Keys, $Data) = @_;
	my($key);
	my($Str) = "<TABLE BORDER=\"0\">\n";
	for $key (@$Keys) {
		$Str .= "<TR>\n";
		$Str .= "  <TD BGCOLOR=\"#3A6EA5\" CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$key</FONT></TD>\n";
		$Str .= "  <TD BGCOLOR=\"#EAEAEA\" ALIGN=\"left\">$$Data{$key}</TD>\n";
		$Str .= "</TR>\n";
	}
	$Str .= "</TABLE>\n";
	return $Str;
}


sub GetUniqueUserNum {
	my($no_ref, $host_ref, $cookies_ref) = @_;
	my $i;
	my $UniqueNum = 0;
	my %UniqueCookies = ();
	for my $i (@$no_ref) {
		$UniqueCookies{$$cookies_ref{$i}} ++;
	}
	my $key;
	my %UniqueRemoteHosts = ();
	my %ReverseCookies = reverse %$cookies_ref;
	for my $key (keys(%UniqueCookies)) {
		if($UniqueCookies{$key} > 1) {
			$UniqueNum ++;
		} else {
    		my $No = $ReverseCookies{$key};
    		$UniqueRemoteHosts{$$host_ref{$No}} ++;
		}
	}
	my @TempArray = keys %UniqueRemoteHosts;
	my $TempNum = scalar @TempArray;
	$UniqueNum += $TempNum;
	return $UniqueNum;
}

sub GetSessionNum {
	my($no_ref, $date_ref, $host_ref, $cookies_ref) = @_;
	my($i, $diff);
	my %UniqueCookies = ();
	for my $i (@$no_ref) {
		$UniqueCookies{$$cookies_ref{$i}} ++;
	}
	my %LastAccessDate  = ();
	my %CookieLastAccessDate = ();
	my($SessionNum) = 0;
	for my $i (sort {$a<=>$b} @$no_ref) {
		if($UniqueCookies{$$cookies_ref{$i}} > 1) {
			if(exists($CookieLastAccessDate{$$cookies_ref{$i}})) {
				my $diff = &GetSecDiff($$date_ref{$i}, $CookieLastAccessDate{$$cookies_ref{$i}});
				if($diff > $CONF{'INTERVAL'}) {
					$SessionNum ++;
				}
		    } else {
				$SessionNum ++;
			}
		} else {
			if(exists($LastAccessDate{$$host_ref{$i}})) {
				$diff = &GetSecDiff($$date_ref{$i}, $LastAccessDate{$$host_ref{$i}});
				if($diff > $CONF{'INTERVAL'}) {
					$SessionNum ++;
				}
			} else {
				$SessionNum ++;
			}
		}
		$CookieLastAccessDate{$$cookies_ref{$i}} = $$date_ref{$i};
		$LastAccessDate{$$host_ref{$i}} = $$date_ref{$i};
	}
	return $SessionNum;
}

sub GetSecDiff {
	my(@DateList) = @_;
	my @TimeList = ();
	for my $DateStr (@DateList) {
		my ($Year, $Mon, $Day, $Hour, $Min, $Sec) = $DateStr =~ /^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/;
		$Year -= 1900;
		$Mon =~ s/^0//;	$Mon --;
		$Day =~ s/^0//;
		$Hour =~ s/^0//;
		$Min =~ s/^0//;
		$Sec =~ s/^0//;
		my $Time = timelocal($Sec, $Min, $Hour, $Day, $Mon, $Year);
		push(@TimeList, $Time);
	}
	my $Diff = abs($TimeList[0] - $TimeList[1]);
	return $Diff;
}

sub GetToday {
	my @Date = localtime(time + $CONF{'TIMEDIFF'}*60*60);
	my $Year = $Date[5] + 1900;
	my $Mon = $Date[4] + 1;
	my $Day = $Date[3];
	if($Mon < 10) {$Mon = "0$Mon";}
	if($Day < 10) {$Day = "0$Day";}
	return $Year.$Mon.$Day;
}

# ����������iYYYYMMDDhhmmss�j�� YYYY/MM/DD hh:mm:ss �ɕϊ�����
sub ConvDspDate {
	my($DateStr) = @_;
	my($Year, $Mon, $Day, $Hour, $Min, $Sec) = $DateStr =~ /^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/;
	return "$Year/$Mon/$Day $Hour:$Min:$Sec";
}

# �J�n�����ƏI�������������Ƃ��A���̊Ԃ̕b����Ԃ��B
# �����́AYYYYMMDDhhmmss �`��
sub GetRangeSecond {
	my($StartStr, $EndStr) = @_;
	my($MinYear, $MinMon, $MinDay, $MinHour, $MinMin, $MinSec) = $StartStr =~ /^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/;
	my($MaxYear, $MaxMon, $MaxDay, $MaxHour, $MaxMin, $MaxSec) = $EndStr =~ /^(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/;
	$MinYear -= 1900;
	$MinMon =~ s/^0//;	$MinMon --;
	$MinDay =~ s/^0//;
	$MinHour =~ s/^0//;
	$MinMin =~ s/^0//;
	$MinSec =~ s/^0//;
	$MaxYear -= 1900;
	$MaxMon =~ s/^0//;	$MaxMon --;
	$MaxDay =~ s/^0//;
	$MaxHour =~ s/^0//;
	$MaxMin =~ s/^0//;
	$MaxSec =~ s/^0//;
	my($StartTime) = timelocal($MinSec, $MinMin, $MinHour, $MinDay, $MinMon, $MinYear);
	my($EndTime) = timelocal($MaxSec, $MaxMin, $MaxHour, $MaxDay, $MaxMon, $MaxYear);
	return abs($EndTime - $StartTime);
}


# ���O�t�@�C���̃T�C�Y�𒲂ׂ�(KB)
sub AnalyzeLogfileSize {
	my($File) = @_;
	my(@log_stat) = stat($File);
	my($log_size) = $log_stat[7];
	return $log_size;
}

sub PrintResult {
	my($Title, $ResultStr) = @_;
	my $html = &ReadTemplate("$TEMPLATEDIR/result.html");
	$html =~ s/<!--RESULT-->/$ResultStr/;
	$html =~ s/<!--TITLE-->/$Title/;
	print "Content-type: text/html; charset=Shift_JIS\n\n";
	print "$html\n";
	exit;
}


sub MakeGraph {
	my($InputData, $Titles) = @_;
	my %ElementList = %$InputData;
	my($Str);
	$Str .= "<TABLE BORDER=\"0\">\n";
	$Str .= "<TR BGCOLOR=\"#3A6EA5\">";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[0]</FONT></td>";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[1]</FONT></td>";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[2]</FONT></td>";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[3]</FONT></td>";
	$Str .= "</TR>\n";
	my $Sum = 0;
	for my $key (keys %ElementList) {
		$Sum += $ElementList{$key};
	}
	my $order = 1;
	my $dsp_order = 1;
	my($rate, $GraphLength, $pre_velue);
	foreach my $key (ValueSort(\%ElementList)) {
		unless($ElementList{$key} == $pre_velue) {
			$dsp_order = $order;
			last if($dsp_order > $CONF{'ROW'});
		}
		$rate = int($ElementList{$key} * 10000 / $Sum) / 100;
		$GraphLength = int($CONF{'GRAPHMAXLENGTH'} * $rate / 100);

		$Str .= "<TR BGCOLOR=\"#EAEAEA\">\n";
		$Str .= "  <TD><CENTER>$dsp_order</CENTER></TD>\n";
		$Str .= "  <TD>$key</TD>\n";
		$Str .= "  <TD ALIGN=\"RIGHT\">$ElementList{$key}</TD>\n";
		$Str .= "  <TD class=\"size2\">";
		if($rate < 1) {
			$Str .= "";
		} else {
			$Str .= "<IMG SRC=\"$CONF{'IMAGE_URL'}/graphbar\.gif\" WIDTH=\"$GraphLength\" HEIGHT=\"10\">";
		}
		$Str .= " ($rate%)</TD></TR>\n";
		$pre_velue = $ElementList{$key};
		$order ++;
	}
	$Str .= "</TABLE>\n";
	return $Str;
}

sub MakeGraph2 {
	my($InputData, $Titles, $ConvList) = @_;
	my %ElementList = %$InputData;
	my($Str);
	$Str .= "<TABLE BORDER=\"0\">\n";
	$Str .= "<TR BGCOLOR=\"#3A6EA5\">";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[0]</FONT></td>";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[1]</FONT></td>";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[2]</FONT></td>";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[3]</FONT></td>";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[4]</FONT></td>";
	$Str .= "</TR>\n";
	my $Sum = 0;
	for my $key (keys %ElementList) {
		$Sum += $ElementList{$key};
	}
	my $order = 1;
	my $dsp_order = 1;
	my($rate, $GraphLength, $pre_velue);
	foreach my $key (ValueSort(\%ElementList)) {
		unless($ElementList{$key} == $pre_velue) {
			$dsp_order = $order;
			last if($dsp_order > $CONF{'ROW'});
		}
		$rate = int($ElementList{$key} * 10000 / $Sum) / 100;
		$GraphLength = int($CONF{'GRAPHMAXLENGTH'} * $rate / 100);
		$Str .= "<TR BGCOLOR=\"#EAEAEA\">\n";
		$Str .= "  <TD><CENTER>$dsp_order</CENTER></TD>\n";
		$Str .= "  <TD>$key</TD>\n";
		if($$ConvList{$key}) {
			$Str .= "  <TD>$$ConvList{$key}</TD>\n";
		} else {
			$Str .= "  <TD>&nbsp;</TD>\n";
		}
		$Str .= "  <TD ALIGN=\"RIGHT\">$ElementList{$key}</TD>\n";
		$Str .= "  <TD class=\"size2\">";
		if($rate < 1) {
			$Str .= "";
		} else {
			$Str .= "<IMG SRC=\"$CONF{'IMAGE_URL'}/graphbar\.gif\" WIDTH=\"$GraphLength\" HEIGHT=\"10\">";
		}
		$Str .= " ($rate%)</TD></TR>\n";
		$pre_velue = $ElementList{$key};
		$order ++;
	}
	$Str .= "</TABLE>\n";
	return $Str;
}

sub MakeGraph3 {
	my($InputData, $Titles, $Map) = @_;
	my %ElementList = %$InputData;
	my($Str);
	$Str .= "<TABLE BORDER=\"0\">\n";
	$Str .= "<TR BGCOLOR=\"#3A6EA5\">";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[0]</FONT></td>";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[1]</FONT></td>";
	$Str .= "<td CLASS=ListHeader><FONT COLOR=\"#FFFFFF\">$$Titles[2]</FONT></td>";
	$Str .= "</TR>\n";
	my $Sum = 0;
	for my $key (keys %ElementList) {
		$Sum += $ElementList{$key};
	}
	my($rate, $GraphLength);
	foreach my $key (sort {$a <=> $b} (keys %ElementList)) {
		if($Sum == 0) {
			$rate = 0;
		} else {
			$rate = int($ElementList{$key} * 10000 / $Sum) / 100;
		}
		$GraphLength = int($CONF{'GRAPHMAXLENGTH'} * $rate / 100);

		$Str .= "<TR BGCOLOR=\"#EAEAEA\">\n";
		if($Map) {
			$Str .= "  <TD>$$Map[$key]</TD>\n";
		} else {
			$Str .= "  <TD>$key</TD>\n";
		}
		$Str .= "  <TD ALIGN=\"RIGHT\">$ElementList{$key}</TD>\n";
		$Str .= "  <TD class=\"size2\">";
		if($rate < 1) {
			$Str .= "";
		} else {
			$Str .= "<IMG SRC=\"$CONF{'IMAGE_URL'}/graphbar\.gif\" WIDTH=\"$GraphLength\" HEIGHT=\"10\">";
		}
		$Str .= " ($rate%)</TD></TR>\n";
	}
	$Str .= "</TABLE>\n";
	return $Str;
}


sub MakeCircleGraph {
	my($InputData) = @_;
	my(%ElementList) = %$InputData;
	my($ItemNum);
	$ItemNum = scalar keys %$InputData;
	if($ItemNum > 10) {
		$ItemNum = 10;
	}
	my $Str;

	if($CONF{'CIRCLE_GLAPH'}) {
		$Str .= "<APPLET\n";
		$Str .= "  CODEBASE = \"$CONF{'IMAGE_URL'}\"\n";
		$Str .= "  CODE     = \"CircleGraph.class\"\n";
		$Str .= "  NAME     = \"CircleGraph\"\n";
		$Str .= "  WIDTH    = 400\n";
		$Str .= "  HEIGHT   = 220\n";
		$Str .= "  HSPACE   = 0\n";
		$Str .= "  VSPACE   = 0\n";
		$Str .= "  ALIGN    = top\n";
		$Str .= ">\n";
		$Str .= "<PARAM NAME = \"ItemNum\" VALUE = \"$ItemNum\">\n";
		my $key;
		my $i = 1;
		my $OtherCnt = 0;
		foreach $key (ValueSort(\%ElementList)) {
			if($i < 10) {
	    		$Str .= "<PARAM NAME = \"Name$i\" VALUE = \"$key\">\n";
	    		$Str .= "<PARAM NAME = \"Value$i\" VALUE = \"$ElementList{$key}\">\n";
			} else {
				$OtherCnt += $ElementList{$key};
			}
			$i ++;
		}
		if($OtherCnt) {
			$Str .= "<PARAM NAME = \"Name10\" VALUE = \"���̑�\">\n";
			$Str .= "<PARAM NAME = \"Value10\" VALUE = \"$OtherCnt\">\n";
		}
		$Str .= "</APPLET>\n";
	} else {
		my $key;
		my $i = 1;
		my $OtherCnt = 0;
		my $list;
		foreach $key (ValueSort(\%ElementList)) {
			if($i < 10) {
				my $enc_name = &URL_Encode($key);
				$list .= "name$i=$enc_name&";
				$list .= "value$i=$ElementList{$key}&";
			} else {
				$OtherCnt += $ElementList{$key};
			}
			$i ++;
		}
		if($OtherCnt) {
			my $key = '���̑�';
			my $enc_name = &URL_Encode($key);
			$list .= "name10=$enc_name&value10=$OtherCnt";
		} else {
			$list =~ s/\&$//;
		}
		$Str .= "<OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"\n";
		$Str .= "  codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0\"\n";
		$Str .= "  WIDTH=400 HEIGHT=220>\n";
		$Str .= "  <PARAM NAME=movie VALUE=\"$CONF{'IMAGE_URL'}/CircleGraph.swf?$list\">\n";
		$Str .= "  <PARAM NAME=quality VALUE=high>\n";
		$Str .= "  <PARAM NAME=bgcolor VALUE=#FFFFFF>\n";
		$Str .= "  <EMBED\n";
		$Str .= "    src=\"$CONF{'IMAGE_URL'}/CircleGraph.swf?$list\"\n";
		$Str .= "    quality=high bgcolor=#FFFFFF\n";
		$Str .= "    WIDTH=400 HEIGHT=220\n";
		$Str .= "    TYPE=\"application/x-shockwave-flash\"\n";
		$Str .= "    PLUGINSPAGE=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\">\n";
		$Str .= "  </EMBED>\n";
		$Str .= "'</OBJECT>\n";
	}
	return $Str;
}


# URL�G���R�[�h���ꂽ��������A�f�R�[�h���ĕԂ�
sub URL_Decode {
	my($string) = @_;
	$string =~ s/%([0-9A-Fa-f]{2})/chr(hex($1))/eg;
	$string =~ s/\+/ /g;
	return $string;
}

sub URL_Encode {
	my($string) = @_;
	$string =~ s/ /+/g;
	$string =~ s/([^A-Za-z0-9\+])/'%'.unpack("H2", $1)/ego;
	return $string;
}

# ����A���A���������Ɏ��A�j���R�[�h��Ԃ��B
# ��:0, ��:1, ��:2, ��:3, ��:4, ��:5, �y:6
sub Youbi {
	my($year, $month, $day) = @_;
	$month =~ s/^0//;
	if($month eq '') {return '';}
	$day =~ s/^0//;
	my($time) = timelocal(0, 0, 0, $day, $month - 1, $year);
	my(@date_array) = localtime($time);
	return $date_array[6];
}

# ����ƌ��������Ɏ��A�Y�����̍ŏI����Ԃ�
sub LastDay {
	my($year, $month) = @_;
	$month =~ s/^0//;
	if($month =~ /[^0-9]/ || $year =~ /[^0-9]/) {
		return '';
	}
	if($month < 1 && $month > 12) {
		return '';
	}
	if($year > 2037 || $year < 1900) {
		return '';
	}
	my($lastday) = 1;
	my($time) = timelocal(0, 0, 0, 1, $month-1, $year-1900);
	my(@date_array) = localtime($time);
	my($mon) = $date_array[4];
	my($flag) = 1;
	my($count) = 0;
	while($flag) {
		if($mon ne $date_array[4]) {
			return $lastday;
			$flag = 0;
		}
		$lastday = $date_array[3];
		$time = $time + (60 * 60 * 24);
		@date_array = localtime($time);
		$count ++;
		last if($count > 40);
	}
}

sub SecureHtml {
	my($html) = @_;
	$html =~ s/\&amp;/\&/g;
	$html =~ s/\&/&amp;/g;
	$html =~ s/\"/&quot;/g;
	$html =~ s/</&lt;/g;
	$html =~ s/>/&gt;/g;
	return $html;
}

sub HtmlHeader {
	if($CONF{'AUTHFLAG'}) {
		print "P3P: CP=\"NOI TAIa\"\n";
		my $CookieHeaderString = &SetCookie('PASS', $CONF{'PASSWORD'});
		print "$CookieHeaderString\n";
	}
	print "Content-type: text/html; charset=Shift_JIS\n\n";
	print "\n";
}

sub ErrorPrint {
	my($message) = @_;
	print "Content-type: text/html; charset=Shift_JIS\n\n";
	print "<center>\n";
	print "$message\n";
	print "</center>\n";
	exit;
}


# �A�z�z���l�ivalue�j�Ń\�[�g�����A�z�z���Ԃ�
sub ValueSort {
	my $x = shift;
	my %array=%$x;
	return sort {$array{$b} <=> $array{$a};} keys %array;
}

# �w�肳�ꂽ��`�t�@�C����ǂݎ��A�A�z�z���Ԃ��B
sub ReadDef {
	my($file) = @_;
	my(@buff, %array);
	open(FILE, "$file") || &ErrorPrint("$file ���I�[�v���ł��܂���ł����B");
	while(<FILE>) {
		if(/^\s*\#/) {next;}
		chop;
		@buff = split(/=/);
		if($buff[0] && $buff[1]) {
			$array{$buff[0]} = $buff[1];
		} else {
			next;
		}
	}
	close(FILE);
	return %array;
}

sub ReadTitleDat {
	my $file = './data/title.dat';
	my(@buff, %array);
	open(FILE, "$file") || &ErrorPrint("$file ���I�[�v���ł��܂���ł����B");
	while(my $line=<FILE>) {
		if($line =~ /^\s*\#/) {next;}
		chop $line;
		if($line =~ /^([^\t]+)\t+(.+)$/) {
			$array{$1} = $2;
		} elsif($line =~ /^([^\=]+)\=(.+)$/) {
			$array{$1} = $2;
		} else {
			next;
		}
	}
	close(FILE);
	return %array;
}

sub PrintAuthForm {
	my($Repeat) = @_;
	my $html = &ReadTemplate("$TEMPLATEDIR/logon.html");
	my $form;
	if($Repeat) {
		$form .= "<font color=\"\#FF0000\">�p�X���[�h���Ⴂ�܂��B</font>\n";
	}
	$form .= $q->br;
	$form .= $q->start_form(-method=>'POST',-action=>$CGI_URL);
	$form .= "�p�X���[�h ";
	$form .= $q->password_field(-name=>'PASS');
	$form .= $q->submit(-name=>'submit', -value=>'�@�F�@�؁@');
	$html =~ s/<!--FORM-->/$form/;
	$html =~ s/<!--COPYRIGHT-->/$COPYRIGHT/g;
	$html =~ s/<!--COPYRIGHT4-->/$COPYRIGHT4/g;
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "$html\n";
	exit;
}

sub SetCookie {
	my($CookieName, $CookieValue) = @_;
	# URL�G���R�[�h
	$CookieValue =~ s/([^\w\=\& ])/'%' . unpack("H2", $1)/eg;
	$CookieValue =~ tr/ /+/;
	my($CookieHeaderString) = "Set-Cookie: $CookieName=$CookieValue\;";
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


#�w�肵��URL(URI)����AHTML�^�C�g�����擾����B
sub GetHtmlTitle {
	my($URL) = @_;
	my($Title, $Path);
	my $HtmlFile;
	if($CONF{'URL2PATH_FLAG'}) {
		my($key);
		for $key (keys %URL2PATH) {
			if($URL =~ /^$key/) {
				$HtmlFile = $URL;
				$HtmlFile =~ s/^$key/$URL2PATH{$key}/;
			}
		}
		unless($HtmlFile) {
			return '';
		}
	} else {
		$_ = $URL;
		m|https*://[^/]+/(.*)|;
		$Path = '/'.$1;
		$HtmlFile = $ENV{'DOCUMENT_ROOT'}.$Path;
	}
	$HtmlFile =~ s/\?.*$//;
	$HtmlFile =~ s/\#.*$//;
	unless(-e $HtmlFile) {return ''};
	my $size = -s $HtmlFile;
	if(!open(HTML, "$HtmlFile")) {
		return '';
	}
	binmode(HTML);	# For Windows
	my $buf;
	sysread(HTML, $buf, $size);
	close(HTML);
	if( $buf =~ /<title[^>]*>([^<]*)<\/title>/i ) {
		$Title = $1;
	}
	if($Title) {
		&Jcode::convert(\$Title, "sjis");
		return $Title;
	} else {
		return '';
	}
}


sub GetLogDateList {
	my($LogFile) = @_;
	my @DateList = ();
	if(-e $LogFile) {
		open(LOGFILE, "$LogFile") || return @DateList;
	} else {
		return @DateList;
	}
	my($Buff, $DateBuff, %DateListBuff);
	while(<LOGFILE>) {
		chop;
		next if($_ eq '');
		($Buff) = split(/\s/);
		unless($Buff) {next;}
		$DateBuff = substr($Buff, 0, 8);
		$DateListBuff{$DateBuff} ++;
	}
	close(LOGFILE);
	my $key;
	for $key (sort keys %DateListBuff) {
		if($key =~ /^[0-9]{8}$/) {
			push(@DateList, $key);
		}
	}
	return @DateList;
}


sub GetLastMonth {
	my($ThisYearMonth) = @_;
	my $ThisYear = substr($ThisYearMonth, 0, 4);
	my $ThisMonth = substr($ThisYearMonth, 4, 2);
	$ThisMonth =~ s/^0//;
	my($LastMonth, $LastYear);
	if($ThisMonth == 1) {
		$LastMonth = 12;
		$LastYear = $ThisYear - 1;
	} else {
		$LastMonth = $ThisMonth - 1;
		$LastYear = $ThisYear;
	}
	if($LastMonth < 10) {
		$LastMonth = "0$LastMonth";
	}
	return "$LastYear$LastMonth";
}


sub GetNextMonth {
	my($ThisYearMonth) = @_;
	my $ThisYear = substr($ThisYearMonth, 0, 4);
	my $ThisMonth = substr($ThisYearMonth, 4, 2);
	$ThisMonth =~ s/^0//;
	my($NextMonth, $NextYear);
	if($ThisMonth == 12) {
		$NextMonth = 1;
		$NextYear = $ThisYear + 1;
	} else {
		$NextMonth = $ThisMonth + 1;
		$NextYear = $ThisYear;
	}
	if($NextMonth < 10) {
		$NextMonth = "0$NextMonth";
	}
	return "$NextYear$NextMonth";
}


sub GetPrefKeyword {
	my($HostName) = @_;
	my (@HostParts, @TmpList);
	my $key = '';
	@HostParts = split(/\./, $HostName);
	if($HostName =~ /\.ocn\.ne\.jp$/) {
		$key = $HostParts[1];
	} elsif($HostName =~ /\.infoweb\.ne\.jp$/) {
		if($HostName =~ /^\w+\.(\w+)\.\w+\.\w+\.ppp\.infoweb\.ne\.jp$/) {
			$key = $1;
		} elsif($HostParts[0] =~ /^(nt|te)tkyo/) {
			$key = 'tkyo';
		} elsif($HostParts[0] =~ /^ntt([a-z]{4})/) {
			$key = $1;
		} elsif($HostParts[0] =~ /^(ea|ac|nt|ho|ct|st|th|ht|tc)([a-z]{4})/) {
			$key = $2;
		} elsif($HostParts[0] =~ /^([a-z]+)/) {
			$key = $1;
		}
	} elsif($HostName =~ /\.mesh\.ad\.jp$/) {
		$key = $HostParts[1];
		$key =~ s/[0-9]+$//;
	} elsif($HostName =~ /\.s[^\.]+\.a([^\.]+)\.ap\.plala\.or\.jp$/) {
		$key = 'a' . $1;
	} elsif($HostName =~ /\.dion\.ne\.jp$/) {
		$key = $HostParts[0];
		$key =~ s/[0-9\-]+//;
	} elsif($HostName =~ /\.hi-ho\.ne\.jp$/) {
		@TmpList = split(/\-/, $HostParts[0]);
		$key = $TmpList[0];
		$key =~ s/^(adsl|ea|ip)//;
		$key =~ s/[0-9]+$//;
	} elsif($HostName =~ /\.so-net\.ne\.jp$/) {
		if($HostParts[1] =~ /^ntt/) {
			$key = substr($HostParts[1], 3, 4);
		} else {
			$key = substr($HostParts[1], 0, 4);
		}
	} elsif($HostName =~ /\.dti\.ne\.jp$/) {
		@TmpList = split(/\-/, $HostParts[1]);
		$key = $TmpList[0];
	} elsif($HostName =~ /\.alpha-net\.ne\.jp$/) {
		@TmpList = split(/\-/, $HostName);
		if($TmpList[0] =~ /^fl/) {
			$_ = $TmpList[1];
		} else {
			$_ = $TmpList[0];
		}
		m/^([a-zA-Z]+)/;
		$key = $1;
	} elsif($HostName =~ /\.[A-Z]([a-z]+?)FL[0-9]+\.vectant\.ne\.jp$/i) {
		$key = $1;
	} elsif($HostName =~ /\.att\.ne\.jp$/) {
		$key = $HostParts[2];
		$key =~ s/^(ipc|dsl|ftth|newfamily)//;
		$key =~ s/^\d+m//;
		$key =~ s/[0-9]+$//;
	} elsif($HostName =~ /\.([a-zA-Z]+)\d+\.bbiq\.jp$/) {
		$key = $1;
	} elsif($HostName =~ /\.coara\.or\.jp$/) {
		@TmpList = split(/\-/, $HostParts[0]);
		$key = $TmpList[0];
		$key =~ s/[0-9]+$//;
		$key =~ s/ap$//;
	} elsif($HostName =~ /\.highway\.ne\.jp$/) {
		$key = $HostParts[1];
		$key =~ s/^ip\-//;
		$key =~ s/^e\-//;
	} elsif($HostName =~ /\.interq\.or\.jp$/) {
		@TmpList = split(/\-/, $HostParts[0]);
		$key = $TmpList[0];
		$key =~ s/ipconnect$//;
		$key =~ s/[0-9]+$//;
	} elsif($HostName =~ /\.mbn\.or\.jp$/) {
		$key = $HostParts[1];
	} elsif($HostName =~ /\.psinet.ne.jp$/) {
		$key = $HostParts[1];
		$key =~ s/^fli\-//;
	} elsif($HostName =~ /\.sannet\.ne\.jp$/) {
		$key = $HostParts[1];
	} elsif($HostName =~ /\.uu\.net$/) {
		$key = $HostParts[2];
		$key =~ s/[0-9]+$//;
	} elsif($HostName =~ /\.zero\.ad\.jp$/) {
		@TmpList = split(/\-/, $HostParts[0]);
		if($TmpList[0] eq 'f') {
			$key = $TmpList[1];
		} else {
			$key = $TmpList[0];
		}
		$key =~ s/[0-9]+$//;
	} elsif($HostName =~ /\.pias\.ne\.jp$/) {
		$_ = $HostParts[0];
		m/^([a-zA-Z]+)/;
		$key = $1;
	} elsif($HostName =~ /\.nttpc\.ne\.jp$/) {
		$key = $HostParts[2];
	} elsif($HostName =~ /\.interlink\.or\.jp$/) {
		$key = $HostParts[1];
	} elsif($HostName =~ /\.kcom\.ne\.jp$/) {
		$key = $HostParts[1];
		$key =~ s/[0-9\-]+$//;
	} elsif($HostName =~ /\.home\.ne\.jp$/) {
		$key = $HostParts[1];
		$key =~ s/[0-9]+$//;
	} elsif($HostName =~ /\.isao\.net$/) {
		$key = $HostParts[1];
		$key =~ s/[0-9]+$//;
	} else {
		my(@AreaList) = ('hokkaido', 'aomori', 'iwate', 'miyagi', 'akita', 'yamagata', 'fukushima',
	                 'ibaraki', 'tochigi', 'gunma', 'saitama', 'chiba', 'tokyo', 'kanagawa',
	                 'niigata', 'toyama', 'ishikawa', 'fukui', 'yamanashi', 'nagano', 'gifu',
	                 'shizuoka', 'aichi', 'mie', 'shiga', 'kyoto', 'osaka', 'hyogo', 'nara',
	                 'wakayama', 'tottori', 'shimane', 'okayama', 'hiroshima', 'yamaguchi',
	                 'tokushima', 'kagawa', 'ehime', 'kochi', 'fukuoka', 'saga', 'nagasaki',
	                 'kumamoto', 'oita', 'miyazaki', 'kagoshima', 'okinawa', 'sapporo',
	                 'sendai', 'chiba', 'yokohama', 'kawasaki', 'nagoya', 'kyoto', 'osaka',
	                 'kobe', 'hiroshima', 'fukuoka', 'kitakyushu');
		my $tld = pop @HostParts;
		my $sld = pop @HostParts;
		if($tld eq 'jp' and grep(/^$sld$/, @AreaList)) {
			$key = $sld;
		}
	}
	return $key;
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
	$html =~ s/<!--COPYRIGHT-->/$COPYRIGHT/;
	$html =~ s/<!--COPYRIGHT2-->/$COPYRIGHT2/g;
	$html =~ s/<!--COPYRIGHT3-->/$COPYRIGHT3/g;
	$html =~ s/<!--COPYRIGHT4-->/$COPYRIGHT4/g;
	return $html;
}

sub CheckHoliday {
	my($year, $mon, $day) = @_;
	#�w��������݂���������`�F�b�N����
	my $time;
	eval {$time = timelocal(0, 0, 0, $day, $mon-1, $year-1900);};
	if($@) {return -1;}
	#��������肷��B
	my @list = localtime($time);
	my $today = sprintf("%02d", $mon).sprintf("%02d", $day);
	my $youbi = $list[6];
	my $order = int(($day-1) / 7) + 1;
	#�O������肷��B
	my @y_list = localtime($time-60*60*24);
	my $yesterday = sprintf("%02d", $y_list[4]+1).sprintf("%02d", $y_list[3]);
	my $y_youbi = $y_list[6];
	my $y_order = int(($y_list[3] - 1) / 7) + 1;
	my $y_flag = 0;
	#��������肷��
	my @t_list = localtime($time+60*60*24);
	my $tomorrow = sprintf("%02d", $t_list[4]+1).sprintf("%02d", $t_list[3]);
	my $t_youbi = $t_list[6];
	my $t_order = int(($t_list[3] - 1) / 7) + 1;
	my $t_flag = 0;

	#���������j�����ǂ������`�F�b�N
	#���j���ł���΁A��������1��Ԃ��B
	if($youbi == 0) {return 1;}

	#���t�����܂��Ă���j�����`
	my @fix_horidays = (
		'0101',		#����
		'0211',		#�����L�O��
		'0429',		#�݂ǂ�̓�
		'0503',		#���@�L�O��
		'0505',		#���ǂ��̓�
		'1103',		#�����̓�
		'1123',		#�ΘJ���ӂ̓�
	);
	#�t���̓��ƏH���̓���}������B
	#���N�ύX�ɂȂ�̂ŁA�K�X�C�����K�v�B
	if($year eq '2003') {
		push(@fix_horidays, '0321', '0923');
	} elsif($year eq '2004') {
		push(@fix_horidays, '0320', '0923');
	}
	#1989�N�i�������N�j�ȍ~�ł���΁A�V�c�a������}������B
	if($year >= 1989) {
		push(@fix_horidays, '1223');
	}

	#�������Œ�j�����ǂ������`�F�b�N
	#�Œ�j���ł���΁A1��Ԃ��B
	if(grep(/^$today$/, @fix_horidays)) {return 1;}

	#�������ϓ��j�����ǂ������`�F�b�N
	#  ���l�̓� �P���̑�Q���j��
	if($mon eq '1' && $youbi == 1 && $order == 2) {return 1;}
	#  �C �� �� �V���̑�R���j��
	if($mon eq '7' && $youbi == 1 && $order == 3) {return 1;}
	#  �h�V�̓� �X���̑�R���j��
	if($mon eq '9' && $youbi == 1 && $order == 3) {return 1;}
	#  �̈�̓� �P�O���̑�Q���j��
	if($mon eq '10' && $youbi == 1 && $order == 2) {return 1;}

	#������Œ�j�����ǂ������`�F�b�N
	if(grep(/^$yesterday$/, @fix_horidays)) {$y_flag = 1;}
	#������ϓ��j�����ǂ������`�F�b�N
	my $y_mon = substr($yesterday, 0, 2);
	if($y_mon eq '01' && $y_youbi == 1 && $y_order == 2) {$y_flag = 1;}
	if($y_mon eq '07' && $y_youbi == 1 && $y_order == 3) {$y_flag = 1;}
	if($y_mon eq '09' && $y_youbi == 1 && $y_order == 3) {$y_flag = 1;}
	if($y_mon eq '10' && $y_youbi == 1 && $y_order == 2) {$y_flag = 1;}
	#������j���ŁA�����j���̏ꍇ�ɂ́A�����͋x��
	if($y_flag == 1 && $y_youbi == 0) {return 1;}

	#�������Œ�j�����ǂ������`�F�b�N
	if(grep(/^$tomorrow$/, @fix_horidays)) {$t_flag = 1;}
	#�������ϓ��j�����ǂ������`�F�b�N
	my $t_mon = substr($tomorrow, 0, 2);
	if($t_mon eq '01' && $t_youbi == 1 && $t_order == 2) {$t_flag = 1;}
	if($t_mon eq '07' && $t_youbi == 1 && $t_order == 3) {$t_flag = 1;}
	if($t_mon eq '09' && $t_youbi == 1 && $t_order == 3) {$t_flag = 1;}
	if($t_mon eq '10' && $t_youbi == 1 && $t_order == 2) {$t_flag = 1;}

	#����Ɩ������Ƃ��ɏj���̏ꍇ�ɂ́A�����͋x���B
	if($y_flag && $t_flag) {return 1;}

	#�ȏ�̃`�F�b�N�ɂЂ�������Ȃ�������A�x���łȂ��B
	return 0;
}

sub Auth {
	my %cookies = &GetCookie;
	my $inpass = $q->param('PASS');
	if($inpass eq '') {
		$inpass = $cookies{'PASS'};
	}
	if($inpass) {
		if($inpass ne $CONF{'PASSWORD'}) {
			&PrintAuthForm(1);
		}
	} else {
		&PrintAuthForm();
	}
}

sub SpecifyLogFileName {
	my $filename = $q->param('LOG');
	unless($filename) {
		my $date_str = &GetToday;
		my $mon_str = substr($date_str, 0, 6) . '00';
		if($CONF{'LOTATION'} == 2) {	#�����Ƃ̃��[�e�[�V����
			$filename = "$PRE_LOGNAME\.$date_str\.cgi";
		} elsif($CONF{'LOTATION'} == 3) {	#�����Ƃ̃��[�e�[�V����
			$filename = "$PRE_LOGNAME\.$mon_str\.cgi";
		} elsif($CONF{'LOTATION'} == 4) {	#�T���Ƃ̃��[�e�[�V����
			my $t = time + $CONF{'TIMEDIFF'}*60*60;
			my @date_array = localtime($t);
			my $wday = $date_array[6];
			my $epoc_time = $t;
			$epoc_time -= $wday*60*60*24;
			@date_array = localtime($epoc_time);
			my $day = $date_array[3];
			if($day < 10) {$day = "0$day";}
			my $mon = $date_array[4];
			$mon ++;	if($mon < 10) {$mon = "0$mon";}
			my $year = $date_array[5];
			$year += 1900;
			$filename = "$PRE_LOGNAME\.$year$mon$day\.cgi";
		} else {
			$filename = "$PRE_LOGNAME\.cgi";
		}
	}
	return $filename
}

sub RedirectPage {
	my($url) = @_;
	print $q->header(-type=>'text/html; charset=Shift_JIS');
	print "<html><head><title>$COPYRIGHT</title>";
	print "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=$url\">";
	print "</head><body>\n";
	print "�����I�ɓ]�����܂��B�]�����Ȃ��ꍇ�ɂ�<a href=\"$url\">������</a>���N���b�N���ĉ������B\n";
	print "</body></html>\n";
	exit;
}

sub GetDomainByHostname {
	my($host) = @_;
	my %tld_fix = (
		'com' =>'2', 'net'=>'2', 'org'=>'2', 'biz'=>'2', 'info'=>'2', 'name'=>'3',
		'aero'=>'2', 'coop'=>'2', 'museum'=>'2', 'pro'=>'3', 'edu'=>'2', 'gov'=>'2',
		'mil'=>'2', 'int'=>'2', 'arpa'=>'2', 'nato'=>'2',
		'hk'=>'3', 'sg'=>'3', 'kr'=>'3', 'uk'=>'3'
	);
	my %sld_fix = (
		#���{
		'ac.jp'=>'3', 'ad.jp'=>'3', 'co.jp'=>'3', 'ed.jp'=>'3', 'go.jp'=>'3',
		'gr.jp'=>'3', 'lg.jp'=>'3', 'ne.jp'=>'3', 'or.jp'=>'3',
		'hokkaido.jp'=>'3', 'aomori.jp'=>'3', 'iwate.jp'=>'3', 'miyagi.jp'=>'3',
		'akita.jp'=>'3', 'yamagata.jp'=>'3', 'fukushima.jp'=>'3', 'ibaraki.jp'=>'3',
		'tochigi.jp'=>'3', 'gunma.jp'=>'3', 'saitama.jp'=>'3', 'chiba.jp'=>'3',
		'tokyo.jp'=>'3', 'kanagawa.jp'=>'3', 'niigata.jp'=>'3', 'toyama.jp'=>'3',
		'ishikawa.jp'=>'3', 'fukui.jp'=>'3', 'yamanashi.jp'=>'3', 'nagano.jp'=>'3',
		'gifu.jp'=>'3', 'shizuoka.jp'=>'3', 'aichi.jp'=>'3', 'mie.jp'=>'3',
		'shiga.jp'=>'3', 'kyoto.jp'=>'3', 'osaka.jp'=>'3', 'hyogo.jp'=>'3',
		'nara.jp'=>'3', 'wakayama.jp'=>'3', 'tottori.jp'=>'3', 'shimane.jp'=>'3',
		'okayama.jp'=>'3', 'hiroshima.jp'=>'3', 'yamaguchi.jp'=>'3', 'tokushima.jp'=>'3',
		'kagawa.jp'=>'3', 'ehime.jp'=>'3', 'kochi.jp'=>'3', 'fukuoka.jp'=>'3',
		'saga.jp'=>'3', 'nagasaki.jp'=>'3', 'kumamoto.jp'=>'3', 'oita.jp'=>'3',
		'miyazaki.jp'=>'3', 'kagoshima.jp'=>'3', 'okinawa.jp'=>'3', 'sapporo.jp'=>'3',
		'sendai.jp'=>'3', 'chiba.jp'=>'3', 'yokohama.jp'=>'3', 'kawasaki.jp'=>'3',
		'nagoya.jp'=>'3', 'kyoto.jp'=>'3', 'osaka.jp'=>'3', 'kobe.jp'=>'3',
		'hiroshima.jp'=>'3', 'fukuoka.jp'=>'3', 'kitakyushu.jp'=>'3',
		#��p
		'com.tw'=>'3', 'net.tw'=>'3', 'org.tw'=>'3', 'idv.tw'=>'3', 'game.tw'=>'3',
		'ebiz.tw'=>'3', 'club.tw'=>'3',
		#����
		'com.cn'=>'3', 'net.cn'=>'3', 'org.cn'=>'3', 'gov.cn'=>'3', 'ac.cn'=>'3',
		'edu.cn'=>'3'
	);
	my($level3, $level2, $level1) = $host =~ /([^\.]+)\.([^\.]+)\.([^\.]+)$/;
	my $org_domain;
	if(my $dom_level = $tld_fix{$level1}) {
		if($dom_level eq '2') {
			$org_domain = "${level2}.${level1}";
		} else {
			$org_domain = "${level3}.${level2}.${level1}";
		}
	} elsif($sld_fix{"${level2}.${level1}"}) {
		$org_domain = "${level3}.${level2}.${level1}";
	} else {
		$org_domain = "${level2}.${level1}";
	}
	return $org_domain;
}

sub CommaFormat {
	my($num) = @_;
	#�����ƃh�b�g�ȊO�̕������܂܂�Ă�����A���������̂܂ܕԂ��B
	if($num =~ /[^0-9\.]/) {return $num;}
	#���������Ə����_�𕪗�
	my($int, $decimal) = split(/\./, $num);
	#���������̌����𒲂ׂ�
	my $figure = length $int;
	my $commaformat;
	#���������ɃJ���}��}��
	for(my $i=1;$i<=$figure;$i++) {
		my $n = substr($int, $figure-$i, 1);
		if(($i-1) % 3 == 0 && $i != 1) {
			$commaformat = "$n,$commaformat";
		} else {
			$commaformat = "$n$commaformat";
		}
	}
	#�����_������΁A�����������
	if($decimal) {
		$commaformat .= "\.$decimal";
	}
	#���ʂ�Ԃ�
	return $commaformat;
}

sub User_Agent {
	my($user_agent, $remote_host) = @_;
	my($platform, @agentPart, $browser, $browser_v);
	my($platform_v, @agentPart2, $user_agent2, @buff, @buff2, @buff3);
	my($flag, $key, @version_buff);

	if($user_agent =~ /DoCoMo/i) {
		$platform = 'DoCoMo';
		@agentPart = split(/\//, $user_agent);
		$browser = 'DoCoMo';
		$browser_v = $agentPart[1];
		$platform_v = $agentPart[2];
		if($platform_v eq '') {
			if($user_agent =~ /DoCoMo\/([0-9\.]+)\s+([0-9a-zA-Z]+)/) {
				$browser_v = $1;
				$platform_v = $2;
			}
		}
	} elsif($user_agent =~ /NetPositive/i) {
		$browser = 'NetPositive';
		if($user_agent =~ /NetPositive\/([0-9\.\-]+)/) {
			$browser_v = $1;
		}
		$platform = 'BeOS';
		$platform_v = '';
	} elsif($user_agent =~ /OmniWeb/) {
		$browser = 'OmniWeb';
		if($user_agent =~ /Mac_PowerPC/i) {
			$platform = 'MacOS';
			$platform_v = 'PowerPC';
		} else {
			$platform = '';
			$platform_v = '';
		}
		if($user_agent =~ /OmniWeb\/([0-9\.]+)/) {
			$browser_v = $1;
		} else {
			$browser_v = '';
		}
	} elsif($user_agent =~ /Cuam/i) {
		$browser = 'Cuam';
		$platform = 'Windows';
		$browser_v = '';
		$platform_v = '';
		if($user_agent =~ /Cuam Ver([0-9\.]+)/i) {
			$platform_v = '';
			$browser_v = $1;
		} else {
			if($user_agent =~ /Windows\s+([^\;\)]+)/) {
				$platform_v = $1;
			}
			if($user_agent =~ /Cuam\s+(0-9a-z\.)/) {
				$browser_v = $1;
			}
		}
	} elsif($user_agent =~ /^JustView\/([0-9\.]+)/) {
		$platform = 'Windows';
		$platform_v = '';
		$browser = 'JustView';
		$browser_v = $1;
	} elsif($user_agent =~ /^sharp pda browser\/([0-9\.]+).*\((.+)\//) {
		$platform = 'ZAURUS';
		$platform_v = $2;
		$browser = 'sharp_pda_browser';
		$browser_v = $1;
	} elsif($user_agent =~ /DreamPassport\/([0-9\.]+)/) {
		$platform = 'Dreamcast';
		$platform_v = '';
		$browser = 'DreamPassport';
		$browser_v = $1;
	} elsif($user_agent =~ /^Sonybrowser2 \(.+\/PlayStation2 .+\)/) {
		$platform = 'PlayStation2';
		$platform_v = '';
		$browser = 'Sonybrowser2';
		$browser_v = '';
	} elsif($user_agent =~ /(CBBoard|CBBstandard)\-[0-9\.]+/) {
		$platform = 'DoCoMo';
		$platform_v = 'ColorBrowserBorad';
		$browser = 'DoCoMo';
		$browser_v = 'ColorBrowserBorad';
	} elsif($user_agent =~ /^PDXGW/) {
		$platform = 'DDI POCKET';
		$platform_v = 'H"';
		$browser = 'DDI POCKET';
		$browser_v = 'H"';
	} elsif($user_agent =~ /^Sleipnir Version ([0-9\.]+)/) {
		$browser = 'Sleipnir';
		$browser_v = $1;
		$platform = 'Windows';
		$platform_v = '';
	} elsif($user_agent =~ /Safari\/([0-9]+)/) {
		$browser = 'Safari';
		$browser_v = $1;
		$platform = 'MacOS';
		if($user_agent =~ / PPC /) {
			$platform_v = 'PowerPC';
		}
	} elsif($user_agent =~ /UP\.\s*Browser/i) {
		$user_agent =~ s/UP\.\s*Browser/UP\.Browser/;
		$browser = 'UP.Browser';
		@agentPart = split(/ /, $user_agent);
		if($agentPart[0] =~ /KDDI/i) {
			my @tmp = split(/\-/, $agentPart[0]);
			$platform_v = $tmp[1];
			my @tmp2 = split(/\//, $agentPart[1]);
			$browser_v = $tmp2[1];
		} else {
			@agentPart2 = split(/\//, $agentPart[0]);
			($browser_v, $platform_v) = split(/\-/, $agentPart2[1]);
		}
		my %devid_list = (
			'P-PAT'=>'DoCoMo,P-PAT',
			'D2'=>'DoCoMo,D2',
			'SA31' => 'au,W21SA',
			'KC32' => 'au,W21K',
			'KC31' => 'au,W11K',
			'SN31' => 'au,W21S',
			'HI32' => 'au,W21H',
			'HI31' => 'au,W11H',
			'ST22' => 'au,INFOBAR',
			'SA27' => 'au,A5505SA',
			'SA26' => 'au,A5503SA',
			'TS26' => 'au,A5501T',
			'CA25' => 'au,A5406CA',
			'SN25' => 'au,A5404S',
			'SN24' => 'au,A5402S',
			'CA23' => 'au,A5401CA',
			'KC22' => 'au,A5305K',
			'HI24' => 'au,A5303H II',
			'CA22' => 'au,A5302CA',
			'TS21' => 'au,C5001T',
			'TS28' => 'au,A5506T',
			'TS27' => 'au,A5504T',
			'KC24' => 'au,A5502K',
			'KC25' => 'au,A5502K',
			'CA26' => 'au,A5407CA',
			'ST23' => 'au,A5405SA',
			'CA24' => 'au,A5403CA',
			'CA23' => 'au,A5401CA II',
			'ST21' => 'au,A5306ST',
			'TS24' => 'au,A5304T',
			'HI23' => 'au,A5303H',
			'TS23' => 'au,A5301T',
			'SN27' => 'au,A1402S II',
			'SN26' => 'au,A1402S',
			'SA28' => 'au,A1305SA',
			'TS25' => 'au,A1304T',
			'SA24' => 'au,A1302SA',
			'SN22' => 'au,A1101S',
			'SN28' => 'au,A1402S II',
			'KC23' => 'au,A1401K',
			'TS25' => 'au,A1304T II',
			'SA25' => 'au,A1303SA',
			'SN23' => 'au,A1301S',
			'SA22' => 'au,A3015SA',
			'TS22' => 'au,A3013T',
			'SA21' => 'au,A3011SA',
			'KC21' => 'au,C3002K',
			'SN21' => 'au,A3014S',
			'CA21' => 'au,A3012CA',
			'MA21' => 'au,C3003P',
			'HI21' => 'au,C3001H',
			'ST14' => 'au,A1014ST',
			'KC14' => 'au,A1012K',
			'SN17' => 'au,C1002S',
			'CA14' => 'au,C452CA',
			'TS14' => 'au,C415T',
			'SN15' => 'au,C413S',
			'SN16' => 'au,C413S',
			'ST12' => 'au,C411ST',
			'CA13' => 'au,C409CA',
			'HI13' => 'au,C407H',
			'SY13' => 'au,C405SA',
			'ST11' => 'au,C403ST',
			'SY12' => 'au,C401SA',
			'CA12' => 'au,C311CA',
			'HI12' => 'au,C309H',
			'KC11' => 'au,C307K',
			'SY11' => 'au,C304SA',
			'HI11' => 'au,C302H',
			'DN01' => 'au,C202DE',
			'KC15' => 'au,A1013K',
			'ST13' => 'au,A1011ST',
			'SY15' => 'au,C1001SA',
			'HI14' => 'au,C451H',
			'KC13' => 'au,C414K',
			'SY14' => 'au,C412SA',
			'TS13' => 'au,C410T',
			'MA13' => 'au,C408P',
			'SN13' => 'au,C406S',
			'SN12' => 'au,C404S',
			'SN14' => 'au,C404S',
			'DN11' => 'au,C402DE',
			'KC12' => 'au,C313K',
			'TS12' => 'au,C310T',
			'MA11' => 'au,C308P',
			'MA12' => 'au,C308P',
			'SN11' => 'au,C305S',
			'CA11' => 'au,C303CA',
			'TS11' => 'au,C301T',
			'HI01' => 'au,C201H',
			'HI02' => 'au,C201H',
			'KCU1' => 'TU-KA,TK41',
			'KCTD' => 'TU-KA,TK40',
			'TST7' => 'TU-KA,TT31',
			'SYT4' => 'TU-KA,TS31',
			'KCTA' => 'TU-KA,TK22',
			'KCT9' => 'TU-KA,TK21',
			'TST4' => 'TU-KA,TT11',
			'SYT3' => 'TU-KA,TS11',
			'MIT1' => 'TU-KA,TD11',
			'KCT6' => 'TU-KA,TK05',
			'KCT5' => 'TU-KA,TK04',
			'SYT2' => 'TU-KA,TS02',
			'TST2' => 'TU-KA,TT02',
			'KCT1' => 'TU-KA,TK01',
			'SYT1' => 'TU-KA,TSO1',
			'SYT5' => 'TU-KA,TS41',
			'TST8' => 'TU-KA,TT32',
			'KCTC' => 'TU-KA,TK31',
			'KCTB' => 'TU-KA,TK23',
			'TST6' => 'TU-KA,TT22',
			'TST5' => 'TU-KA,TT21',
			'KCT8' => 'TU-KA,TK12',
			'KCT7' => 'TU-KA,TK11',
			'MAT3' => 'TU-KA,TP11',
			'TST3' => 'TU-KA,TT03',
			'KCT4' => 'TU-KA,TK03',
			'MAT1' => 'TU-KA,TP01',
			'MAT2' => 'TU-KA,TP01',
			'KCT2' => 'TU-KA,TK02',
			'KCT3' => 'TU-KA,TK02',
			'TST1' => 'TU-KA,TT01',
			'NT95'=>'UP.SDK',
			'UPG'=>'UP.SDK'
		);
		if($devid_list{$platform_v} eq '') {
			$platform = '';
			$platform_v = '';
		} else {
			($platform, $platform_v) = split(/,/, $devid_list{$platform_v});
		}
	} elsif($user_agent =~ /^J-PHONE/) {
		$platform = 'vodafone';
		$browser = 'vodafone';
		my @parts = split(/\//, $user_agent);
		$browser_v = $parts[1];
		$platform_v = $parts[2];
	} elsif($user_agent =~ /^ASTEL\/(.+)\/(.+)\/(.+)\//) {
		$platform = 'ASTEL';
		$browser = 'ASTEL';
		$browser_v = '';
		$platform_v = substr($2, 0, 5);
	} elsif($user_agent =~ /^Mozilla\/.+ AVE-Front\/(.+) \(.+\;Product=(.+)\;.+\)/) {
		$browser = 'NetFront';
		$browser_v = $1;
		$platform = $2;
		$platform_v = '';
	} elsif($user_agent =~ /^Mozilla\/.+ Foliage-iBrowser\/([0-9\.]+) \(WinCE\)/) {
		$platform = 'Windows';
		$platform_v = 'CE';
		$browser = 'Foliage-iBrowser';
		$browser_v = $1;		
	} elsif($user_agent =~ /^Mozilla\/.+\(compatible\; MSPIE ([0-9\.]+)\; Windows CE/) {
		$platform = 'Windows';
		$platform_v = 'CE';
		$browser = 'PocketIE';
		$browser_v = $1;
	} elsif($user_agent =~ /Opera/) {
		$browser = "Opera";
		if($user_agent =~ /^Opera\/([0-9\.]+)/) {
			$browser_v = $1;
		} elsif($user_agent =~ /Opera\s+([0-9\.]+)/) {
			$browser_v = $1;
		} else {
			$browser_v = '';
		}
		if($user_agent =~ /Windows\s+([^\;]+)(\;|\))/i) {
			$platform = "Windows";
			$platform_v = $1;
			if($platform_v eq 'NT 5.0') {
				$platform_v = '2000';
			} elsif($platform_v eq 'NT 5.1') {
				$platform_v = 'XP';
			} elsif($platform_v eq 'NT 5.2') {
				$platform_v = '2003';
			} elsif($platform_v eq 'ME') {
				$platform_v = 'Me';
			}
		} elsif($user_agent =~ /Macintosh\;[^\;]+\;([^\)]+)\)/) {
			$platform = "MacOS";
			$platform_v = $1;
			if($platform_v eq 'PPC') {
				$platform_v = 'PowerPC';
			}
		} elsif($user_agent =~ /Mac_PowerPC/i) {
			$platform = 'MacOS';
			$platform_v = 'PowerPC';
		} elsif($user_agent =~ /Linux\s+([0-9\.\-]+)/) {
			$platform = "Linux";
			$platform_v = $1;
		} elsif($user_agent =~ /BeOS ([A-Z0-9\.\-]+)(\;|\))/) {
			$platform = 'BeOS';
			$platform_v = $1;
		} else {
			$platform = '';
			$platform_v = '';
		}
	} elsif($user_agent =~ /^Mozilla\/[^\(]+\(compatible\; MSIE .+\)/) {
		if($user_agent =~ /NetCaptor ([0-9\.]+)/) {
			$browser = 'NetCaptor';
			$browser_v = $1;
		} else {
			$browser = 'InternetExplorer';
			$user_agent2 = $user_agent;
			$user_agent2 =~ s/ //g;
			@buff = split(/\;/, $user_agent2);
			@version_buff = grep(/MSIE/i, @buff);
			$browser_v = $version_buff[0];
			$browser_v =~ s/MSIE//g;
			if($browser_v =~ /^([0-9]+)\.([0-9]+)/) {
        			$browser_v = "$1\.$2";
			}
		}

		if($user_agent =~ /Windows 3\.1/i) {
			$platform = 'Windows';
			$platform_v = '3.1';
		} elsif($user_agent =~ /Win32/i) {
			$platform = 'Windows';
			$platform_v = '32';
		} elsif($user_agent =~ /Windows 95/i) {
			$platform = 'Windows';
			$platform_v = '95';
		} elsif($user_agent =~ /Windows 98/i) {
			$platform = 'Windows';
			if($user_agent =~ /Win 9x 4\.90/) {
				$platform_v = 'Me';
			} else {
				$platform_v = '98';
			}
		} elsif($user_agent =~ /Windows NT 5\.0/i) {
			$platform = 'Windows';
			$platform_v = '2000';
		} elsif($user_agent =~ /Windows NT 5\.1/i) {
			$platform = 'Windows';
			$platform_v = 'XP';
		} elsif($user_agent =~ /Windows NT/i 
				&& $user_agent !~ /Windows NT 5\.0/i) {
			$platform = 'Windows';
			$platform_v = 'NT';
		} elsif($user_agent =~ /Windows 2000/) {
			$platform = 'Windows';
			$platform_v = '2000';
		} elsif($user_agent =~ /Windows ME/i) {
			$platform = 'Windows';
			$platform_v = 'Me';
		} elsif($user_agent =~ /Windows XP/i) {
			$platform = 'Windows';
			$platform_v = 'XP';
		} elsif($user_agent =~ /Windows CE/i) {
			$platform = 'Windows';
			$platform_v = 'CE';
		} elsif($user_agent =~ /Mac/i) {
			$platform = 'MacOS';
			if($user_agent =~ /Mac_68000/i) {
				$platform_v = '68K';
			} elsif($user_agent =~ /Mac_PowerPC/i) {
				$platform_v = 'PowerPC';
			}
		} elsif($user_agent =~ /WebTV/i) {
			$platform = 'WebTV';
			@buff2 = split(/ /, $user_agent);
			@buff3 = split(/\//, $buff2[1]);
			$platform_v = $buff3[1];
		} else {
			$platform = '';
			$platform_v = '';
		}
	} elsif($user_agent =~ /^Mozilla\/([0-9\.]+)/) {
		$browser = 'NetscapeNavigator';
		$browser_v = $1;
		if($user_agent =~ /Gecko\//) {
			if($user_agent =~ /Netscape[0-9]*\/([0-9a-zA-Z\.]+)/) {
				$browser_v = $1;
			} elsif($user_agent =~ /(Phoenix|Chimera|Firefox|Camino)\/([0-9a-zA-Z\.]+)/) {
				$browser = $1;
				$browser_v = $2;
			} else {
				$browser = 'Mozilla';
				if($user_agent =~ /rv:([0-9\.]+)/) {
					$browser_v = $1;
				} else {
					$browser_v = '';
				}
			}
		}

		if($user_agent =~ /Win95/) {
			$platform = 'Windows';
			$platform_v = '95';
		} elsif($user_agent =~ /Windows 95/) {
			$platform = 'Windows';
			$platform_v = '95';
		} elsif($user_agent =~ /Win 9x 4\.90/i) {
			$platform = 'Windows';
			$platform_v = 'Me';
		} elsif($user_agent =~ /Windows Me/i) {
			$platform = 'Windows';
			$platform_v = 'Me';
		} elsif($user_agent =~ /Win98/i) {
			$platform = 'Windows';
			$platform_v = '98';
		} elsif($user_agent =~ /WinNT/i) {
			$platform = 'Windows';
			$platform_v = 'NT';
		} elsif($user_agent =~ /Windows NT 5\.0/i) {
			$platform = 'Windows';
			$platform_v = '2000';
		} elsif($user_agent =~ /Windows NT 5\.1/i) {
			$platform = 'Windows';
			$platform_v = 'XP';
		} elsif($user_agent =~ /Windows 2000/i) {
			$platform = 'Windows';
			$platform_v = '2000';
		} elsif($user_agent =~ /Windows XP/i) {
			$platform = 'Windows';
			$platform_v = 'XP';
		} elsif($user_agent =~ /Macintosh/i) {
			$platform = 'MacOS';
			if($user_agent =~ /68K/i) {
				$platform_v = '68K';
			} elsif($user_agent =~ /PPC/i) {
				$platform_v = 'PowerPC';
			}
		} elsif($user_agent =~ /SunOS/i) {
			$platform = 'SunOS';
			if($user_agent =~ /SunOS\s+([0-9\-\.]+)/i) {
				$platform_v = $1;
			} else {
				$platform_v = '';
			}
		} elsif($user_agent =~ /Linux/i) {
			$platform = 'Linux';
			if($user_agent =~ /Linux\s+([0-9\-\.]+)/) {
				$platform_v = $1;
			} else {
				$platform_v = '';
			}
		} elsif($user_agent =~ /FreeBSD/i) {
			$platform = 'FreeBSD';
			if($user_agent =~ /FreeBSD\s+([a-zA-Z0-9\.\-\_]+)/i) {
				$platform_v = $1;
			} else {
				$platform_v = '';
			}
		} elsif($user_agent =~ /NetBSD/i) {
			$platform = 'NetBSD';
			$platform_v = '';
		} elsif($user_agent =~ /AIX/i) {
			$platform = 'AIX';
			if($user_agent =~ /AIX\s+([0-9\.]+)/) {
				$platform_v = $1;
			} else {
				$platform_v = '';
			}
		} elsif($user_agent =~ /IRIX/i) {
			$platform = 'IRIX';
			if($user_agent =~ /IRIX\s+([0-9\.]+)/i) {
				$platform_v = $1;
			} else {
				$platform_v = '';
			}
		} elsif($user_agent =~ /HP-UX/i) {
			$platform = 'HP-UX';
			if($user_agent =~ /HP-UX\s+([a-zA-Z0-9\.]+)/i) {
				$platform_v = $1;
			} else {
				$platform_v = '';
			}
		} elsif($user_agent =~ /OSF1/i) {
			$platform = 'OSF1';
			if($user_agent =~ /OSF1\s+([a-zA-Z0-9\.]+)/i) {
				$platform_v = $1;
			} else {
				$platform_v = '';
			}
		} elsif($user_agent =~ /BeOS/i) {
			$platform = 'BeOS';
			$platform_v = '';
		} else {
			$platform = '';
			$platform_v = '';
		}
	} else {
		$platform = '';
		$platform_v = '';
		$browser = '';
		$browser_v = '';
	}

	return ($platform, $platform_v, $browser, $browser_v);

}


