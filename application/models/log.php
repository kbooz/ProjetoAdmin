<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Log extends CI_Model
{
	#Também funciona como passador de dados padrão
	
	public $database = 'user';
	
	
	public function validate($user,$pass)
	{
		$pass = md5($pass);
		$data = array(
			'user'=> $user,
			'senha'=> $pass,
			'status' => 1
			);
		
		$query= $this->db->get_where($this->database, $data)->result_array();
		
		if(count($query)>0)
			return true;
		return false;
	}

	public function logged()
	{
		$logged = $this->session->userdata('logged');


		if (!isset($logged) || $logged != true) {
			redirect('login');
		}
	}
	
	public function needLogin()
	{
		$logged = $this->session->userdata('logged');


		if ($logged == true) {
			return true;
		}
		return false;
	}
	
	public function add($user,$password,$status,$grupo)
	{
		$password = md5($password);
		$data = array(
			'user'=>$user,
			'senha'=>$password,
			'status'=>$status,
			'grupo'=>$grupo
			);
		return $this->db->insert($this->database, $data);
	}
	
	public function returnGroup($user)
	{
		
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
}

/* End of file log.php */
/* Location: ./application/models/log.php */

?>