<?php
$mail->IsSMTP();      
					$mail->SMTPDebug = 0;
					$mail->SMTPAuth = true;
					$mail->Host = 'mail.angelgrafico.com';                
					//$mail->Port = '587';                                  
					$mail->SMTPAutoTLS = true;
					$mail->SMTPAuth = true;                              
					$mail->Username = 'hector@angelgrafico.com';               
					$mail->Password = 'Montse20162';                 
					//$mail->SMTPSecure = 'tls';     
					$mail->SMTPOptions = array(
						'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						)
					);
					$mail->setFrom("hector@angelgrafico.com", "Rehubic");
?>