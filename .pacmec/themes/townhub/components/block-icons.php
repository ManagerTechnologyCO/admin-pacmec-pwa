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
<section data-scrollax-parent="true">
	<div class="container">
		<div class="section-title">
			<?php if($title!==null) echo "<h2>"._autoT($title)."</h2>"; ?>
			<?php if($subtitle!==null) echo "<div class=\"section-subtitle\">"._autoT($subtitle)."</div>"; ?>
			<span class="section-separator"></span>
      <?php if($content!==null) echo "<p>"._autoT($content)."</p>"; ?>
		</div>
		<div class="process-wrap fl-wrap">
			<ul class="no-list-style">
        <?php foreach($steps As $icon_item_i => $icon_item): ?>
				<li>
					<div class="process-item">
						<span class="process-count"><?= $icon_item_i+1; ?></span>
						<div class="time-line-icon"><i class="<?= $icon_item->icon; ?>"></i></div>
						<h4><?= _autoT($icon_item->title); ?></h4>
						<p><?= _autoT($icon_item->content); ?></p>
					</div>
					<span class="pr-dec"></span>
				</li>
        <?php endforeach; ?>
			</ul>
			<div class="limit-box fl-wrap"></div>
			<div class="process-end"><i class="<?= $icon; ?>"></i></div>
		</div>
	</div>
</section>
