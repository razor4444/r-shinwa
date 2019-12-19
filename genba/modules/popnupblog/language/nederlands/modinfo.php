<?php
// $Id: modinfo.php,v 1.1.1.1 2005/08/28 02:13:09 yoshis Exp $ 

define('_MI_POPNUPBLOG_APPL_DESC', '');
define('_MI_POPNUPBLOG_1_LINE', 'Recent bijgewerkt blog');
define('_MI_POPNUPBLOG_CONF_DESC', 'Beschrijving');
define('_MI_POPNUPBLOG_TRACKBACK', 'TrackBack');
define('_MI_POPNUPBLOG_REWRITE_TITLE', 'Gebruik Apache rewrite engine');
define('_MI_POPNUPBLOG_NAME', 'PopnupBLOG');
define('_MI_POPNUPBLOG_DESC', 'Popnup Blog');
define('_MI_POPNUPBLOG_UNUSE_UPDATE_PING', 'Gebruik geen update ping');
define('_MI_POPNUPBLOG_UNUSE_TRACKBACK', 'Gebruik geen trackback');
define('_MI_POPNUPBLOG_APPL_WAITING_TITLE', 'PopnupBlog nieuwe aanvraag');
define('_MI_POPNUPBLOG_NAME_BIG_BLOCK', 'PopnupBlog');
define('_MI_POPNUPBLOG_USE_REWRITE', 'Gebruik rewrite');
define('_MI_POPNUPBLOG_UPDATE_PING', 'Gebruik update ping');
define('_MI_POPNUPBLOG_1_LINE_DESC', '1 line view block');
define('_MI_POPNUPBLOG_REWRITE_DESC', 'Gebruikers mogen URL /modules/popnupblog/view/index.php?uid=1 of /modules/popnupblog/view/1.html gebruiken (alleen gevorderden)');
define('_MI_POPNUPBLOG_APPL_WAITING', 'Nieuwe Aanvraag');
define('_MI_POPNUPBLOG_UPDATE_PING_DESC', 'Activeer update ping');
define('_MI_POPNUPBLOG_WRITE', 'Schrijf in Blog');
define('_MI_POPNUPBLOG_PREFERENCE', 'Voorkeuren');
define('_MI_POPNUPBLOG_APPLY', 'Ik wil ook Bloggen');
define('_MI_POPNUPBLOG_TRACKBACK_DESC', 'Activeer TrackBack');
define('_MI_POPNUPBLOG_UNUSE_REWRITE', 'Gebruik geen rewrite');
define('_MI_POPNUPBLOG_APPL_DENY', 'Weiger');
define('_MI_POPNUPBLOG_CONFIG_RSS_DEF', 'Popnup blog gebruiker mag schrijven');
define('_MI_POPNUPBLOG_USE_TRACKBACK', 'Gebruik trackback');
define('_MI_POPNUPBLOG_APPL_ALLOW', 'toestaan');
define('_MI_POPNUPBLOG_APPL_OK', 'Aanvraag toestaan voor gebruiker');
define('_MI_POPNUPBLOG_USE_UPDATE_PING', 'Gebruik update ping');
define('_MI_POPNUPBLOG_CONFIG_RSS_DESC', 'Omschrijving van deze Blog op rss feed');
// Add 2004.10.27 by yoshis
define('_MI_POPNUPBLOG_MAILSERVER', 'Mail Server');
define('_MI_POPNUPBLOG_MAILSERVER_DESC', 'POP3 mail server om Blogs op te ontvangen:');
define('_MI_POPNUPBLOG_MAILUSER', 'Mail gebruiker');
define('_MI_POPNUPBLOG_MAILUSER_DESC', 'Mail gebruikersnaam waarop Blogs worden ontvangen:');
define('_MI_POPNUPBLOG_MAILPWD', 'Mail Wachtwoord');
define('_MI_POPNUPBLOG_MAILPWD_DESC', 'Wachtwoord dat hoort bij de mail gebruikersnaam');
define('_MI_POPNUPBLOG_MAILADDR', 'Mail Adres');
define('_MI_POPNUPBLOG_MAILADDR_DESC', 'E-mail adres waarop de Blogs worden ontvangen');
// Add 2005.01.22 by yoshis
define("_MI_POPNUPBLOG_GUESTBLOGID","Allow to Blog ID from anonymous mail");
define("_MI_POPNUPBLOG_ACTVTYPE","Selecteer activeringsmethode voor nieuwe Blogs");
define("_MI_POPNUPBLOG_AUTOACTV","Automatisch activeren");
define("_MI_POPNUPBLOG_ADMINACTV","Activering door administrators");
define("_MI_POPNUPBLOG_NEWUNOTIFY","Notificatie per mail als een nieuwe blog wordt ingediend");
define("_MI_POPNUPBLOG_SHOWNAME","Vervang gebruikersnaam door echte naam?");
// Add 2006.03.21 by yoshis
define("_MI_POPNUPBLOG_GROUPSETBYUSER","Group permission by user (post,view,comment,vote)");

