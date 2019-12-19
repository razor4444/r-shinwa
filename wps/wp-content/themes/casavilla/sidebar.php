<aside>
<div id="sidebar">
<nav>
<ul id="side_nav">
<li><a id="smenu_home" href="<?php echo home_url();?>"><span class="none">ホーム</span></a></li>
<li><a id="smenu_news" href="<?php echo home_url();?>/?page_id=10"><span class="none">新着情報</span></a></li>
<li><a id="smenu_concept" href="<?php echo home_url();?>/?page_id=12"><span class="none">コンセプト</span></a></li>
<li><a id="smenu_portfolio" href="<?php echo home_url();?>/?page_id=18"><span class="none">ポートフォリオ</span></a></li>
<li><a id="smenu_works" href="<?php echo home_url();?>/?page_id=20"><span class="none">施工事例</span></a></li>
<li><a id="smenu_showroom" href="<?php echo home_url();?>/?page_id=23"><span class="none">ショールーム</span></a></li>
<li><a id="smenu_aboutus" href="<?php echo home_url();?>/?page_id=25"><span class="none">会社概要</span></a></li>
<?php $faq = new WP_Query('page_id=26'); if( $faq -> have_posts()): $faq ->the_post(); ?>
<li><a id="smenu_gaq" href="<?php echo home_url();?>/?page_id=26"><span class="none">Q&amp;A</span></a></li>
<?php endif;?>
<li><a id="smenu_contact" href="<?php echo home_url();?>/contact/"><span class="none">資料請求</span></a></li>
</ul>
</nav>
<?php $faq = new WP_Query('page_id=26'); if( $faq -> have_posts()): $faq ->the_post(); else: ?>
<div style="height:35px;"></div>
<?php endif;?>
<ul id="side_banner">
<li><a href="<?php echo home_url();?>/?page_id=30"><img src="<?php bloginfo('template_url'); ?>/image/casavilla_banner.png" width="161" height="55" alt=""></a></li>
<li><a href="<?php echo home_url();?>/?page_id=32"><img src="<?php bloginfo('template_url'); ?>/image/rc-villa_banner.png" width="161" height="55" alt=""></a></li>
<li><a href="<?php echo home_url();?>/?page_id=34"><img src="<?php bloginfo('template_url'); ?>/image/joytas_banner.png" width="161" height="55" alt=""></a></li>
<li><a href="http://www.casavita.jp/" target="blank"><img src="<?php bloginfo('template_url'); ?>/image/vita_banner.jpg" width="161" height="48" alt=""></a></li>
<li><a href="http://www.r-shinwa.jp/vita/" target="blank"><img src="<?php bloginfo('template_url'); ?>/image/kuro_banner.jpg" width="161" height="55" alt=""></a></li>
<li><a href="http://www.r-shinwa.jp/kodawari/" target="blank"><img src="<?php bloginfo('template_url'); ?>/image/blog.jpg" width="161" height="55" alt=""></a></li>
<?php if(!is_front_page()){?>
<li><a href="http://concept.r-shinwa.jp/" target="blank"><img src="<?php bloginfo('template_url'); ?>/image/660_bar.png" width="161" height="55" alt=""></a></li>
<?php }?>
<li><a href="https://www.facebook.com/pages/%E9%80%B2%E5%92%8C%E3%83%9B%E3%83%BC%E3%83%A0%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BE-%E4%BA%BA%E7%94%9F%E3%82%92%E8%AC%B3%E6%AD%8C%E3%81%99%E3%82%8B%E4%BD%8F%E3%81%BE%E3%81%84/470774426374003" target="blank"><img src="<?php bloginfo('template_url'); ?>/image/fb.png" width="161" height="55" alt=""></a></li>
</ul>
</div>
</aside>