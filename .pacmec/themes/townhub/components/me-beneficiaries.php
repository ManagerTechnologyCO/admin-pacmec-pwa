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
$beneficiaries = $meinfo->beneficiaries;
?>
<div id="me-beneficiaries">
	<v-style type="text/css">
		.booking-list-message-text {
			margin-left: 20px;
			padding-left: 0px;
		}
		.list-single-header-column:after {
			content: "\f102b4"
		}
	</v-style>
	<div class="dashboard-title fl-wrap">
		<h3><?= _autoT('beneficiaries'); ?></h3>
	</div>
	<div class="profile-edit-container fl-wrap block_box" v-if="membership==null || !(membership.id)">
		<p><?= _autoT('membership_expired'); ?></p>
	</div>
	<div v-else>
		<!--//
			<p>
				Puedes tener {{membership.max_members}}} beneficiarios,
				actualmente tienes ({{beneficiaries.length}}) Beneficiarios,
				puedes agregar ({{membership.max_members - beneficiaries.length}}) beneficiarios.
			</p>
		-->
		<div class="fl-wrap">
 			<div v-if="beneficiaries.length==0">
 					<?= _autoT('without_beneficiaries'); ?>
 			</div>
			<template v-else v-for="(beneficiary, beneficiary_i) in beneficiaries"> <!---->
				<div class="" style="width:100%;" v-if="(beneficiary_i+1)<=membership.max_members">
					<div class="list-single-header list-single-header-inside block_box fl-wrap">
						<div class="list-single-header-item  fl-wrap">
							<div class="row">
								<div class="col-md-9">
									<h1>
										{{ beneficiary.names }} {{ beneficiary.surname }}
										({{ beneficiary.birthday }})
										<span v-if="beneficiary.status == 'authorized'" class="verified-badge green-bg tolt" data-microtip-position="left" data-tooltip="<?= _autoT('beneficiaries_status_authorized'); ?>"><i class="fal fa-check"></i></span>
										<span v-else-if="beneficiary.status == 'not_authorized'" class="verified-badge red-bg tolt" data-microtip-position="left" data-tooltip="<?= _autoT('beneficiaries_status_not_authorized'); ?>"><i class="fal fa-times"></i></span>
										<span v-else-if="beneficiary.status == 'in_review'" class="verified-badge red-bg tolt" data-microtip-position="left" data-tooltip="<?= _autoT('beneficiaries_status_in_review'); ?>"><i class="fal fa-times"></i></span>
									</h1>
									<div class="geodir-category-location fl-wrap">
										<a href="#"><i class="fas fa-mobile-alt"></i> <?= _autoT('beneficiaries_mobile'); ?>: {{ beneficiary.mobile }}  </a><br>
										<a href="#"><i class="fas fa-location"></i> <?= _autoT('beneficiaries_address'); ?>: {{ beneficiary.address }}  </a><br>
										<a href="#"><i class="fas fa-globe-americas"></i> <?= _autoT('beneficiaries_country'); ?>: {{ beneficiary.country }}  </a><br>
										<a href="#"><i class="fas fa-at"></i> <?= _autoT('beneficiaries_email'); ?>: {{ beneficiary.email }}  </a><br>
										<a href="#"><i class="fas fa-id-card-alt"></i> <?= _autoT('beneficiaries_emergency_contact'); ?>: {{ beneficiary.emergency_contact }}  </a><br>
										<a href="#"><i class="fas fa-phone-rotary"></i> <?= _autoT('beneficiaries_emergency_phone'); ?>: {{ beneficiary.emergency_phone }}  </a><br>
									</div>
								</div>
								<div class="col-md-3">
									<div class="fl-wrap list-single-header-column  block_box">
										<div class="listing-rating-count-wrap single-list-count">
											<div class="review-score" style="border-radius:100px 100px 100px 100px;width:100%;">
												{{ beneficiary.identification_number }}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="list-single-header_bottom fl-wrap">
							<a class="listing-item-category-wrap tolt" data-microtip-position="top" data-tooltip="<?= _autoT('beneficiaries_blood'); ?>" href="#">
								<div class="listing-item-category  blue-bg">
									<i class="fas fa-tint"></i>
								</div>
								<span> {{ beneficiary.blood_type }} {{ beneficiary.blood_rh }} </span>
							</a>
						</div>
					</div>
				</div>
			</template>
		</div>
	</div>
</div>

<script>
Vue.component('v-style', {
  render: function (createElement) {
    return createElement('style', this.$slots.default)
  }
});

var me_beneficiaries = new Vue({
	data(){
		return {
			me: <?= json_encode($me, JSON_PRETTY_PRINT); ?>,
			wallets: <?= json_encode($wallets, JSON_PRETTY_PRINT); ?>,
			beneficiaries: <?= json_encode($beneficiaries, JSON_PRETTY_PRINT); ?>,
			membership: <?= json_encode($membership, JSON_PRETTY_PRINT); ?>,
		};
	},
	mounted(){
		let self = this;
		self.$nextTick(function () {
		})
	},
	methods: {
		translateField(label){
			let self = this;
			return `Þ{${label}}`;
		},
		initScripts(){
			let self = this;
		},
	},
	computed: {
	},
	created(){
		let self = this;

	},
}).$mount('#me-beneficiaries');
</script>
