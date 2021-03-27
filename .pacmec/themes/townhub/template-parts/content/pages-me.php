<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Themes
 * @category   Townhub
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 */
if(isGuest()) echo "<meta http-equiv=\"refresh\" content=\"0;URL='".infosite("homeurl")."'\" /> ";
$membership = meMembership();
$meinfo = meinfo();
?>
<div>
	<div class="content" v-if="me!==null">
		<section class="parallax-section dashboard-header-sec gradient-bg" data-scrollax-parent="true">
			<div class="container">
				<div class="tfp-btn">
					<span><?= _autoT('membership'); ?>: </span>
          <?php if (isset($membership)): ?>
            <strong><?= (isMember()? _autoT('membership_' . $membership->membership->id):'membership_expired'); ?></strong>
          <?php endif; ?>
				</div>
				<div class="tfp-det">
					<!--//<p>You Are on <a href="#">Extended</a> . Use link bellow to view details or upgrade. </p>-->
          <?php if (isMember()): ?>
            <p><?= _autoT($membership!==null ? _autoT('membership_' . $membership->membership->id . '_description') : 'membership_expired'); ?></p>
          <?php endif; ?>
          <?php if (isset($membership->id)&&$membership->id>0): ?>
            <a href="/me/membership" class="tfp-det-btn color2-bg"><?= _autoT('view_membership'); ?></a>
          <?php endif; ?>
				</div>
				<div class="dashboard-header_conatiner fl-wrap dashboard-header_title">
					<h1><?= me("username"); ?>: <span><?= me("display_name"); ?></span></h1>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="dashboard-header fl-wrap">
				<div class="container">
					<div class="dashboard-header_conatiner fl-wrap">
						<div class="dashboard-header-stats-wrap">
							<div class="dashboard-header-stats">
								<div class="swiper-container">
									<div class="swiper-wrapper">
										<?php if (isMember()): ?>
											<div class="swiper-slide">
												<div class="dashboard-header-stats-item">
													<i class="fal fa-map-marked"></i>
													<?= _autoT('wallets'); ?>
													<span> <?= count($meinfo->wallets); ?> </span>
												</div>
											</div>
										<?php endif; ?>
										<!--//
										<div class="swiper-slide">
											<div class="dashboard-header-stats-item">
												<i class="fal fa-map-marked"></i>
												<?= _autoT('notifications'); ?>
												<span>{{notifications.length}}</span>
											</div>
										</div>
										-->
										<div class="swiper-slide">
											<div class="dashboard-header-stats-item">
												<i class="fal fa-map-marked"></i>
												<?= _autoT('wallets_balance'); ?>
												<span>$<?= ($meinfo->balance_total); ?></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="dhs-controls">
								<div class="dhs dhs-prev"><i class="fal fa-angle-left"></i></div>
								<div class="dhs dhs-next"><i class="fal fa-angle-right"></i></div>
							</div>
						</div>
						<a href="/me/wallets" class="add_new-dashboard"><?= _autoT('add_balance'); ?> <i class="fal fa-layer-plus"></i></a>
					</div>
				</div>
			</div>
			<div class="gradient-bg-figure" style="right:-30px;top:10px;"></div>
			<div class="gradient-bg-figure" style="left:-20px;bottom:30px;"></div>
			<div class="circle-wrap" style="left:120px;bottom:120px;" data-scrollax="properties: { translateY: '-200px' }">
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
		<section class="gray-bg main-dashboard-sec" id="sec1">
			<div class="container">
				<div class="col-md-3">
					<div class="mob-nav-content-btn color2-bg init-dsmen fl-wrap"><i class="fal fa-bars"></i> <?= _autoT('me_menu'); ?></div>
					<div class="clearfix"></div>
					<div class="fixed-bar fl-wrap" id="dash_menu">
						<div class="user-profile-menu-wrap fl-wrap block_box">
							<div class="user-profile-menu">
							<?php if($meinfo->payment == null): ?>
								<ul class="no-list-style" v-if="payment == null">
									<li>
										<a href="/me/add/payment">
											<i class="fas fa-credit-card-front"></i>
											<?= _autoT('payment_auto'); ?>
											<span style="width: auto;border-radius: 5px;"><?= _autoT('important'); ?> </span>
										</a>
									</li>
								</ul>
								<?php endif; ?>
                <?= do_shortcode('[pacmec-ul-no-list-style class="no-list-style" menu_slug="me_profile_memberships"][/pacmec-ul-no-list-style]'); ?>
                <?= do_shortcode('[pacmec-ul-no-list-style class="no-list-style" menu_slug="me_profile"][/pacmec-ul-no-list-style]'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-9">
          <?php
					//echo json_encode($_SESSION, JSON_PRETTY_PRINT);
					?>
					<?php the_content(); ?>
				</div>
			</div>
		</section>
		<div class="limit-box fl-wrap"></div>
	</div>
</div>
