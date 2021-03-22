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
<section   id="sec1" data-scrollax-parent="true">
	<div class="container">
		<div class="section-title" v-if="page!==null">
			<h2> <?php do_action('page_title'); ?> </h2>
			<div class="section-subtitle"><?php do_action('page_title'); ?></div>
			<span class="section-separator"></span>
			<p><?= _autoT(pageinfo('description')); ?></p>
		</div>
		<div class="about-wrap">
			<div class="row">
				<?php if($picture!==null): ?>
				<div class="col-md-6">
					<div class="list-single-main-media fl-wrap" style="box-shadow: 0 9px 26px rgba(58, 87, 135, 0.2);">
						<img src="<?= $picture; ?>" class="respimg" alt="" />
					</div>
				</div>
				<?php endif; ?>
				<div class="<?= ($picture!==null) ? 'col-md-6' : 'col-md-12'; ?>">
					<div class="ab_text">
						<div class="ab_text-title fl-wrap">
							<?php if($title!==null) echo "<h3>"._autoT($title)."</h3>"; ?>
							<?php if($subtitle!==null) echo "<h4>"._autoT($subtitle)."</h4>"; ?>
							<span class="section-separator fl-sec-sep"></span>
						</div>
						<?php if($description!==null) echo "<p>"._autoT($description)."</p>"; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
