<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orcamentos extends CI_Model {

	public $query;
	public $database = 'orcamento';
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
	
	public function add($orcamento)
	{
		
		$data = array(
			'nome' => $orcamento['nome'],
			'idCliente' => $orcamento['cliente'],
			'valor' => $orcamento['valor'],
			'despesa' => $orcamento['despesa'],
			'lucro' => $orcamento['lucro'],
			'dataentrada' => $this->date_br_to_default($orcamento['dataentrada']),
			'datasaida' => $this->date_br_to_default($orcamento['datasaida']),
			'obs' => $orcamento['obs']
			);
		
		$this->db->insert($this->database, $data);
		return $this->db->insert_id();
	}
	
	public function update($orcamento,$id)
	{
		$orcamento['id'] = $id;
		$data = array(
			'nome' => $orcamento['nome'],
			'idCliente' => $orcamento['cliente'],
			'valor' => $orcamento['valor'],
			'despesa' => $orcamento['despesa'],
			'lucro' => $orcamento['lucro'],
			'dataentrada' => $this->date_br_to_default($orcamento['dataentrada']),
			'datasaida' => $this->date_br_to_default($orcamento['datasaida']),
			'obs' => $orcamento['obs']
			);
		
		$this->db->where('id', $id);
		return $this->db->update($this->database, $data);
	}
	
	
	public function getById($id=null)
	{
		$query= $this->db->get_where($this->database, array('id =' => $id))->result_array();
		return $query[0];
	}
	
	public function columns()
	{
		return $this->query->list_fields();
	}

	public function count()
	{
		return $this->db->count_all($this->database);
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
	
	public function delete($id)
	{
		$this->db->delete($this->database, array('id' => $id));
	}

}

/* End of file orcamentos.php */
/* Location: ./application/models/orcamentos.php */