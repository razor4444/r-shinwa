<?php get_header(); ?>
<div id="main">
<article>
<div id="content">
<p class="pankuzu"><a href="<?php echo home_url();?>">HOME</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;404 Page Not Fund</p>
<?php have_posts(); the_post(); ?>
<section>
<p>申し訳ございません。お探しのページが見つかりませんでした。</p>
<p>なおトップページの正しいアドレスは<a href="http://www.r-shinwa.jp/">http://www.r-shinwa.jp/</a>です</p>
</section>
<div class="clear"></div>
</div><!--content-->
</article>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>
<?php get_footer(); ?>