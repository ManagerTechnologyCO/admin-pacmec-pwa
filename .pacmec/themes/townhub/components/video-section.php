<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Townhub
 * @category   Themes
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 *
 */
?>
<section class="parallax-section" data-scrollax-parent="true">
  <?php if($pictureBG !== null) echo "<div class=\"bg par-elem\" data-bg=\"{$pictureBG}\" data-scrollax=\"properties: { translateY: '30%' }\"></div>"; ?>
	<div class="overlay op7"></div>
	<!--container-->
	<div class="container">
		<div class="video_section-title fl-wrap">
      <?php if($title!==null) echo "<h4>"._autoT($title)."</h4>"; ?>
      <?php if($content!==null) echo "<h2>"._autoT($content)."</h2>"; ?>
		</div>
    <?php if($link!==null) echo "<a href=\"{$link}\" class=\"promo-link big_prom image-popup\"><i class=\"fal fa-play\"></i><span>"._autoT('video_play')."</span></a>"; ?>
	</div>
</section>
