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
<section>
	<div class="container">
		<div class="section-title">
			<?php if($title!==null) echo "<h2>"._autoT($title)."</h2>"; ?>
			<?php if($subtitle!==null) echo "<div class=\"section-subtitle\">"._autoT($subtitle)."</div>"; ?>
			<span class="section-separator"></span>
			<?php if($description!==null) echo "<p>"._autoT($description)."</p>"; ?>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="testimonilas-carousel-wrap fl-wrap">
		<div class="listing-carousel-button listing-carousel-button-next"><i class="fas fa-caret-right"></i></div>
		<div class="listing-carousel-button listing-carousel-button-prev"><i class="fas fa-caret-left"></i></div>
		<div class="testimonilas-carousel">
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<?php foreach($records as $person): ?>
						<div class="swiper-slide">
							<div class="testi-item fl-wrap">
								<!--//
								<div class="testi-avatar">
									<img src="/townhub/images/avatar/1.jpg" alt="">
								</div>
								-->
								<div class="testimonilas-text fl-wrap">
									<div class="listing-rating card-popup-rainingvis" data-starrating2="<?= $person->vote; ?>"></div>
									<p><?= $person->comment; ?></p>
									<!-- // <a href="#" class="testi-link" target="_blank">Via Facebook</a> -->
									<div class="testimonilas-avatar fl-wrap">
										<h3><?= $person->name; ?></h3>
										<!-- // <h4>Restaurant Owner</h4> -->
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="tc-pagination"></div>
	</div>
	<div class="waveWrapper waveAnimation">
	  <div class="waveWrapperInner bgMiddle">
		<div class="wave-bg-anim waveMiddle" style="background-image: url('/townhub/images/wave-top.png')"></div>
	  </div>
	  <div class="waveWrapperInner bgBottom">
		<div class="wave-bg-anim waveBottom" style="background-image: url('/townhub/images/wave-top.png')"></div>
	  </div>
	</div>
</section>
