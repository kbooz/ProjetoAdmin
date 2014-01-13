<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pessoa extends CI_Controller
{

	public $dados;

	public function __construct()
	{
		parent::__construct();
		$this->log->logged();
		$this->load->model( array( 'pessoas', 'pessoafuncoes' ) );
		$this->dados = $this->functions->dados();
		$this->dados['tabela'] = 'pessoa';
		$this->dados['registros'] = $this->pessoas->count();
		$this->dados['set']= array(
			'nascimentofundacao' => 'date',
			'funcao' => 'foreign',
			'equipe' => 'bool',
			'obs' => 'text',
			'valorpadrao' => 'money'
			);
		
		$this->dados['rename']= array(
			'nome' => 'Nome / Razão Social',
			'apelidofantasia' => 'Apelido / Nome Fantasia',
			'nascimentofundacao' => 'Data de Nascimento / Fundação',
			'funcao' => 'Função',
			'rginsc' => 'Rg / Inscrição Municipal/Federal',
			'cpfcnpj' => 'CPF/CNPJ',
			'equipe' => 'Funcionário?',
			'endereco' => 'Endereço',
			'obs' => 'Observações',
			'agencia' => 'Agência',
			'tipodeconta' => 'Tipo de Conta',
			'enderecoconta' => 'Endereço da Conta',
			'complementoconta' => 'Complemento da Conta',
			'bairroconta' => 'Bairro da Conta',
			'cidadeconta' => 'Cidade da Conta',
			'ufconta' => 'UF da Conta',
			'cepconta' => 'CEP da Conta',
			'valorpadrao' => 'Pagamento Padrão'
			);
		$this->form_validation->set_message('required', 'Campo "%s" não pode ser vazio');
		$this->form_validation->set_message('integer', 'Campo "%s" apenas permite números');
		$this->dados['actions'] = array('edit'=>true,'delete'=>true,'view'=>true);
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
		$dados['lista'] = $this->pessoas->getAll();
		$dados['titulo'] = 'Lista de '.plural( humanize( $dados['tabela'] ) );
		$dados['page'] = 'all';
		$dados['external'] = array(array(
			'href' => $this->dados['url']."/pessoafuncao",
			'class' => 'buttonBlue',
			'text' => 'Lista de Funções'
			));
		
		//Transformação de idTipo para nomeTipo e data para padrão Brasileiro
		foreach ( $dados['lista'] as &$linha ) {
			$linha['funcao'] = $this->pessoafuncoes->getName( $linha['funcao'] );
			$linha['nascimentofundacao'] = $this->pessoas->date_default_to_br( $linha['nascimentofundacao'] );
		}
		
		//Colunas que deseja mostrar
		$dados['columns'] = array(
			'nome' => TRUE,
			'apelidofantasia' => TRUE,
			'nascimentofundacao' => FALSE,
			'telefone' => FALSE,
			'site' => FALSE,
			'funcao' => FALSE,
			'rginsc' => FALSE,
			'cpfcnpj' => FALSE,
			'equipe' => TRUE,
			'endereco' => FALSE,
			'complemento' => FALSE,
			'bairro' => FALSE,
			'cidade' => FALSE,
			'uf' => TRUE,
			'cep' => FALSE,
			'obs' => FALSE,
			'banco' => FALSE,
			'agencia' => FALSE,
			'conta' => FALSE,
			'tipodeconta' => FALSE,
			'enderecoconta' => FALSE,
			'complementoconta' => FALSE,
			'bairroconta' => FALSE,
			'cidadeconta' => FALSE,
			'ufconta' => FALSE,
			'cepconta' => FALSE,
			'valorpadrao' => FALSE
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
		$dados['columns'] = $this->pessoas->columns();
		
		//Recebe a chave estrangeira
		$dados['foreign']['data']=$this->pessoafuncoes->getAll();
		
		$dados['foreign'] = $this->functions->foreign($dados['foreign']);
		

		
		//Validação da página
		$config = $this->pessoas->validation();
		$this->form_validation->set_rules( $config );
		
		if($this->input->post('send')=='Cancelar')
		{
			redirect($dados['tabela']);
		}
		
		if ($this->form_validation->run() === FALSE)
			$this->functions->view( $dados['page'], $dados );
		else
		{
			$this->pessoas->add();
			$eq = humanize($this->input->post('nome'));
			$this->session->set_flashdata(array('class'=>'success','msg'=>"O equipamento <strong>$eq</strong> foi adicionado com sucesso"));
			redirect($dados['tabela']);
		}
	}	
	
	public function delete($id=null)
	{
		
		if($id)
			$name = $this->pessoas->getName($id);
		else
			$name = false;
		$del = $this->pessoas->delete($id);
		if($del)
		{
			$this->session->set_flashdata(array('class'=>'success','msg'=>"'$name' deletada com sucesso!"));
			redirect($this->dados['tabela']);
		}
		else
		{
			if($this->db->_error_number()==1451)
				$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível deletar pois esta pessoa está sendo utilizada"));
			else
				$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível deletar pois esta pessoa não existe"));
			redirect($this->dados['tabela']);
		}
	}
	
	public function view($id=null)
	{
		$dados=$this->dados;
		//Recebe os Valores
		$dados['values']= $this->pessoas->getById($id);
		if($dados['values']!=null)
		{
			//Configurações da Página
			$dados['page'] = 'view';
			$dados['titulo'] = 'Equipamento: '.humanize( $dados['values']['nome']);
			//Converte idTipo para nomeTipo
			$dados['values']['funcao'] = $this->pessoafuncoes->getName( $dados['values']['funcao'] );
			
			
			//Converte data para formato brasileiro
			$dados['values']['nascimentofundacao'] = $this->pessoas->date_default_to_br( $dados['values']['nascimentofundacao'] );
			
			$this->functions->view( $dados['page'], $dados );
		}	
		else
		{
			$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível visualizar pois esta pessoa não existe"));
			redirect($this->dados['tabela']);
		}	
	}
	
	public function edit($id=null)
	{
		if($id)
			$name = $this->pessoas->getName($id);
		else
			$name = false;
		
		if($name)
		{
			$dados = $this->dados;
			//Recebe os Valores
			$dados['values']= $this->pessoas->getById($id);
			//Configurações da Página
			$dados['page'] = 'form';
			$dados['do'] = "edit"; //Define se o botão é add ou edit
			$this->session->set_userdata('update');
			$dados['titulo'] = 'Editar '.humanize( $dados['tabela'] ).": ".humanize( $name );
			$dados['columns'] = $this->pessoas->columns();
			$dados['css']= array( 'bootstrap-timepicker.min', 'bootstrap-fileupload.min' );
			$dados['js'] = array( 'jquery.uniform.min', 'jquery.validate.min', 'jquery.tagsinput.min', 'jquery.autogrow-textarea', 'chosen.jquery.min', 'jquery.cookie', 'forms' ,'date','script');
			
			//Recebe a chave estrangeira
			$dados['foreign']['data']=$this->pessoafuncoes->getAll();
			
			$dados['foreign'] = $this->functions->foreign($dados['foreign']);
			
			
			//Tratamento dos valores
			$dados['values']['dataentrada'] = $this->pessoas->date_default_to_br($dados['values']['dataentrada']);
			$dados['values']['datasaida'] = $this->pessoas->date_default_to_br($dados['values']['datasaida']);
			
			
			//Validação da página
			$config = $this->pessoas->validation();
			$this->form_validation->set_rules( $config );
			
			if($this->input->post('send')=='Cancelar')
			{
				redirect($dados['tabela']);
			}
			
			if ($this->form_validation->run() === FALSE)
				$this->functions->view( $dados['page'], $dados );
			else
			{
				$this->pessoas->update($id);
				$eq = humanize($name);
				$this->session->set_flashdata(array('class'=>'success','msg'=>"<strong>$eq</strong> foi editada com sucesso"));
				redirect($dados['tabela']);
			}
		}
		else
		{
			$this->session->set_flashdata(array('class'=>'error','msg'=>"Não é possível editar pois esta pessoa não existe"));
			redirect($this->dados['tabela']);
		}
	}	
	
}


?>