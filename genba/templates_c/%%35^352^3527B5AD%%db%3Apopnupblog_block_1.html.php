<?php /* Smarty version 2.6.12, created on 2007-07-11 13:24:23
         compiled from db:popnupblog_block_1.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'db:popnupblog_block_1.html', 17, false),)), $this); ?>
<!-- begin of popnup blog block -->
<table class="outer" cellspacing="1" width="100%">
  <tr>
    <th><?php echo $this->_tpl_vars['block']['_MB_POPNUPBLOG_BLOG_TITLE']; ?>
</th>
    <th><?php echo $this->_tpl_vars['block']['_MB_POPNUPBLOG_TITLE']; ?>
</th>
    <th><?php echo $this->_tpl_vars['block']['_MB_POPNUPBLOG_UPDATE_DATE']; ?>
</th>
    <th><?php echo $this->_tpl_vars['block']['_MB_POPNUPBLOG_BLOGGER_NAME']; ?>
</th>
  </tr>
<?php $_from = $this->_tpl_vars['block']['popnupblog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['blog_user']):
?>
  <tr class="even">
    <td><a href='<?php echo $this->_tpl_vars['blog_user']['url']; ?>
'><?php echo $this->_tpl_vars['blog_user']['title']; ?>
</a></td>
    <td><?php echo $this->_tpl_vars['blog_user']['last_title']; ?>
</TD>
    <td><?php echo $this->_tpl_vars['blog_user']['last_update_s']; ?>
</TD>
    <td><a href='<?php echo $this->_tpl_vars['xoops_url']; ?>
/userinfo.php?uid=<?php echo $this->_tpl_vars['blog_user']['uid']; ?>
'><?php echo $this->_tpl_vars['blog_user']['uname']; ?>
</a></td>
    </tr><tr class="odd">
    <td colspan=4>
      <?php echo ((is_array($_tmp=$this->_tpl_vars['blog_user']['last_text'])) ? $this->_run_mod_handler('replace', true, $_tmp, "<img", "<img hspace='5'") : smarty_modifier_replace($_tmp, "<img", "<img hspace='5'")); ?>

    </td>
  </tr><tr>
    <td align="right"><?php echo $this->_tpl_vars['blog_user']['commentuname']; ?>
&nbsp</TD>
    <td colspan=3><?php echo $this->_tpl_vars['blog_user']['comment']; ?>
</TD>
  </tr>
<?php endforeach; endif; unset($_from); ?>
<tr>
<td align="right" colspan="4">
<?php if ($this->_tpl_vars['block']['show_rss'] == 1): ?>
<a href="http://feeds.archive.org/validator/check?url=<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss.php" target="_blank"><img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss-valid-line.gif" border="0"></a> <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss.php"><img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss.png" border="0" /></a>
<?php endif; ?> 
<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/"><?php echo $this->_tpl_vars['block']['_MB_POPNUPBLOG_VSTBLGS']; ?>
</a>
</td></tr></table>
<!-- end of popnup blog block -->