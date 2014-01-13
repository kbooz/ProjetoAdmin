<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	function index()
	{
		if($this->log->needLogin())
			redirect('main');
		
		$this->form_validation->set_rules('username', 'Usuário', 'required');
		$this->form_validation->set_rules('password', 'Senha', 'required');
		$this->form_validation->set_error_delimiters("","");
		$this->form_validation->set_message('required', '<b>%s</b> não pode ser vazio');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('login');
		}

		else {
			$query = $this->log->validate($this->input->post('username'),$this->input->post('password'));
			if($query)
			{
				$data = array('logged'=>true,'user'=>$this->input->post('username'));
				$this->session->set_userdata($data);
				redirect('main');
			}
			else
			{
				$this->session->set_flashdata('msg','<b>Usuário</b> ou <b>Senha</b> incorretos');
				redirect('login');
			}
		}
	}

	function logout()
	{
		$this->log->logout();
	}


	public function add ($user = null,$password = null,$status = null,$grupo = null)
	{
		
		if($user and $password and $status and $grupo)
		{
			$this->log->add($user,$password,$status,$grupo);
			echo "added: $user,$password,$status,$grupo";
		}
		else
			echo 'a';
	}

	}
?>