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
          $data = !empty(@json_decode($payment->data))?@json_decode($payment->data):($payment->data);
					$data = !empty(@json_decode($data))?@json_decode($data):$data;
					$data = !empty(@json_decode($data))?@json_decode($data):$data;
					$data = !empty(@json_decode($data))?@json_decode($data):$data;
					$data = !empty(@json_decode($data))?@json_decode($data):$data;
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
										 <a href="#"><?= _autoT('WCO_'.$payment->type); ?></a>
                      <?= _autoT('WCO_' . $payment->token_status); ?>
									</p>
                  <p>
                    <?php
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
</script>
