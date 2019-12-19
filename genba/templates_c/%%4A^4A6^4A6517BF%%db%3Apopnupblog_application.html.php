<?php /* Smarty version 2.6.12, created on 2007-07-11 13:24:23
         compiled from db:popnupblog_application.html */ ?>
<!-- begin of popnup blog block -->
<table class="outer" cellspacing="1" width="95%">
<tr class="outer">
<th colspan="2"><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_NAME']; ?>
</th>
</td>
<tr class="even"><td colspan="5">
<?php if (count ( $this->_tpl_vars['bloginfo'] ) > 0): ?>
	<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_APPLICATION_PREFERENCE']; ?>
</td></tr>
	<?php $_from = $this->_tpl_vars['bloginfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['info']):
?>
	<form method="post" action="edit.php">
	<tr class="head"><td colspan=5>
		Blog ID : <?php echo $this->_tpl_vars['info']['bid']; ?>
<input type="hidden" name="bid" value="<?php echo $this->_tpl_vars['info']['bid']; ?>
" />
		Last Update : <?php echo $this->_tpl_vars['info']['lastUpdate']; ?>

	</td></tr>
	<tr class="even">
		<td width="25%"><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_TITLE']; ?>
</td>
		<td colspan=4>
		<input type="text" name="title" length="50" value="<?php echo $this->_tpl_vars['info']['title']; ?>
"></input>
		&nbsp;<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_CATEGORY'];  echo $this->_tpl_vars['info']['cidselect']; ?>

	</td></tr>
	<tr class="even"><td ><span class='fg2'><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_DESCRIPTION']; ?>
</span></td>
		<td colspan=4><TEXTAREA name='desc' ROWS="3" COLS="50" WRAP="VIRTUAL"><?php echo $this->_tpl_vars['info']['desc']; ?>
</TEXTAREA>
	</td></tr>
	<?php if ($this->_tpl_vars['GroupSetByUser'] == 1): ?>
	<tr class="even">
		<td rowspan=2><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_PERMISSION_TITLE']; ?>
</td>
		<td><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_GROUPPARMITION']; ?>
</td>
		<td><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_PERMISSION0']; ?>
</td>
		<td><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_PERMISSION1']; ?>
</td>
		<td><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_PERMISSION2']; ?>
</td>
	</tr>
	<tr class="even">
		<td><?php echo $this->_tpl_vars['info']['g_post']; ?>
</td>
		<td><?php echo $this->_tpl_vars['info']['g_read']; ?>
</td>
		<td><?php echo $this->_tpl_vars['info']['g_comment']; ?>
</td>
		<td><?php echo $this->_tpl_vars['info']['g_vote']; ?>
</td>
	</tr>
	<?php else: ?>
	<tr><td width="25%"></td><td width="25%"></td><td width="25%"></td><td width="25%"></td></tr>
	<?php endif; ?>
	<tr class="even"><td><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_POSTMAILADDR']; ?>
</td>
		<td colspan=4>
		<input type="text" name="email" value="<?php echo $this->_tpl_vars['info']['email']; ?>
" />
		&nbsp;<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_ADMIN_USAGE']; ?>
<BR />
		<?php echo $this->_tpl_vars['mail_prefix']; ?>

		</td>
	</tr>
	<tr class="even"><td ><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_POSTMAILADDR']; ?>
<p><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_MAIL_SECONDLY']; ?>
</td>
		<td colspan=2>
		<select name="emailalias[]" size="5" multiple='multiple' style="width: 250px;">
		<?php echo $this->_tpl_vars['info']['emailalias_options']; ?>

		</select>
		<input type="submit" name="remove_mailalias" value="<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_REMOVE']; ?>
" />
		</td>
		<td colspan=2>
		<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_UNAME']; ?>
&nbsp;
		<input type="text" SIZE="8" name="alias_uname" value="<?php echo $this->_tpl_vars['alias_uname']; ?>
" />
		<input type="submit" name="confirm_mailalias" value="<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_CONFIRM']; ?>
" />
		<br />
		email&nbsp;<input type="text" name="emailalias_txt" value="<?php echo $this->_tpl_vars['alias_email']; ?>
" />
		<input type="hidden" name="alias_uid" value="<?php echo $this->_tpl_vars['alias_uid']; ?>
" />
		<input type="submit" name="add_mailalias" value="<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_ADD']; ?>
" />
		</td>
	</tr>
	<tr class="even"><td><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_SENDMAILADDR']; ?>
</td><td colspan=2>
		<select name="emailsends[]" size="5" multiple='multiple' style="width: 250px;">
		<?php echo $this->_tpl_vars['info']['emailsends_options']; ?>

		</select>
		<input type="submit" name="remove_mailsends" value="<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_REMOVE']; ?>
" />
		</td><td colspan=2>
		<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_UNAME']; ?>
&nbsp;
		<input type="text" SIZE="8" name="sends_uname" value="<?php echo $this->_tpl_vars['sends_uname']; ?>
" />
		<input type="submit" name="confirm_mailsends" value="<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_CONFIRM']; ?>
" />
		<br />
		email&nbsp;<input type="text" name="emailsends_txt" value="<?php echo $this->_tpl_vars['sends_email']; ?>
" />
		<input type="hidden" name="sends_uid" value="<?php echo $this->_tpl_vars['sends_uid']; ?>
" />
		<input type="submit" name="add_mailsends" value="<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_ADD']; ?>
" />
	</tr>
	<tr><td colspan="5" align="center">
		<input type="submit" value=<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_SEND']; ?>
 name="updatepreference" />
	</td></tr>
	</form>
	<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
    <?php echo $this->_tpl_vars['_MD_POPNUPBLOG_APPLICATION_HEAD']; ?>
</td></tr>
	<form method="post" action="application.php">
	<tr class="even"><td width="25%"><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_TITLE']; ?>
</td><td colspan=4>
		<input type="text" name="title" length="50" value=""></input>
		&nbsp;<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_CATEGORY'];  echo $this->_tpl_vars['categories']; ?>

	</td></tr>
	<tr class="even"><td ><span class='fg2'><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_DESCRIPTION']; ?>
</span></td>
		<td colspan=4><TEXTAREA name='desc' ROWS="3" COLS="50" WRAP="VIRTUAL"></TEXTAREA>
	</td></tr>
	<?php if ($this->_tpl_vars['GroupSetByUser'] == 1): ?>
	<tr class="even">
		<td rowspan=2><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_PERMISSION_TITLE']; ?>
</td>
		<td><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_GROUPPARMITION']; ?>
</td>
		<td><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_PERMISSION0']; ?>
</td>
		<td><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_PERMISSION1']; ?>
</td>
		<td><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_PERMISSION2']; ?>
</td>
	</tr>
	<tr class="even">
		<td><?php echo $this->_tpl_vars['g_post']; ?>
</td>
		<td><?php echo $this->_tpl_vars['g_read']; ?>
</td>
		<td><?php echo $this->_tpl_vars['g_comment']; ?>
</td>
		<td><?php echo $this->_tpl_vars['g_vote']; ?>
</td>
	</tr>
	<?php else: ?>
	<tr><td width="25%"></td><td width="25%"></td><td width="25%"></td><td width="25%"></td></tr>
	<?php endif; ?>
	<tr class="even"><td><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_POSTMAILADDR']; ?>
</td><td colspan=4>
		<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_MAIL_PRIMARY']; ?>
<input type="text" name="email" value="" />
		<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_MAIL_SECONDLY']; ?>
<input type="text" name="emailalias" value="" /></td>
	</tr>
	<tr>
	<td colspan="4" align="center">
		<input type="submit" name="submit" value="<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_APPLICATION_SUBMIT']; ?>
" />
	</tr>
<?php endif; ?>
	</form>
</table>
<!-- end of popnup blog block -->