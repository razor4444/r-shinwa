<?php get_header(); ?>
<div id="main">
<article>
<div id="content">
<div id="flash">
<script src="<?php bloginfo('template_url'); ?>/js/top_slide.js"></script>
<ul id="top_slide">
<li><img src="<?php bloginfo('template_url'); ?>/image/slide_01.jpg" width="750" height="350" alt=""> </li>
<li><img src="http://www.r-shinwa.jp/wps/wp-content/uploads/2012/08/CASAVILLA1.jpg" width="750" height="350" alt=""> </li>
<li><img src="http://www.r-shinwa.jp/wps/wp-content/uploads/2012/08/CASAVILLA3.jpg" width="750" height="350" alt=""> </li>
<li><img src="<?php bloginfo('template_url'); ?>/image/slide_04.jpg" width="750" height="350" alt="<?php bloginfo('description'); ?>"> </li>
</ul>
</div>
<div id="top_news">


<a href="http://www.r-shinwa.jp/?page_id=10"><img src="http://www.r-shinwa.jp/wps/wp-content/themes/casavilla/image/550.png"></a>


<h2><a href="<?php echo home_url();?>/?page_id=10"><span class="none">information</span></a></h2>
<dl>
<?php query_posts('posts_per_page=10');while(have_posts()): the_post(); ?>
<dt>
<?php the_time("Y.m.d"); ?>
</dt>
<dd><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo mb_strimwidth($post->post_title, 0, 60, "..."); ?></a></dd>
<?php endwhile; wp_reset_query(); ?>
</dl>
</div>
<div id="top_works">
<h3><a href="<?php echo home_url();?>/?page_id=20"><span class="none">works</span></a></h3>
<?php $works = new WP_Query('post_type=works&posts_per_page=3&order=ASC&orderby=menu_order'); if( $works->have_posts()): ?>
<ul>
<?php while( $works->have_posts()): $works->the_post(); ?>
<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
<?php if(has_post_thumbnail()):?>
<?php the_post_thumbnail('topworks');?>
<?php else: ?>
<img src="<?php bloginfo('template_url'); ?>/image/topworks.png" width="160" height="100" alt="<?php the_title(); ?>" />
<?php endif; ?>
</a></li>
<?php endwhile; ?>
</ul>
<?php endif;wp_reset_postdata(); ?>
</div>
<div class="clear"></div>
</div>
<!--content--> 
</article>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>
<?php get_footer(); ?>
