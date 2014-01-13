<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Equipamentos extends CI_Model
{
	public $query;
	public $database = 'equipamento';
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
		$tipo = $this->input->post('tipo');
		$valor = $this->input->post('valor');
		$aluguel = $this->input->post('aluguel');
		$proprio = $this->input->post('proprio');
		if(!$proprio)
			$proprio = 0;
		else
			$proprio = 1;
		
		$de = $this->input->post('dataentrada');
		$ds = $this->input->post('datasaida');
		$obs = $this->input->post('obs');
		
		$data = array(
			'nome' => $nome,
			'tipo' => $tipo,
			'valor' => $valor,
			'proprio' => $proprio,
			'aluguel' => $aluguel,
			'dataentrada' => $this->date_br_to_default($de),
			'datasaida' => $this->date_br_to_default($ds),
			'obs' => $obs
			);
		
		// return $data;
		return $this->db->insert($this->database, $data);
	}
	
	public function update($id)
	{
		$nome = $this->input->post('nome');
		$tipo = $this->input->post('tipo');
		$valor = $this->input->post('valor');
		$aluguel = $this->input->post('aluguel');
		$proprio = $this->input->post('proprio');
		if(!$proprio)
			$proprio = 0;
		else
			$proprio = 1;
		
		$de = $this->input->post('dataentrada');
		$ds = $this->input->post('datasaida');
		$obs = $this->input->post('obs');
		
		$data = array(
			'nome' => $nome,
			'tipo' => $tipo,
			'valor' => $valor,
			'proprio' => $proprio,
			'aluguel' => $aluguel,
			'dataentrada' => $this->date_br_to_default($de),
			'datasaida' => $this->date_br_to_default($ds),
			'obs' => $obs
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
				'field'=> 'tipo',
				'label'=> 'Tipo',
				'rules'=> 'required'
				),
			array(
				'field'=> 'valor',
				'label'=> 'Valor',
				'rules'=> 'integer'
				),
			array(
				'field'=> 'proprio',
				'label'=> 'Proprio',
				'rules'=> ''
				),
			array(
				'field'=> 'aluguel',
				'label'=> 'Aluguel',
				'rules'=> 'integer'
				),
			array(
				'field'=> 'dataentrada',
				'label'=> 'DataEntrada',
				'rules'=> ''
				),
			array(
				'field'=> 'datasaida',
				'label'=> 'DataSaida',
				'rules'=> ''
				),
			array(
				'field'=> 'obs',
				'label'=> 'Obs',
				'rules'=> ''
				)
			);
		return $c;
	}
	
}

/* End of file equipamentos.php */
/* Location: ./application/models/equipamentos.php */
?>