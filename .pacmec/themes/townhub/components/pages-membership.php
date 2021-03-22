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
<?php if($membership !== null): ?>
<div class="content">
    <section class="listing-hero-section hidden-section" data-scrollax-parent="true" id="sec1">
        <div class="bg-parallax-wrap">
          <?php if(!empty($membership->thumb)) echo "<div class=\"bg par-elem\" data-bg=\"{$membership->thumb}\" data-scrollax=\"properties: { translateY: '30%' }\"></div>"; ?>
            <div class="overlay"></div>
        </div>
        <div class="container">
            <div class="list-single-header-item  fl-wrap">
                <div class="row">
                    <div class="col-md-9">
                        <h1><?= _autoT('membership_'.$membership->id);?> <?php if($membership->favorite == 1) echo '<span class="verified-badge"><i class="fal fa-heart"></i></span>'; ?></h1>
                        <div class="geodir-category-location fl-wrap">
                          <?php if($membership->initial_payment>0) echo "<a href=\"#\"><i class=\"fas fa-hand-holding-usd\"></i>"._autoT('required_initial_payment')."</a>"; ?>
													<a href="#"> <i class="<?= $membership->max_members==1?'fal fa-user':'fal fa-users'; ?>"></i><?=($membership->max_members==1)?_autoT('individual_membership'):_autoT('group_membership'); ?></a>
													<!-- <a href="#"><i class="fal fa-envelope"></i> yourmail@domain.com</a> -->
												</div>
                    </div>
                    <div class="col-md-3">
											<!--//
                        <a class="fl-wrap list-single-header-column custom-scroll-link " href="#sec5">
                            <div class="listing-rating-count-wrap single-list-count">
                                <div class="review-score">{{$membership.max_members}}</div>
                                <div class="listing-rating card-popup-rainingvis" :data-membersrating="$membership.max_members"></div>
                                <br>
                                <div class="reviews-count">
																	<template v-if="$membership.max_members == 0">
																		&nbsp;Miembros inlimitados&nbsp;
																	</template>
																	<template v-else-if="$membership.max_members == 1">
																		&nbsp;Uso personal&nbsp;
																	</template>
																	<template v-else>
																		&nbsp;{{$membership.max_members}} miembros maximos&nbsp;
																	</template>
																</div>
                            </div>
                        </a>
											-->
                    </div>
                </div>
            </div>
            <div class="list-single-header_bottom fl-wrap">
              <?php if($membership->initial_payment > 0): ?>
  							<a class="listing-item-category-wrap tolt" href="#" data-microtip-position="top" data-tooltip="<?= _autoT('initial_payment'); ?>">
  									<div class="listing-item-category  yellow-bg"><i class="fal fa-lightbulb-dollar"></i></div>
  									<span><?= $membership->initial_payment; ?></span>
  									&nbsp;
  									&nbsp;
  							</a>
              <?php else: ?>
  							<a class="listing-item-category-wrap" href="#">
  								<div class="listing-item-category  green-bg"><i class="fal fa-star-exclamation"></i></div>
  								<span><?= _autoT('no_required_initial_payment'); ?></span>
  								&nbsp;
  								&nbsp;
  							</a>
              <?php endif; ?>

              <?php if($membership->billing_amount > 0): ?>
  							<a class="listing-item-category-wrap tolt" href="#" data-microtip-position="top" data-tooltip="<?= _autoT('billing_amount') . 'x' . ($membership->cycle_number==1 ? _autoT('period_single_'.$membership->cycle_period) : $membership->cycle_number . _autoT('period_plural_'.$membership->cycle_period)); ?>">
  								<div class="listing-item-category  green-bg"><i class="fal fa-lightbulb-dollar"></i></div>
  								<span><?= $membership->billing_amount; ?></span>
  								&nbsp;
  								&nbsp;
  							</a>
              <?php else: ?>
  							<a class="listing-item-category-wrap" href="#">
  								<div class="listing-item-category  green-bg"><i class="fal fa-calendar-star"></i></div>
  								<span><?= _autoT('no_required_billing_amount'); ?></span>
  								&nbsp;
  								&nbsp;
  							</a>
              <?php endif; ?>
              <div class="list-single-stats">
                  <ul class="no-list-style">
                      <li>
													<span class="viewed-counter">
													<?php if($membership->max_members == 0): ?>
														<i class="fal fa-lock-open"></i>&nbsp;<?= _autoT('unlimit_members'); ?>&nbsp;
													<?php elseif($membership->max_members == 1): ?>
														<i class="fal fa-user"></i>&nbsp;<?= _autoT('personal_use'); ?>&nbsp;
                          <?php else: ?>
														<i class="fal fa-users"></i>&nbsp;<?= $membership->max_members; ?> <?= _autoT('max_members'); ?>&nbsp;
													<?php endif; ?>
													</span>
											</li>
                      <!--//<li><span class="bookmark-counter"><i class="fas fa-heart"></i> Bookmark -  24 </span></li> -->
                  </ul>
              </div>
            </div>
        </div>
    </section>
    <section class="gray-bg no-top-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="list-single-main-wrapper fl-wrap" id="sec2">
											<!--//
                        <div class="list-single-main-media fl-wrap">
                            <img :src="(!$membership.thumb) ? '/townhub/images/all/1.jpg' : $membership.thumb" class="respimg" alt="">
                            <a href="https://vimeo.com/70851162" class="promo-link   image-popup"><i class="fal fa-video"></i><span>Promo Video</span></a>
                        </div>
											-->
                        <div class="list-single-main-item fl-wrap block_box">
                            <div class="list-single-main-item-title">
                                <h3><?= _autoT('description'); ?></h3>
                            </div>
                            <div class="list-single-main-item_content fl-wrap">
                                <p><?= _autoT('membership_'.$membership->id.'_description'); ?></p>
                                <!--//<a href="#" class="btn color2-bg    float-btn">Visit Website<i class="fal fa-chevron-right"></i></a> -->
                            </div>
                        </div>
                        <div class="list-single-main-item fl-wrap block_box">
                            <div class="list-single-main-item-title">
                                <h3><?= _autoT('benefits'); ?></h3>
                            </div>
                            <div class="list-single-main-item_content fl-wrap">
                                <div class="listing-features fl-wrap">
                                  <?php if(count($membership->benefits_in)>0){ ?>
              											<ul class="no-list-style">
                                      <?php foreach ($membership->benefits_in as $include): ?>
                                        <li>
                                            <a><i class="<?= $include->feature->icon; ?>"></i> <?= _autoT('benefit_'.$include->id); ?></a>
                                        </li>
                                      <?php endforeach; ?>
              											</ul>
                                  <?php } else { ?>
                                    <p><?= _autoT('membership_no_beneficits'); ?></p>
                                  <?php }; ?>
                                </div>
                            </div>
                        </div>
                        <div class="list-single-main-item fl-wrap block_box">
                            <div class="list-single-main-item-title">
                                <h3><?= _autoT('discounts'); ?></h3>
                            </div>
                            <div class="list-single-main-item_content fl-wrap">
                                <div class="listing-features fl-wrap">
                                  <?php if(count($membership->discounts_in)>0){ ?>
              											<ul class="no-list-style">
                                      <?php foreach ($membership->discounts_in as $include): ?>
                                        <li>
                                            <a><i class="<?= $include->feature->icon; ?>"></i> <?= _autoT('benefit_'.$include->id); ?></a>
                                        </li>
                                      <?php endforeach; ?>
              											</ul>
                                  <?php } else { ?>
                                    <p><?= _autoT('membership_no_beneficits'); ?></p>
                                  <?php }; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php
                      //echo json_encode($membership->day_schedule);
                    ?>
                    <div class="box-widget-item fl-wrap block_box">
                        <div class="box-widget-item-header">
                            <h3><?= _autoT('week_benefits'); ?></h3>
                        </div>
                        <div class="box-widget opening-hours fl-wrap">
                            <div class="box-widget-content">
                                <ul class="no-list-style">
                                    <?php
                                      foreach ([
                                        [
                                          "label" => "Monday",
                                          "min"   => "mon"
                                        ],
                                        [
                                          "label" => "Tuesday",
                                          "min"   => "thu"
                                        ],
                                        [
                                          "label" => "Wednesday",
                                          "min"   => "wed"
                                        ],
                                        [
                                          "label" => "Thursday",
                                          "min"   => "thu"
                                        ],
                                        [
                                          "label" => "Friday",
                                          "min"   => "fri"
                                        ],
                                        [
                                          "label" => "Saturday",
                                          "min"   => "sat"
                                        ],
                                        [
                                          "label" => "Sunday",
                                          "min"   => "sun"
                                        ],
                                      ] as $dai_i => $dai) {
                                        if (is_array($dai)) $dai = (object) $dai;
                                        ?>
                                        <li class="<?= _autoT($dai->min); ?>">
  																				<span class="opening-hours-day"><?= _autoT($dai->label); ?> </span>
  																				<span class="opening-hours-time">
                                            <?php if(count($membership->day_schedule[$dai->label])>0): ?>
                                              <ul class="no-list-style">
                                                <?php foreach($membership->day_schedule[$dai->label] as $include): ?>
    																						<li class="tolt" data-microtip-position="left" data-tooltip="<?= ($include->type == 'discount' ? _autoT('discount').': ' : _autoT('benefit').': ') . _autoT('benefit_'.$include->id); ?>">
    																							<a href="#">
    																								<i class="<?= (isset($include->feature->icon)) ? $include->feature->icon: ""; ?>"></i>
                                                    <?php
                                                    if($include->limit_cycle == null || !($include->limit_cycle)) { echo _autoT('not_limit_cycle'); }
                                                    else {
                                                      foreach (explode(',', $include->limit_cycle) as $cycle_i => $cycle) {
                                                        echo $include->{'limit_'.strtolower($cycle)} . " x ". _autoT($cycle);
                                                      }
                                                    }
                                                    if($include->quantity !== null && $include->quantity > 0){
                                                      echo " - " . _autoT($include->type == 'discount' ? 'discount' : 'limit_quantity') . ": {$include->quantity} " . ($include->type == 'benefit' ? 'uses' : '%');
                                                    }
                                                    if($include->amount !== null && $include->amount > 0	&& $include->type == 'discount') echo _autoT('discount') . ": $ " . $include->amount;
                                                    ?>
    																							</a>
    																						</li>
                                                <?php endforeach; ?>
    																					</ul>
                                            <?php else: ?>
                                              <p><?= _autoT('membership_no_beneficits_day'); ?></p>
                                            <?php endif; ?>
  																					<!--//
  																						<div class="facilities-list fl-wrap">
  																							<ul class="no-list-style" v-if="days.Monday.length>0">
  																								<li v-for="(include, include_i) in days.Monday" class="tolt" data-microtip-position="left" :data-tooltip="(include.type == 'discount' ? _autoT('discount')+': ' : _autoT('benefit')+': ') + _autoT('benefit_'+include.id)">
  																									<i :class="include.feature.icon"></i>
  																								</li>
  																							</ul>
  																							<p v-else><?= _autoT('membership_no_beneficits_day'); ?></p>
  																						</div>
                                            -->
  																			</span>
  																		</li>
                                        <?php
                                      }
                                    ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="limit-box fl-wrap"></div>
</div>
<?php endif; ?>
