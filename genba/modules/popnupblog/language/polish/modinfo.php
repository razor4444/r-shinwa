<?php
// $Id: modinfo.php,v 1.1.1.1 2005/08/28 02:13:09 yoshis Exp $ 

define('_MI_POPNUPBLOG_APPL_DESC', '');
define('_MI_POPNUPBLOG_1_LINE', 'Blog z nowym wpisem');
define('_MI_POPNUPBLOG_CONF_DESC', 'Opis');
define('_MI_POPNUPBLOG_TRACKBACK', 'TrackBack');
define('_MI_POPNUPBLOG_REWRITE_TITLE', 'U�ywaj Apache rewrite engine');
define('_MI_POPNUPBLOG_NAME', 'Blogi');
define('_MI_POPNUPBLOG_DESC', 'Blogi');
define('_MI_POPNUPBLOG_UNUSE_UPDATE_PING', 'Nie u�ywaj update ping');
define('_MI_POPNUPBLOG_UNUSE_TRACKBACK', 'Nie u�ywaj trackback');
define('_MI_POPNUPBLOG_APPL_WAITING_TITLE', 'Nowe zg�oszenie na blogach');
define('_MI_POPNUPBLOG_NAME_BIG_BLOCK', 'Blogi');
define('_MI_POPNUPBLOG_USE_REWRITE', 'U�ywaj rewrite');
define('_MI_POPNUPBLOG_UPDATE_PING', 'U�ywaj update ping');
define('_MI_POPNUPBLOG_1_LINE_DESC', 'blok widoku 1 linii');
define('_MI_POPNUPBLOG_REWRITE_DESC', 'U�ytkownik mo�e u�y� adresu url from/modules/popnupblog/view/index.php?uid=1 do /modules/popnupblog/view/1.html (tylko dla ekspert�w)');
define('_MI_POPNUPBLOG_APPL_WAITING', 'Nowe zg�oszenie');
define('_MI_POPNUPBLOG_UPDATE_PING_DESC', 'U�ywaj update ping');
define('_MI_POPNUPBLOG_WRITE', 'Pisz bloga');
define('_MI_POPNUPBLOG_PREFERENCE', 'Preferencje');
define('_MI_POPNUPBLOG_APPLY', 'Nowy blog');
define('_MI_POPNUPBLOG_TRACKBACK_DESC', 'W��cz funkcj� TrackBack');
define('_MI_POPNUPBLOG_UNUSE_REWRITE', 'Nie u�ywaj rewrite');
define('_MI_POPNUPBLOG_APPL_DENY', 'Odmowa');
define('_MI_POPNUPBLOG_CONFIG_RSS_DEF', 'U�ytkownik blog�w mo�e pisa�');
define('_MI_POPNUPBLOG_USE_TRACKBACK', 'U�yj trackback');
define('_MI_POPNUPBLOG_APPL_ALLOW', 'Zgoda');
define('_MI_POPNUPBLOG_APPL_OK', 'Zatwierd� zg�oszenie u�ytkownika');
define('_MI_POPNUPBLOG_USE_UPDATE_PING', 'U�yj update ping');
define('_MI_POPNUPBLOG_CONFIG_RSS_DESC', 'Opis tego bloga dla wie�ci RSS');
// Add 2006.02.02 by yoshis
define('_MI_POPNUPBLOG_FILECHRSET', 'Spos�b kodowania za��czanych plik�w');
define('_MI_POPNUPBLOG_FILECHRSET_DESC', 'Ustaw kodowanie do zapisania na serwerze. (ASCII,UTF-8,EUC etc)');
// Add 2004.10.27 by yoshis
define('_MI_POPNUPBLOG_MAILSERVER', 'Mail Server');
define('_MI_POPNUPBLOG_MAILSERVER_DESC', 'Wpisz pop3 mail server do otrzymywania bloga.');
define('_MI_POPNUPBLOG_MAILUSER', 'Mail User');
define('_MI_POPNUPBLOG_MAILUSER_DESC', 'Wpisz mail username do otrzymywania bloga.');
define('_MI_POPNUPBLOG_MAILPWD', 'Mail Password');
define('_MI_POPNUPBLOG_MAILPWD_DESC', 'Wpisz mail password do otrzymywania bloga.');
define('_MI_POPNUPBLOG_MAILADDR', 'Mail Address');
define('_MI_POPNUPBLOG_MAILADDR_DESC', 'Wpisz adres e-mail do otrzymywania bloga.');
// Add 2005.01.22 by yoshis
define("_MI_POPNUPBLOG_GUESTBLOGID","Zezwalaj na Blog ID z anonimowego e-maila");
define("_MI_POPNUPBLOG_ACTVTYPE","Wybierz spos�b aktywowania nowo zak�adanych blog�w");
define("_MI_POPNUPBLOG_AUTOACTV","Aktywacja automatyczna");
define("_MI_POPNUPBLOG_ADMINACTV","Aktywacja przez administratora");
define("_MI_POPNUPBLOG_NEWUNOTIFY","Powiadomi� e-mailem o zarejestrowaniu nowego bloga?");
define("_MI_POPNUPBLOG_SHOWNAME","Zamieniaj nazw� u�ytkownika na jego prawdziwe imi� i nazwisko");
// Add 2006.03.21 by yoshis
define("_MI_POPNUPBLOG_GROUPSETBYUSER","Grupowe uprawnienia przez u�ytkownika (pisanie, czytanie, komentowanie, g�osowanie)");

