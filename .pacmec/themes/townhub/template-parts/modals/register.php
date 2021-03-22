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
                    <i class="fa fa-exclamation red-bg"></i>
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
          <!-- //
            <div class="tab">
                <div id="tab-2" class="tab-content">
                    <div class="custom-form">
                        <form method="post"   name="registerform" class="main-register-form" id="main-register-form2">
                            <label >Full Name <span>*</span> </label>
                            <input name="name" type="text"   onClick="this.select()" value="">
                            <label>Email Address <span>*</span></label>
                            <input name="email" type="text"  onClick="this.select()" value="">
                            <label >Password <span>*</span></label>
                            <input name="password" type="password"   onClick="this.select()" value="" >
                            <div class="filter-tags ft-list">
                                <input id="check-a2" type="checkbox" name="check">
                                <label for="check-a2">I agree to the <a href="#">Privacy Policy</a></label>
                            </div>
                            <div class="clearfix"></div>
                            <div class="filter-tags ft-list">
                                <input id="check-a" type="checkbox" name="check">
                                <label for="check-a">I agree to the <a href="#">Terms and Conditions</a></label>
                            </div>
                            <div class="clearfix"></div>
                            <button type="submit"     class="btn float-btn color2-bg"> Register  <i class="fas fa-caret-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
          -->
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

  // dashboard-list fl-wrap
  // custom-login-message
  /*
  PACMEC.submitLogin('feliphegomez', '1035429360', (a)=>{
    console.log('a',a);
  });*/
};
</script>
