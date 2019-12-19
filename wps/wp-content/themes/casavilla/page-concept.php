<?php /*Template Name: コンセプトページ*/ get_header(); ?>
<div id="main">
<article>
<div id="content">
<p class="pankuzu"><a href="<?php echo home_url();?>">HOME</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php the_title(); ?></p>
<?php have_posts(); the_post(); ?>
<section>
<?php if(has_post_thumbnail()):?>
<div class="concept_image">
<?php the_post_thumbnail('full');?>
</div><?php endif; ?>
<div class="concept_detail">
<?php the_content(); ?>
</div>
</section>
<div class="clear"></div>
</div><!--content-->
</article>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>
<?php get_footer(); ?>