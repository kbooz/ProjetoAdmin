<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Functions extends CI_Model {

	public $dados = array();
	
	public function __construct()
	{
		$this->dados['url'] = "http://".$_SERVER['HTTP_HOST']."/ci";
		$this->dados['assets'] = $this->dados['url']."/assets/";
		$this->dados['js'] = array();
		$this->dados['css'] = array();
	}
	
	public function dados()
	{
		return $this->dados;
	}
	
	public function view( $pg = null, $d = null){
		if($d==null)
			$d = $this->dados;
		$this->load->view( 'template/header', $d );
		if($pg!=null)
			$this->load->view( $pg, $d );
		$this->load->view( 'template/footer', $d );
	}
	
	public function date_br_to_default($date)
	{
		list($dia, $mes, $ano) = explode ('/', $date);
		$newDate = "$ano-$mes-$dia";
		return $newDate;
	}
	
	public function date_default_to_br($date)
	{
		list($ano, $mes, $dia) = explode ('-', $date);
		$newDate = "$dia/$mes/$ano";
		return $newDate;
	}
	
	
	public function validateDate($dbr1,$dbr2)
	{
		$ddf1 = $this->functions->date_br_to_default($dbr1);
		$new1 = strtotime($ddf1);
		$ddf2 = $this->functions->date_br_to_default($dbr2);
		$new2 = strtotime($ddf2);
		if ($new1<=$new2) {
			return true;
		}
		return false;
	}
	
	public function foreign($foreign)
	{
		$input = array();
		
		foreach ( $foreign['data'] as $a ) {
		$input[$a['id']] = $a['nome'];
		}
		return $input;
	}
	
	public function convertDates($aux)
	{
		if(isset($aux['lucro']))
		{
			$aux['dataentrada'] = $this->date_default_to_br($aux['dataentrada']);
			$aux['datasaida'] = $this->date_default_to_br($aux['datasaida']);
		}
		else
		{
			if(isset($aux['idOrcamento']))
			{
				foreach ($aux as $linha)
				{
					$linha['dataentrada'] = $this->functions->date_default_to_br($linha['dataentrada']);
					$linha['datasaida'] = $this->functions->date_default_to_br($linha['datasaida']);
				}
			}
		}
		
		return $aux;
	}

}

/* End of file  */
/* Location: ./application/models/ */ ?>