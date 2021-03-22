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
<div>
	<section class="parallax-section small-par" data-scrollax-parent="true">
		<?php if($pictureBG!==null) echo "<div class=\"bg par-elem\" data-bg=\"{$pictureBG}\" data-scrollax=\"properties: { translateY: '30%' }\"></div>"; ?>
    <?php if($pictureBG!==null) echo "<div class=\"overlay  op7\"></div>"; ?>
		<div class="container">
			<div class="<?= $pictureBG!==false ? 'single-facts single-facts_2 fl-wrap' : 'single-facts bold-facts fl-wrap'; ?>">
        <?php foreach($records as $counter_i => $counter): ?>
				<div class="inline-facts-wrap">
					<div class="inline-facts">
						<div class="milestone-counter">
							<div class="stats animaper">
								<div class="num" data-content="0" data-num="<?= ($counter->total); ?>"><?= ($counter->total); ?></div>
							</div>
						</div>
						<h6><?= _autoT($counter->name) . " " . _autoT('in_site'); ?></h6>
					</div>
				</div>
        <?php endforeach; ?>
			</div>
		</div>
	</section>
</div>
