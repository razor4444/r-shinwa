<?php /* Smarty version 2.6.12, created on 2007-07-11 13:24:23
         compiled from db:popnupblog_blogrss.html */ ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="UTF-8"<?php echo '?>'; ?>

<rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/" 
         xmlns="http://purl.org/rss/1.0/" 
	 xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" 
	 xml:lang="ja">
  <channel rdf:about="<?php echo $this->_tpl_vars['channel_link']; ?>
">
    <title><?php echo $this->_tpl_vars['channel_title']; ?>
</title>
    <link><?php echo $this->_tpl_vars['channel_link']; ?>
</link>
    <description><?php echo $this->_tpl_vars['channel_desc']; ?>
</description>
    <items>
      <rdf:Seq>
      <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
        <rdf:li rdf:resource="<?php echo $this->_tpl_vars['item']['link']; ?>
" />
      <?php endforeach; endif; unset($_from); ?>
      </rdf:Seq>
    </items>
  </channel>
  <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
  <item rdf:about="<?php echo $this->_tpl_vars['item']['link']; ?>
">
    <title><?php echo $this->_tpl_vars['item']['title']; ?>
</title>
    <link><?php echo $this->_tpl_vars['item']['link']; ?>
</link>
    <description><?php echo $this->_tpl_vars['item']['desc']; ?>
</description>
    <dc:date><?php echo $this->_tpl_vars['item']['date']; ?>
</dc:date> 
    <dc:creator><?php echo $this->_tpl_vars['item']['uname']; ?>
</dc:creator> 
  </item>
  <?php endforeach; endif; unset($_from); ?>
</rdf:RDF>