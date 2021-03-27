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
$r_message = null;

if(isset($meinfo->user) && $meinfo->user->id > 0):
  $me = $meinfo->user;

  if(!$_POST){}
  else {
    // Email address verification, do not edit.
    function isEmail($email) {
    	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
    }
    if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");
    $display_name     = $_POST['display_name'];
    $email    = $_POST['email'];
    $phones = $_POST['phones'];
    if(trim($display_name) == '') {
    	$r_message = '<div class="error_message">'._autoT('enter_your_display_name').'</div>';
    } else if(trim($phones) == '') {
    	$r_message = '<div class="error_message">'._autoT('enter_your_phone').'</div>';
    } else if(trim($email) == '') {
    	$r_message = '<div class="error_message">'._autoT('enter_your_email').'</div>';
    } else if(!isEmail($email)) {
    	$r_message = '<div class="error_message">'._autoT('email_invalid').'</div>';
    } else {
      $result = $meinfo->save([
        "display_name" => $display_name,
        "email" => $email,
        "phones" => $phones,
      ]);
      if($result==true){
        $r_message = "<fieldset>";
      		$r_message .= "<div id='success_page'>";
      		$r_message .= "<h3>"._autoT('save_successfully')."</h3>";
      		$r_message .= "</div>";
      	$r_message .= "</fieldset>";
        $meinfo->refreshSession();
        $me = $meinfo->user;
      } else {
        $r_message = _autoT('save_error');
      }
    }
    $_POST = array();
  }
?>
<div class="dashboard-title fl-wrap">
	<h3><?= _autoT('me_profile'); ?></h3>
</div>
<!-- profile-edit-container-->
<div class="profile-edit-container fl-wrap block_box">
  <div id="message"><?php if($r_message !== null && !empty($r_message)) echo $r_message; ?></div>
	<form action="<?= current_url(); ?>" method="POST">
		<div class="custom-form">
			<div class="row">
				<div class="col-sm-12">
					<label><?= _autoT('users_display_name'); ?> <i class="fal fa-user"></i></label>
					<input type="text" placeholder="<?= _autoT('display_name'); ?>" name="display_name" value="<?= $me->display_name; ?>" required="" />
				</div>
				<div class="col-sm-6">
					<label><?= _autoT('users_email'); ?><i class="far fa-envelope"></i>  </label>
					<input type="text" placeholder="<?= _autoT('email'); ?>" name="email" value="<?= $me->email; ?>" required="" />
				</div>
				<div class="col-sm-6">
					<label><?= _autoT('users_phones'); ?><i class="far fa-phone"></i>  </label>
					<input type="text" placeholder="<?= _autoT('phones'); ?>" name="phones" value="<?= $me->phones; ?>" required="" />
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="custom-form">
			<button type="submit" class="btn color2-bg  float-btn"><?= _autoT('save_changes'); ?><i class="fal fa-save"></i></button>
		</div>
	</form>
</div>
<?php endif; ?>
