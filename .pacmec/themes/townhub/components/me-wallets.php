<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Themes
 * @category   Townhub
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 */
$meinfo = meinfo();
$me = $meinfo->user;
$wallets = $meinfo->wallets;
$purses_to_send = $meinfo->purses_to_send;
$membership = $meinfo->membership;

//echo json_encode($_SESSION['membership']);
/*
echo json_encode([
	'status' => 'review',
	'user_id' => $_SESSION['user']['id'],
	'affiliate_id' => \meAffiliationId(),
]);*/
?>
<div id="me-wallets">
	<v-style type="text/css">
		.nav-holder nav li a.act-link, .nav-holder nav li a:hover, .header-search_btn i, .show-reg-form i, .nice-select:before, .main-register_title span strong, .lost_password a, .custom-form.dark-form label span, .filter-tags input:checked:after, .custom-form .filter-tags input:checked:after, .custom-form .filter-tags label a, .section-subtitle, .footer-social li a, .subfooter-nav li a, #footer-twiit .timePosted a:before, #subscribe-button i, .nice-select .nice-select-search-box:before, .nav-holder nav li a i, .show-lang i, .lang-tooltip a:hover, .main-register-holder .tabs-menu li a i, .header-modal_btn i, .custom-form .log-submit-btn:hover i, .main-search-input-item label i, .header-search-input label i, .location a, .footer-contacts li i, #footer-twiit p.tweet:after, .subscribe-header h3 span, .footer-link i, .footer-widget-posts .widget-posts-date i, .clear-wishlist, .widget-posts-descr-link a:hover, .geodir-category-location a i, .header-modal-top span strong, .cart-btn:hover i, .to-top, .map-popup-location-info i, .infowindow_wishlist-btn, .infobox-raiting_wrap span strong, .map-popup-footer .main-link i, .infoBox-close, .mapnavbtn, .mapzoom-in, .mapzoom-out, .location-btn, .list-main-wrap-title h2 span, .grid-opt li span.act-grid-opt, .reset-filters i, .avatar-tooltip strong, .facilities-list li i, .geodir-opt-list a:hover i, .geodir-js-favorite_btn:hover i, .geodir-category_contacts li span i, .geodir-category_contacts li a:hover, .close_gcc:hover, .listsearch-input-wrap-header i, .listsearch-input-item span.iconn-dec, .more-filter-option-btn i, .clear-filter-btn i, .back-to-filters, .price-rage-wrap-title i, .listsearch-input-wrap_contrl li a i, .geodir-opt-tooltip strong, .listing-features li i, .gdop-list-link:hover i, .show-hidden-sb i, .filter-sidebar-header .tabs-menu li a i, .datepicker--day-name, .scroll-nav li a.act-scrlink, .scroll-nav-wrapper-opt a.scroll-nav-wrapper-opt-btn i, .show-more-snopt:hover, .show-more-snopt-tooltip a i, .breadcrumbs a:before, .list-single-stats li span i, .list-single-main-item-title h3 i, .box-widget-item-header i, .opening-hours ul li.todaysDay span.opening-hours-day, .listing-carousel-button, .list-single-main-item-title i, .list-single-main-item-title:before, .box-widget-item-header:before, .list-author-widget-contacts li span i, .btn i, .reviews-comments-item-date i, .rate-review i, .chat-widget_input button, .chat-widget_header h3 a, .custom-form .review-total span input, .photoUpload span i, .bottom-bcw-box_link a:hover, .custom-form label i, .video-box-btn, .claim-widget-link a, .custom-form .quantity span i, .scroll-nav li a.act-scrlink i, .share-holder.hid-share .share-container .share-icon, .sc-btn, .list-single-main-item-title h3 span, .ss-slider-cont, .team-social li a, .team-info h4, .simple-title span, .back-tofilters i, .breadcrumbs.block-breadcrumbs:before, .breadcrumbs.top-breadcrumbs a:before, .top-breadcrumbs .container:before, .header-sec-link a i, .map-modal-container h3 a, .map-modal-close, .post-opt li i, .cat-item li span, .cat-item li a:hover, .brd-show-share i, .author-social li a, .post-nav-text strong, .post-nav:before, .faq-nav li a.act-scrlink i, .faq-nav li a.act-scrlink:before, .faq-nav li a:hover i, .log-massage a, .cart-total strong, .action-button i, .dashboard-header-stats-item span, .dashboard-header-stats-item i, .add_new-dashboard i, .tfp-btn strong, .user-profile-menu li a i, .logout_btn i, .dashboard-message-text p a, .dashboard-message-time i, .pass-input-wrap span, .fuzone .fu-text i, .radio input[type="radio"]:checked + span:before, .booking-list-message-text h4 span, .dashboard-message-text h4 a:hover, .chat-contacts-item .chat-contacts-item-text span, .recomm-price i, .time-line-icon i, .testi-link, .testimonilas-avatar h4, .testimonilas-text:before, .testimonilas-text:after, .cc-btn, .single-facts_2 .inline-facts-wrap .inline-facts i, .images-collage-title, .collage-image-input i, .process-count, .listing-counter span, .main-search-input-tabs .tabs-menu li.current a, .hero-categories li a i, .main-search-input-item span.iconn-dec, .main-search-button i, .shb, .follow-btn i, .user-profile-header_stats li span, .follow-user-list li:hover a span, .dashboard-tabs .tabs-menu li a span, .bold-facts .inline-facts-wrap .num, .page-scroll-nav nav li a i, .mob-nav-content-btn i, .map-close, .post-opt-title a:hover, .post-author a:hover span, .post-opt a:hover, .breadcrumbs a:hover, .reviews-comments-header h4 a:hover, .listing-item-grid_title h3 a:hover, .geodir-category-content h3 a:hover, .footer-contacts li a:hover, .footer-widget-posts .widget-posts-descr a:hover, .footer-link:hover, .geodir-category-opt h4 a:hover, .header-search-button:hover i, .list-author-widget-contacts li a:hover, .list-single-author a:hover, .close_sbfilters, .show-lang:hover i, .show-reg-form:hover, .close-reg:hover, .pac-icon:before, .pi-text h4, .section-subtitle, .close-lpt { content:none; }
		.list-single-header-column:after { content: none; }
		.listing-rating-count-wrap .review-score { float: revert; }
		.btn-add-balance {
			float: right;
			padding: 5px;
			position: relative;
			height: 35px;
			top: -7px;
			line-height: 25px;
			border-radius: 45px;
			color: #fff;
			font-weight: 500;
			font-size: 13px;
			transition: all .2s ease-in-out;
			box-shadow: 0px 0px 1px 4px rgba(238 238 238, 0.7);
			width: 35px;
			right: -5px;
		}
		.btn-add-balance span {
			position: relative !important;
			top: 0px !important;
			left: 0px !important;
			font-size: 15px !important;
			color: #fff !important;
		}
		.listing-rating-count-wrap .review-score { margin-right: 0px; }
		.menu-filters a, .listing-filters a { padding: 5px 15px; }
		.menu-filters, .listing-filters { margin-bottom: 10px; }
		.listing-item-category-wrap { padding: 0 10px; }
		.list-single-header_bottom { zoom:0.85; }
		.restmenu-item { padding: inherit; }
	</v-style>
	<div class="dashboard-title fl-wrap">
		<h3><?= _autoT('wallets'); ?></h3>
	</div>
	<div v-if="wallets!==null">
		<div class="fl-wrap">
			<template v-for="(wallet, wallet_i) in wallets">
				<div :class="'restmenu-item ' + wallet.wallet.status + ' ' + wallet.wallet.type" style="width:100%;">
					<div class="list-single-header list-single-header-inside block_box fl-wrap">
						<div class="list-single-header-item  fl-wrap">
							<div class="row">
								<div class="col-md-7">
									<h1>
										<a style="cursor:pointer;" @click="changeNameWallet(wallet_i)" class="bottom share-text" data-microtip-position="right" data-tooltip="Cambiar Nombre"><span><i class="fas fa-edit"></i></span></a>
										{{ wallet.alias }} <!-- // {{ $root.bracelets_types[wallet.type] }} -->

										<span v-if="wallet.wallet.status == 'locked'" class="verified-badge green-bg tolt" data-microtip-position="left" :data-tooltip="translateField('wallet_locked')"><i class="fal fa-check"></i></span>
										<span v-else-if="wallet.wallet.status == 'active'" class="verified-badge dark-blue-bg tolt" data-microtip-position="left" :data-tooltip="translateField('wallet_active')"><i class="fal fa-check-double"></i></span>
										<span v-else-if="wallet.wallet.status == 'lost'" class="verified-badge orange-bg tolt" data-microtip-position="left" :data-tooltip="translateField('wallet_report')"><i class="fal fa-mask"></i></span>
										<span v-else-if="wallet.wallet.status == 'not_activated'" class="verified-badge orange-bg tolt" data-microtip-position="left" :data-tooltip="translateField('wallet_not_active')"><i class="fal fa-ban"></i></span>
										<span v-else-if="wallet.wallet.status == 'recovered'" class="verified-badge purp-bg tolt" data-microtip-position="left" :data-tooltip="translateField('wallet_recovered')"><i class="fal fa-headset"></i></span>

									</h1>
									<div class="geodir-category-location fl-wrap">
										<a href="#"><i class="fas fa-fingerprint"></i> <?= _autoT('wallet_ID'); ?>: ******{{ wallet.wallet.puid.substr(-4) }} </a>
										<br>
										<a href="#"><i class="fas fa-hand-holding-usd"></i> <?= _autoT('last_expense_date'); ?>: {{ wallet.wallet.modified }}</a>
									</div>
								</div>
								<div class="col-md-5">
									<div class="fl-wrap list-single-header-column  block_box">
										<div class="listing-rating-count-wrap single-list-count">
											<div class="review-score" style="border-radius:100px 100px 100px 100px;">
												$ {{wallet.wallet.balance.toLocaleString()}}

												<a @click="transferWalletToWallet(wallet_i)" style="cursor:pointer;border-radius: 0px 45px 45px 0px;background: slategray;" class="btn-add-balance color-bg tolt" data-microtip-position="top" :data-tooltip="translateField('transfer_other_wallet')">
													<span><i class="fas fa-share"></i></span>
												</a>
												<a style="border-radius: 45px 0px 0px 45px;cursor:pointer;" @click="addBalance(wallet_i)" class="btn-add-balance color-bg tolt" data-microtip-position="top" :data-tooltip="translateField('add_balance')">
													<span><i class="fas fa-donate"></i></span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="list-single-header_bottom fl-wrap">
							<a v-if="wallet.wallet.type == 'card'" class="listing-item-category-wrap" href="#"><div class="listing-item-category  blue-bg"><i class="fas fa-credit-card"></i></div><span> {{ translateField('wallets_type_card') }} </span></a>
							<a v-else-if="wallet.wallet.type == 'keychain'" class="listing-item-category-wrap" href="#"><div class="listing-item-category  blue-bg"><i class="fas fa-weight-hanging"></i></div><span> {{ translateField('wallets_type_keychain') }} </span></a>
							<a v-else-if="wallet.wallet.type == 'bracelet'" class="listing-item-category-wrap" href="#"><div class="listing-item-category  blue-bg"><i class="fas fa-band-aid"></i></div><span> {{ translateField('wallets_type_bracelet') }} </span></a>
							<a v-else-if="wallet.wallet.type == 'adhesive'" class="listing-item-category-wrap" href="#"><div class="listing-item-category  blue-bg"><i class="fas fa-ticket-alt"></i></div><span> {{ translateField('wallets_type_adhesive') }} </span></a>
							<a v-else-if="wallet.wallet.type == 'codebar'" class="listing-item-category-wrap" href="#"><div class="listing-item-category  blue-bg"><i class="fas fa-barcode"></i></div><span> {{ translateField('wallets_type_codebar') }} </span></a>
							<a v-else-if="wallet.wallet.type == 'tag'" class="listing-item-category-wrap" href="#"><div class="listing-item-category  blue-bg"><i class="fas fa-tag"></i></div><span> {{ translateField('wallets_type_tag') }} </span></a>
							<a v-else-if="wallet.wallet.type == 'other'" class="listing-item-category-wrap" href="#"><div class="listing-item-category  blue-bg"><i class="fas fa-microchip"></i></div><span> {{ translateField('wallets_type_other') }} </span></a>


							<div v-if="wallet.wallet.status == 'locked'" class="geodir_status_date gsd_open yellow-bg"><i class="fas fa-lock"></i> {{ translateField('wallets_status_'+wallet.wallet.status) }} </div>
							<div v-else-if="wallet.wallet.status == 'active'" class="geodir_status_date gsd_open red-bg"><i class="fas fa-check-double"></i> {{ translateField('wallets_status_'+wallet.wallet.status) }} </div>
							<div v-else-if="wallet.wallet.status == 'lost'" class="geodir_status_date gsd_open orange-bg"><i class="fas fa-mask"></i> {{ translateField('wallets_status_'+wallet.wallet.status) }} </div>
							<div v-else-if="wallet.wallet.status == 'not_activated'" class="geodir_status_date gsd_open orange-bg"><i class="fas fa-ban"></i> {{ translateField('wallets_status_'+wallet.wallet.status) }} </div>
							<div v-else-if="wallet.wallet.status == 'recovered'" class="geodir_status_date gsd_open purp-bg"><i class="fas fa-headset"></i> {{ translateField('wallets_status_'+wallet.wallet.status) }} </div>

							<div class="list-single-stats">
								<ul class="no-list-style">
									<!-- // <li><span class="viewed-counter"><i class="fas fa-eye"></i> Viewed -  156 </span></li> -->
									<template v-if="wallet.wallet.status == 'locked'"><li @click="activeWallet(wallet_i)" style="cursor:pointer;"><span class="bookmark-counter"><i class="fas fa-lock"></i> {{ translateField('unlock_wallet') }} </span></li></template>
									<template v-else-if="wallet.wallet.status == 'active'">
										<li @click="lostWallet(wallet_i)" style="cursor:pointer;"><span class="bookmark-counter"><i class="fas fa-mask"></i> {{ translateField('lost_wallet') }} </span></li>
										<li @click="lockWallet(wallet_i)" style="cursor:pointer;"><span class="bookmark-counter"><i class="fas fa-lock"></i> {{ translateField('lock_wallet') }} </span></li>
									</template>
									<template v-else-if="wallet.wallet.status == 'lost'"><li @click="activeWallet(wallet_i)" style="cursor:pointer;"><span class="bookmark-counter"><i class="fas fa-times"></i> {{ translateField('cancel_lock_wallet') }} </span></li></template>
									<template v-else-if="wallet.wallet.status == 'not_activated'"><li @click="activeWallet(wallet_i)" style="cursor:pointer;"><span class="bookmark-counter"><i class="fas fa-check-double"></i> {{ translateField('actived_wallet') }} </span></li></template>
									<template v-else-if="wallet.wallet.status == 'recovered'"><li @click="activeWallet(wallet_i)" style="cursor:pointer;"><span class="bookmark-counter"><i class="fas fa-check-double"></i> {{ translateField('actived_wallet') }} </span></li></template>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</template>
		</div>
		<div class="clearfix"></div>
		<div class="restmenu-item" style="width:100%;" v-if="wallets.length==0">
			<div class="list-single-header list-single-header-inside block_box fl-wrap">
				<div class="list-single-header-item  fl-wrap">
					<div class="row">
						<?php if(isMember()): ?>
							<div class="col-md-12" v-if="purses_to_send.length==0">
								<?= _autoT('purses_to_send_text_member_prv'); ?> {{membership.max_members}} <?= _autoT('purses_to_send_text_member_next'); ?>
							</div>
						<?php else: ?>
							<p><?= _autoT('request_wallets_no_is_member'); ?></p>
						<?php endif; ?>
							<div class="col-md-12">
								<?php foreach ($purses_to_send as $peti): ?>
									<div class="dashboard-message">
			            	<div class="dashboard-message-text">
			                <!--//<i class="fal fa-user-times orange-bg"></i>-->
											<p>
												<?= _autoT('purses_to_send_prv_text_view'); ?> <a href="#"><?= $peti->quantity; ?></a> <?= _autoT('purses_to_send_next_text_view'); ?>
											</p>
										</div>
			              <div class="dashboard-message-time"><i class="fal fa-wallet"></i><?= _autoT('purses_to_send_status_'.$peti->status); ?></div>
									</div>
								<?php endforeach; ?>
							</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php if(isMember()): ?>
			<div class="fl-wrap" v-if="wallets.length == 0">
					<a @click="requestPurse" v-if="purses_to_send.length==0" class="btn color2-bg float-btn"><i class="fas fa-wallet"></i> <?= _autoT('request_wallets'); ?> </a>
			</div>
		<?php else: ?>
			<a href="/me/membership" class="btn color2-bg float-btn"><i class="fas fa-fal fa-users-crown"></i> <?= _autoT('choose_membership'); ?> </a>
		<?php endif; ?>

		<!--//<router-link :to="{ name: 'add-wallet' }" class="btn color2-bg float-btn"><i class="fas fa-plus"></i> Añadir Monedero </router-link>-->
	</div>
