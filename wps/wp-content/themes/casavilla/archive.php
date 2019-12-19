<?php /*
Template Name: アーカイブ
*/
 get_header(); ?>
<div id="main">
<article>
<div id="content">
<?php if ( function_exists('yoast_breadcrumb') ) {
yoast_breadcrumb('<p class="pankuzu">','</p>');
} /*?>
<!--<p class="pankuzu"><a href="<?php echo home_url();?>">HOME</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php if(is_page('10')){the_title();
}
elseif(is_category()){single_cat_title();}
elseif ( is_day() ){echo get_the_date();}
elseif ( is_month() ) {echo get_the_date('Y年F');}
elseif ( is_year() ){echo get_the_date('Y年');}
elseif(is_tag()){single_tag_title();}
elseif(is_post_type_archive()){post_type_archive_title();}
elseif(is_tax() ){single_term_title();}
elseif(is_author){the_author();}
else {echo ('新着情報');}?>
</p>-->*/?>
<?php if(is_page('10')): ?>
<?php $paged = get_query_var('paged'); query_posts('cat=0&paged='.$paged); ?>
<?php elseif(is_category('7')):?>
<?php $paged = get_query_var('paged'); query_posts('cat=7&paged='.$paged); ?>
<?php endif; ?>
<section>
<div id="top_news">
<h2><span class="none">information</span></h2>
<dl>
<?php while(have_posts()): the_post(); ?>
<dt><?php the_time("Y.m.d"); ?></dt><dd><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo mb_strimwidth($post->post_title, 0, 70, "..."); ?></a></dd>
<?php endwhile;wp_reset_query();?>
</dl>
<div class="pagelink">
<span class="oldpage"><?php next_posts_link('次のページ &raquo;') ;?></span>
<span class="newpage"><?php previous_posts_link('&laquo; 前のページ');?></span>
</div>
<?php wp_reset_query();?>
</div>
</section>
<div class="clear"></div>
</div><!--content-->
</article>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>
<?php get_footer(); ?>