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
// echo json_encode($meinfo->payment);
?>
<div id="app-pay-method">
	<div class="dashboard-title dt-inbox fl-wrap">
			<h3><?= _autoT('me_history_payments'); ?></h3>
	</div>
	<div class="dashboard-list-box  fl-wrap">
    <?php if($payments !== null && count($payments)>0): ?>
      <?php
        foreach($payments as $payment):
          $data = json_decode(json_decode($payment->data));
      ?>
      <div class="dashboard-list fl-wrap" v-if="payment!==null">
					<div class="dashboard-message">
            <?php if($me_payment !== null && $payment->id == $me_payment->id && $payment->source_status == 'AVAILABLE'): ?>
              <span style="cursor:pointer;" onclick="javascript:cancelToken(<?= $payment->id; ?>)" class="new-dashboard-item"><i class="fal fa-times"></i></span>
            <?php endif; ?>
							<div class="dashboard-message-text">
                <?php
                if($payment->source_status == 'AVAILABLE' && ($payment->token_status == 'APPROVED' || $payment->token_status == 'CREATED')) {
                  echo "<i class=\"fal fa-check green-bg\"></i>";
                } else if ($payment->source_status == 'AVAILABLE' && ($payment->token_status == 'PENDING' || $payment->source_status == 'PENDING')) {
                  echo "<i class=\"fal fa-spinner spin yellow-bg\"></i>";
                } else if ($payment->token_status == 'DECLINED') {
                  echo "<i class=\"fal fa-times orange-bg\"></i>";
                } else {
                  echo "<i class=\"fal fa-user-times orange-bg\"></i>";
                }
                ?>
									<p>
										<!-- //  {{translateField('WCO_'+payment.token_status)}} -->
										 <a href="#"><?= _autoT('WCO_'.$payment->type); ?></a>

                      <?= _autoT('WCO_' . $payment->token_status); ?>
									</p>
                  <p>
                    <?php
                    if(@json_decode($data)){
                      $data = json_decode($data);
                    }
                    switch ($payment->type) {
                      case 'CARD':
                        echo ($data->name);
                        break;
                      case 'NEQUI':
                        echo ($data->phone_number);
                        break;
                      default:
                        break;
                    }
                    ?>
                  </p>
							</div>
              <div class="dashboard-message-time"><i class="fal fa-calendar-week"></i><?= $payment->created; ?></div>
					</div>
			</div>
    <?php endforeach; ?>
    <?php endif; ?>
	</div>
</div>


<script type="text/javascript">
function cancelToken(token_id){
  let self = this;
  console.log('cancelToken',token_id);
  let final = null;

  PACMEC.core.get('/', {
    params: {
      controller:'PaymentEvents',
      action:'cancelTokenWompi', 'token': token_id
    }
  })
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
       if(final.data && final.data.message){
         Swal.fire({
          icon: final.data.error == false ? 'success' : 'error',
          title: final.data.message,
          showConfirmButton: true,
          showCloseButton: false,
          showCancelButton: false,
          confirmButtonText: "<?= _autoT('btn_close'); ?>",
         }).then((result) => {
          location.reload();
        })
       }
     }
   });
};

/*
var pacmec_global = {
  data: {
    definition: null,
    glossary: null,
    lang: '<?= $GLOBALS['PACMEC']['lang']; ?>',
    list_menus: null,
    userStatus: null,
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
    PACMEC.
    userStatus
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
					 self.$root.checkLoginState();
					 if(final.data && final.data.message){
						 if(final.data.error == false){
							 Swal.queue([{
							  title: self.$root.translateField(final.data.message),
							  confirmButtonText: self.$root.translateField('wco_nequi_pending_approved_btn'),
							  text: self.$root.translateField('wco_nequi_pending_approved_txt'),
							  showLoaderOnConfirm: true,
							  preConfirm: () => {
							    return self.$root.checkLoginState();
							  }
							}])
						} else {
							 Swal.fire({
									icon: 'error',
									title: self.$root.translateField(final.data.message)
								})
						}
					 } else {
						  Swal.fire({
						 		icon: 'error',
						 		title: self.$root.translateField("wco_add_payment_fail")
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
					 self.$root.checkLoginState();
					 if(final.data && final.data.message){
						 Swal.fire({
						 	icon: final.data.error == false ? 'success' : 'error',
						 	title: self.$root.translateField(final.data.message)
						 })
					 }
				 }
			 });
		},

    translateField(field_slug){
      let self = this;
      try {
        if(self.lang !== null && self.glossary !== null){
          let label = self.lang_labels.find((z,x) => z.slug == field_slug);
          if(label !== undefined && label.label !== undefined){ return label.label; }
        }
        return "Þ{" + field_slug + "}";
      } catch(e) {
        console.log('error tras', e);
        return "Þ{" + field_slug + "}";
      }
    },
  },
}).$mount("#app-pay-method");
*/
</script>
