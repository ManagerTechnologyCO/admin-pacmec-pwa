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
	<section class="<?= ($filters_active == "true") ? 'gray-bg small-padding no-top-padding-sec' : 'gray-bg small-padding'; ?>" id="sec1">
		<div class="container">
      <?php if($filters_active == "true"): ?>
			<div class="list-main-wrap-header fl-wrap   block_box no-vis-shadow no-bg-header fixed-listing-header">
				<div class="list-main-wrap-opt">
					<!-- //
						<div class="price-opt">
							<span class="price-opt-title"><?= _autoT('sort_by'); ?>: </span>
							<div class="listsearch-input-item">
								<select data-placeholder="modified,desc" class="chosen-select no-search-select ordering-selected">
									<option value="created,desc"><?= _autoT('order_created_desc'); ?></option>
									<option value="modified,desc"><?= _autoT('order_modified_desc'); ?></option>
									<option value="billing_amount,desc"><?= _autoT('order_billing_amount_desc'); ?></option>
									<option value="billing_amount,asc"><?= _autoT('order_billing_amount_asc'); ?></option>
									<option value="max_members,asc"><?= _autoT('order_max_members_asc'); ?></option>
									<option value="max_members,desc"><?= _autoT('order_max_members_desc'); ?></option>
								</select>
							</div>
						</div>
					-->
					<div class="grid-opt">
						<ul class="no-list-style">
							<li class="grid-opt_act"><span class="two-col-grid act-grid-opt tolt" data-microtip-position="bottom" :data-tooltip="_autoT('grid_view')"><i class="fal fa-th"></i></span></li>
							<li class="grid-opt_act"><span class="one-col-grid tolt" data-microtip-position="bottom" :data-tooltip="_autoT('list_view')"><i class="fal fa-list"></i></span></li>
						</ul>
					</div>
				</div>
			</div>
      <?php endif; ?>
			<div class="fl-wrap">
				<div class="listing-item-container init-grid-items fl-wrap nocolumn-lic three-columns-grid">
          <?php if(count($memberships)>0): ?>
            <?php
              $i = 0;
              foreach($memberships as $membership):
                if($i>=$limit) break;
                $url = "/memberships?membership_id={$membership->id}";
                ?>
                <div class="listing-item">
    							<article class="geodir-category-listing fl-wrap">
    								<div class="geodir-category-img">
    									<!-- // <div class="geodir-js-favorite_btn"><i class="fal fa-cash-register"></i><span>Tomar plan</span></div> -->
    									<a href="<?= $url; ?>" class="geodir-category-img-wrap fl-wrap">
    										<img src="<?= (!empty($membership->thumb)) ? $membership->thumb : '/townhub/images/all/1.jpg'; ?>" alt="" />
    									</a>
                       <?php if($membership->initial_payment>0): ?>
                         <div class="geodir_status_date gsd_open"><i class="fal fa-hand-holding-usd"></i> <?= _autoT('required_initial_payment'); ?> </div>
                       <?php endif; ?>
    									<div class="geodir-category-opt">
    										<div class="listing-rating-count-wrap">
    											<div class="review-score"><i class="<?= ($membership->max_members==1) ? 'fal fa-user':'fal fa-users'; ?>"></i></div>
    											<!--//<div class="listing-rating card-popup-rainingvis" data-starrating2="5"></div>-->
    											<br>
    											<div class="reviews-count">
                            <?= ($membership->max_members==1) ? _autoT('individual_membership'):_autoT('group_membership'); ?>
    											</div>
    										</div>
    									</div>
    								</div>
    								<div class="geodir-category-content fl-wrap title-sin_item">
    									<div class="geodir-category-content-title fl-wrap">
    										<div class="geodir-category-content-title-item">
    											<h3 class="title-sin_map">
    												<a href="<?= $url; ?>"><?= _autoT('membership_'.$membership->id); ?></a>
                            <?php if($membership->favorite==1) echo "<span class=\"verified-badge\"><i class=\"fal fa-heart\"></i></span>"; ?>
    											</h3>
    										</div>
    									</div>
    									<div class="geodir-category-text fl-wrap">
    										<p class="small-text"><?= _autoT('membership_'.$membership->id.'_description'); ?></p>
    										<div class="facilities-list fl-wrap">
    											<div class="facilities-list-title"><?= _autoT('benefits'); ?>: </div>
                          <?php if(count($membership->benefits_in)>0){ ?>
      											<ul class="no-list-style">
                              <?php foreach ($membership->benefits_in as $include): ?>
        												<li class="tolt2" data-tippy-content="<?= _autoT('benefit_'.$include->id); ?>">
        													<i class="<?= $include->feature->icon; ?>"></i>
        												</li>
                              <?php endforeach; ?>
      											</ul>
                          <?php } else { ?>
                            <p><?= _autoT('membership_no_beneficits'); ?></p>
                          <?php }; ?>
    										</div>
    										<div class="facilities-list fl-wrap">
    											<div class="facilities-list-title"><?= _autoT('discounts'); ?>: </div>
                          <?php if(count($membership->discounts_in)>0){ ?>
      											<ul class="no-list-style">
                              <?php foreach ($membership->discounts_in as $include): ?>
        												<li class="tolt2" data-tippy-content="<?= _autoT('benefit_'.$include->id); ?>">
        													<i class="<?= $include->feature->icon; ?>"></i>
        												</li>
                              <?php endforeach; ?>
      											</ul>
                          <?php } else { ?>
                            <p><?= _autoT('membership_no_discounts'); ?></p>
                          <?php }; ?>
    										</div>
    									</div>
    									<div class="geodir-category-footer fl-wrap">
    										<a class="listing-item-category-wrap">
    											<div class="listing-item-category red-bg"><i class="fal fa-cheeseburger"></i></div>
    											<span>
                            <?php if($membership->initial_payment > 0) echo "\${$membership->initial_payment} + "; ?>
                            <?php if($membership->billing_amount > 0) echo "\${$membership->billing_amount} x "; ?>
                            <?= ($membership->cycle_number == 1) ? _autoT('period_single_'.$membership->cycle_period) : _autoT('period_plural_'.$membership->cycle_period); ?>
    											</span>
    										</a>
    										<div class="price-level geodir-category_price">
    											<span class="price-level-item" :data-membersrating="record.max_members"></span>
    											<span class="price-name-tooltip">
    												<template v-if="record.max_members == 0">
    													&nbsp;<?= _autoT('unlimit_members'); ?>&nbsp;
    												</template>
    												<template v-else-if="record.max_members == 1">
    													&nbsp;<?= _autoT('personal_use'); ?>&nbsp;
    												</template>
    												<template v-else>
    													&nbsp;{{record.max_members}} <?= _autoT('max_members'); ?>&nbsp;
    												</template>
    											</span>
    										</div>
    									</div>
    								</div>
    							</article>
    						</div>
            <?php
              $i++;
              endforeach; ?>
          <?php endif; ?>
          <?php if($btns_explore == true): ?>
  					<div class="pagination fwmpag">
  						<!--//
  						<a class="prevposts-link" tag="a" href="$route.path" v-if="(parseInt(page)-1) > 0 && total > 0"><i class="fas fa-fast-backward"></i></a>
  						<a class="prevposts-link" tag="a" v-if="(parseInt(page)-1) > 0 && total > 0" href="$route.path+'?page='+parseInt(page)-1"><i class="fas fa-step-backward"></i></a>
  						-->
  					<!-- // <a v-for="(i) in ((total / limit) - parseInt(total / limit) > 0) ? parseInt(total / limit)+1 : (total / limit)" :class="'cursor-pointer page-item ' + (page == i ? ' current-page' : '')" tag="a" href="$route.path+'?page='+i"><span> {{ i }} </span></a> -->
  						<!--//
  						<a class="nextposts-link" tag="a" v-if="(parseInt(page)+1) > 0 && total > 0" href="$route.path+'?page='+parseInt(page)+1"><i class="fas fa-step-forward"></i></a>
  						<a class="nextposts-link" v-if="parseInt(page) < (((total / limit) - parseInt(total / limit) > 0) ? parseInt(total / limit)+1 : (total / limit))" tag="a" href="$route.path+'?page='+(((total / limit) - parseInt(total / limit) > 0) ? parseInt(total / limit)+1 : (total / limit))"><i class="fas fa-fast-forward"></i></a>
  						-->
  					</div>
          <?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<div class="limit-box fl-wrap"></div>
</div>
