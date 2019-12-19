<?php /* Smarty version 2.6.12, created on 2007-07-12 23:34:48
         compiled from db:wp_block_contents.html */ ?>
<?php if ($this->_tpl_vars['block']['style'] != ""): ?>
<style type="text/css">
	<!--
	<?php echo $this->_tpl_vars['block']['style']; ?>

	-->
</style>
<?php endif; ?>
<div id='<?php echo $this->_tpl_vars['block']['divid']; ?>
'>
<?php if ($this->_tpl_vars['block']['use_theme_template'] == 0): ?>
  <?php $_from = $this->_tpl_vars['block']['contents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['content']):
?>
    <?php if ($this->_tpl_vars['content']['date'] != ""): ?>
        <h2><?php echo $this->_tpl_vars['content']['date']; ?>
</h2>
    <?php endif; ?>
        <div class="post">
            <h3 class="storytitle" id="post-<?php echo $this->_tpl_vars['content']['date']; ?>
"><a href="<?php echo $this->_tpl_vars['content']['permlink']; ?>
" rel="bookmark" title="Permanent Link: <?php echo $this->_tpl_vars['content']['title']; ?>
"><?php echo $this->_tpl_vars['content']['title']; ?>
</a></h3>
            <div class="meta">
                Filed under: <?php echo $this->_tpl_vars['content']['category']; ?>
 - <?php echo $this->_tpl_vars['content']['author']; ?>
 @ <?php echo $this->_tpl_vars['content']['time']; ?>

            </div>
            <div class="storycontent">
                <p><?php echo $this->_tpl_vars['content']['body']; ?>
</p>
                <br clear=left>
            </div>
            <div class="feedback">
                <?php echo $this->_tpl_vars['content']['linkpage']; ?>
 <?php echo $this->_tpl_vars['content']['comments']; ?>
 
            </div>
<!--
<?php echo $this->_tpl_vars['content']['trackback']; ?>

-->
        </div>
  <?php endforeach; endif; unset($_from); ?>
<?php else: ?>
  <?php echo $this->_tpl_vars['block']['template_content']; ?>

<?php endif; ?>
</div>