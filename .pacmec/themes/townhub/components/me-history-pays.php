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
<div id="me-pays">
  <div v-if="pays!==null">
  	<v-style type="text/css">
  	</v-style>
  	<div class="dashboard-title fl-wrap">
  		<h3>{{translateField('history_recharges')}}</h3>
  	</div>
  	<div class="profile-edit-container fl-wrap block_box" v-if="pays.length==0">
  		<p>{{translateField('no_history')}}</p>
  	</div>
  	<div v-else>
  		<!-- dashboard-list-box-->
      <div class="dashboard-list-box  fl-wrap pacmec-responsive">
				<table class="pacmec-table pacmec-bordered">
					<thead class="pacmec-light-grey">
							<tr>
								<td>{{translateField('membership')}}</td>
								<td>{{translateField('affiliates_status')}}</td>
								<td>{{translateField('affiliates_amount')}}</td>
								<td>{{translateField('affiliates_startdate')}}</td>
								<td>{{translateField('affiliates_enddate')}}</td>
							</tr>
					</thead>
					<tbody>
						<tr v-for="(pay, pay_i) in pays">

						</tr>
					</tbody>
				</table>
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
      pays: null,
		};
	},
	computed: {
	},
	created(){
		let self = this;

	},
	mounted(){
		let self = this;
    self.loadHistory();
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
    loadHistory(){
			let self = this;
			PACMEC.pagination('pays', {}, (a) => {
				if(a.response){
					self.pays = a.response;
				}
			});
		},
	},
}).$mount('#me-pays');
</script>
