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
$meinfo = meinfo();
$me_payment = $meinfo->payment;
$payments = $meinfo->payments;
$r_message = null;
?>
<div id="app-pay-method">
	<div class="dashboard-title dt-inbox fl-wrap">
			<h3>{{translateField('me_payment')}}</h3>
	</div>
	<div class="dashboard-list-box  fl-wrap">
			<div class="dashboard-list fl-wrap" v-if="payment!==null">
					<div class="dashboard-message">
							<!--//<span style="cursor:pointer;" @click="cancelToken(payment.id)" class="new-dashboard-item"><i class="fal fa-times"></i></span>-->
							<div class="dashboard-message-text">
									<i v-if="payment.source_status == 'AVAILABLE' && (payment.token_status == 'APPROVED' || payment.token_status == 'CREATED')" class="fal fa-check green-bg"></i>
									<i v-else-if="payment.source_status == 'AVAILABLE' && (payment.token_status == 'PENDING' || payment.source_status == 'PENDING')" class="fal fa-hourglass-half yellow-bg"></i>
									<i v-else-if="payment.token_status == 'DECLINED'" class="fal fa-times orange-bg"></i>
									<i v-else class="fal fa-exclamation orange-bg"></i>
									<p>
										{{translateField('WCO_'+payment.type)}}
										<!-- //  {{translateField('WCO_'+payment.token_status)}} -->
										<!--//
										 <a href="#">Park Central</a> has been approved!
									 -->
									 </p>
							</div>
							<div class="dashboard-message-time"><i class="fal fa-calendar-week"></i> {{translateField('WCO_'+payment.source_status)}}</div>
					</div>
			</div>
			<template v-else>
        <div class="row">
          <div class="col-md-12">
            <div class="dashboard-list fl-wrap">
                <div class="dashboard-message">
                    <!--// <span class="new-dashboard-item"><i class="fas fa-times"></i></span> -->
                    <div class="dashboard-message-text">
                        <p><?= _autoT('me_payment_text'); ?></p>
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="dashboard-list fl-wrap">
              <div class="ab_text">
                <div class="ab_text-title fl-wrap">
                    <h3 v-if="form_create.type!==''">{{translateField('WCO_'+form_create.type)}}</h3>
                    <span class="section-separator fl-sec-sep"></span>
                </div>
                <div>
                    <div id="message"></div>
                    <form  v-if="form_create.type=='CARD'" class="custom-form" action="javascript:return;" name="contactform" v-on:submit="createTokenC">
                      <fieldset v-if="merchants!==null">
                        <div class="row">
                          <div class="col-md-12">
                            <label class="vis-label">{{translateField('holder_name')}}<i class="far fa-user"></i></label>
                            <input type="text" placeholder="" value="" v-model="form_create.holder_name" required="" />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <label class="vis-label">{{translateField('holder_email')}}<i class="far fa-at"></i></label>
                            <input type="email" placeholder="" value="" v-model="form_create.holder_email" required="" />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <label class="vis-label">{{translateField('card_number')}} <i class="fal fa-credit-card-front"></i></label>
                            <input type="text" placeholder="xxxx-xxxx-xxxx-xxxx" value="" v-model="tokens.CARD.number" required="" />
                          </div>
                          <div class="col-md-3">
                            <label class="vis-label">{{translateField('card_exp_month')}}<i class="fal fa-calendar"></i></label>
                            <input type="text" placeholder="MM" value="" v-model="tokens.CARD.exp_month" required="" />
                          </div>
                          <div class="col-md-3">
                            <label class="vis-label">{{translateField('card_exp_year')}}<i class="fal fa-calendar"></i></label>
                            <input type="text" placeholder="YY" value="" v-model="tokens.CARD.exp_year" required="" />
                          </div>
                          <div class="col-md-2">
                            <label class="vis-label">{{translateField('card_cvc')}}<i class="fal fa-credit-card"></i></label>
                            <input type="password" placeholder="***" value="" v-model="tokens.CARD.cvc" required="" />
                              <p style="padding-top:20px;">{{translateField('card_cvc_extra')}}</p>
                          </div>
                        </div>


                        <div class="filter-tags">
                          <input id="check-a" type="checkbox" name="check" required="" />
                          <label for="check-a">
                            {{ translateField('WCO_terms_and_conditions_prv_text') }} <a :href="merchants.presigned_acceptance.permalink" target="_blank">{{ translateField('WCO_terms_and_conditions_link_text') }}</a>.
                          </label>
                        </div>
                      </fieldset>

                      <button @click="form_create.type=''" class="btn float-btn color-bg" type="button">{{translateField('cancel')}}<i class="fal fa-paper-plane"></i></button>
                      <button class="btn float-btn color2-bg" type="submit">{{translateField('acceptance_and_continue')}}<i class="fal fa-paper-plane"></i></button>
                  </form>
                  <form v-else-if="form_create.type=='NEQUI'" class="custom-form" action="javascript:return;" name="contactform" v-on:submit="createTokenN">
                      <fieldset v-if="merchants!==null">
                        <div class="row">
                          <div class="col-sm-12">
                            <label class="vis-label">{{translateField('holder_name')}}<i class="far fa-user"></i></label>
                            <input type="text" placeholder="" value="" v-model="form_create.holder_name" required="" />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <label class="vis-label">{{translateField('holder_email')}}<i class="far fa-at"></i></label>
                            <input type="email" placeholder="" value="" v-model="form_create.holder_email" required="" />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <label class="vis-label">{{translateField('phone_number')}} <i class="fal fa-phone"></i></label>
                            <input type="text" placeholder="3XX-xxxx-xxx" value="" v-model="tokens.NEQUI.phone_number" required="" />
                          </div>
                        </div>

                        <div class="filter-tags">
                          <input id="check-a" type="checkbox" name="check" required="" />
                          <label for="check-a">
                            {{ translateField('WCO_terms_and_conditions_prv_text') }} <a :href="merchants.presigned_acceptance.permalink" target="_blank">{{ translateField('WCO_terms_and_conditions_link_text') }}</a>.
                          </label>
                        </div>
                      </fieldset>

                      <button @click="form_create.type=''" class="btn float-btn color-bg" type="button">{{translateField('cancel')}}<i class="fal fa-paper-plane"></i></button>
                      <button class="btn float-btn color2-bg" type="submit">{{translateField('acceptance_and_continue')}}<i class="fal fa-paper-plane"></i></button>
                  </form>
                  <div v-else class="success-table-container">
                    <div class="col-md-5">
                        <div class="profile-edit-container">
                            <div class="custom-form">
                                <div class="add-list-media-header" style="margin-bottom:20px">
                                    <label class="radio inline">
                                    <input type="radio" name="pay_method" value="NEQUI" v-model="form_create.type" />
                                    <span>{{translateField('WCO_NEQUI')}}</span>
                                    </label>
                                </div>
                                <div class="add-list-media-header" style="margin-bottom:20px">
                                    <label class="radio inline">
                                    <input type="radio" name="pay_method" value="CARD" v-model="form_create.type" />
                                    <span>{{translateField('WCO_CARD')}}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                      <div class="success-table-header fl-wrap">
                        <i class="fal fa-hand-pointer decsth"></i>
                        <h4>{{translateField('WCO_method_no_selected')}}</h4>
                        <div class="clearfix"></div>
                        <p>{{translateField('WCO_method_no_selected_text')}}</p>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
		</template>

		<p>
			<strong><?= _autoT('important')?>: </strong> <?= _autoT('me_payme_more_info')?>
		</p>
	</div>
