<?php
	require_once('../classes/businessline.class.php');
	$businessLineObj = new BusinessLine();
	$response = array();
	
	header('Content-Type: application/json');
	if(isset($_POST['id'])){
		
		$id =  trim(strip_tags($_POST['id']));
	
		if(!empty($id)){
			$businessLineObj->deleteBusinessLine($id);
			$response['success'] = "success";
		}else{
			$response['error'] = "An unexpected error occured, please try again";
		}
	}else{
		$response['error'] = "An error occured, please try again";
	}
	
	echo json_encode($response);		
?>