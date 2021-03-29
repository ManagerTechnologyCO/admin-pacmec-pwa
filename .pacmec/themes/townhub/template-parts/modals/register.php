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
$login_form = new stdClass();
$login_form->message = null;

/*
*/

?>

<div class="main-register-wrap modal">
  <div class="reg-overlay"></div>
  <div class="main-register-holder tabs-act">
    <div class="main-register fl-wrap  modal_main">
      <div class="main-register_title"><?= _autoT('login_welcome'); ?></div>
      <div class="close-reg"><i class="fal fa-times"></i></div>
      <ul class="tabs-menu fl-wrap no-list-style">
        <li class="current"><a href="#tab-1"><i class="fal fa-sign-in-alt"></i> <?= _autoT('user_login')?> </a></li>
        <li><a href="#tab-2"><i class="fal fa-user-plus"></i> <?= _autoT('user_register'); ?> </a></li>
      </ul>
      <div class="tabs-container">
        <div class="tab">
          <div id="tab-1" class="tab-content first-tab">
            <div class="dashboard-list-box fl-wrap" id="custom-login-message">
              <div class="dashboard-list fl-wrap">
                <div class="dashboard-message">
                  <div class="dashboard-message-text" style="width:100%;">
                    <!-- <i class="fa fa-exclamation red-bg"></i> -->
                    <p id="custom-login-message-text"></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="custom-form">
              <!-- CUSTOM LOGIN -->
              <form method="post" action="javascript:loginSite()" id="login-custom-form">
                <label><?= _autoT('login_nick_label'); ?> <span>*</span> </label>
                <input name="nick" type="text" onClick="this.select()" value="" required="" />

                <label ><?= _autoT('login_hash_label'); ?> <span>*</span> </label>
                <input name="pass" type="password"   onClick="this.select()" value="" required="" />


                <button onclick="loginSite" type="submit"  class="btn float-btn color2-bg"> <?= _autoT('user_login'); ?> <i class="fas fa-caret-right"></i></button>
                <div class="clearfix"></div>
              </form>
              <div class="lost_password">
                <a href="#"><?= _autot('lost_password'); ?></a>
              </div>
            </div>
            <!-- // CUSTOM LOGIN -->
          </div>
            <div class="tab">
                <div id="tab-2" class="tab-content">
                  <div class="dashboard-list-box  fl-wrap" v-if="register_form.message!==null">
                      <div class="dashboard-list fl-wrap">
                        <div class="dashboard-message">
                          <!-- // <span class="new-dashboard-item"><i class="fal fa-times"></i></span> -->
                          <div class="dashboard-message-text" style="width:100%;">
                            <!--//<i class="fa fa-exclamation red-bg"></i>-->
                            <p id="custom-register-message-text"></p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="custom-form">
                        <form method="post" action="javascript:registerSite()" name="registerform" class="main-register-form" id="register-custom-form">
                            <label><?= _autoT('users_display_name'); ?> <span>*</span> </label>
                            <input name="display_name" type="text"   onClick="this.select()" value="" required="" />

                            <label><?= _autoT('users_username'); ?> <span>*</span> </label>
                            <input name="username" type="text"   onClick="this.select()" value="" required="" />

                            <label <span><?= _autoT('users_email'); ?>*</span></label>
                            <input name="email" type="text"  onClick="this.select()" value="" required="" />

                            <label><?= _autoT('users_address'); ?> <span>*</span> </label>
                            <input name="address" type="text"   onClick="this.select()" value="" required="" />

                            <label><?= _autoT('users_phones'); ?> <span>*</span> </label>
                            <input name="phones" type="text"   onClick="this.select()" value="" required="" />

                            <label><?= _autoT('users_password'); ?> <span>*</span></label>
                            <input name="password" type="password"   onClick="this.select()" value="" required="" />

                            <label><?= _autoT('users_confirm_pass'); ?> <span>*</span></label>
                            <input name="password2" type="password"   onClick="this.select()" value="" required="" />

                            <div class="filter-tags ft-list">
                                <input id="check-a2" type="checkbox" name="check" required="" />
                                <label for="check-a2"><?= _autoT('i_agree_to_the_s_f'); ?> <a href="#"><?= _autoT('privacy_policy'); ?></a></label>
                            </div>
                            <div class="clearfix"></div>
                            <div class="filter-tags ft-list">
                                <input id="check-a" type="checkbox" name="check" required="" />
                                <label for="check-a"><?= _autoT('i_agree_to_the_p_m'); ?> <a href="#"><?= _autoT('terms_of_use'); ?></a></label>
                            </div>
                            <div class="clearfix"></div>
                            <label><?= _autoT('solvemedia_resolve'); ?> <span>*</span> </label>
                            <?php
                            echo solvemedia_get_html("hqf0HycsKOX3uP9.ggJtdy7tUdEOM8Ce");
                            ?>
                            <!--//
                            <div id="adcopy-outer">
                              <div id="adcopy-puzzle-image"></div>
                              <div id="adcopy-puzzle-audio"></div>
                              <div id="adcopy-pixel-image"></div>
                              <div><span id="adcopy-instr"></span></div>
                              <div><span id="adcopy-error-msg"></span></div>
                              <input type="text" name="adcopy_response" id="adcopy_response">
                              <input type="hidden" name="adcopy_challenge" id="adcopy_challenge">

                              <a href="javascript:ACPuzzle.reload()"       id="adcopy-link-refresh">Reload</a>
                              <a href="javascript:ACPuzzle.change2audio()" id="adcopy-link-audio">Audio</a>
                              <a href="javascript:ACPuzzle.change2image()" id="adcopy-link-image">Visual</a>
                              <a href="javascript:ACPuzzle.moreinfo()"     id="adcopy-link-info">Info</a>
                            </div>
                            <div class="clearfix"></div>
                            -->

                            <div class="clearfix"></div>
                            <button type="submit" class="btn float-btn color2-bg"> <?= _autoT('user_register'); ?>  <i class="fas fa-caret-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--tabs end
        <div class="log-separator fl-wrap"><span>or</span></div>
        <div class="soc-log fl-wrap">
            <p>For faster login or register use your social account.</p>
            <a href="#" class="facebook-log"> Facebook</a>
        </div>
        -->
        <div class="wave-bg">
          <div class='wave -one'></div>
          <div class='wave -two'></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