// For Notify
define ('_MI_POPNUPBLOG_BLOG_NOTIFY', 'Blogi');
define ('_MI_POPNUPBLOG_BLOG_NOTIFYDSC', 'Opcje powiadomie� odnosz�ce si� do tego bloga.');

define ('_MI_POPNUPBLOG_GLOBAL_NOTIFY', 'Globalne');
define ('_MI_POPNUPBLOG_GLOBAL_NOTIFYDSC', 'Globalne opcje powiadomie� o blogu.');

define ('_MI_POPNUPBLOG_BLOG_NEWPOST_NOTIFY', 'Nowy wpis');
define ('_MI_POPNUPBLOG_BLOG_NEWPOST_NOTIFYCAP', 'Powiadamiaj mnie o ka�dym nowym wpisie na tym blogu.');
define ('_MI_POPNUPBLOG_BLOG_NEWPOST_NOTIFYDSC', 'Otrzymasz powiadomienie, gdy nowy wpis pojawi si� na tym blogu.');
define ('_MI_POPNUPBLOG_BLOG_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-powiadomienie : Nowy wpis na blogu!');

define ('_MI_POPNUPBLOG_GLOBAL_NEWBLOG_NOTIFY', 'Nowy blog');
define ('_MI_POPNUPBLOG_GLOBAL_NEWBLOG_NOTIFYCAP', 'Powiadamiaj mnie o utworzeniu nowego bloga.');
define ('_MI_POPNUPBLOG_GLOBAL_NEWBLOG_NOTIFYDSC', 'Otrzymasz powiadomienie, gdy utworzony zostanie nowy blog.');
define ('_MI_POPNUPBLOG_GLOBAL_NEWBLOG_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-powiadomienie : Nowy blog!');

define ('_MI_POPNUPBLOG_GLOBAL_NEWPOST_NOTIFY', 'Nowy wpis');
define ('_MI_POPNUPBLOG_GLOBAL_NEWPOST_NOTIFYCAP', 'Powiadamiaj mnie o wszelkich nowych wpisach.');
define ('_MI_POPNUPBLOG_GLOBAL_NEWPOST_NOTIFYDSC', 'Otrzymasz powiadomienie, gdy pojawi si� jakikolwiek nowy wpis.');
define ('_MI_POPNUPBLOG_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-powiadomienie : Nowy wpis!');

define ('_MI_POPNUPBLOG_GLOBAL_NEWFULLPOST_NOTIFY', 'Nowy wpis (pe�ny tekst)');
define ('_MI_POPNUPBLOG_GLOBAL_NEWFULLPOST_NOTIFYCAP', 'Powiadamiaj mnie o wszelkich nowych wpisach (do��cz do wiadomo�ci pe�n� tre�� wpisu).');
define ('_MI_POPNUPBLOG_GLOBAL_NEWFULLPOST_NOTIFYDSC', 'Otrzymasz powiadomienie z pe�n� tre�ci� ka�dego nowego wpisu.');
define ('_MI_POPNUPBLOG_GLOBAL_NEWFULLPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-powiadomienie : Nowy wpis (pe�ny tekst)');

?>
<!--ISO-->
