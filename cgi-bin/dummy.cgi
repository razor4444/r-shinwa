#!/usr/bin/perl
###########################################################
# �ե�����̾��:: dummy.cgi
#
#   ��ǽ: �ƥ���CGI������ץ� 
#
# location : URL location
# comments : comments for url
###########################################################
&ReadParse;
$SENDMAIL = '/usr/sbin/sendmail';
$MailTo = 'administrator@r-shinwa.jp';
###########################################################
print "Content-type: text/html\n\n";
###########################################################
if ($in{'val'} !~ /1/) {
	# �ȥåץڡ���
	print "<HTML>\n";
	print "<HEAD><TITLE>alpha-mail dummy.cgi</TITLE></HEAD>\n";
	print "<BODY>\n";
	print "���Υڡ����ϡ�CGI�Υƥ����ѤǤ���<BR>\n";
	print "�ʲ������Ϲ��ܤ�ʸ��(Ⱦ�ѱѿ���)�����Ϥ���Ȥ���ʸ���������ԤΥ᡼�륢�ɥ쥹�������ޤ���<P>\n";
	print "<FORM METHOD=post ACTION=/cgi-bin/dummy.cgi>\n";
	print "<INPUT TYPE=hidden NAME=val VALUE=1>\n";
	print "<INPUT TYPE=text NAME=msg>\n";
	print "<INPUT TYPE=submit VALUE=OK>\n";
	print "</BODY>\n";
	print "</HTML>\n";
} else {
	# �᡼����������
	&send_mail;
	# ���ڡ���
	print "<HTML>\n";
	print "<HEAD><TITLE>alpha-mail dummy.cgi</TITLE></HEAD>\n";
	print "<BODY>\n";
	print "�᡼������ꤤ�����ޤ�����<BR>\n";
	print "��ǧ�򤪴ꤤ�������ޤ���<P>\n";
	print "</BODY>\n";
	print "</HTML>\n";
}

exit;

###########################################################
# ����ʸ���β���
sub ReadParse
{
	# �ʲ����ѿ��ϥ�����
	local ($pair, $key, $val);

	if (&MethGet) {
		# �Ķ��ѿ� QUERY_STRING �����ꤵ�줿ʸ�����������롣
		$in = $ENV{'QUERY_STRING'};
	} elsif ($ENV{'REQUEST_METHOD'} eq "POST") {
		# ɸ�����Ϥ����������������롣
		read(STDIN,$in,$ENV{'CONTENT_LENGTH'});
		# �⤷Ƭ�� NULL ʸ�����Ĥ��Ƥ���������� (pending)
		# proxy ������δط��Ǥ��Τ褦���б��򤷤Ƥ��롣
		# ����ʤ����ɬ�פʤΤ����꤬ľ�ä��Ȥ��ˤ��Τ����ΰ�ԤϺ�����롣
		$in =~ s/^\0//eg;
	}

	# ���Ϥ�ʬ�䤹�롣
	@in = split(/&/,$in);

	foreach $pair (@in) {
		# key=val ��ʬ�䤹�롣
		($key, $val) = split(/=/,$pair);

		# url-encoding ���줿16�ʿ���ǥ����ɤ��롣
		$val =~ s/\+/ /g;
		$key =~ s/%([A-F0-9][A-F0-9])/pack("c",hex($1))/egi;
		$val =~ s/%([A-F0-9][A-F0-9])/pack("c",hex($1))/egi;

		# Ϣ������ %in �� key,val �����ꤹ�롣
		$in{$key} .= "\0" if (defined($in{$key})); 
		$in{$key} .= $val;
	}
	return length($in); 
}
###########################################################
sub MethGet {
  return ($ENV{'REQUEST_METHOD'} eq "GET");
}
###########################################################
# mail �ǿ��������򤹤롣
sub send_mail {
	open(MAIL, "| $SENDMAIL -t -oi");
	print MAIL "From: $MailTo\n";
	print MAIL "To: $MailTo\n";
	print MAIL "Subject: dummy.cgi test mail\n\n";
	print MAIL "InputData ->  $in{'msg'}\n";
	close(MAIL);
}
###########################################################
