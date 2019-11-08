<?php	
	require_once('../classes/businessline.class.php');
	$businessLineObj = new BusinessLine();

	header('Content-Type: application/json');
	if(isset($_POST['business_line_name'])){				
		$business_line_name =  trim(strip_tags($_POST['business_line_name']));
		

		if(!empty($business_line_name)){
			if(preg_match('/^[a-zA-Z_0-9\s]*$/',$business_line_name)){
				if($businessLineObj->checkDuplicateBusinessLineName($business_line_name) == false){
					//Inserting business line
					$businessLineObj->addBusinessLine($business_line_name);
					$response['success'] = true;
				}else{
					$response['error'] = "Busness line with this name already exist";
				}
			}else{
				$response['error'] = "Busness line name contain some invalid characters";
			}
		}else{
			$response['error'] = "Enter in a business line name";
		}
	}else{
		$response['error'] = "An error occured, please try again";
	}
	
	echo json_encode($response);		
?>