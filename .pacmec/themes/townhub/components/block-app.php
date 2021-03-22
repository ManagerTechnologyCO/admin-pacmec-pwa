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
<section class="gradient-bg hidden-section" data-scrollax-parent="true">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="colomn-text  pad-top-column-text fl-wrap">
					<div class="colomn-text-title" id="divInstall2">
            <?php if($title !== null) echo "<h3>"._autoT($title)."</h3>"; ?>
            <?php if($content !== null) echo "<p>"._autoT($content)."</p>"; ?>
						<a style="cursor:pointer" @click="installApp" class=" down-btn color3-bg"><i class="fab fa-android"></i> <?= _autoT('app_install'); ?> </a>
						<a style="cursor:pointer" @click="installApp" class=" down-btn color3-bg"><i class="fab fa-apple"></i> <?= _autoT('app_install'); ?> </a>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="collage-image">
          <?php if($pictureBG !== null) echo "<img src=\"{$pictureBG}\" class=\"main-collage-image\" />"; ?>
          <?php if(siteinfo('site_logo') !== 'NaN') echo "<div class=\"images-collage-title color2-bg icdec\"> <img src=\"".siteinfo('site_logo')."\" /></div>"; ?>
					<div class="images-collage_icon green-bg" style="right:-20px; top:120px;"><i class="fal fa-thumbs-up"></i></div>
					<div class="collage-image-min cim_1"><img src="<?= get_template_directory_uri(); ?>/assets/images/api/1.jpg" alt=""></div>
					<div class="collage-image-min cim_2"><img src="<?= get_template_directory_uri(); ?>/assets/images/api/1.jpg" alt=""></div>
					<div class="collage-image-btn green-bg">Booking now</div>
					<div class="collage-image-input">Search <i class="fa fa-search"></i></div>
				</div>
			</div>
		</div>
	</div>
	<div class="gradient-bg-figure" style="right:-30px;top:10px;"></div>
	<div class="gradient-bg-figure" style="left:-20px;bottom:30px;"></div>
	<div class="circle-wrap" style="left:270px;top:120px;" data-scrollax="properties: { translateY: '-200px' }">
		<div class="circle_bg-bal circle_bg-bal_small"></div>
	</div>
	<div class="circle-wrap" style="right:420px;bottom:-70px;" data-scrollax="properties: { translateY: '150px' }">
		<div class="circle_bg-bal circle_bg-bal_big"></div>
	</div>
	<div class="circle-wrap" style="left:420px;top:-70px;" data-scrollax="properties: { translateY: '100px' }">
		<div class="circle_bg-bal circle_bg-bal_big"></div>
	</div>
	<div class="circle-wrap" style="left:40%;bottom:-70px;"  >
		<div class="circle_bg-bal circle_bg-bal_middle"></div>
	</div>
	<div class="circle-wrap" style="right:40%;top:-10px;"  >
		<div class="circle_bg-bal circle_bg-bal_versmall" data-scrollax="properties: { translateY: '-350px' }"></div>
	</div>
	<div class="circle-wrap" style="right:55%;top:90px;"  >
		<div class="circle_bg-bal circle_bg-bal_versmall" data-scrollax="properties: { translateY: '-350px' }"></div>
	</div>
</section>
