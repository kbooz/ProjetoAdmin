<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller {

	public $dados = array();

	public function __construct()
	{
		parent::__construct();
		$this->log->logged();
		$this->dados = $this->functions->dados();
		$this->dados['titulo'] = 'Menu';
	}

	public function index()
	{
		$dados = $this->dados;
		$this->functions->view('main',$this->dados);
		
	}

}


?>