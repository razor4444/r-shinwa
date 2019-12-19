<?php /*
Template Name: 事例一覧
*/ get_header(); ?>
<div id="main">
<article>
<div id="content">
<p class="pankuzu"><a href="<?php echo home_url();?>">HOME</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php the_title(); ?></p>
<?php $paged = get_query_var('paged'); query_posts('post_type=works&order=ASC&orderby=menu_order&paged='.$paged); ?>
<section>
<ul class="works_list">
<?php while(have_posts()): the_post(); ?>
<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
<?php if(has_post_thumbnail()):?>
<?php the_post_thumbnail('works_list');?>
<?php else: ?>
<img src="<?php bloginfo('template_url'); ?>/image.png" width="160" height="160" alt="<?php the_title(); ?>" /><?php endif; ?></a>
<p><?php the_title(); ?>&nbsp;&nbsp;<?php if (is_object_in_term( $post->ID,'brand_type', 'rc-villa')): ?>
<img src="<?php bloginfo('template_url'); ?>/image/rc-villa_icon.png" width="72" height="10" alt="">
<?php elseif (is_object_in_term( $post->ID, 'brand_type','joytas')): ?>
<img src="<?php bloginfo('template_url'); ?>/image/joytas_icon.png" width="72" height="10" alt="">
<?php elseif (is_object_in_term( $post->ID,'brand_type', 'casavilla')): ?>
<img src="<?php bloginfo('template_url'); ?>/image/casavilla_icon.png" width="72" height="10" alt="">
<?php endif; ?>
</p></li>
<?php endwhile; ?>
</ul>
<div class="pagelink">
<span class="oldpage"><?php next_posts_link('次のページ &raquo;') ;?></span>
<span class="newpage"><?php previous_posts_link('&laquo; 前のページ');?></span>
</div>
<?php wp_reset_query(); ?>
</section>
<div class="clear"></div>
</div><!--content-->
</article>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>
<?php get_footer(); ?>