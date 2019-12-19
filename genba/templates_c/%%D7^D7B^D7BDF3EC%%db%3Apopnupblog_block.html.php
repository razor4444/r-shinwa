<?php /* Smarty version 2.6.12, created on 2007-07-11 13:24:23
         compiled from db:popnupblog_block.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'db:popnupblog_block.html', 10, false),)), $this); ?>
<!-- begin of popnup blog block -->
<table class="head" cellspacing="1" width="100%">
  <tr>
    <th><?php echo $this->_tpl_vars['block']['_MB_POPNUPBLOG_BLOG_TITLE']; ?>
</th>
    <th><?php echo $this->_tpl_vars['block']['_MB_POPNUPBLOG_BLOGGER_NAME']; ?>
</th>
    <th><?php echo $this->_tpl_vars['block']['_MB_POPNUPBLOG_UPDATE_DATE']; ?>
</th>
    <th><?php echo $this->_tpl_vars['block']['_MB_POPNUPBLOG_TITLE']; ?>
</th>
  </tr>
<?php $_from = $this->_tpl_vars['block']['popnupblog']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['blog_user']):
?>
  <tr class="<?php echo smarty_function_cycle(array('values' => "even,odd"), $this);?>
">
    <td align="left"><a href='<?php echo $this->_tpl_vars['blog_user']['url']; ?>
'><?php echo $this->_tpl_vars['blog_user']['title']; ?>
</a></td>
    <td align="left"><?php echo $this->_tpl_vars['blog_user']['uname']; ?>
</td>
    <td align="right"><?php echo $this->_tpl_vars['blog_user']['last_update_m']; ?>
</td>
    <td align="left"><?php echo $this->_tpl_vars['blog_user']['last_title']; ?>
</td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
<?php if ($this->_tpl_vars['block']['show_rss'] == 1): ?>
  <tr><td align="right" colspan="4">
  <a href="http://feeds.archive.org/validator/check?url=<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss.php" target="_blank">
  <img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss-valid-line.gif" border="0"></a>
  <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss.php">
  <img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss.png" border="0" /></a> 
  <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/"><?php echo $this->_tpl_vars['block']['_MB_POPNUPBLOG_VSTBLGS']; ?>
</a>
  </td></tr>
<?php endif; ?>
</table>
<!-- end of popnup blog block -->