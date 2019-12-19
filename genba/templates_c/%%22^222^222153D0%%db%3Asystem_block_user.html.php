<?php /* Smarty version 2.6.12, created on 2007-07-11 10:32:53
         compiled from db:system_block_user.html */ ?>
<table cellspacing="0">
  <tr>
    <td id="usermenu">
      <a class="menuTop" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/user.php"><?php echo $this->_tpl_vars['block']['lang_youraccount']; ?>
</a>
      <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/edituser.php"><?php echo $this->_tpl_vars['block']['lang_editaccount']; ?>
</a>
      <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/notifications.php"><?php echo $this->_tpl_vars['block']['lang_notifications']; ?>
</a>
      <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/user.php?op=logout"><?php echo $this->_tpl_vars['block']['lang_logout']; ?>
</a>
      <?php if ($this->_tpl_vars['block']['new_messages'] > 0): ?>
        <a class="highlight" href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/viewpmsg.php"><?php echo $this->_tpl_vars['block']['lang_inbox']; ?>
 (<span style="color:#ff0000; font-weight: bold;"><?php echo $this->_tpl_vars['block']['new_messages']; ?>
</span>)</a>
      <?php else: ?>
        <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/viewpmsg.php"><?php echo $this->_tpl_vars['block']['lang_inbox']; ?>
</a>
      <?php endif; ?>

      <?php if ($this->_tpl_vars['xoops_isadmin']): ?>
        <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/admin.php"><?php echo $this->_tpl_vars['block']['lang_adminmenu']; ?>
</a>
      <?php endif; ?>
    </td>
  </tr>
</table>