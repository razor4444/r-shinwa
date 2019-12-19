<?php get_header(); ?>
<div id="main">
<article>
<div id="content">
<p class="pankuzu"><a href="<?php echo home_url();?>">HOME</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php the_title(); ?></p>
<?php have_posts(); the_post(); ?>
<article>
<h2><img src="<?php bloginfo('template_url'); ?>/image/showroom_title.png" width="162" height="20" alt="SHOWROOM" /></h2>
<p class="small">カーサビラ/進和ホームのショールーム</p>
<script src="<?php bloginfo('template_url'); ?>/js/slide.js"></script>
<div id="slideshow" class="showroom">
<div class="show_box">
<div><a href="<?php bloginfo('template_url'); ?>/image/showroom_07b.jpg" class="lightbox"><img src="<?php bloginfo('template_url'); ?>/image/showroom_07.jpg" /></a></div>
<div><a href="<?php bloginfo('template_url'); ?>/image/showroom_06b.jpg" class="lightbox"><img src="<?php bloginfo('template_url'); ?>/image/showroom_06.jpg" /></a></div>
<div><a href="<?php bloginfo('template_url'); ?>/image/showroom_02b.jpg" class="lightbox"><img src="<?php bloginfo('template_url'); ?>/image/showroom_02.jpg" /></a></div>
<div><a href="<?php bloginfo('template_url'); ?>/image/showroom_03b.jpg" class="lightbox"><img src="<?php bloginfo('template_url'); ?>/image/showroom_03.jpg" /></a></div>
<div><a href="<?php bloginfo('template_url'); ?>/image/showroom_08b.jpg" class="lightbox"><img src="<?php bloginfo('template_url'); ?>/image/showroom_08.jpg" /></a></div>
</div>
<ul>
<li><a href="javascript:void(0);">
<img src="<?php bloginfo('template_url'); ?>/image/showroom_07s.jpg" />
</a></li>
<li><a href="javascript:void(0);">
<img src="<?php bloginfo('template_url'); ?>/image/showroom_06s.jpg" />
</a></li>
<li><a href="javascript:void(0);">
<img src="<?php bloginfo('template_url'); ?>/image/showroom_02s.jpg" />
</a></li>
<li><a href="javascript:void(0);">
<img src="<?php bloginfo('template_url'); ?>/image/showroom_03s.jpg" />
</a></li>
<li><a href="javascript:void(0);">
<img src="<?php bloginfo('template_url'); ?>/image/showroom_08s.jpg" />
</a></li>
</ul>
</div>
<div id="showroom_detail">
<div>
<h3><img src="<?php bloginfo('template_url'); ?>/image/casavilla_gallery.png" width="217" height="25" alt="CASAvilla Gallery" /></h3>
<p class="small">カーサビラ　ギャラリー</p>
<?php the_content(); ?>
</div>
</div>
<p class="print_icon"><a href="#" onclick="window.print();return false;">
印刷する
</a></p>
<div class="clear"></div>



</article>
<div class="clear"></div>
</div><!--content-->
</article>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>
<?php get_footer(); ?>