<?php if(in_category('work')){get_template_part('single-works');}get_header(); ?>
<div id="main">
<article>
<div id="content">

<?php have_posts(); the_post(); ?>
<section>
<h2 class="blog_title"><?php the_title(); ?></h2>
<p class="time"><time datetime="<?php the_time("Y-m-d"); ?>" pubdate="pubdata"><?php the_time("Y.m.d"); ?></time></p>
<div class="blog_post">
<?php the_content(); ?>
</div>
<?php get_template_part('social'); ?>
<div class="pagelink">
<span class="oldpage"><?php previous_post_link('%link &raquo;','%title',true );?></span>
<span class="newpage"><?php next_post_link('&laquo; %link','%title',true) ;?></span>
</div>
</section>
<div class="clear"></div>
</div><!--content-->
</article>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>
<?php get_footer(); ?>