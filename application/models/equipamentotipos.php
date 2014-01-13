<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class EquipamentoTipos extends CI_Model
{
	public $query;
	public $database = 'equipamento_tipo';
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

	public function getName($id)
	{
		$this->db->where('id',$id);
		$this->query = $this->db->get($this->database);
		$tipo = $this->query->result_array();
		if ($tipo[0]) {
			return $tipo[0]['nome'];
		}
		return false;
	}
	
	public function add()
	{
		$nome = $this->input->post('nome');
		$data = array('nome'=>$nome);
		return $this->db->insert($this->database, $data);
	}
	
	public function update($id)
	{
		$nome = $this->input->post('nome');
		$data = array('nome'=>$nome);
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
	
	public function validation()
	{
		$c = array(
			array(
				'field'=> 'nome',
				'label'=> 'Nome',
				'rules'=> 'required'
				)
		);
		return $c;
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
	

	
}
/* End of file equipamentotipos.php */
/* Location: ./application/models/equipamentotipos.php */
	?>