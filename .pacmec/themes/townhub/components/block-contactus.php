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
$contact_info = pacmec_decode_64_sys('site_info');
$r_message = null;

if(!$_POST){}
else {
  // Email address verification, do not edit.
  function isEmail($email) {
  	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
  }
  if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");
  $name     = $_POST['name'];
  $email    = $_POST['email'];
  $comments = $_POST['comments'];
  $phone = $_POST['phone'];
  if(trim($name) == '') {
  	$r_message = '<div class="error_message">'._autoT('email_sent_enter_your_name').'</div>';
  } else if(trim($phone) == '') {
  	$r_message = '<div class="error_message">'._autoT('email_sent_enter_your_phone').'</div>';
  } else if(trim($email) == '') {
  	$r_message = '<div class="error_message">'._autoT('email_sent_enter_your_email').'</div>';
  } else if(!isEmail($email)) {
  	$r_message = '<div class="error_message">'._autoT('email_sent_email_invalid').'</div>';
  } else if(trim($comments) == '') {
  	$r_message = '<div class="error_message">'._autoT('email_sent_enter_your_message').'</div>';
  } else {
    if(
        (  function_exists("get_magic_quotes_gpc") && @get_magic_quotes_gpc()  )
       ){
        $comments = @stripslashes($comments);
    }
    $address = infosite('contact_email');
    // Configuration option.
    // i.e. The standard subject will appear as, "You've been contacted by John Doe."
    // Example, $e_subject = '$name . ' has contacted you via Your Website.';
    $e_subject = 'Ha sido contactado por  ' . $name . '.';
    // Configuration option.
    // You can change this if you feel that you need to.
    // Developers, you may wish to add more fields to the form, in which case you must be sure to add them here.
    $e_body = "Ha sido contactado por: $name" . PHP_EOL . PHP_EOL;
    $e_reply = "E-mail: $email\r\nPhone: $phone";
    $e_content = "Mensaje:\r\n$comments" . PHP_EOL . PHP_EOL;
    $msg = wordwrap( $e_body . $e_content . $e_reply, 70 );
    $headers = "From: $email" . PHP_EOL;
    $headers .= "Reply-To: $email" . PHP_EOL;
    $headers .= "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
    $headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
    if(mail($address, $e_subject, $msg, $headers)) {
    	$r_message = "<fieldset>";
    		$r_message .= "<div id='success_page'>";
    		$r_message .= "<h3>"._autoT('email_sent_successfully')."</h3>";
    		$r_message .= "<p>"._autoT('email_sent_thank_you')." <strong>$name</strong>, "._autoT('email_sent_thank_you_extra')."</p>";
    		$r_message .= "</div>";
    	$r_message .= "</fieldset>";
    } else {
    	$r_message = _autoT('email_sent_error');
    }
  }
  $_POST = array();
};
?>
<section   id="sec1" data-scrollax-parent="true">
	<div class="container">
		<!--about-wrap -->
		<div class="about-wrap">
			<div class="row">
				<div class="col-md-4">
					<div class="ab_text-title fl-wrap">
						<h3></h3>
						<span class="section-separator fl-sec-sep"></span>
					</div>
					<div class="box-widget-item fl-wrap block_box">
						<div class="box-widget">
							<div class="box-widget-content bwc-nopad">
								<div class="list-author-widget-contacts list-item-widget-contacts bwc-padside">
									<ul class="no-list-style">
                    <?php if(is_array($contact_info)): ?>
                    <?php foreach($contact_info as $ctn_i => $ctn): ?>
  										<li>
  											<span><i class="<?= $ctn->icon; ?>"></i> <?= _autoT($ctn->slug); ?> :</span>
  											<a href="#" target="_blank"><?= $ctn->text; ?></a>
  										</li>
                    <?php endforeach; ?>
                    <?php endif; ?>
									</ul>
								</div>
								<div class="list-widget-social bottom-bcw-box  fl-wrap">
                  <?= do_shortcode('[pacmec-ul-no-list-style-one-level-social-icons target="_blank" class="no-list-style" menu_slug="socials"][/pacmec-ul-no-list-style-one-level-social-icons]'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="ab_text">
						<div class="ab_text-title fl-wrap">
							<?php if($title!==false) echo "<h3>"._autoT($title)."</h3>"; ?>
							<span class="section-separator fl-sec-sep"></span>
						</div>
            <?php if($title!==false) echo "<p>"._autoT($content)."</p>"; ?>
            <?php if(infosite('contact_form') == true && !empty(infosite('contact_email'))): ?>
  						<div id="contact-form">
  							<div id="message"><?php if($r_message !== null && !empty($r_message)) echo $r_message; ?></div>
  							<form method="POST" class="custom-form" action="<?= current_url(); ?>" name="pacemc-contactform" id="pacemc-contactform">
  								<fieldset>
  									<label><i class="fal fa-user"></i></label>
  									<input type="text" name="name" id="name" placeholder="<?= _autoT('form_contact_name_placeholder'); ?>" value="" required="" />
  									<div class="clearfix"></div>
  									<label><i class="fal fa-envelope"></i>  </label>
  									<input type="text"  name="email" id="email" placeholder="<?= _autoT('form_contact_email_placeholder'); ?>" value="" required="" />
  									<label><i class="fal fa-phone"></i>  </label>
  									<input type="text"  name="phone" id="phone" placeholder="<?= _autoT('form_contact_phone_placeholder'); ?>" value="" required="" />
  									<textarea name="comments"  id="comments" cols="40" rows="3" placeholder="<?= _autoT('form_contact_message_placeholder'); ?>" required=""></textarea>
  								</fieldset>
  								<button class="btn float-btn color2-bg" id="submit"><?= _autoT('form_contact_btn_text'); ?><i class="fal fa-paper-plane"></i></button>
  							</form>
  						</div>
            <?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- about-wrap end  -->
	</div>
</section>
