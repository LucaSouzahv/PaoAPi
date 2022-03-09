<?php 

	require_once '../includes/DbOperation.php';

	function isTheseParametersAvailable($params){
	
		$available = true; 
		$missingparams = ""; 
		
		foreach($params as $param){
			if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
				$available = false; 
				$missingparams = $missingparams . ", " . $param; 
			}
		}
		
		
		if(!$available){
			$response = array(); 
			$response['error'] = true; 
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
			
		
			echo json_encode($response);
			
		
			die();
		}
	}
	
	
	$response = array();
	

	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
	
			case 'createpao':
				
				isTheseParametersAvailable(array('name','tipo','valor'));
				
				$db = new DbOperation();
				
				$result = $db->createpao(
					$_POST['name'],
					$_POST['tipo'],
					$_POST['valor'],
				);
				

			
				if($result){
					
					$response['error'] = false; 

					
					$response['message'] = 'produto adicionado com sucesso';

					
					$response['paos'] = $db->getpaos();
				}else{

					
					$response['error'] = true; 

				
					$response['message'] = 'Algum erro ocorreu por favor tente novamente';
				}
				
			break; 
			
		
			case 'getpaos':
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Pedido concluído com sucesso';
				$response['paos'] = $db->getpaos();
			break; 
			
			
		
			case 'updatepao':
				isTheseParametersAvailable(array('id','name','tipo','valor'));
				$db = new DbOperation();
				$result = $db->updatepao(
					$_POST['id'],
					$_POST['name'],
					$_POST['tipo'],
					$_POST['valor'],
				);
				
				if($result){
					$response['error'] = false; 
					$response['message'] = 'Produto atualizado com sucesso';
					$response['paos'] = $db->getpaos();
				}else{
					$response['error'] = true; 
					$response['message'] = 'Algum erro ocorreu por favor tente novamente';
				}
			break; 
			
			
			case 'deletePao':

				
				if(isset($_GET['id'])){
					$db = new DbOperation();
					if($db->deletePao($_GET['id'])){
						$response['error'] = false; 
						$response['message'] = 'Produto excluído com sucesso';
						$response['paos'] = $db->getpaos();
					}else{
						$response['error'] = true; 
						$response['message'] = 'Algum erro ocorreu por favor tente novamente';
					}
				}else{
					$response['error'] = true; 
					$response['message'] = 'Não foi possível deletar, forneça um id por favor';
				}
			break; 
		}
		
	}else{
		 
		$response['error'] = true; 
		$response['message'] = 'Chamada de API inválida';
	}
	

	echo json_encode($response);