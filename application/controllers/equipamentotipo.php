<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class EquipamentoTipo extends CI_Controller
{

	public $dados;

	public function __construct()
	{
		parent::__construct();
		$this->log->logged();
		$this->load->model('equipamentotipos');
		$this->dados = $this->functions->dados();
		$this->dados['tabela'] = 'equipamentotipo';
		$this->dados['altertable'] = 'tipo de equipamento';
		$this->dados['registros'] = $this->equipamentotipos->count();
		$this->form_validation->set_message('required', 'Campo "%s" não pode ser vazio');
		$this->dados['set']= array(
			'nome' => 'string'
			);
		$this->dados['actions'] = array('edit'=>true,'delete'=>true,'view'=>false);
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		
	}
	
	public function page( $pg, $d){
		$this->load->view( 'template/header', $d );
		$this->load->view( $pg, $d );
		$this->load->view( 'template/footer', $d );
	}

	public function index()
	{
		$dados = $this->dados;	
		//Configuração da página	
		$dados['js'] = array('jquery.dataTables.min','datatable.script');
		$dados['lista'] = $this->equipamentotipos->getAll();
		$dados['titulo'] = 'Lista de Tipos de Equipamento';
		$dados['page'] = 'all';
		$dados['external'] = array(array(
				'href' => $dados['url']."/equipamento",
				'class' => 'buttonBlue',
				'text' => 'Lista de Equipamentos'
			));
		
		//Colunas que deseja mostrar
		$dados['columns'] = array(
			'nome' => true,
			);
		// $dados['colunas'] = array( 'nome', 'tipo' );
		$this->functions->view( $dados['page'], $dados );
	}

	public function add()
	{
		$dados=$this->dados;
		
		//Configurações da Página
		$dados['page'] = 'form';
		$dados['do'] = "add"; //Define se o botão é add ou edit
		$dados['titulo'] = 'Adicionar Tipo de Equipamento';
		$dados['css']= array( 'bootstrap-timepicker.min', 'bootstrap-fileupload.min' );
		$dados['js'] = array( 'jquery.uniform.min', 'jquery.validate.min', 'jquery.tagsinput.min', 'jquery.autogrow-textarea', 'chosen.jquery.min', 'jquery.cookie', 'forms' ,'date','script');
		$dados['columns'] = $this->equipamentotipos->columns();
		

		
		//Validação da página
		$config = $this->equipamentotipos->validation();
		$this->form_validation->set_rules( $config );
		
		if($this->input->post('send')=='Cancelar')
		{
			redirect($dados['tabela']);
		}
		
		if ($this->form_validation->run() === FALSE)
			$this->functions->view( $dados['page'], $dados );
		else
		{
			$this->equipamentotipos->add();
			$eq = humanize($this->input->post('nome'));
			$this->session->set_flashdata(array('class'=>'success','msg'=>"O tipo de equipamento <strong>$eq</strong> foi adicionado com sucesso"));
			redirect($dados['tabela']);
		}
	}
	
	public function delete($id=null)
	{
		if($id)
			$name = $this->equipamentotipos->getName($id);
		else
			$name = false;
		$del = $this->equipamentotipos->delete($id);
		if($del)
		{
			$this->session->set_flashdata(array('class'=>'success','msg'=>"Tipo '$name' deletado com sucesso!"));
			redirect($this->dados['tabela']);
		}
		else
		{
			if($this->db->_error_number()==1451)
				$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível deletar pois este tipo está sendo utilizado"));
			else
				$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível deletar pois este tipo não existe"));
			redirect($this->dados['tabela']);
		}
	}
	
	public function edit($id=null)
	{
		if($id)
			$name = $this->equipamentotipos->getName($id);
		else
			$name = false;
		
		if($name)
		{
			$dados = $this->dados;
			//Recebe os Valores
			$dados['values']= $this->equipamentotipos->getById($id);
			//Configurações da Página
			$dados['page'] = 'form';
			$dados['do'] = "edit"; //Define se o botão é add ou edit
			$this->session->set_userdata('update');
			$dados['titulo'] = "Editar Tipo de Equipamento : ".humanize( $name );
			$dados['columns'] = $this->equipamentotipos->columns();
			$dados['js'] = array( 'jquery.uniform.min', 'jquery.validate.min', 'jquery.tagsinput.min', 'jquery.autogrow-textarea', 'chosen.jquery.min', 'jquery.cookie', 'forms' ,'date','script');
			
						
			//Validação da página
			$config = $this->equipamentotipos->validation();
			$this->form_validation->set_rules( $config );
			
			if($this->input->post('send')=='Cancelar')
			{
				redirect($dados['tabela']);
			}
			
			if ($this->form_validation->run() === FALSE)
				$this->functions->view( $dados['page'], $dados );
			else
			{
				$this->equipamentotipos->update($id);
				$eq = humanize($name);
				$this->session->set_flashdata(array('class'=>'success','msg'=>"O equipamento <strong>$eq</strong> foi editado com sucesso"));
				redirect($dados['tabela']);
			}
		}
		else
		{
			$this->session->set_flashdata(array('class'=>'error','msg'=>"Não é possível editar pois este equipamento não existe"));
			redirect($this->dados['tabela']);
		}
	}

}
?>