<?php get_header(); ?>
<div id="main">
<article>
<div id="content">
<p class="pankuzu"><a href="<?php echo home_url();?>">HOME</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<a href="<?php echo home_url();?>/?page_id=20">施工事例一覧</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php the_title(); ?></p>
<?php have_posts(); the_post(); ?>
<script src="<?php bloginfo('template_url'); ?>/js/slide.js"></script>
<script>
$(function() {$('#slideshow .lightbox').lightBox({imageUrl:'<?php bloginfo('template_url'); ?>/image/'});});
</script>
<section>
<div class="works_box">
<div id="slideshow">
<div class="show_box">
<?php if(has_post_thumbnail()):?>
<div><a href="<?php $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(),"full", true); echo $image_url[0]; ?>" class="lightbox">
<?php the_post_thumbnail('slideimg');?></a></div>
<?php endif; ?>
<?php if(post_custom("サブ画像1")): ?>
<div><a href="<?php echo wp_get_attachment_url(post_custom('サブ画像1'),'full'); ?>" class="lightbox"><?php echo wp_get_attachment_image(post_custom('サブ画像1'),'slideimg'); ?></a></div>
<?php endif;?>
<?php if(post_custom("サブ画像2")): ?>
<div><a href="<?php echo wp_get_attachment_url(post_custom('サブ画像2'),'full'); ?>" class="lightbox"><?php echo wp_get_attachment_image(post_custom('サブ画像2'),'slideimg'); ?></a></div>
<?php endif;?>
<?php if(post_custom("サブ画像3")): ?>
<div><a href="<?php echo wp_get_attachment_url(post_custom('サブ画像3'),'full'); ?>" class="lightbox"><?php echo wp_get_attachment_image(post_custom('サブ画像3'),'slideimg'); ?></a></div>
<?php endif;?>
<?php if(post_custom("サブ画像4")): ?>
<div><a href="<?php echo wp_get_attachment_url(post_custom('サブ画像4'),'full'); ?>" class="lightbox"><?php echo wp_get_attachment_image(post_custom('サブ画像4'),'slideimg'); ?></a></div>
<?php endif;?>
<?php if(post_custom("サブ画像5")): ?>
<div><a href="<?php echo wp_get_attachment_url(post_custom('サブ画像5'),'full'); ?>" class="lightbox"><?php echo wp_get_attachment_image(post_custom('サブ画像5'),'slideimg'); ?></a></div>
<?php endif;?>
<?php if(post_custom("サブ画像6")): ?>
<div><a href="<?php echo wp_get_attachment_url(post_custom('サブ画像6'),'full'); ?>" class="lightbox"><?php echo wp_get_attachment_image(post_custom('サブ画像6'),'slideimg'); ?></a></div>
<?php endif;?>
</div>
<ul>
<?php if(has_post_thumbnail()):?><li><?php the_post_thumbnail('thumbnail');?></li>
<?php endif; ?>
<?php if(post_custom("サブ画像1")): ?>
<li><a href="javascript:void(0);">
<?php echo wp_get_attachment_image(post_custom('サブ画像1'),'thumbnail'); ?></a></li>
<?php endif;?>
<?php if(post_custom("サブ画像2")): ?>
<li><a href="javascript:void(0);">
<?php echo wp_get_attachment_image(post_custom('サブ画像2'),'thumbnail'); ?></a></li>
<?php endif;?>
<?php if(post_custom("サブ画像3")): ?>
<li><a href="javascript:void(0);">
<?php echo wp_get_attachment_image(post_custom('サブ画像3'),'thumbnail'); ?></a></li>
<?php endif;?>
<?php if(post_custom("サブ画像4")): ?>
<li><a href="javascript:void(0);">
<?php echo wp_get_attachment_image(post_custom('サブ画像4'),'thumbnail'); ?></a></li>
<?php endif;?>
<?php if(post_custom("サブ画像5")): ?>
<li><a href="javascript:void(0);">
<?php echo wp_get_attachment_image(post_custom('サブ画像5'),'thumbnail'); ?></a></li>
<?php endif;?>
<?php if(post_custom("サブ画像6")): ?>
<li><a href="javascript:void(0);">
<?php echo wp_get_attachment_image(post_custom('サブ画像6'),'thumbnail'); ?></a></li>
<?php endif;?>
</ul>
</div>
<div class="works_detail">
<h2><?php if(post_custom('catch')){echo post_custom('catch');}else{the_title();}; ?></h2>
<div class="brand_tag">
<?php if (is_object_in_term( $post->ID,'brand_type', 'rc-villa')): ?>
<img src="<?php bloginfo('template_url'); ?>/image/rc-villa_icon.png" width="72" height="10" alt="">
<?php elseif (is_object_in_term( $post->ID, 'brand_type','joytas')): ?>
<img src="<?php bloginfo('template_url'); ?>/image/joytas_icon.png" width="72" height="10" alt="">
<?php elseif (is_object_in_term( $post->ID,'brand_type', 'casavilla')): ?>
<img src="<?php bloginfo('template_url'); ?>/image/casavilla_icon.png" width="72" height="10" alt="">
<?php endif; ?>
</div>
<?php the_content(); ?>
</div>
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