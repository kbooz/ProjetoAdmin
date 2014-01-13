<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public $dados;

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('equipamentos','pessoas'));
		$this->dados = $this->functions->dados();
	}

	public function teste1()
	{
		$dados = $this->dados;
		$url = $dados['url'];
		
		/*
		obs: datatype = retorno que o jquery espera do server
		original que estava: html
		colocarei json pq quero que retorne o php retorne um array javascript
		*/
		$this->load->view('test',$dados);
	}
	
	public function index()
	{
		$dados = $this->dados;
		$url = $dados['url'];
		$dados['css'] = array('select2');
		$dados['js'] = array( 'jquery-ui.min','chosen.jquery.min','select2.min','select2.pt-BR','date','orcamento');
		$dados['equipamentos']['data']=$this->equipamentos->getAll();
		$dados['equipamentos'] = $this->functions->foreign($dados['equipamentos']);
		$dados['funcionarios']['data']=$this->pessoas->getAll();
		$dados['funcionarios'] = $this->functions->foreign($dados['funcionarios']);
		/*
		obs: datatype = retorno que o jquery espera do server
		original que estava: html
		colocarei json pq quero que retorne o php retorne um array javascript
		*/
		$dados['javascript'] = "var localurl = '$url';";
		//$dados['css'] = array('bootstrap.min');
		$this->load->view('test',$dados);
	}
	
	// public function equipamentos()
	// {
	// 	$a = $this->equipamentos->getAll();
	// 	// print_r($a[0]);
	// 	echo json_encode($a[0]);
	// }
	
	public function equipamentos($id = null)
	{
		$a = $this->equipamentos->getById($id);
		$a['dataentrada'] = $this->functions->date_default_to_br($a['dataentrada']);
		$a['datasaida'] = $this->functions->date_default_to_br($a['datasaida']);
		echo json_encode($a);
	}
	
	public function funcionarios($id = null)
	{
		$a = $this->pessoas->getById($id);
		echo json_encode($a);
		// print_r($a);
	}
	
	public function teste()
	{
		$a = 100;
		
		echo "inicio: $a";
		
		for ($i=$a; $i >0 ; $i--) { 
			echo "meio: $i";
			if($i == 1){
				echo "UMMMMM";
				break;
			}
		}
		
		echo "fim: $i";
	}
	
	public function datedefaultbr($date)
	{
		echo $this->function->date_default_to_br($date);
	}
	
	public function datebrdefault($date)
	{
		echo $this->function->date_br_to_default($date);
	}

}

/* End of file test.php */
/* Location: ./application/controllers/test.php */