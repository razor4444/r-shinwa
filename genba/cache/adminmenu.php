<?php
$xoops_admin_menu_js = "function popUpL1() {
shutdown();
popUp(\"L1\",true);
}
function popUpL16() {
shutdown();
popUp(\"L16\",true);
}
function popUpL20() {
shutdown();
popUp(\"L20\",true);
}
";
$xoops_admin_menu_ml[1] = "setleft('L1',105);
settop('L1',150);
";
$xoops_admin_menu_ml[5] = "setleft('L16',105);
settop('L16',165);
";
$xoops_admin_menu_ml[2] = "setleft('L20',105);
settop('L20',180);
";
$xoops_admin_menu_sd[1] = "popUp('L1',false);
";
$xoops_admin_menu_sd[5] = "popUp('L16',false);
";
$xoops_admin_menu_sd[2] = "popUp('L20',false);
";
$xoops_admin_menu_ft[1] = "<a href='".XOOPS_URL."/modules/system/admin.php' onmouseover='moveLayerY(\"L1\", currentY,event) ; popUpL1();'><img src='".XOOPS_URL."/modules/system/images/system_slogo.png' alt='' /></a><br />
";
$xoops_admin_menu_ft[5] = "<a href='".XOOPS_URL."/modules/wordpress/admin/index.php' onmouseover='moveLayerY(\"L16\", currentY,event) ; popUpL16();'><img src='".XOOPS_URL."/modules/wordpress/wp-images/wordpress.png' alt='' /></a><br />
";
$xoops_admin_menu_ft[2] = "<a href='".XOOPS_URL."/modules/XP-Weather/admin/index.php' onmouseover='moveLayerY(\"L20\", currentY,event) ; popUpL20();'><img src='".XOOPS_URL."/modules/XP-Weather/wweather.jpg' alt='' /></a><br />
";
$xoops_admin_menu_dv = "<div id='L1' style='position: absolute; visibility: hidden; z-index:1000;'><table class='outer' width='150' cellspacing='1'><tr><th nowrap='nowrap'>システム管理</th></tr><tr><td class='even' nowrap='nowrap'><img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=banners' onmouseover='popUpL1();'>バナー管理</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=blocksadmin' onmouseover='popUpL1();'>ブロック管理</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=groups' onmouseover='popUpL1();'>グループ管理</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=images' onmouseover='popUpL1();'>イメージ・マネジャー</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=modulesadmin' onmouseover='popUpL1();'>モジュール管理</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=preferences' onmouseover='popUpL1();'>一般設定</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=smilies' onmouseover='popUpL1();'>顔アイコン設定</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=userrank' onmouseover='popUpL1();'>ユーザランキング設定</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=users' onmouseover='popUpL1();'>ユーザ管理</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=findusers' onmouseover='popUpL1();'>ユーザ検索</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=mailusers' onmouseover='popUpL1();'>ユーザ宛メール送信</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=avatars' onmouseover='popUpL1();'>アバター・マネジャー</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=tplsets' onmouseover='popUpL1();'>テンプレート・マネジャー</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=comments' onmouseover='popUpL1();'>コメント・マネジャー</a><br />
<div style='margin-top: 5px; font-size: smaller; text-align: right;'><a href='#' onmouseover='shutdown();'>[閉じる]</a></div></td></tr><tr><th style='font-size: smaller; text-align: left;'><img src='".XOOPS_URL."/modules/system/images/system_slogo.png' alt='' /><br /><b>"._VERSION.":</b> 1<br /><b>"._DESCRIPTION.":</b> サイトのコア部分の設定を行います</th></tr></table></div>
<div id='L16' style='position: absolute; visibility: hidden; z-index:1000;'><table class='outer' width='150' cellspacing='1'><tr><th nowrap='nowrap'>WordPress</th></tr><tr><td class='even' nowrap='nowrap'><img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/wordpress/wp-admin/options.php' onmouseover='popUpL16();'>WordPressオプション</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/wordpress/admin/myblocksadmin.php' onmouseover='popUpL16();'>ブロックアクセス権限</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=5' onmouseover='popUpL16();'>一般設定</a><br />
<div style='margin-top: 5px; font-size: smaller; text-align: right;'><a href='#' onmouseover='shutdown();'>[閉じる]</a></div></td></tr><tr><th style='font-size: smaller; text-align: left;'><img src='".XOOPS_URL."/modules/wordpress/wp-images/wordpress.png' alt='' /><br /><b>"._VERSION.":</b> 0.33<br /><b>"._DESCRIPTION.":</b> WordPress MEのXOOPSモジュールです。</th></tr></table></div>
<div id='L20' style='position: absolute; visibility: hidden; z-index:1000;'><table class='outer' width='150' cellspacing='1'><tr><th nowrap='nowrap'>お天気ガイド</th></tr><tr><td class='even' nowrap='nowrap'><img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/XP-Weather/admin/index.php' onmouseover='popUpL20();'>トップ</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/XP-Weather/admin/myblocksadmin.php' onmouseover='popUpL20();'>ブロック管理</a><br />
<img src='".XOOPS_URL."/images/pointer.gif' width='8' height='8' alt='' />&nbsp;<a href='".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=2' onmouseover='popUpL20();'>一般設定</a><br />
<div style='margin-top: 5px; font-size: smaller; text-align: right;'><a href='#' onmouseover='shutdown();'>[閉じる]</a></div></td></tr><tr><th style='font-size: smaller; text-align: left;'><img src='".XOOPS_URL."/modules/XP-Weather/wweather.jpg' alt='' /><br /><b>"._VERSION.":</b> 1.3<br /><b>"._DESCRIPTION.":</b> Weather forecast module - block support, 5 day forecast, highly customizable, easy install.</th></tr></table></div>
<script language='JavaScript'>
<!--
moveLayers();
loaded = 1;
// -->
</script>
";

?>