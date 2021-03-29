<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Themes
 * @category   Townhub
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 */
?>
<div id="me-recharges">
  <div v-if="recharges!==null">
  	<v-style type="text/css">
  	</v-style>
  	<div class="dashboard-title fl-wrap">
  		<h3>{{translateField('history_recharges')}}</h3>
  	</div>
  	<div class="profile-edit-container fl-wrap block_box" v-if="recharges.length==0">
  		<p>{{translateField('no_history')}}</p>
  	</div>
  	<div v-else>
  		<!-- dashboard-list-box-->
  		<div class="dashboard-list-box  fl-wrap">
  				<!-- dashboard-list -->
  				<div class="dashboard-list fl-wrap" v-for="(recharge, recharge_i) in recharges">
  						<div class="dashboard-message">
  								<div class="booking-list-contr">
  										<a v-if="recharge.status == 'APPROVED'" class="color-bg tolt" data-microtip-position="left" :data-tooltip="translateField('WCO_APPROVED')"><i class="fal fa-check"></i></a>
  										<a v-else-if="recharge.status == 'CREATED' || recharge.status == 'PENDING'" class="red-bg tolt" data-microtip-position="left" :data-tooltip="translateField('WCO_PENDING')"><i class="fal fa-hourglass"></i></a>
  								</div>
  								<div class="dashboard-message-text">
  										<img src="images/all/1.jpg" alt="">
  										<h4><a href="#">{{recharge.transaction_id}}</a></h4>
  										<div class="geodir-category-location clearfix">
  											<a href="#">
  												${{recharge.amount.toLocaleString()}}
  												<!-- {{translateField('WCO_'+recharge.payment_method_type)}} -->
  											</a>
  											{{translateField('WCO_'+recharge.payment_method_type)}}
  										</div>
  								</div>
  						</div>
  				</div>
  		</div>
  		<!-- dashboard-list-box end-->
  		<!-- //
  		<div class="pagination">
  				<a href="#" class="prevposts-link"><i class="fas fa-caret-left"></i><span>Prev</span></a>
  				<a href="#">1</a>
  				<a href="#" class="current-page">2</a>
  				<a href="#">3</a>
  				<a href="#">...</a>
  				<a href="#">7</a>
  				<a href="#" class="nextposts-link"><span>Next</span><i class="fas fa-caret-right"></i></a>
  		</div>
  		-->
  	</div>
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
			glossary_txt: <?= json_encode($GLOBALS['PACMEC']['glossary_txt'], JSON_PRETTY_PRINT); ?>,
      recharges: null,
		};
	},
	computed: {
	},
	created(){
		let self = this;

	},
	mounted(){
		let self = this;
    self.loadRecharges();
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
    loadRecharges(){
			let self = this;
			PACMEC.pagination('recharges', {}, (a) => {
				if(a.response){
					self.recharges = a.response;
				}
			});
		},
	},
}).$mount('#me-recharges');
</script>
