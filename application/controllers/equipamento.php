<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Equipamento extends CI_Controller
{

	public $dados;

	public function __construct()
	{
		parent::__construct();
		$this->log->logged();
		$this->load->model( array( 'equipamentos', 'equipamentotipos' ) );
		$this->dados = $this->functions->dados();
		$this->dados['tabela'] = 'equipamento';
		$this->dados['registros'] = $this->equipamentos->count();
		$this->dados['set']= array(
			'nome' => 'string',
			'tipo' => 'foreign',
			'valor' => 'money',
			'proprio' => 'bool',
			'aluguel' => 'money',
			'dataentrada' => 'date',
			'datasaida' => 'date',
			'obs' => 'text'
			);
		
		$this->dados['rename']= array(
			'tipo' => 'Tipo do equipamento',
			'valor' => 'Valor do equipamento',
			'aluguel' => 'Valor de aluguel do equipamento',
			'proprio' => 'Equipamento próprio da empresa',
			'dataentrada' => 'Data de Entrada',
			'datasaida' => 'Data de Saída',
			'obs' => 'Observação'
			);
		$this->form_validation->set_message('required', 'Campo "%s" não pode ser vazio');
		$this->form_validation->set_message('integer', 'Campo "%s" apenas permite números');
		$this->dados['actions'] = array('edit'=>true,'delete'=>true,'view'=>true);
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		
		
	}
	
	
	public function index()
	{
		$dados = $this->dados;	
		//Configuração da página	
		$dados['js'] = array('jquery.dataTables.min','datatable.script');
		$dados['lista'] = $this->equipamentos->getAll();
		$dados['titulo'] = 'Lista de '.plural( humanize( $dados['tabela'] ) );
		$dados['page'] = 'all';
		$dados['external'] = array(array(
				'href' => $dados['url']."/equipamentotipo",
				'class' => 'buttonBlue',
				'text' => 'Tipos de Equipamentos'
			));
		
		//Transformação de idTipo para nomeTipo e data para padrão Brasileiro
		foreach ( $dados['lista'] as &$linha ) {
			$linha['tipo'] = $this->equipamentotipos->getName( $linha['tipo'] );
			$linha['dataentrada'] = $this->equipamentos->date_default_to_br( $linha['dataentrada'] );
			$linha['datasaida'] = $this->equipamentos->date_default_to_br( $linha['datasaida'] );
		}
		
		//Colunas que deseja mostrar
		$dados['columns'] = array(
			'nome' => true,
			'tipo' => true,
			'valor' => true,
			'proprio' => false,
			'aluguel' => true,
			'dataentrada' => false,
			'datasaida' => false,
			'obs' => false
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
		$dados['titulo'] = 'Adicionar '.humanize( $dados['tabela'] );
		$dados['css']= array( 'bootstrap-timepicker.min', 'bootstrap-fileupload.min' );
		$dados['js'] = array( 'jquery.uniform.min', 'jquery.validate.min', 'jquery.tagsinput.min', 'jquery.autogrow-textarea', 'chosen.jquery.min', 'jquery.cookie', 'forms' ,'date','script');
		$dados['columns'] = $this->equipamentos->columns();
		
		//Recebe a chave estrangeira
		$dados['foreign']['data']=$this->equipamentotipos->getAll();
		
		$dados['foreign'] = $this->functions->foreign($dados['foreign']);
		
		//Validação da página
		$config = $this->equipamentos->validation();
		$this->form_validation->set_rules( $config );
		
		if($this->input->post('send')=='Cancelar')
		{
			redirect($dados['tabela']);
		}
		
		if ($this->form_validation->run() === FALSE)
			$this->functions->view( $dados['page'], $dados );
		else
		{
			$this->equipamentos->add();
			$eq = humanize($this->input->post('nome'));
			$this->session->set_flashdata(array('class'=>'success','msg'=>"O equipamento <strong>$eq</strong> foi adicionado com sucesso"));
			redirect($dados['tabela']);
		}
	}
	
	public function delete($id=null)
	{
		
		if($id)
			$name = $this->equipamentos->getName($id);
		else
			$name = false;
		$del = $this->equipamentos->delete($id);
		if($del)
		{
			$this->session->set_flashdata(array('class'=>'success','msg'=>"Equipamento '$name' deletado com sucesso!"));
			redirect($this->dados['tabela']);
		}
		else
		{
			if($this->db->_error_number()==1451)
				$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível deletar pois este equipamento está sendo utilizado"));
			else
				$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível deletar pois este equipamento não existe"));
			redirect($this->dados['tabela']);
		}
	}
	
	public function view($id=null)
	{
		$dados=$this->dados;
		//Recebe os Valores
		$dados['values']= $this->equipamentos->getById($id);
		if($dados['values']!=null)
		{
			//Configurações da Página
			$dados['page'] = 'view';
			$dados['titulo'] = 'Equipamento: '.humanize( $dados['values']['nome'] );
			//Converte idTipo para nomeTipo
			$dados['values']['tipo'] = $this->equipamentotipos->getName( $dados['values']['tipo'] );
			
			
			//Converte data para formato brasileiro
			$dados['values']['dataentrada'] = $this->equipamentos->date_default_to_br( $dados['values']['dataentrada'] );
			$dados['values']['datasaida'] = $this->equipamentos->date_default_to_br( $dados['values']['datasaida'] );
			
			$this->functions->view( $dados['page'], $dados );	
		}
			
		else
		{
			$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível visualizar pois este equipamento não existe"));
			redirect($this->dados['tabela']);
		}
			
	}
	
	public function edit($id=null)
	{
		if($id)
			$name = $this->equipamentos->getName($id);
		else
			$name = false;
		
		if($name)
		{
			$dados = $this->dados;
			//Recebe os Valores
			$dados['values']= $this->equipamentos->getById($id);
			//Configurações da Página
			$dados['page'] = 'form';
			$dados['do'] = "edit"; //Define se o botão é add ou edit
			$this->session->set_userdata('update');
			$dados['titulo'] = 'Editar '.humanize( $dados['tabela'] ).": ".humanize( $name );
			$dados['columns'] = $this->equipamentos->columns();
			$dados['css']= array( 'bootstrap-timepicker.min', 'bootstrap-fileupload.min' );
			$dados['js'] = array( 'jquery.uniform.min', 'jquery.validate.min', 'jquery.tagsinput.min', 'jquery.autogrow-textarea', 'chosen.jquery.min', 'jquery.cookie', 'forms','script');
			
			//Recebe a chave estrangeira
			$dados['foreign']['data']=$this->equipamentotipos->getAll();
			
			$dados['foreign'] = $this->functions->foreign($dados['foreign']);
			
			//Tratamento dos valores
			$dados['values']['dataentrada'] = $this->equipamentos->date_default_to_br($dados['values']['dataentrada']);
			$dados['values']['datasaida'] = $this->equipamentos->date_default_to_br($dados['values']['datasaida']);
			
			
			//Validação da página
			$config = $this->equipamentos->validation();
			$this->form_validation->set_rules( $config );
			
			if($this->input->post('send')=='Cancelar')
			{
				redirect($dados['tabela']);
			}
			
			if ($this->form_validation->run() === FALSE)
				$this->functions->view( $dados['page'], $dados );
			else
			{
				$this->equipamentos->update($id);
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
