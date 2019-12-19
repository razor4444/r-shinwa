<?php /* Smarty version 2.6.12, created on 2007-07-11 13:24:23
         compiled from db:popnupblog_view.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'db:popnupblog_view.html', 42, false),array('modifier', 'regex_replace', 'db:popnupblog_view.html', 44, false),array('modifier', 'count_characters', 'db:popnupblog_view.html', 44, false),array('modifier', 'replace', 'db:popnupblog_view.html', 52, false),)), $this); ?>
<!-- begin of popnup blog main block -->
<script language="JavaScript">
<!-- Altanate Contents By Yoshi @ bluemooninc.biz
  function showhide(id){
    if(document.getElementById){
      if(document.getElementById(id).style.display == "none")
        document.getElementById(id).style.display = "block";
      else
        document.getElementById(id).style.display = "none";
    }
  }
-->
</script>
<?php if ($this->_tpl_vars['popnupblog_votable'] == true): ?>
  <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/index.php?param=<?php echo $this->_tpl_vars['params']; ?>
&vote=1">
  <?php echo $this->_tpl_vars['_MD_POPNUPBLOG_VOTERANKING']; ?>

  </a>
<?php endif; ?>
<?php if ($this->_tpl_vars['popnupblog_editable'] == true): ?>
  <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/edit.php?today=<?php echo $this->_tpl_vars['popnupblog_targetBid']; ?>
">
    <?php echo $this->_tpl_vars['_MI_POPNUPBLOG_WRITE']; ?>

  </a>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['popnupblog_index']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['year']):
?>
<div align="right"><?php echo $this->_tpl_vars['key']; ?>

	<?php $_from = $this->_tpl_vars['year']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['month']):
?> | <a href='<?php echo $this->_tpl_vars['month']['url']; ?>
'><?php echo $this->_tpl_vars['month']['month']; ?>
</a><?php endforeach; endif; unset($_from); ?></div>
<?php endforeach; endif; unset($_from); ?>
<table class="outer" cellspacing="0">
<?php if (count ( $this->_tpl_vars['popnupblog_blogdata'] ) > 0): ?>
  <tr class="outer"><th colspan="3">
    <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/index.php?param=<?php echo $this->_tpl_vars['popnupblog_targetBid']; ?>
">
      <font size="+1"><?php echo $this->_tpl_vars['blog_title']; ?>
</font>
    </a>
    &nbsp;<?php echo $this->_tpl_vars['blog_desc']; ?>

    </th>
    <!--<?php if ($this->_tpl_vars['popnupblog_editable'] == true): ?>
		<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/edit.php?param=<?php echo $this->_tpl_vars['popnupblog_targetBid']; ?>
">
		[<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_LINK_EDIT']; ?>
]</a>
	<?php endif; ?>-->
  </tr>
<!--<?php echo smarty_function_counter(array('start' => 0,'skip' => 1), $this);?>
-->
<?php $_from = $this->_tpl_vars['popnupblog_blogdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
  <?php if (count ( $this->_tpl_vars['popnupblog_blogdata'] ) == 1 && ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['i']['url'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, '/.*-/', '') : smarty_modifier_regex_replace($_tmp, '/.*-/', '')))) ? $this->_run_mod_handler('count_characters', true, $_tmp) : smarty_modifier_count_characters($_tmp)) == 14): ?>
    <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
    <rdf:Description
     rdf:about="<?php echo $this->_tpl_vars['i']['url']; ?>
"
     dc:identifier="<?php echo $this->_tpl_vars['i']['url']; ?>
"
     dc:title="<?php echo $this->_tpl_vars['i']['title']; ?>
"
     trackback:ping="<?php echo ((is_array($_tmp=$this->_tpl_vars['i']['url'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'index.php?param=', 'trackback.php/') : smarty_modifier_replace($_tmp, 'index.php?param=', 'trackback.php/')); ?>
" />
    </rdf:RDF>
  <?php endif; ?>
    <?php if ($this->_tpl_vars['i']['hidedate'] != true): ?>
    <tr valign="middle" ><td class="head" colspan="3">
	  <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/index.php?param=<?php echo $this->_tpl_vars['popnupblog_targetBid']; ?>
-<?php echo $this->_tpl_vars['i']['year'];  echo $this->_tpl_vars['i']['month'];  echo $this->_tpl_vars['i']['date']; ?>
">
      <font size="+1"><?php echo $this->_tpl_vars['i']['date_str']; ?>
</font>
      </a>
    </td></tr>
  <?php endif; ?>
  <tr>
  <!--<td class="even" width="1%" rowspan="3" valign="middle"><?php echo smarty_function_counter(array(), $this);?>
.</td>-->
  <td class="even" >
    <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/index.php?postid=<?php echo $this->_tpl_vars['i']['postid']; ?>
"><b><?php echo $this->_tpl_vars['i']['title']; ?>
</b></a></td>
  <td class="even" align="right"><?php echo $this->_tpl_vars['i']['hours']; ?>
:<?php echo $this->_tpl_vars['i']['minutes']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['i']['uname']; ?>
&nbsp;
  <?php if ($this->_tpl_vars['popnupblog_editable'] == true): ?>
    <?php if ($this->_tpl_vars['i']['uid'] == $this->_tpl_vars['xoops_userid'] || $this->_tpl_vars['popnupblog_admin'] == true): ?>
	<!-- $popnupblog_editable eq true -->
	<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/edit.php?postid=<?php echo $this->_tpl_vars['i']['postid']; ?>
">[<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_LINK_EDIT']; ?>
]</a>
	<?php endif; ?>
  <?php endif; ?>
  </td></tr>
  <tr><td class="odd" colspan="2">
    <div class="comText">
      <?php echo ((is_array($_tmp=$this->_tpl_vars['i']['post_text'])) ? $this->_run_mod_handler('replace', true, $_tmp, "<img", "<div style='clear:both'></div><img hspace='5' vspace='5'") : smarty_modifier_replace($_tmp, "<img", "<div style='clear:both'></div><img hspace='5' vspace='5'")); ?>

    </div></td></tr>
  <tr>
  <?php if ($this->_tpl_vars['popnupblog_commentable'] == true || $this->_tpl_vars['popnupblog_votable'] == true): ?>
    <form action="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/votenow.php" method="post">
    <input type="hidden" name="targetUid" value="<?php echo $this->_tpl_vars['popnupblog_targetUid']; ?>
" />
  <?php endif; ?>
  <td colspan="2">
  <!-- Comment Read Area -->
  <?php if (count ( $this->_tpl_vars['i']['comments'] ) > 0): ?>
    <HR>
    <?php $_from = $this->_tpl_vars['i']['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j']):
?>
       <div title="<?php echo $this->_tpl_vars['j']['create_date']; ?>
"><?php echo $this->_tpl_vars['j']['create_date_m']; ?>

	   <?php if ($this->_tpl_vars['j']['comment'] != '' || ( $this->_tpl_vars['j']['uid'] == $this->_tpl_vars['popnupblog_uid'] )): ?>
		 <?php echo $this->_tpl_vars['j']['name']; ?>
&nbsp;
         <?php if ($this->_tpl_vars['j']['commentedit'] == true): ?>
           <a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/commentedit.php?comment_id=<?php echo $this->_tpl_vars['j']['id']; ?>
">[<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_LINK_EDIT']; ?>
]</a>
         <?php endif; ?>
		 <?php if (( $this->_tpl_vars['j']['vote'] != 0 )): ?>
			<?php if (( $this->_tpl_vars['j']['uid'] == $this->_tpl_vars['popnupblog_uid'] )): ?>
				<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_VOTE']; ?>
:
				<?php if ($this->_tpl_vars['j']['vote'] == 1):  echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_YES'];  endif; ?>
				<?php if ($this->_tpl_vars['j']['vote'] == -1):  echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_NO'];  endif; ?>
			<?php else: ?>
				<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_VOTED']; ?>
:
			<?php endif; ?>
		 <?php endif; ?>
		 </div>
         <div style="margin-left: 10px; margin-right: 10px; padding: 4px; background-color:#E6E6E6; border-color:#999999;" class="outer">
         <?php echo $this->_tpl_vars['j']['comment']; ?>

		 </div>
		 <HR>
		<?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
  <?php endif; ?>
  <!-- Vote Parcentage Area -->
  <?php if ($this->_tpl_vars['i']['votes_all'] > 0): ?>
      <table>
		<tr><td width="18%"><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_VOTEREASULT']; ?>

		<?php echo $this->_tpl_vars['i']['votes_all'];  echo $this->_tpl_vars['_MD_POPNUPBLOG_VOTEALL']; ?>
</td>
		<td width="8%" align="right"><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_YES']; ?>
</td><td width="32%">
          <?php if ($this->_tpl_vars['i']['votes_yes_par'] > 0): ?>
            <div style="background-color: #9999ff; border: 1px solid #777777; text-align: center; width: <?php echo $this->_tpl_vars['i']['votes_yes_pix']; ?>
px">
            (<?php echo $this->_tpl_vars['i']['votes_yes']; ?>
)&nbsp;<?php echo $this->_tpl_vars['i']['votes_yes_par']; ?>
%</div>
          <?php endif; ?>
        </td><td width="8%" align="right"><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_NO']; ?>
</td><td width="32%">
          <?php if ($this->_tpl_vars['i']['votes_no_par'] > 0): ?>
            <div style="background-color: #9999ff; border: 1px solid #777777; text-align: center; width: <?php echo $this->_tpl_vars['i']['votes_no_pix']; ?>
px">
            (<?php echo $this->_tpl_vars['i']['votes_no']; ?>
)&nbsp;<?php echo $this->_tpl_vars['i']['votes_no_par']; ?>
%</div>
          <?php endif; ?>
        </td></tr>
      </table>
  <?php endif; ?>
  <!-- Comment and Vote input Area -->
  <?php if ($this->_tpl_vars['popnupblog_commentable'] == true): ?>
      <input type="hidden" name="param" value="<?php echo $this->_tpl_vars['popnupblog_targetBid']; ?>
-<?php echo $this->_tpl_vars['i']['year'];  echo $this->_tpl_vars['i']['month'];  echo $this->_tpl_vars['i']['date'];  echo $this->_tpl_vars['i']['hours'];  echo $this->_tpl_vars['i']['minutes'];  echo $this->_tpl_vars['i']['seconds']; ?>
" />
      <input type="hidden" name="postid" value="<?php echo $this->_tpl_vars['i']['postid']; ?>
" />
      <!--
      <?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_NAME']; ?>
:
      <?php if ($this->_tpl_vars['popnupblog_uname'] == ""): ?>
          <input type="text" name="commentersname" value="" size="10" />@<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_GUEST']; ?>
&nbsp
      <?php else: ?>
	      <input type="hidden" name="commentersname" value="<?php echo $this->_tpl_vars['popnupblog_uname']; ?>
" />
          <?php echo $this->_tpl_vars['popnupblog_uname']; ?>

      <?php endif; ?>
      -->
      <DIV Align="right">
      [<a href="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/commentedit.php?postid=<?php echo $this->_tpl_vars['i']['postid']; ?>
"><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_LEAVEACOMMENT']; ?>
</a>]
      </DIV>
  <?php endif; ?>
  <CENTER>
  <?php if ($this->_tpl_vars['popnupblog_votable'] == true): ?>
      <!--<input type="hidden" name="param" value="<?php echo $this->_tpl_vars['popnupblog_targetBid']; ?>
-<?php echo $this->_tpl_vars['i']['year'];  echo $this->_tpl_vars['i']['month'];  echo $this->_tpl_vars['i']['date'];  echo $this->_tpl_vars['i']['hours'];  echo $this->_tpl_vars['i']['minutes'];  echo $this->_tpl_vars['i']['seconds']; ?>
" />-->
      <input type="hidden" name="postid" value="<?php echo $this->_tpl_vars['i']['postid']; ?>
" />
      <?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_VOTE']; ?>
:
      <input type="radio" name="vote" value=1><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_YES']; ?>
</input>
      <input type="radio" name="vote" value=-1><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_NO']; ?>
</input>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['popnupblog_commentable'] == true || $this->_tpl_vars['popnupblog_votable'] == true): ?>
      <input type="submit" value="<?php echo $this->_tpl_vars['_MD_POPNUPBLOG_FORM_SEND']; ?>
" />
      </form>
  <?php endif; ?>
  </CENTER>
  <!-- TrackBack Area -->
  <?php if (count ( $this->_tpl_vars['i']['trackbacks'] ) > 0): ?>
	<br />
    <a href="JavaScript:showhide('<?php echo $this->_tpl_vars['i']['date'];  echo $this->_tpl_vars['i']['hours'];  echo $this->_tpl_vars['i']['minutes'];  echo $this->_tpl_vars['i']['seconds']; ?>
')"><?php echo $this->_tpl_vars['_MD_POPNUPBLOG_TRACKBACK']; ?>

    	&nbsp;(<?php echo $this->_tpl_vars['i']['tb_count']; ?>
)</a>
	<div id="<?php echo $this->_tpl_vars['i']['date'];  echo $this->_tpl_vars['i']['hours'];  echo $this->_tpl_vars['i']['minutes'];  echo $this->_tpl_vars['i']['seconds']; ?>
" style="display:none;">
	<hr />
	<?php $_from = $this->_tpl_vars['i']['trackbacks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tb']):
?>
		<li><?php echo $this->_tpl_vars['tb']['count']; ?>
<a href="<?php echo $this->_tpl_vars['tb']['url']; ?>
" target="_blank">
			<?php if ($this->_tpl_vars['tb']['title']):  echo $this->_tpl_vars['tb']['title'];  else:  echo $this->_tpl_vars['tb']['url'];  endif; ?></a>
	<?php endforeach; endif; unset($_from); ?>
	</div>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['i']['trackback_url']): ?>
    <div align="right">[<a href="<?php echo $this->_tpl_vars['i']['trackback_url']; ?>
">TrackBack</a>]</div>
  <?php endif; ?>
  </td></tr>
<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
  <tr><td>no blog</td></tr>
<?php endif; ?>
<tr class="foot"><td align="center" colspan="3">
  <?php echo $this->_tpl_vars['jump_url']; ?>

</td></tr><tr>
<td align="right" valign="bottom" colspan="3">PopnupBlog <?php echo $this->_tpl_vars['POPNUPBLOG_VERSION']; ?>
 created by 
<a href="http://www.bluemooninc.biz/" target="_blank">Bluemoon inc.</a> &nbsp; 
<a href="http://feeds.archive.org/validator/check?url=<?php echo $this->_tpl_vars['popnupblog_user_rss']; ?>
" target="_blank">
<img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss-valid-line.gif" border="0"></a> 
<a href="<?php echo $this->_tpl_vars['popnupblog_user_rss']; ?>
"><img src="<?php echo $this->_tpl_vars['xoops_url']; ?>
/modules/popnupblog/rss10.gif" border="0" /></a>
</td></tr>
</table>
<!-- XOOPS Buit-in comment
<div style="text-align: center; padding: 3px; margin: 3px;">
  <?php echo $this->_tpl_vars['commentsnav']; ?>

  <?php echo $this->_tpl_vars['lang_notice']; ?>

</div>
<div style="margin: 3px; padding: 3px;">
<?php if ($this->_tpl_vars['comment_mode'] == 'flat'): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "db:system_comments_flat.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php elseif ($this->_tpl_vars['comment_mode'] == 'thread'): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "db:system_comments_thread.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php elseif ($this->_tpl_vars['comment_mode'] == 'nest'): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "db:system_comments_nest.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
</div>
-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'db:system_notification_select.html', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<!-- end of popnup blog main block -->