</div>
<script>
Vue.component('v-style', {
  render: function (createElement) {
    return createElement('style', this.$slots.default)
  }
});

var me_profile_change_pass = new Vue({
	//mixins: [pacmec_global],
	data: function () {
		return {
			me: <?= json_encode($me, JSON_PRETTY_PRINT); ?>,
			wallets: <?= json_encode($wallets, JSON_PRETTY_PRINT); ?>,
			membership: <?= json_encode($membership, JSON_PRETTY_PRINT); ?>,
			purses_to_send: <?= json_encode($purses_to_send, JSON_PRETTY_PRINT); ?>,
			glossary_txt: <?= json_encode($GLOBALS['PACMEC']['glossary_txt'], JSON_PRETTY_PRINT); ?>,
		};
	},
	computed: {
	},
	created(){
		let self = this;

	},
	mounted(){
		let self = this;
		self.$nextTick(function () {
		})
	},
	methods: {
		translateField(label){
			try {
				let self = this;
				if(self.glossary_txt[label]){
					return self.glossary_txt[label];
				} else {
					return `Þ{${label}}`;
				}
			} catch (e) {
				return `Þ{${label}}`;
			}
		},
		initScripts(){
			let self = this;
		},
		addBalance(wallet_index){
			let self = this;
			Swal.queue([
				{
					title: "<?= _autoT('add_balance_title'); ?>",
					text: "<?= _autoT('add_balance_text'); ?>",
					input: 'number',
					inputAttributes: {
						min: 1500,
						autocomplete: 'off',
						autocapitalize: 'off'
					},
					inputValidator: (value) => {
						if (!value || value<1500) {
							return "<?= _autoT('ammount_invalid'); ?>";
						}
					},
					showCancelButton: true,
					cancelButtonText: "<?= _autoT('cancel'); ?>",
					confirmButtonText: "<?= _autoT('add_balance_btn'); ?>",
					showLoaderOnConfirm: true,
					preConfirm: (amount) => {
						console.log('amount', amount);
						let final = null;
						return PACMEC.core.get('/', {params: {
							controller: 'PaymentEvents',
							action: 'WompiCreateRecharge',
							puid: self.wallets[wallet_index].wallet.puid,
							amount: amount,
						}})
						.then((response) => {
							final = response;
						})
						.catch((error) => {
							console.log('error', error);
							final = error.response;
						})
						.finally(()=>{
							console.log('final', final);
							if(final.status == 200 && final.data.error == false){
								let options = {
								  currency: 'COP',
								  amountInCents: (amount*100),
								  reference: final.data.message,
								  publicKey: WCO.pub,
								  redirectUrl: location.href // Opcional
								};
								console.log('options', options)
								let checkout = new WidgetCheckout(options);
								console.log('checkout', checkout);

								checkout.open(function ( result ) {
									console.log('result', result);
									if(result.transaction){
										var transaction = result.transaction;
										console.log('Transaction ID: ', transaction.id);
										console.log('Transaction object: ', transaction);
										let timerInterval;
										Swal.fire({
											icon: 'success',
											title: "<?= _autoT('add_balance_success_title'); ?>",
											text: "<?= _autoT('transaction_id'); ?>" + ': ' + transaction.id + ' ' + "<?= _autoT('transaction_status'); ?>" + ': ' + transaction.status + ' - ' + "<?= _autoT('loading_wait'); ?>",
										  timer: 10000,
										  timerProgressBar: true,
										  didOpen: () => {
										    Swal.showLoading()
										  },
										  willClose: () => {
										    clearInterval(timerInterval)
												location.reload();
										  }
										}).then((result) => {
										  /* Read more about handling dismissals below */
										  if (result.dismiss === Swal.DismissReason.timer) {
										    console.log('I was closed by the timer')
												//location.reload();
										  }
										})
									} else {
										Swal.insertQueueStep({
											icon: 'error',
											title: "<?= _autoT('add_balance_error'); ?>"
										})
									}
								});
							} else {
								console.log('ups', final.data);
								Swal.insertQueueStep({
									icon: 'error',
									title: "<?= _autoT('add_balance_error'); ?>"
								})
							}
							//location.reload();
						});
					},
					allowOutsideClick: () => !Swal.isLoading()
				}
			]);
		},
		changeNameWallet(index){
			let self = this;
			Swal.queue([
				{
					title: "<?= _autoT('change_alias_wallet'); ?>",
					text: "<?= _autoT('new_alias'); ?>",
					input: 'text',
					inputAttributes: {
						autocomplete: 'off',
						autocapitalize: 'off'
					},
					showCancelButton: true,
					cancelButtonText: "<?= _autoT('cancel'); ?>",
					confirmButtonText: "<?= _autoT('save_changes'); ?>",
					showLoaderOnConfirm: true,
					preConfirm: (new_alias) => {
						console.log('new_alias', new_alias);
						return PACMEC.modified('purses', self.wallets[index].id, {
							alias: new_alias
						}, (z) => {
							try {
								if(z.status == 200 && z.error== false && z.response>0){
									location.reload();
									Swal.fire({
										icon: 'success',
										title: "<?= _autoT('success_save_title'); ?>",
										text: "<?= _autoT('success_save'); ?>",
										//footer: '<a href>Why do I have this issue?</a>'
									});
									return true;
								} else {
									throw new Error('error_save');
									return false;
								}
							} catch (error) {
								console.log('error', error);
								console.error(error);
								Swal.fire({
									icon: 'error',
									title: "<?= _autoT('error_save_title'); ?>",
									//text: error.message,
									footer: '<a href="/faq">'+"<?= _autoT('why_this_issue_question'); ?>"+'</a>'
								})
							}
						});
					},
					allowOutsideClick: () => !Swal.isLoading()
				}
			]);
		},
		transferWalletToWallet(wallet_index){
			let self = this;
			console.log('transferWalletToWallet', wallet_index);
			let input_opts = {};
			self.wallets.forEach(function(wallet){
				if(wallet.wallet.puid!==self.wallets[wallet_index].wallet.puid) input_opts[wallet.wallet.puid] = wallet.alias + " (******" + wallet.wallet.puid.substr(-4) + ")";
			})
			const inputOptions = new Promise((resolve) => { setTimeout(() => { resolve(input_opts) }, 1000) })

			Swal.queue([{
				title: "<?= _autoT('send_balance_title'); ?>",
				text: "<?= _autoT('enter_pin'); ?>",
				input: 'password',
				inputAttributes: {
					autocomplete: 'off',
					autocapitalize: 'off',
				},
				inputPlaceholder: "<?= _autoT('enter_pin'); ?>",
				showCancelButton: true,
				cancelButtonText: "<?= _autoT('cancel'); ?>",
				confirmButtonText: "<?= _autoT('confirm'); ?>",
				showLoaderOnConfirm: true,
				allowOutsideClick: () => !Swal.isLoading(),
				preConfirm: (pin) => {
					console.log('wallet pin', pin);
					if(pin && pin.length >= 4){
						Swal.insertQueueStep({
							title: "<?= _autoT('send_balance_title'); ?>",
							text: "<?= _autoT('select_wallet_to'); ?>",
							input: 'select',
							inputOptions: inputOptions,
							inputPlaceholder: "<?= _autoT('select_option'); ?>",
							inputValidator: (value)=>{
								return new Promise((resolve)=>{
									if(value===self.wallets[wallet_index].wallet.puid){
										resolve("<?= _autoT('identical_origin_and_destination'); ?>");
									} else if(!value){
										resolve("<?= _autoT('selected_wallet'); ?>");
									} else {
										resolve();
									}
								})
							},
							showCancelButton: true,
							cancelButtonText: "<?= _autoT('cancel'); ?>",
							confirmButtonText: "<?= _autoT('confirm'); ?>",
							showLoaderOnConfirm: true,
							allowOutsideClick: () => !Swal.isLoading(),
							preConfirm: (wallet_to) => {
								console.log('wallet_to', wallet_to);
								return Swal.insertQueueStep({
									title: "<?= _autoT('send_balance_quantity_title'); ?>",
									input: 'range',
									inputAttributes: {
										min: 1,
										max: self.wallets[wallet_index].wallet.balance-1,
									},
									inputValue: 0,
									showCancelButton: true,
									cancelButtonText: "<?= _autoT('cancel'); ?>",
									confirmButtonText: "<?= _autoT('send_amount'); ?>",
									showLoaderOnConfirm: true,
									preConfirm: (amount) => {
										console.log('amount', amount);
										let sending = {
											controller: 'Wallet',
											action: 'exchangeMw2Mw',
											puid: self.wallets[wallet_index].wallet.puid,
											pin: pin,
											amount: amount,
											to: wallet_to
										};
										return PACMEC.core.get('/', {
											params: sending
										})
										.then((response) => response.data)
										.then(data => {
											location.reload();
											return Swal.insertQueueStep(data.message);
										})
										.catch((error) => {
											console.log('error', error);
											Swal.insertQueueStep({
												icon: 'error',
												title: "<?= _autoT('error_exchanging'); ?>"
											})
										})
										.finally(()=>{
											// location.reload();
										});
									}
								});
							}
						})
					} else {
						Swal.insertQueueStep({
							icon: 'error',
							title: "<?= _autoT('error_pin'); ?>"
						})
					}
				}
			}]);

		},
		lockWallet(wallet_index){
			let self = this;
			console.log('lockWallet', wallet_index);

			Swal.queue([{
				title: "<?= _autoT('locked_wallet_title'); ?>",
				text: "<?= _autoT('enter_pin'); ?>",
				input: 'password',
				inputAttributes: {
					autocomplete: 'off',
					autocapitalize: 'off'
				},
				inputPlaceholder: "<?= _autoT('enter_pin'); ?>",
				showCancelButton: true,
				cancelButtonText: "<?= _autoT('cancel'); ?>",
				confirmButtonText: "<?= _autoT('confirm'); ?>",
				showLoaderOnConfirm: true,
				allowOutsideClick: () => !Swal.isLoading(),
				preConfirm: (pin) => {
					console.log('wallet pin', pin);
					if(pin && pin.length >= 4){
						 return PACMEC.core.get('/', {
							params: {
								controller: 'Wallet',
								action: 'changeStatus',
								status: 'locked',
								puid: self.wallets[wallet_index].wallet.puid,
								pin: pin
							}
						})
						.then((response) => {
							let data = response.data;
							console.log('data', data);
							return Swal.insertQueueStep({
								icon: data.error == false ? 'success' : 'error',
								title: data.message
							});
						})
						.catch((error) => {
							console.log('error', error);
							Swal.showValidationMessage("<?= _autoT('error_locked'); ?>");
						})
						.finally(()=>{
							location.reload();
						});
					} else {
						Swal.insertQueueStep({
							icon: 'error',
							title: "<?= _autoT('error_pin'); ?>"
						})
					}
				}
			}]);
		},
		activeWallet(wallet_index){
			let self = this;
			console.log('activeWallet', wallet_index);

			Swal.queue([{
				title: "<?= _autoT('actived_wallet_title'); ?>",
				text: "<?= _autoT('enter_pin'); ?>",
				input: 'password',
				inputAttributes: {
					autocomplete: 'off',
					autocapitalize: 'off'
				},
				inputPlaceholder: "<?= _autoT('enter_pin'); ?>",
				showCancelButton: true,
				cancelButtonText: "<?= _autoT('cancel'); ?>",
				confirmButtonText: "<?= _autoT('confirm'); ?>",
				showLoaderOnConfirm: true,
				allowOutsideClick: () => !Swal.isLoading(),
				preConfirm: (pin) => {
					console.log('wallet pin', pin);
					if(pin && pin.length >= 4){
						 return PACMEC.core.get('/', {
							params: {
								controller: 'Wallet',
								action: 'changeStatus',
								status: 'actived',
								puid: self.wallets[wallet_index].wallet.puid,
								pin: pin
							}
						})
						.then((response) => {
							let data = response.data;
							console.log('data', data);
							return Swal.insertQueueStep({
								icon: data.error == false ? 'success' : 'error',
								title: data.message
							});
						})
						.catch((error) => {
							console.log('error', error);
							Swal.showValidationMessage("<?= _autoT('error_actived'); ?>");
						})
						.finally(()=>{
							location.reload();
						});
					} else {
						Swal.insertQueueStep({
							icon: 'error',
							title: "<?= _autoT('error_pin'); ?>"
						})
					}
				}
			}]);
		},
		lostWallet(wallet_index){
			let self = this;
			console.log('lostWallet', wallet_index);

			Swal.queue([{
				title: "<?= _autoT('losted_wallet_title'); ?>",
				text: "<?= _autoT('enter_pin'); ?>",
				input: 'password',
				inputAttributes: {
					autocomplete: 'off',
					autocapitalize: 'off'
				},
				inputPlaceholder: "<?= _autoT('enter_pin'); ?>",
				showCancelButton: true,
				cancelButtonText: "<?= _autoT('cancel'); ?>",
				confirmButtonText: "<?= _autoT('confirm'); ?>",
				showLoaderOnConfirm: true,
				allowOutsideClick: () => !Swal.isLoading(),
				preConfirm: (pin) => {
					console.log('wallet pin', pin);
					if(pin && pin.length >= 4){
						 return PACMEC.core.get('/', {
							params: {
								controller: 'Wallet',
								action: 'changeStatus',
								status: 'losted',
								puid: self.wallets[wallet_index].wallet.puid,
								pin: pin
							}
						})
						.then((response) => {
							let data = response.data;
							console.log('data', data);
							return Swal.insertQueueStep({
								icon: data.error == false ? 'success' : 'error',
								title: data.message
							});
						})
						.catch((error) => {
							console.log('error', error);
							Swal.showValidationMessage("<?= _autoT('error_losted'); ?>");
						})
						.finally(()=>{
							location.reload();
						});
					} else {
						Swal.insertQueueStep({
							icon: 'error',
							title: "<?= _autoT('error_pin'); ?>"
						})
					}
				}
			}]);
		},
		requestPurse(){
			let self = this;
			console.log('requestPurse');
			Swal.queue([{
				title: "<?= _autoT('request_purse_title'); ?>",
				text: "<?= _autoT('request_purse_text'); ?>",
				input: 'number',
				inputValue: self.membership.max_members,
				inputAttributes: {
					min: self.membership.max_members,
					step: 1,
				},
				inputPlaceholder: "<?= _autoT('enter_quantity'); ?>",
				showCancelButton: true,
				cancelButtonText: "<?= _autoT('cancel'); ?>",
				confirmButtonText: "<?= _autoT('confirm'); ?>",
				showLoaderOnConfirm: true,
				allowOutsideClick: () => !Swal.isLoading(),
				preConfirm: (quantity) => {
					if(quantity && quantity >= self.membership.max_members){
						 return PACMEC.create('purses_to_send', {
							 quantity: quantity,
							 user_id: <?= $_SESSION['user']['id']; ?>,
							 affiliate_id: <?= $_SESSION['membership']->id; ?>
						 }, (resultado) => {
							 console.log('resultado', resultado);

							 if(resultado.error == false){
								 return Swal.fire({
								  icon: 'success',
								  title: "<?= _autoT('purses_to_send_success'); ?>",
									preConfirm: (quantity) => {
										location.reload();
									}
								})
							 } else {
								 if(!(resultado.data.message)){
									 return Swal.fire({
			 							icon: 'error',
			 							title: "<?= _autoT('purses_to_send_fail'); ?>"
			 						})
								} else {
									return Swal.fire({
									 icon: 'error',
									 title: resultado.data.message
								 })
								}
							 }
						 })

						 /*PACMEC.core.get('/', {
							params: {
								controller: 'Wallet',
								action: 'changeStatus',
								status: 'losted',
								puid: self.wallets[wallet_index].wallet.puid,
								pin: pin
							}
						})
						.then((response) => {
							let data = response.data;
							console.log('data', data);
							return Swal.insertQueueStep({
								icon: data.error == false ? 'success' : 'error',
								title: data.message
							});
						})
						.catch((error) => {
							console.log('error', error);
							Swal.showValidationMessage("<?= _autoT('error_losted'); ?>");
						})
						.finally(()=>{
							location.reload();
						});*/
					} else {
						return Swal.insertQueueStep({
							icon: 'error',
							title: "<?= _autoT('error_quantity'); ?>"
						})
					}
				}
			}]);
		},
	},
}).$mount('#me-wallets');
</script>
