<?php /* Smarty version 2.6.12, created on 2007-07-11 13:24:22
         compiled from db:popnupblog_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'db:popnupblog_list.html', 47, false),)), $this); ?>
<!-- begin of popnup blog block -->
<form method="post" action="index.php">
<table  width="100%" class="outer" cellspacing="1">
  <tr>
  <td align="center">
	<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_CONTENTS_VIEW']; ?>

	<input type="radio" name="view" value="1" <?php if ($this->_tpl_vars['view'] == 1): ?>CHECKED<?php endif; ?>><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_YES']; ?>
</input>
	<input type="radio" name="view" value="0" <?php if ($this->_tpl_vars['view'] == 0): ?>CHECKED<?php endif; ?>><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_NO']; ?>
</input>
	&nbsp;
	<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_CATEGORY'];  echo $this->_tpl_vars['categories']; ?>

	<input type="submit" value=<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FILTERON']; ?>
 name="filter" />
  </td>
  </tr>
</table>
</form>
<form method="post" action="mlfunction.php">
<table  width="100%" class="outer" cellspacing="1">
  <tr>
    <th><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_LIST_TITLE']; ?>
</th>
    <th><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_TITLE']; ?>
</th>
    <th><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_LIST_CREATOR']; ?>
</th>
    <th><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_CATEGORY']; ?>
</th>
    <th><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_LIST_UPDATE_DATE']; ?>
</th>
    <th><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_ML_JOIN']; ?>
</th>
  </tr>
<?php $_from = $this->_tpl_vars['popnupblog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['blog_user']):
?>
  <tr class="even">
    <td><a href='<?php echo $this->_tpl_vars['blog_user']['url']; ?>
'><?php echo $this->_tpl_vars['blog_user']['title']; ?>
</a></td>
    <td><?php echo $this->_tpl_vars['blog_user']['last_title']; ?>
</TD>
    <td><a href='<?php echo $this->_tpl_vars['xoops_url']; ?>
/userinfo.php?uid=<?php echo $this->_tpl_vars['blog_user']['uid']; ?>
'><?php echo $this->_tpl_vars['blog_user']['uname']; ?>
</a></td>
    <td><?php echo $this->_tpl_vars['blog_user']['catname']; ?>
</TD>
    <td><?php echo $this->_tpl_vars['blog_user']['last_update_m']; ?>
</TD>
    <td>
      <?php if ($this->_tpl_vars['blog_user']['ml_function'] == 1): ?>
        <input type="hidden" name="blogid[]" value="<?php echo $this->_tpl_vars['blog_user']['bid']; ?>
" />
        <input type="checkbox" name="mlset[]" value="<?php echo $this->_tpl_vars['blog_user']['bid']; ?>
" 
        <?php if ($this->_tpl_vars['blog_user']['ml_checked'] > 0): ?>
          checked
        <?php endif; ?>
        />
      <?php endif; ?>
    </TD>
    </tr><tr class="odd">
  <?php if ($this->_tpl_vars['view'] == 1): ?>
    <td colspan=6>
      <?php echo ((is_array($_tmp=$this->_tpl_vars['blog_user']['last_text'])) ? $this->_run_mod_handler('replace', true, $_tmp, "<img", "<img hspace='5'") : smarty_modifier_replace($_tmp, "<img", "<img hspace='5'")); ?>

    </td>
	<!--
	</tr><tr class="even">
    <td align="right"><?php echo $this->_tpl_vars['blog_user']['commentuname']; ?>
&nbsp</TD>
    <td colspan=5><?php echo $this->_tpl_vars['blog_user']['comment']; ?>
</TD>
	</tr>
	-->
  <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<tr>
<tr class="foot"><td align="center" colspan="5">
  <?php echo $this->_tpl_vars['jump_url']; ?>

</td><td>
  <input type="submit" value=<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_ML_UPDATE']; ?>
 name="join" />
</td></tr>
<td align="right" valign="bottom" colspan="6"><font size="-1">PopnupBlog <?php echo $this->_tpl_vars['POPNUPBLOG_VERSION']; ?>
 by 
<a href="http://www.bluemooninc.biz/" target="_blank">Bluemoon inc.</a>
<a href="http://feeds.archive.org/validator/check?url=<?php echo $this->_tpl_vars['popnupblog_rss_url']; ?>
" target="_blank">
<img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss-valid-line.gif" border="0"></a>
<a href="<?php echo $this->_tpl_vars['popnupblog_rss_url']; ?>
"><img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss10.gif" border="0" /></a>
</font>
</td></tr>
</table>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'db:system_notification_select.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo $this->_tpl_vars['popimg']; ?>

<!-- end of popnup blog block -->