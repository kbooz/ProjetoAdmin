<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orcamento extends CI_Controller {

	public $dados;

	public function __construct()
	{
		parent::__construct();
		$this->log->logged();
		$this->load->model (array('equipamentos','orcamentos','pessoas','orcamentodespesas','orcamentofuncionarios','orcamentoequipamentos'));
		//PhpSession usa mais espaço https://github.com/EllisLab/CodeIgniter/wiki/PHPSession
		$this->dados = $this->functions->dados();
		$this->dados['tabela'] = 'orcamento';
		$this->dados['registros'] = $this->orcamentos->count();
		
		$this->dados['set'] = array(
			'nome' => 'string',
			'idCliente' => 'foreign',
			'valor' => 'money',
			'despesa' => 'money',
			'dataentrada' => 'date',
			'datasaida' => 'date',
			'obs' => 'text'
			);
		
		$this->dados['rename'] = array(
			'idCliente' => 'Cliente',
			'valor' => 'Valor do Orçamento',
			'lucro' => 'Valor do Lucro',
			'despesa' => 'Valor Despesa',
			'dataentrada' => 'Data de Começo',
			'datasaida' => 'Data de Término',
			'obs' => 'Observações'
			);
		
		$this->form_validation->set_message('required', 'Campo "%s" não pode ser vazio');
		
		$this->form_validation->set_message('integer', 'Campo "%s" apenas permite números');
		
		$this->dados['actions'] = array('edit'=>true,'delete'=>true,'view'=>true);
		$this->form_validation->set_error_delimiters('<li>', '</li>');	
	}

	public function index()
	{
		$dados = $this->dados;
		$this->clear();
		#Configuração da Página
		$dados['page'] = 'all';
		$dados['js'] = array('jquery.dataTables.min','datatable.script');
		$dados['lista'] = $this->orcamentos->getAll();
		$dados['titulo'] = 'Lista de '.plural( humanize( $dados['tabela'] ) );
		
		$dados['columns'] = array(
			'nome' => true,
			'idCliente' => true,
			'valor' => true,
			'lucro' => true,
			'despesa' => false,
			'dataentrada' => true,
			'datasaida' => true,
			'obs' => false
			);
		
		//Transformação de idTipo para nomeTipo e data para padrão Brasileiro
		foreach ( $dados['lista'] as &$linha ) {
			$linha['idCliente'] = $this->pessoas->getName( $linha['idCliente'] );
			$linha['dataentrada'] = $this->orcamentos->date_default_to_br( $linha['dataentrada'] );
			$linha['datasaida'] = $this->orcamentos->date_default_to_br( $linha['datasaida'] );
		}
		
		$this->functions->view( $dados['page'], $dados );
	}
	
	public function add($etapa = 1)
	{
		if($etapa>3)
			$etapa=1;
		
		$dados=$this->dados;
		
		//Configurações da Página
		$dados['page'] = "orcamento/part$etapa";
		$dados['do'] = "add"; //Define se o botão é add ou edit
		$dados['titulo'] = 'Adicionar '.humanize( $dados['tabela'] );
		$dados['css']= array( 'bootstrap-timepicker.min', 'bootstrap-fileupload.min','select2','datepicker');
		
		$dados['js'] = array( 'select2.min','select2.pt-BR','date','orcamento','jquery.uniform.min', 'jquery.validate.min', 'jquery.tagsinput.min', 'jquery.autogrow-textarea', 'chosen.jquery.min', 'jquery.cookie', 'forms');
		$url = $dados['url'];
		
		if($etapa==1)
		{
			
			$dados['columns'] = array('nome','cliente','dataentrada','datasaida');
			
			//Recebe a chave estrangeira
			$dados['foreign']['data']=$this->pessoas->getByFuncao(1);		
			$dados['foreign'] = $this->functions->foreign($dados['foreign']);
			
			//validations
			$validation = array(
				array('field' => 'nome','label' => 'nome','rules' => 'required'),
				array('field' => 'cliente','label' => 'cliente','rules' => 'required'),
				array('field' => 'dataentrada','label' => 'dataentrada','rules' => 'required'),
				array('field' => 'datasaida','label' => 'datasaida','rules' => 'required|callback_compareDate'),
				);
			
			$this->form_validation->set_rules($validation);
			
			$dados['values'] = array(
				'nome' => $this->phpsession->get('nome','orcamento'),
				'cliente' => $this->phpsession->get('cliente','orcamento'),
				'dataentrada' => $this->phpsession->get('dataentrada','orcamento'),
				'datasaida' => $this->phpsession->get('datasaida','orcamento')
				);
			$dados['javascript'] = "var localurl = '$url'; var pg=1;";
			
		}
		
		if($etapa==2)
		{
			
			$dados['equipamentos']['data']=$this->equipamentos->getAll();
			$dados['equipamentos'] = $this->functions->foreign($dados['equipamentos']);
			$dados['funcionarios']['data']=$this->pessoas->getAll();
			$dados['funcionarios'] = $this->functions->foreign($dados['funcionarios']);
			$dados['javascript'] = "var localurl = '$url'; var pg=2;";
			
			$dados['lista_equipamentos'] = $this->phpsession->get('equipamentos','orcamento');
			$dados['lista_funcionarios'] = $this->phpsession->get('funcionarios','orcamento');
			$dados['lista_despesas'] = $this->phpsession->get('despesas','orcamento');
			$dados['orcamento'] = $this->phpsession->get('orcamento','orcamento');
			
			//validations
			$validation = array(
				array('field' => 'number','label' => 'number','rules' => 'integer')
				);
			
			$this->form_validation->set_rules($validation);
		}
		if($etapa==3)
		{
			
			$dados['javascript'] = "var localurl = '$url'; var pg=3;";
			$dados['orcamento'] = $this->phpsession->get('orcamento','orcamento');
			$dados['equipamentos'] = $this->phpsession->get('equipamentos','orcamento');
			$dados['funcionarios'] = $this->phpsession->get('funcionarios','orcamento');
			$dados['despesas'] = $this->phpsession->get('despesas','orcamento');
			
			$validation = array(
				array('field' => 'obs','label' => 'obs','rules' => '')
				);
			
			$this->form_validation->set_rules($validation);
		}
		
		if($this->input->post('send')=='Cancelar')
		{
			redirect($dados['tabela']);
		}
		
		if($this->input->post('back')=='Voltar')
		{
			$etapa--;
			redirect($dados['tabela']."/add"."/$etapa");
		}
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->functions->view( $dados['page'], $dados );
		}
		else
		{
			if($etapa == 1)
			{
				$orcamento = array(
					'nome' => $this->input->post('nome'),
					'cliente' => $this->input->post('cliente'),
					'dataentrada' => $this->input->post('dataentrada'),
					'datasaida' => $this->input->post('datasaida'));
				$this->phpsession->save('orcamento',$orcamento,'orcamento');
			}
			
			$etapa++;
			redirect($dados['tabela']."/add"."/$etapa");
			#$eq = humanize($this->input->post('nome'));
			#$this->session->set_flashdata(array('class'=>'success','msg'=>"O equipamento <strong>$eq</strong> foi adicionado com sucesso"));
		}
	}
	
	public function view($id=null)
	{
		$dados = $this->dados;
		$this->clear();
		$dados['orcamento'] = $this->orcamentos->getById($id);
		if($dados['orcamento']!=null)
		{

			$dados['orcamento'] = $this->functions->convertDates($dados['orcamento']);
			
			$dados['id'] = $id;
			$dados['despesas'] = $this->functions->convertDates($this->orcamentodespesas->getByIdOrc($id));
			$dados['funcionarios'] = $this->functions->convertDates($this->orcamentofuncionarios->getByIdOrc($id));
			$dados['equipamentos'] = $this->functions->convertDates($this->orcamentoequipamentos->getByIdOrc($id));
			
			
			
			//Configurações da Página
			$dados['page'] = 'orcamento/view';
			$dados['titulo'] = 'Orcamento: '.humanize( $dados['orcamento']['nome'] );
			$dados['js'] = array( 'select2.min','select2.pt-BR','date','orcamento','jquery.uniform.min', 'jquery.validate.min', 'jquery.tagsinput.min', 'jquery.autogrow-textarea', 'chosen.jquery.min', 'jquery.cookie', 'forms');
			$url = $dados['url'];
			$dados['javascript'] = "var localurl = '$url'; var pg=3;";
			
			$this->functions->view( $dados['page'], $dados );
		}
		else
		{
			$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível visualizar pois este orcamento não existe"));
			redirect($this->dados['tabela']);
		}
	}
	
	public function delete($id)
	{
		$orcamento = $this->orcamentos->getById($id);
		if($orcamento)
		{
			$nome = $orcamento['nome'];
			$this->orcamentodespesas->delete($id);
			$this->orcamentofuncionarios->delete($id);
			$this->orcamentoequipamentos->delete($id);
			$this->orcamentos->delete($id);
			
			$this->session->set_flashdata(array('class'=>'error','msg'=>"Orcamento <b>$nome</b> deletado com sucesso!"));
			redirect($this->dados['tabela']);
		}
		else
		{
			$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível deletar pois este orcamento não existe"));
			redirect($this->dados['tabela']);
		}
	}
	
	public function edit($id=0,$etapa = 1)
	{
		$aux = $this->functions->convertDates($this->orcamentos->getById($id));
		if($this->phpsession->get('orcamento','orcamento'))
		{
			$orcamento = $this->phpsession->get('orcamento','orcamento');
			if(!isset($orcamento['obs']))
			{
				$orcamento['obs'] = $aux['obs'];
			}
			if(!isset($orcamento['valor']))
			{
				$orcamento['valor'] = $aux['valor'];
			}
		}
		else
			$orcamento = $aux;
		if($orcamento)
		{
			if($etapa>3)
				$etapa=1;

			$dados=$this->dados;

			//Configurações da Página
			$dados['page'] = "orcamento/part$etapa";
			$dados['do'] = "edit"; //Define se o botão é add ou edit
			$dados['titulo'] = 'Adicionar '.humanize( $dados['tabela'] );
			$dados['css']= array( 'bootstrap-timepicker.min', 'bootstrap-fileupload.min','select2','datepicker');

			$dados['js'] = array( 'select2.min','select2.pt-BR','date','orcamentoUpdate','jquery.uniform.min', 'jquery.validate.min', 'jquery.tagsinput.min', 'jquery.autogrow-textarea', 'chosen.jquery.min', 'jquery.cookie', 'forms');
			$url = $dados['url'];


			if($etapa==1)
			{
				
				$dados['columns'] = array('nome','cliente','dataentrada','datasaida');
				
				//Recebe a chave estrangeira
				$dados['foreign']['data']=$this->pessoas->getByFuncao(1);		
				$dados['foreign'] = $this->functions->foreign($dados['foreign']);
				
				
				
				
				//validations
				$validation = array(
					array('field' => 'nome','label' => 'nome','rules' => 'required'),
					array('field' => 'cliente','label' => 'cliente','rules' => 'required'),
					array('field' => 'dataentrada','label' => 'dataentrada','rules' => 'required'),
					array('field' => 'datasaida','label' => 'datasaida','rules' => 'required|callback_compareDate'),
					);
				
				$this->form_validation->set_rules($validation);
				
				//Valores pré-definidos dos campos
				$dados['values'] = array(
					'nome' => $orcamento['nome'],
					'cliente' =>$orcamento['idCliente'],
					'dataentrada' => $orcamento['dataentrada'],
					'datasaida' => $orcamento['datasaida']
					);
				
				$dados['javascript'] = "var localurl = '$url'; var pg=1; var pid = $id";
				
			}

			if($etapa==2)
			{
				
				$dados['equipamentos']['data']=$this->equipamentos->getAll();
				$dados['equipamentos'] = $this->functions->foreign($dados['equipamentos']);
				$dados['funcionarios']['data']=$this->pessoas->getAll();
				$dados['funcionarios'] = $this->functions->foreign($dados['funcionarios']);
				$dados['javascript'] = "var localurl = '$url'; var pg=2; var pid = $id";
				
				if($this->phpsession->get('equipamentos','orcamento'))
					$dados['lista_equipamentos'] = $this->phpsession->get('equipamentos','orcamento');
				else
					$dados['lista_equipamentos'] = $this->functions->convertDates($this->orcamentoequipamentos->getByIdOrc($id));
				if($this->phpsession->get('funcionarios','orcamento'))
					$dados['lista_funcionarios'] = $this->phpsession->get('funcionarios','orcamento');
				else
					$dados['lista_funcionarios'] = $this->functions->convertDates($this->orcamentofuncionarios->getByIdOrc($id));
				if($this->phpsession->get('despesas','orcamento'))
					$dados['lista_despesas'] = $this->phpsession->get('despesas','orcamento');
				else
					$dados['lista_despesas'] = $this->functions->convertDates($this->orcamentodespesas->getByIdOrc($id));
				$dados['orcamento'] = $orcamento;
				if(isset($dados['orcamento']['idCliente']))
					$dados['orcamento']['cliente'] = $dados['orcamento']['idCliente'];
				
				//validations
				$validation = array(
					array('field' => 'number','label' => 'number','rules' => 'integer')
					);
				
				$this->form_validation->set_rules($validation);
			}
			if($etapa==3)
			{
				$dados['javascript'] = "var localurl = '$url'; var pg=3; var pid = $id";
				$dados['orcamento'] = $this->phpsession->get('orcamento','orcamento');
				$dados['orcamento']['obs'] = $orcamento['obs'];
				$dados['equipamentos'] = $this->phpsession->get('equipamentos','orcamento');
				$dados['funcionarios'] = $this->phpsession->get('funcionarios','orcamento');
				$dados['despesas'] = $this->phpsession->get('despesas','orcamento');
				
				$validation = array(
					array('field' => 'obs','label' => 'obs','rules' => '')
					);
				
				$this->form_validation->set_rules($validation);
			}

			if($this->input->post('send')=='Cancelar')
			{
				redirect($dados['tabela']);
			}

			if($this->input->post('back')=='Voltar')
			{
				$etapa--;
				redirect($dados['tabela']."/edit/$id"."/$etapa");
			}

			if ($this->form_validation->run() === FALSE)
			{
				$this->functions->view( $dados['page'], $dados );
			}
			else
			{
				if($etapa == 1)
				{
					$orcamento = array(
						'nome' => $this->input->post('nome'),
						'cliente' => $this->input->post('cliente'),
						'dataentrada' => $this->input->post('dataentrada'),
						'datasaida' => $this->input->post('datasaida'));
					$this->phpsession->save('orcamento',$orcamento,'orcamento');
				}
				
				$etapa++;
				redirect($dados['tabela']."/edit/$id"."/$etapa");
				#$eq = humanize($this->input->post('nome'));
				#$this->session->set_flashdata(array('class'=>'success','msg'=>"O equipamento <strong>$eq</strong> foi adicionado com sucesso"));
			}
		}
		else
		{
			$this->session->set_flashdata(array('class'=>'error','msg'=>"Não foi possível editar pois este orcamento não existe"));
			redirect($this->dados['tabela']);
		}
	}
	
	function compareDate()
	{
		$sd = $this->input->post('dataentrada');
		$ed = $this->input->post('datasaida');
		if($this->functions->validateDate($sd,$ed))
			return true;
		$this->form_validation->set_message('compareDate', 'A Data de Término deve ser <b>igual</b> ou <b>maior</b> a Data de Começo');
		return false;
	}
	
	public function equipamentos($id = null)
	{
		$a = $this->equipamentos->getById($id);
		echo json_encode($a);
	}
	
	public function funcionarios($id = null)
	{
		$a = $this->pessoas->getById($id);
		if(!$a['valorpadrao'])
			$a['valorpadrao'] = 0;
		echo json_encode($a);
	}
	
	public function setarrays()
	{
		$equipamentos = json_decode($_POST['equipamentos'],true);
		$funcionarios = json_decode($_POST['funcionarios'],true);
		$despesas = json_decode($_POST['despesas'],true);
		$orcamento = json_decode($_POST['orcamento'],true);
		$this->phpsession->save('equipamentos',$equipamentos,'orcamento');
		$this->phpsession->save('funcionarios',$funcionarios,'orcamento');
		$this->phpsession->save('despesas',$despesas,'orcamento');
		$this->phpsession->save('orcamento',$orcamento,'orcamento');
	}
	
	public function pushobs()
	{
		$obs = $_POST['obs'];
		$orcamento = $this->phpsession->get('orcamento','orcamento');
		$orcamento['obs'] = $obs;
		$this->phpsession->save('orcamento',$orcamento,'orcamento');
	}
	
	public function save()
	{
		$this->pushobs();
		$orcamento = $this->phpsession->get('orcamento','orcamento');
		if($orcamento!=null)
		{
			$id = $this->orcamentos->add($orcamento);
			$despesas = $this->phpsession->get('despesas','orcamento');
			$this->orcamentodespesas->add($despesas,$id);
			$equipamentos = $this->phpsession->get('equipamentos','orcamento');
			$this->orcamentoequipamentos->add($equipamentos,$id);
			$funcionarios = $this->phpsession->get('funcionarios','orcamento');
			$this->orcamentofuncionarios->add($funcionarios,$id);
			$oc = $orcamento["nome"];
			$this->session->set_flashdata(array('class'=>'success','msg'=>"O orcamento <strong>$oc</strong> foi adicionado com sucesso"));
		}
	}
	
	public function update($id)
	{
		$this->pushobs();
		$orcamento = $this->phpsession->get('orcamento','orcamento');
		if($orcamento!=null)
		{
			$this->orcamentos->update($orcamento,$id);
			$despesas = $this->phpsession->get('despesas','orcamento');
			$this->orcamentodespesas->update($despesas,$id);
			$equipamentos = $this->phpsession->get('equipamentos','orcamento');
			$this->orcamentoequipamentos->update($equipamentos,$id);
			$funcionarios = $this->phpsession->get('funcionarios','orcamento');
			$this->orcamentofuncionarios->update($funcionarios,$id);
			$oc = $orcamento["nome"];
			$this->session->set_flashdata(array('class'=>'success','msg'=>"O orcamento <strong>$oc</strong> foi atualizado com sucesso"));
		}
	}
	
	
	public function clear()
	{
		$this->phpsession->clear(null,'orcamento');
	}
	
	public function teste()
	{
		echo '<input type="submit" disabled/>';
	}
	

}

/* End of file orcamento.php */
/* Location: ./application/controllers/orcamento.php */



?>