<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('antrian_m');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->template->load('public', 'index');
	}
	function getData()
	{
		// status antrian                   Status LOket
		// 0 = success                      0 = Tutup
		// 1 = process                      1 = process
		// 2 = waiting                      2 = Buka/waiting
		// 3 = wait/belum dipanggil
		// 4 = pending 

		//data semua loket
		$allLoket = $this->antrian_m->getAllLoked();

		// cek next
		$next = $this->antrian_m->getNext()->row();
		if ($next)
			$next = $next;
		else $next = "kosong";


		$content = array();
		foreach ($allLoket->result() as $row) {

			$content[] = $this->antrian_m->getAntrianClient([
				'counter' =>  $row->client,
				'status !=' => 4,
				'status !=' => 3,
				'status !=' => 0
			])->row();
		}
		$response = array(
			'content' => $content,
			'nextAntri' => $next,
			'loket' => $allLoket->result(),
			'jmlLoket' => $allLoket->num_rows()
		);
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
		return json_encode($response);
	}
	function setData()
	{
		$id = $this->input->post('id');
		$this->db->where([
			'id' => $id
		]);
		$this->db->update("data_antrian", [
			'status' => 1
		]);
		$b = $this->db->affected_rows();
		$status = array();
		if ($b > 0) {
			$status['status'] = 1;
		} else {
			$status['status'] = 0;
		}
		echo json_encode($status);
	}
	function add()
	{
		$data['next'] = $this->antrian_m->getLastId();
		$this->template->load('public', 'add', $data);
	}
	function addAntrian()
	{
		$data = [
			'id' => $this->input->post('id'),
			'counter' => $this->input->post('client'),
			'waktu' => time(),
			'status' => 3,
			'type' => 0
		];
		$this->antrian_m->insert($data);
		hasilCUD("Berhasil Insert Data Antrian baru");
		echo true;
	}
}
