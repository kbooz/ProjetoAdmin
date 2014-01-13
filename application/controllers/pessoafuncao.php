<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PessoaFuncao extends CI_Controller
{

	public $dados;

	public function __construct()
	{
		parent::__construct();
		$this->log->logged();
		$this->load->model('pessoafuncoes');
		$this->dados = $this->functions->dados();
		$this->dados['tabela'] = 'pessoafuncao';
		$this->dados['altertable'] = 'função';
		$this->dados['registros'] = $this->pessoafuncoes->count();
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
		$dados['lista'] = $this->pessoafuncoes->getAll();
		$dados['titulo'] = 'Lista de Funções';
		$dados['page'] = 'all';
		$dados['external'] = array(array(
				'href' => $dados['url']."/pessoa",
				'class' => 'buttonBlue',
				'text' => 'Lista de Pessoas'
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
		$dados['titulo'] = 'Adicionar '.humanize( $dados['altertable'] );
		$dados['css']= array( 'bootstrap-timepicker.min', 'bootstrap-fileupload.min' );
		$dados['js'] = array( 'jquery.uniform.min', 'jquery.validate.min', 'jquery.tagsinput.min', 'jquery.autogrow-textarea', 'chosen.jquery.min', 'jquery.cookie', 'forms' ,'date','script');
		$dados['columns'] = $this->pessoafuncoes->columns();
		

		
		//Validação da página
		$config = $this->pessoafuncoes->validation();
		$this->form_validation->set_rules( $config );
		
		if($this->input->post('send')=='Cancelar')
		{
			redirect($dados['tabela']);
		}
		
		if ($this->form_validation->run() === FALSE)
			$this->functions->view( $dados['page'], $dados );
		else
		{
			$this->pessoafuncoes->add();
			$eq = humanize($this->input->post('nome'));
			$this->session->set_flashdata(array('class'=>'success','msg'=>"A função <strong>$eq</strong> foi adicionada com sucesso"));
			redirect($dados['tabela']);
		}
	}	


	
	public function delete($id=null)
	{
		if($id)
			$name = $this->pessoafuncoes->getName($id);
		else
			$name = false;
		$del = $this->pessoafuncoes->delete($id);
		if($del)
		{
			$this->session->set_flashdata(array('class'=>'success','msg'=>"A função '$name' deletada com sucesso!"));
			redirect($this->dados['tabela']);
		}
		else
		{
			if($this->db->_error_number()==1451)
				$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível deletar pois esta função está sendo utilizada"));
			else
				$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível deletar pois esta função não existe"));
			redirect($this->dados['tabela']);
		}
	}
	
	public function edit($id=null)
	{
		if($id)
			$name = $this->pessoafuncoes->getName($id);
		else
			$name = false;
		
		if($name)
		{
			$dados = $this->dados;
			//Recebe os Valores
			$dados['values']= $this->pessoafuncoes->getById($id);
			//Configurações da Página
			$dados['page'] = 'form';
			$dados['do'] = "edit"; //Define se o botão é add ou edit
			$this->session->set_userdata('update');
			$dados['titulo'] = "Editar Função : ".humanize( $name );
			$dados['columns'] = $this->pessoafuncoes->columns();
			$dados['js'] = array( 'jquery.uniform.min', 'forms' , 'date' );
			
						
			//Validação da página
			$config = $this->pessoafuncoes->validation();
			$this->form_validation->set_rules( $config );
			
			if($this->input->post('send')=='Cancelar')
			{
				redirect($dados['tabela']);
			}
			
			if ($this->form_validation->run() === FALSE)
				$this->functions->view( $dados['page'], $dados );
			else
			{
				$this->pessoafuncoes->update($id);
				$eq = humanize($name);
				$this->session->set_flashdata(array('class'=>'success','msg'=>"A função <strong>$eq</strong> foi editada com sucesso"));
				redirect($dados['tabela']);
			}
		}
		else
		{
			$this->session->set_flashdata(array('class'=>'error','msg'=>"Não é possível editar pois esta função não existe"));
			redirect($this->dados['tabela']);
		}
	}

}


?>