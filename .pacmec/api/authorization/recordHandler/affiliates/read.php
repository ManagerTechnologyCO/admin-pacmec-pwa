<?php 
return 'filter[]=enddate,ge,'.date('Y-m-d H:i:s').'&filter[]=user_id,eq,'.$_SESSION['user']['id'];