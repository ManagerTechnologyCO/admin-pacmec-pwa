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
<div id="me-change-pass-component">
  <div>
  	<div class="dashboard-title fl-wrap">
  		<h3><?= _autoT('me_profile_change_pass'); ?></h3>
  	</div>
  	<div class="profile-edit-container fl-wrap block_box">
  		<form action="javascript:return false;" v-on:submit="updateMe">
  			<div class="custom-form">
  				<div class="pass-input-wrap fl-wrap">
  					<label><?= _autoT('pass_current'); ?></label>
  					<input type="password" class="pass-input" placeholder="" value="" required="" v-model="form.pass" />
  					<span class="eye"><i class="far fa-eye" aria-hidden="true"></i> </span>
  				</div>
  				<div class="pass-input-wrap fl-wrap">
  					<label><?= _autoT('pass_enter'); ?></label>
  					<input type="password" class="pass-input" placeholder="" value="" required="" v-model="form.pass1" />
  					<span class="eye"><i class="far fa-eye" aria-hidden="true"></i> </span>
  				</div>
  				<div class="pass-input-wrap fl-wrap">
  					<label><?= _autoT('pass_confirm'); ?></label>
  					<input type="password" class="pass-input" placeholder="" value="" required="" v-model="form.pass2" />
  					<span class="eye"><i class="far fa-eye" aria-hidden="true"></i> </span>
  				</div>
  				<button type="submit" class="btn    color2-bg  float-btn"><?= _autoT('save_changes'); ?><i class="fal fa-save"></i></button>
  			</div>
  		</form>
  	</div>
  </div>
</div>
<script>
var me_profile_change_pass = new Vue({
	mixins: [],
	data: function () {
		return {
			form: {
				pass: '',
				pass1: '',
				pass2: '',
			}
		};
	},
	computed: {
		me(){
			let self = this;
		},
	},
	created(){
		let self = this;

	},
	mounted(){
		let self = this;
    console.log('montado');
		self.$nextTick(function () {
		})
	},
	methods: {
		initScripts(){
			let self = this;

		},
		updateMe(){
			let self = this;
      console.log('updateMe')

			if(self.form.pass1 === self.form.pass2){
				PACMEC.create('password', {
					username: "<?= $_SESSION['user']['username']; ?>",
					password: self.form.pass,
					newPassword: self.form.pass1,
				}, a => {
					console.log('a', a);
					if(a.error == false){
            Swal.fire({
              icon: 'success',
              title: "Contraseña cambiada con éxito"
            });
					} else {
						if(a.response !== undefined && a.response.message !== undefined){
              Swal.fire({
                icon: 'error',
                title: a.response.message
              });
						} else {
              Swal.fire({
                icon: 'error',
                title: "Ocurrio un error actualizando la información."
              });
						}
					}
				}, '/');
			} else {
				console.log("Las contraseñas no coinciden.");
			}
		},
	},
}).$mount('#me-change-pass-component');
</script>