var ACPuzzleOptions = {
	theme:	    'custom',
	size:	    '300x150'
};

const loginSite = function(){
  console.log('loginSite')
  var x_nick = document.forms["login-custom-form"]["nick"].value;
  var x_hash_s = document.forms["login-custom-form"]["pass"].value;
  console.log('x_nick', 'x_hash_s')
  console.log(x_nick, x_hash_s)
  $("#custom-login-message-text").text("nuevo");

	PACMEC.submitLogin(x_nick, x_hash_s, (re) => {
		if(re.status !== 200){
			if(re.response.message){
        Þ("#custom-login-message-text").text(re.response.message);
			} else {
        Þ("#custom-login-message-text").text('Ocurrio un error');
      }
		} else {
      Þ("#custom-login-message-text").text('Bienvenid@, espere un momento mientras recargamos la página.');
			location.reload();
		}
	});
}

const registerSite = function(){
  console.log('registerSite');
  let form = document.forms["register-custom-form"];
  if(form['password'].value !== form['password2'].value){
    // Swal.fire('<?= _autoT('passwords_no_match'); ?>');
    dialog.find('.bootbox-body').html('<?= _autoT('passwords_no_match'); ?>');
    return;
  }
  if(form['adcopy_response'].value.length <= 5 || form['adcopy_challenge'].value.length <= 5){
    Swal.fire('<?= _autoT('solvemedia_req_resolve'); ?>');
    return;
  }
  let final = null;
  return PACMEC.core.post('/', {
    controller: 'Solvemedia',
    action: 'check_answer',
    adcopy_challenge: form['adcopy_challenge'].value,
    adcopy_response: form['adcopy_response'].value,
  })
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
      console.log('Vamos bien');
      let send = {
        display_name: form["display_name"].value,
        username: form["username"].value,
        password: form["password2"].value,
        email: form["email"].value,
        address: form["address"].value,
        phones: form["phones"].value,
      };
      console.log('send', send)
      PACMEC.create('register', send, (response_creation)=>{
        console.log('response_creation', response_creation);
        if(response_creation.status == 200 && response_creation.error == false){
          document.forms["login-custom-form"]["nick"].value = send.username;
          document.forms["login-custom-form"]["pass"].value = send.password;
          loginSite();
        } else {
          if(response_creation.response.code){
            Swal.fire(response_creation.response.message);
          } else {
            Swal.fire('<?= _autoT('register_fail'); ?>');
          }
          ACPuzzle.reload();
        }
      }, '/');
      return;
    } else {
      Swal.fire(final.data.message);
      ACPuzzle.reload();
      return;
    }
  });

  /*
	PACMEC.submitLogin(x_nick, x_hash_s, (re) => {
		if(re.status !== 200){
			if(re.response.message){
        Þ("#custom-login-message-text").text(re.response.message);
			} else {
        Þ("#custom-login-message-text").text('Ocurrio un error');
      }
		} else {
      Þ("#custom-login-message-text").text('Bienvenid@, espere un momento mientras recargamos la página.');
			location.reload();
		}
	});
  */
};
</script>
