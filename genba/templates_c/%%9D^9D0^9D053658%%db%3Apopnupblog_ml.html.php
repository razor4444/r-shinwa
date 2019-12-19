<?php /* Smarty version 2.6.12, created on 2007-07-11 13:24:23
         compiled from db:popnupblog_ml.html */ ?>
<H2><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_ML_RECEPTION']; ?>
</H2>
<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_ML_APPLIED']; ?>

<HR>
<?php if ($this->_tpl_vars['ins_titles']): ?>
  <H3><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_ML_JOIN']; ?>
</H3>
  <TABLE class="outer" cellspacing="1">
  <TR><TH><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_TITLE']; ?>
</TH><TH><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_POSTMAILADDR']; ?>
</TH></TR>
  <?php $_from = $this->_tpl_vars['ins_titles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
	<TR><TD><?php echo $this->_tpl_vars['i']['title']; ?>
</TD><TD><?php echo $this->_tpl_vars['i']['pop_address']; ?>
</TD></TR>
  <?php endforeach; endif; unset($_from); ?>
  </TABLE>
<?php endif; ?>
<?php if ($this->_tpl_vars['del_titles']): ?>
  <H3><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_ML_LEAVE']; ?>
</H3>
  <TABLE class="outer" cellspacing="1">
  <TR><TH><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_TITLE']; ?>
</TH></TR>
  <?php $_from = $this->_tpl_vars['del_titles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
	<TR><TD><?php echo $this->_tpl_vars['i']['title']; ?>
</TD></TR>
  <?php endforeach; endif; unset($_from); ?>
  </TABLE>
<?php endif; ?>
<BR />
<CENTER>
<B><a href='index.php'><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_RETURN']; ?>
</a></B>
</CENTER>