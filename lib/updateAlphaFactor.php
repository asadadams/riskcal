<?php	
	require_once('../classes/bia.class.php');
	$biaObj = new BIA();

	header('Content-Type: application/json');
	if(isset($_POST['alpha_factor_input'])){				
		$alpha_factor_input =  trim(strip_tags($_POST['alpha_factor_input']));
		

		if(!empty($alpha_factor_input)){
			if(preg_match('/^[0-9]*$/',$alpha_factor_input)){
				$biaObj->updateAlphaFactor($alpha_factor_input);
				$response['success'] = true;
			}else{
				$response['error'] = "Alpha factor should be a number";
			}
		}else{
			$response['error'] = "Enter in an alpha factor value";
		}
	}else{
		$response['error'] = "An error occured, please try again";
	}
	
	echo json_encode($response);		
?>