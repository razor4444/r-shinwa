<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<title><?php bloginfo('name'); ?></title>
<link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" media="all" />
<link href="<?php bloginfo('template_url'); ?>/print.css" rel="stylesheet" media="print">
<?php
wp_deregister_script('jquery');
wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', array(), '1.7.1');
?>
<?php wp_head(); ?>
<meta property="og:title" content="<?php the_post();if(is_front_page()){bloginfo('name');}else{the_title();}; ?>" />
<meta property="og:type" content="website" />
<meta property="og:description" content="<?php if(empty($post->post_content)){bloginfo('description');}else{the_excerpt(); } ?>" />
<meta property="og:image" content="<?php bloginfo('template_url'); ?>/image.png" />
<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
<meta property="fb:app_id" content="507870152590975">
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<script src="<?php bloginfo('template_url'); ?>/js/scriptset.js"></script>
</head>
<body <?php body_class(); ?>>
<header>
<div id="header">
<ul id="header_link">
<li><a id="hl_sitemap" href="<?php echo home_url();?>/?page_id=37"><span class="none">サイトマップ</span></a></li>
<li><a id="hl_privacy" href="<?php echo home_url();?>/?page_id=39"><span class="none">プライバシーポリシー</span></a></li>
<li><a id="hl_link" href="<?php echo home_url();?>/?page_id=41"><span class="none">リンク</span></a></li>
</ul>
<div class="clear">
<h1 title="<?php bloginfo('description'); ?>"><a href="<?php echo home_url();?>"><span class="none"><?php bloginfo('description'); ?></span></a></h1>
<div class="siryou"><a href="<?php echo home_url();?>/contact/" title="資料請求"><span class="none">資料請求</span></a></div>
<address title="℡：072-259-0672">
<p class="none">"ご相談はお気軽にお問い合わせください。<br>
電話：072-259-0672</p>
</address>
</div>
</div>
</header>