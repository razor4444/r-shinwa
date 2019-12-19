<?php /*Template Name: サイトマップ*/get_header(); ?>
<div id="main">
<article>
<div id="content">
<p class="pankuzu"><a href="<?php echo home_url();?>">HOME</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php the_title(); ?></p>
<?php have_posts(); the_post(); ?>
<section>
<ul class="sitemaps">
<li><a href="<?php echo home_url(); ?>"><?php bloginfo("name"); ?></a>
<ul>
<?php wp_list_pages("title_li="); ?>
<li><a href="http://www.r-shinwa.jp/contact/">資料請求・コンタクト</a></li>
</ul></li>
<li>施工事例<ul><?php $workspost = new WP_Query(array('post_type' =>'works' , 'taxonomy' => 'works_type', 'posts_per_page' => -1)); 
while($workspost -> have_posts()):$workspost -> the_post();?>
<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?></ul></li><li>新着情報（最新10件表示）
<?php sitemap_q(true,false,false); ?>
</li>
</ul>
</section>
<div class="clear"></div>
</div><!--content-->
</article>
<?php get_sidebar(); ?>
<div class="clear"></div>
</div>
<?php get_footer(); ?>