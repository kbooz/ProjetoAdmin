<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pessoas extends CI_Model
{
	public $query;
	public $database = 'pessoa';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
		$this->query = $this->db->get($this->database);
	}

	public function getAll()
	{	
		return $this->query->result_array();
	}
	
	public function getById($id=null)
	{
		$query= $this->db->get_where($this->database, array('id =' => $id))->result_array();
		return $query[0];
	}
	
	public function getName($id)
	{
		$query= $this->db->get_where($this->database, array('id =' => $id))->result_array();
		
		return $query[0]['nome'];
	}
	
	public function getByFuncao($id)
	{
		$query= $this->db->get_where($this->database, array('funcao =' => $id))->result_array();
		return $query;
	}

	public function count()
	{
		return $this->db->count_all($this->database);
	}

	public function columns()
	{
		return $this->query->list_fields();
	}
	
	public function add()
	{
		$nome = $this->input->post('nome');
		$apelidofantasia = $this->input->post('apelidofantasia');
		$nascimentofundacao = $this->input->post('nascimentofundacao');
		$telefone = $this->input->post('telefone');
		$site = $this->input->post('site');
		$funcao = $this->input->post('funcao');
		$rginsc = $this->input->post('rginsc');
		$cpfcnpj = $this->input->post('cpfcnpj');
		$equipe = $this->input->post('equipe');
		$endereco = $this->input->post('endereco');
		$complemento = $this->input->post('complemento');
		$bairro = $this->input->post('bairro');
		$cidade = $this->input->post('cidade');
		$uf = $this->input->post('uf');
		$cep = $this->input->post('cep');
		$obs = $this->input->post('obs');
		$banco = $this->input->post('banco');
		$agencia = $this->input->post('agencia');
		$conta = $this->input->post('conta');
		$tipodeconta = $this->input->post('tipodeconta');
		$enderecoconta = $this->input->post('enderecoconta');
		$complementoconta = $this->input->post('complementoconta');
		$bairroconta = $this->input->post('bairroconta');
		$cidadeconta = $this->input->post('cidadeconta');
		$ufconta = $this->input->post('ufconta');
		$cepconta = $this->input->post('cepconta');
		$valorpadrao = $this->input->post('valorpadrao');
		
		if(!$equipe)
			$equipe = 0;
		else
			$equipe = 1;
		
		$data = array(
			'nome' => $nome,
			'apelidofantasia' => $apelidofantasia,
			'nascimentofundacao' => $this->date_br_to_default($nascimentofundacao),
			'telefone' => $telefone,
			'site' => $site,
			'funcao' => $funcao,
			'rginsc' => $rginsc,
			'cpfcnpj' => $cpfcnpj,
			'equipe' => $equipe,
			'endereco' => $endereco,
			'complemento' => $complemento,
			'bairro' => $bairro,
			'cidade' => $cidade,
			'uf' => $uf,
			'cep' => $cep,
			'obs' => $obs,
			'banco' => $banco,
			'agencia' => $agencia,
			'conta' => $conta,
			'tipodeconta' => $tipodeconta,
			'enderecoconta' => $enderecoconta,
			'complementoconta' => $complementoconta,
			'bairroconta' => $bairroconta,
			'cidadeconta' => $cidadeconta,
			'ufconta' => $ufconta,
			'cepconta' => $cepconta,
			'valorpadrao' => $valorpadrao
			);
		
		// return $data;
		return $this->db->insert($this->database, $data);
	}
	
	public function update($id)
	{
		$nome = $this->input->post('nome');
		$apelidofantasia = $this->input->post('apelidofantasia');
		$nascimentofundacao = $this->input->post('nascimentofundacao');
		$telefone = $this->input->post('telefone');
		$site = $this->input->post('site');
		$funcao = $this->input->post('funcao');
		$rginsc = $this->input->post('rginsc');
		$cpfcnpj = $this->input->post('cpfcnpj');
		$equipe = $this->input->post('equipe');
		$endereco = $this->input->post('endereco');
		$complemento = $this->input->post('complemento');
		$bairro = $this->input->post('bairro');
		$cidade = $this->input->post('cidade');
		$uf = $this->input->post('uf');
		$cep = $this->input->post('cep');
		$obs = $this->input->post('obs');
		$banco = $this->input->post('banco');
		$agencia = $this->input->post('agencia');
		$conta = $this->input->post('conta');
		$tipodeconta = $this->input->post('tipodeconta');
		$enderecoconta = $this->input->post('enderecoconta');
		$complementoconta = $this->input->post('complementoconta');
		$bairroconta = $this->input->post('bairroconta');
		$cidadeconta = $this->input->post('cidadeconta');
		$ufconta = $this->input->post('ufconta');
		$cepconta = $this->input->post('cepconta');
		$valorpadrao = $this->input->post('valorpadrao');
		
		if(!$equipe)
			$equipe = 0;
		else
			$equipe = 1;
		
		$data = array(
			'nome' => $nome,
			'apelidofantasia' => $apelidofantasia,
			'nascimentofundacao' => $this->date_br_to_default($nascimentofundacao),
			'telefone' => $telefone,
			'site' => $site,
			'funcao' => $funcao,
			'rginsc' => $rginsc,
			'cpfcnpj' => $cpfcnpj,
			'equipe' => $equipe,
			'endereco' => $endereco,
			'complemento' => $complemento,
			'bairro' => $bairro,
			'cidade' => $cidade,
			'uf' => $uf,
			'cep' => $cep,
			'obs' => $obs,
			'banco' => $banco,
			'agencia' => $agencia,
			'conta' => $conta,
			'tipodeconta' => $tipodeconta,
			'enderecoconta' => $enderecoconta,
			'complementoconta' => $complementoconta,
			'bairroconta' => $bairroconta,
			'cidadeconta' => $cidadeconta,
			'ufconta' => $ufconta,
			'cepconta' => $cepconta,
			'valorpadrao' => $valorpadrao
			);
		
		// return $data;
		$this->db->where('id', $id);
		return $this->db->update($this->database, $data);
	}
	
	public function delete($id=-1)
	{
		$this->db->delete($this->database, array('id' => $id));
		if ($this->db->affected_rows() > 0)
			return TRUE;
		return FALSE;
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
	
	public function validation()
	{
		$c = array(
			array(
				'field'=> 'nome',
				'label'=> 'Nome',
				'rules'=> 'required'
				),
			array(
				'field'=> 'funcao',
				'label'=> 'Função',
				'rules'=> 'required'
				)
			);
		return $c;
	}
	
}
?>