</div>



<script type="text/javascript">
var pacmec_global = {
  data: {
    definition: null,
    glossary: null,
    lang: '<?= $GLOBALS['PACMEC']['lang']; ?>',
    list_menus: null,
    userStatus: null,
		payment: <?= json_encode($me_payment, JSON_PRETTY_PRINT); ?>,
		me: <?= json_encode($me, JSON_PRETTY_PRINT); ?>,
		wallets: <?= json_encode($wallets, JSON_PRETTY_PRINT); ?>,
		glossary_txt: <?= json_encode($GLOBALS['PACMEC']['glossary_txt'], JSON_PRETTY_PRINT); ?>,
  },
  methods: {
    _autoT(field_slug){
      return this.$root.translateField(field_slug);
    }
  }
};

const APP_PAY = new Vue({
	mixins: [pacmec_global],
	data: function () {
		return {
			merchants: null,
			tokens: {
				CARD: {
				  number: "", 			// Número de tarjeta (como un string, sin espacios)
				  exp_month: "", 		// Mes de expiración (como string de 2 dígitos)
				  exp_year: "", 		// Año de expiración (como string de 2 dígitos)
				  cvc: "", 				// Código de seguridad (como string de 3 o 4 dígitos)
				  card_holder: '' 		// Nombre del tarjeta habiente (string de mínimo 5 caracteres)
				},
				NEQUI: {
					phone_number: ""
				}
			},
			form_create: {
				type: '',
				token: "",
				holder_email: '',
				holder_name: '',
				acceptance_token: "",
				data: {}
			},
		};
	},
	computed: {
	},
	created(){
		let self = this;
	},
	mounted(){
		let self = this;
    self.paymentWCO();
		self.$nextTick(function () {
		})
	},
	methods: {
		initScripts(){
			let self = this;
			// booking -----------------
			var current_fs, next_fs, previous_fs;
			var left, opacity, scale;
			var animating;
			$(".next-form").on("click", function (e) {
				e.preventDefault();
				if (animating) return false;
				animating = true;
				current_fs = $(this).parent();
				next_fs = $(this).parent().next();
				$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
				next_fs.show();
				current_fs.animate({
					opacity: 0
				}, {
					step: function (now, mx) {
						scale = 1 - (1 - now) * 0.2;
						left = (now * 50) + "%";
						opacity = 1 - now;
						current_fs.css({
							'transform': 'scale(' + scale + ')',
							'position': 'absolute'
						});
						next_fs.css({
							'left': left,
							'opacity': opacity,
							'position': 'relative'
						});
					},
					duration: 1200,
					complete: function () {
						current_fs.hide();
						animating = false;
					},
					easing: 'easeInOutBack'
				});
			});
			$(".back-form").on("click", function (e) {
				e.preventDefault();
				if (animating) return false;
				animating = true;
				current_fs = $(this).parent();
				previous_fs = $(this).parent().prev();
				$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
				previous_fs.show();
				current_fs.animate({
					opacity: 0
				}, {
					step: function (now, mx) {
						scale = 0.8 + (1 - now) * 0.2;
						left = ((1 - now) * 50) + "%";
						opacity = 1 - now;
						current_fs.css({
							'left': left,
							'position': 'absolute'
						});
						previous_fs.css({
							'transform': 'scale(' + scale + ')',
							'opacity': opacity,
							'position': 'relative'
						});
					},
					duration: 1200,
					complete: function () {
						current_fs.hide();
						animating = false;
					},
					easing: 'easeInOutBack'
				});
			});
		},
		paymentWCO(){
			let self = this;
			console.log('paymentWCO');
			PACMEC.Wompi.get('/merchants/' + WCO.pub, {})
			.then((merchants) => {
				let data = merchants.data.data;
				console.log('merchants', merchants);
				console.log('data', data);
				if(data.id && data.id > 0){
					self.merchants = data;
					self.form_create.acceptance_token = data.presigned_acceptance.acceptance_token;
				}
			})
			.catch((error) => {
				console.log('error', error);
				console.error(error);
				Swal.fire({
					icon: 'error',
					title: self.$root.translateField('error_create_payment')
				})
			})
			.finally(() => {
			});
		},
		// NUEVO
		createTokenN(){
			let self = this;
			console.log('createTokenN');
			self.form_create.data = self.tokens.NEQUI;
			let final = null;
			PACMEC.core.post('/', Object.assign({}, {controller:'PaymentEvents',action:'createTokenWompi'}, self.form_create))
			 .then((response) => {
				 final = response;
			 })
			 .catch((error) => {
				 console.log('error', error);
				 final = error.response;
			 })
			 .finally(()=>{
				 console.log('NEQUI FINAL: ', final);
				 if(final.status == 200){
					 // location.reload();
					 if(final.data && final.data.message){
						 if(final.data.error == false){
							 Swal.queue([{
							  title: self.$root.translateField(final.data.message),
							  confirmButtonText: self.$root.translateField('WCO_nequi_pending_approved_btn'),
							  text: self.$root.translateField('WCO_nequi_pending_approved_txt'),
							  showLoaderOnConfirm: true,
							  preConfirm: () => {
							    //return location.reload();
                  return true;
							  }
							}]).then((result) => {
               location.reload();
             })
						} else {
							 Swal.fire({
									icon: 'error',
									title: self.$root.translateField(final.data.message)
								})
						}
					 } else {
						  Swal.fire({
						 		icon: 'error',
						 		title: self.$root.translateField("WCO_add_payment_fail")
						 	})
					 }
				 }
			 });
		},
		createTokenC(){
			let self = this;
			console.log('createTokenC');
			self.form_create.data = self.tokens.CARD;
			let final = null;
			PACMEC.core.post('/', Object.assign({}, {controller:'PaymentEvents',action:'createTokenWompi'}, self.form_create))
			 .then((response) => {
				 final = response;
			 })
			 .catch((error) => {
				 console.log('error', error);
				 final = error.response;
			 })
			 .finally(()=>{
				 console.log('NEQUI FINAL: ', final);
				 if(final.status == 200){
					 // location.reload();
					 if(final.data && final.data.message){
						 Swal.fire({
						 	icon: final.data.error == false ? 'success' : 'error',
						 	title: self.$root.translateField(final.data.message)
						 }).then((result) => {
              location.reload();
            })
					 }
				 }
			 });
		},

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
  },
  cancelToken(token_id){
		let self = this;
		console.log('cancelToken',token_id);
		let final = null;
		PACMEC.core.post('/', {controller:'PaymentEvents',action:'cancelTokenWompi', 'token': token_id})
		 .then((response) => {
			 final = response;
		 })
		 .catch((error) => {
			 console.log('error', error);
			 final = error.response;
		 })
		 .finally(()=>{
			 console.log('cancelToken FINAL: ', final);
			 if(final.status == 200){
				 location.reload();
				 if(final.data && final.data.message){
					 Swal.fire({
					 	icon: final.data.error == false ? 'success' : 'error',
					 	title: self.$root.translateField(final.data.message)
					 }).then((result) => {
            location.reload();
          })
				 }
			 }
		 });
	}
});

window.addEventListener('load', function(){
  setTimeout(function () {
    APP_PAY.$mount("#app-pay-method");
  }, 50);
})
</script>
