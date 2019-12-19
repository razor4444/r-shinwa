<?php /*Template Name: ポートフォリオ*/ get_header(); ?>
<div id="main">
<article>
<div id="content">
<p class="pankuzu"><a href="<?php echo home_url();?>">HOME</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php the_title(); ?></p>
<?php have_posts(); the_post(); ?>
<section>
<ul class="portfolio">
<li><a href="<?php echo home_url();?>/?page_id=30"><img src="<?php bloginfo('template_url'); ?>/image/casavilla_image.jpg" width="641" height="150" alt=""></a></li>
<li><a href="<?php echo home_url();?>/?page_id=32"><img src="<?php bloginfo('template_url'); ?>/image/rc-villa_image.jpg" width="607" height="150" alt=""></a></li>
<li><a href="<?php echo home_url();?>/?page_id=34"><img src="<?php bloginfo('template_url'); ?>/image/joytas_image.jpg" width="620" height="150" alt=""></a></li>
</ul>
</section>
<div class="clear"></div>
</div><!--content-->
</article>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>
<?php get_footer(); ?>