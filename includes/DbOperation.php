<?php
 
class DbOperation
{
    
    private $con;
 
 
    function __construct()
    {
  
        require_once dirname(__FILE__) . '/DbConnect.php';
 
     
        $db = new DbConnect();
 

        $this->con = $db->connect();
    }
	
	
	function createpao($name, $tipo, $valor){
		$stmt = $this->con->prepare("INSERT INTO paos (name, tipo, valor) VALUES (?, ?, ?)");
		$stmt->bind_param("ssi", $name, $tipo, $valor);
		if($stmt->execute())
			return true; 			
		return false;
	}
	
	function getpao(){
		$stmt = $this->con->prepare("SELECT id, name, tipo, valor FROM pao");
		$stmt->execute();
		$stmt->bind_result($id, $name, $tipo, $valor);
		
		$paos = array(); 
		
		while($stmt->fetch()){
			$hero  = array();
			$hero['id'] = $id; 
			$hero['name'] = $name; 
			$hero['tipo'] = $tipo; 
			$hero['valor'] = $valor; 
	 
			
			array_push($paos, $pao); 
		}
		
		return $paos; 
	}
	
	
	function updateHero($id, $name, $tipo, $valor){
		$stmt = $this->con->prepare("UPDATE paos SET name = ?, tipo = ?, valor = ?, WHERE id = ?");
		$stmt->bind_param("ssii", $name, $topo, $valor,, $id);
		if($stmt->execute())
			return true; 
		return false; 
	}
	
	
	function deleteHero($id){
		$stmt = $this->con->prepare("DELETE FROM heroes WHERE id = ? ");
		$stmt->bind_param("i", $id);
		if($stmt->execute())
			return true; 
		return false; 
	}
}