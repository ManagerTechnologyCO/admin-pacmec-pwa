<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Themes
 * @category   Townhub
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 */
?>
<div>
		 <section class="parallax-section single-par" data-scrollax-parent="true">
        <div class="bg par-elem "  data-bg="<?= siteinfo('section_single_bg'); ?>" data-scrollax="properties: { translateY: '30%' }"></div>
        <div class="overlay op7"></div>
        <div class="container">
            <div class="section-title center-align big-title">
                <h2><span><?php do_action('page_title'); ?></span></h2>
                <span class="section-separator"></span>
<!--//
<div class="breadcrumbs fl-wrap"><a href="#">Home</a><a href="#">Pages</a><span>About us</span></div>
-->
            </div>
        </div>
        <!--//
<div class="header-sec-link">
            <a href="#sec1" class="custom-scroll-link"><i class="fal fa-angle-double-down"></i></a>
        </div>
-->
    </section>
    <div>
      <?php the_content(); ?>
    </div>
</div>
