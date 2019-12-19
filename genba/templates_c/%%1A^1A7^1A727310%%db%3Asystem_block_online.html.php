<?php /* Smarty version 2.6.12, created on 2007-07-11 10:57:49
         compiled from db:system_block_online.html */ ?>
<?php echo $this->_tpl_vars['block']['online_total']; ?>
<br /><br /><?php echo $this->_tpl_vars['block']['lang_members']; ?>
: <?php echo $this->_tpl_vars['block']['online_members']; ?>
<br /><?php echo $this->_tpl_vars['block']['lang_guests']; ?>
: <?php echo $this->_tpl_vars['block']['online_guests']; ?>
<br /><br /><?php echo $this->_tpl_vars['block']['online_names']; ?>
 <a href="javascript:openWithSelfMain('<?php echo $this->_tpl_vars['xoops_url']; ?>
/misc.php?action=showpopups&amp;type=online','Online',420,350);"><?php echo $this->_tpl_vars['block']['lang_more']; ?>
</a>