// For Notify
define ('_MI_POPNUPBLOG_BLOG_NOTIFY', 'Forum');
define ('_MI_POPNUPBLOG_BLOG_NOTIFYDSC', 'Notificatie opties voor huidige blog.');

define ('_MI_POPNUPBLOG_GLOBAL_NOTIFY', 'Algemeen');
define ('_MI_POPNUPBLOG_GLOBAL_NOTIFYDSC', 'Algemene notificatie opties voor blog.');

define ('_MI_POPNUPBLOG_BLOG_NEWPOST_NOTIFY', 'Nieuwe Post');
define ('_MI_POPNUPBLOG_BLOG_NEWPOST_NOTIFYCAP', 'Bericht mij van alle nieuwe post in deze blog.');
define ('_MI_POPNUPBLOG_BLOG_NEWPOST_NOTIFYDSC', 'Ontvang een bericht wanneer de huidige blog is vernieuwd.');
define ('_MI_POPNUPBLOG_BLOG_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-bericht : Er is een nieuw bericht');

define ('_MI_POPNUPBLOG_GLOBAL_NEWBLOG_NOTIFY', 'Nieuwe Blog');
define ('_MI_POPNUPBLOG_GLOBAL_NEWBLOG_NOTIFYCAP', 'Bericht mij wanneer een nieuwe Blog is gestart.');
define ('_MI_POPNUPBLOG_GLOBAL_NEWBLOG_NOTIFYDSC', 'Ontvang een bericht wanneer een nieuwe Blog is gestart.');
define ('_MI_POPNUPBLOG_GLOBAL_NEWBLOG_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-bericht : Nieuwe blog');

define ('_MI_POPNUPBLOG_GLOBAL_NEWPOST_NOTIFY', 'Nieuwe Post');
define ('_MI_POPNUPBLOG_GLOBAL_NEWPOST_NOTIFYCAP', 'Bericht mij van alle nieuwe post.');
define ('_MI_POPNUPBLOG_GLOBAL_NEWPOST_NOTIFYDSC', 'Ontvang een bericht wanneer er nieuwe post is.');
define ('_MI_POPNUPBLOG_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-bericht : Nieuwe post');

define ('_MI_POPNUPBLOG_GLOBAL_NEWFULLPOST_NOTIFY', 'Nieuwe Post (Volledig)');
define ('_MI_POPNUPBLOG_GLOBAL_NEWFULLPOST_NOTIFYCAP', 'Bericht mij van alle nieuwe post (inclusief bericht-tekst).');
define ('_MI_POPNUPBLOG_GLOBAL_NEWFULLPOST_NOTIFYDSC', 'Ontvang een volledig tekstbericht van alle nieuwe post.');
define ('_MI_POPNUPBLOG_GLOBAL_NEWFULLPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-bericht : Nieuwe post (Volledig)');

?>
