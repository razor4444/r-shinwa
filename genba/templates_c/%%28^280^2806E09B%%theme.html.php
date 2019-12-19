<?php /* Smarty version 2.6.12, created on 2007-07-11 10:48:17
         compiled from x2t/theme.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
" lang="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->_tpl_vars['xoops_charset']; ?>
" />
<meta http-equiv="content-language" content="<?php echo $this->_tpl_vars['xoops_langcode']; ?>
" />
<meta name="robots" content="<?php echo $this->_tpl_vars['xoops_meta_robots']; ?>
" />
<meta name="keywords" content="<?php echo $this->_tpl_vars['xoops_meta_keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_tpl_vars['xoops_meta_description']; ?>
" />
<meta name="rating" content="<?php echo $this->_tpl_vars['xoops_meta_rating']; ?>
" />
<meta name="author" content="<?php echo $this->_tpl_vars['xoops_meta_author']; ?>
" />
<meta name="copyright" content="<?php echo $this->_tpl_vars['xoops_meta_copyright']; ?>
" />
<meta name="generator" content="XOOPS" />
<title><?php echo $this->_tpl_vars['xoops_sitename']; ?>
 - <?php echo $this->_tpl_vars['xoops_pagetitle']; ?>
</title>
<link href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/favicon.ico" rel="SHORTCUT ICON" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/xoops.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->_tpl_vars['xoops_themecss']; ?>
" />
<!-- RMV: added module header -->
<?php echo $this->_tpl_vars['xoops_module_header']; ?>

<script type="text/javascript">
<!--
<?php echo $this->_tpl_vars['xoops_js']; ?>

//-->
</script>
</head>
<body>
<!-- Start Header -->
<table cellspacing="0" cellpadding="0" width="100%" border="0" style="background-color : #2F5376; color: #ffffff">
  <tr>
    <td height="70" width="150" valign="middle" align="left" rowspan="2">
    <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
logo.gif" alt="" /></a></td>
<td valign="middle" align="center" width="100%">
<?php echo $this->_tpl_vars['xoops_banner']; ?>

</td></tr><tr>
    <td width="100%" valign="bottom" align="right" class="navbar" >
	<table border="0" cellpadding="1" cellspacing="0">
	   <tr>
         <td class="tabOff" onmouseover="this.className='tabOn';" onmouseout="this.className='tabOff';"><a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
">Home</a></td>
         <td class="tabOff" onmouseover="this.className='tabOn';" onmouseout="this.className='tabOff';"><a href="http://xoopscube.org/modules/xhnewbb/">XOOPS Cube Forums</a></td>
         <td class="tabOff" onmouseover="this.className='tabOn';" onmouseout="this.className='tabOff';"><a href="http://xoopscube.org/">XOOPS Cube Support</a></td>
	   </tr>
	</table>
     </td>
  </tr>
</table>
<!-- End Header -->
<!-- Start Headerbar -->
<table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td width="10"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
hbar_left.gif" width="10" height="23" alt="" /></td>
          <td style="background-image: url(<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
hbar_middle.gif);" align="left">&nbsp;</td>
<td width="15%" style="background-image: url(<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
hbar_middle.gif);" align="right">
<form action="<?php echo $this->_tpl_vars['xoops_url']; ?>
/search.php" method="post">
        <input type="text" name="query" class="navinput" /><input type="hidden" name="action" value="results" /> <input class="navinputImage" type="image" src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
searchButton.gif" name="searchSubmit" />
    </form></td>
          <td width="10"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
hbar_right.gif" width="10" height="23" alt="" /></td>
        </tr>
</table>
<!-- End Headerbar -->

    <table width="100%"  cellspacing="0" cellpadding="0" border="0">
  <tr>
         <td class="leftcolumn" valign="top" style="background-image: url(<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
bg_left.gif);"><div class="leftcolumn">
        <!-- Start left blocks loop -->
        <?php $_from = $this->_tpl_vars['xoops_lblocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "x2t/theme_blockleft.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endforeach; endif; unset($_from); ?>
        <!-- End left blocks loop -->
         </div></td>
         <td width="100%" valign="top" class="contentbox">

         <!-- Display center blocks if any -->
         <?php if ($this->_tpl_vars['xoops_showcblock'] == 1): ?>
<br />
<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
<td class="bcenterleft">&nbsp;</td>
<td class="bcenterbg">&nbsp;</td>
<td class="bcenterright">&nbsp;</td>
</tr>
</table>

         <table width="98%" cellpadding="3" cellspacing="0" align="center" style="border-left: #cccccc 1px solid;border-right: #cccccc 1px solid;border-bottom: #cccccc 1px solid;">

              <tr>
                <td class="centerLcolumn" valign="top">
                <div class="centerLcolumn">
            <!-- Start center-left blocks loop -->
              <?php $_from = $this->_tpl_vars['xoops_clblocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "x2t/theme_blockcenter_l.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <br />
              <?php endforeach; endif; unset($_from); ?>
            <!-- End center-left blocks loop -->
                </div>
               </td>
                <td class="centerRcolumn" valign="top">
                <div class="centerRcolumn">
            <!-- Start center-right blocks loop -->
              <?php $_from = $this->_tpl_vars['xoops_crblocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "x2t/theme_blockcenter_r.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <br />
              <?php endforeach; endif; unset($_from); ?>
            <!-- End center-right blocks loop -->
                </div>
       		   </td>
              </tr>
            </table>
            <?php endif; ?>
            <!-- End display center blocks -->


         <br />
            <div class="content">
              <?php echo $this->_tpl_vars['xoops_contents']; ?>

            </div>
         <br />
         <table width="98%" cellpadding="3" cellspacing="0" align="center">
             <tr>
                <td class="centercolumn" valign="top" colspan="2">
			<div class="centercolumn">
			      <!-- Start center-center blocks loop -->
			      <?php $_from = $this->_tpl_vars['xoops_ccblocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
			      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "x2t/theme_blockcenter_c.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			      <br />
			      <?php endforeach; endif; unset($_from); ?>
			      <!-- End center-center blocks loop -->
			</div>
                </td></tr>
	   </table>
	 </td>
         <?php if ($this->_tpl_vars['xoops_showrblock'] == 1): ?>
         <td class="rightcolumn" valign="top" align="right" style="background-image: url(<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
bg_right.gif);"><div class="rightcolumn">
        <!-- Start right blocks loop -->
        <?php $_from = $this->_tpl_vars['xoops_rblocks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['block']):
?>
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "x2t/theme_blockright.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endforeach; endif; unset($_from); ?>
        <!-- End right blocks loop -->
         </div>
         </td>
<?php else: ?>
<td width="10" style="background-image: url(<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
bg_right2.gif);"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
dummy.gif" width="10" height="10" alt="" /></td>
<?php endif; ?>
   </tr>
           <tr>
          <td colspan="3" width="100%">

<table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td width="10"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
hbar_left.gif" width="10" height="23" alt="" /></td>
          <td style="background-image: url(<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
hbar_middle.gif);" align="center">&nbsp;<span class="copyright"><?php echo $this->_tpl_vars['xoops_footer']; ?>
</span></td>
          <td width="10"><img src="<?php echo $this->_tpl_vars['xoops_imageurl']; ?>
hbar_right.gif" width="10" height="23" alt="" /></td></tr>
</table>
</td></tr></table>
</body>
</html>