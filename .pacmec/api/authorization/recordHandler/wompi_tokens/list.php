<?php
return '&filter1[]=user_id,eq,'.$_SESSION['user']['id'] . '&filter1[]=token_status,in,PENDING,APPROVED,CREATED' . '&filter1[]=source_status,in,AVAILABLE';
