<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->load->model('visitor_m');
		$dt = $this->visitor_m->getVisitor()->result_array();
		$this->template->load('admin', 'user/dashboard', $this->data);
	}

	function getLog()
	{
		$this->data['log'] = $this->log_model->getId()->result_array();
		$this->template->load('admin', 'user/log/test', $this->data);
	}
	function profile()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Full Name', 'required|trim');
		$this->form_validation->set_rules('tentang_saya', 'Tentang Saya', 'required|trim');

		if ($this->form_validation->run() == false) {

			$this->data['page']['title'] = 'Profile User';
			$this->data['page']['description'] = 'Silahkan lihat data profile anda, dan ubah jika ada yang tidak sesuai dengan anda, </br> Inggat data harus real.!';
			// $this->data['page']['before'] = ['url' => base_url('admin/menu'), "title" => "Menu Access"];
			$this->data['page']['submenu'] = 'Profile User';


			$this->template->load('admin', 'user/profile/index', $this->data);
		} else {

			$upload_image = $_FILES['image']['name'];

			$img = $this->data['user']['image'];
			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']      = '2048';
				$config['upload_path'] = './assets/img/profile/';
				$this->load->library('upload', $config);

				if ($this->upload->do_upload('image')) {
					if (is_file(FCPATH . 'assets/img/profile/' . $img)) {
						unlink(FCPATH . 'assets/img/profile/' . $img);
						unlink(FCPATH . 'assets/img/thumbnail/profile_' . $img);
					}
					$img = $this->upload->data('file_name');
					$this->_create_thumbs($img);
				} else {
					echo $this->upload->display_errors();
				}
			}
			$data = [
				'image' => $img,
				'no_hp' => htmlspecialchars($this->input->post('no_hp')),
				'tentang_saya' => htmlspecialchars($this->input->post('tentang_saya')),
				'name' => htmlspecialchars($this->input->post('name')),
				'alamat' => htmlspecialchars($this->input->post('alamat')),
				'tgl_lahir' => strtotime($this->input->post('tgl_lahir'))
			];
			$this->user_model->update($data);
			hasilCUD("Data Berhasil di Ubah");
			header("Refresh:0");
		}
	}
	function edit()
	{
		if ($this->session->userdata('role_id') == 1) {
			redirect('admin/admin');
		}
		$this->data['form_action'] = base_url('admin/user/edit');
		$this->load->library('form_validation');
		$this->data['page']['title'] = 'Edit Profile';
		$this->form_validation->set_rules('name', 'Full Name', 'required|trim');
		$this->form_validation->set_rules('tentang_saya', 'Tentang Saya', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->template->load('admin', 'admin/edit_user', $this->data);
		} else {
			$name = htmlspecialchars($this->input->post('name'));
			$email = $this->input->post('email');

			// cek jika ada gambar yang akan diupload
			$upload_image = $_FILES['img_profile']['name'];

			$new_image = $this->data['user']['image'];
			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']      = '2048';
				$config['upload_path'] = './assets/img/profile/';
				$this->load->library('upload', $config);

				if ($this->upload->do_upload('img_profile')) {
					unlink(FCPATH . 'assets/img/profile/' . $new_image);
					unlink(FCPATH . 'assets/img/thumbnail/profile_' . $new_image);
					$new_image = $this->upload->data('file_name');
					$this->_create_thumbs($new_image);
				} else {
					echo $this->upload->display_errors();
				}
			}
			$data = [
				'name' => $name,
				'tentang_saya' => $this->input->post('tentang_saya'),
				'image' => $new_image
			];
			$this->user_model->update($data);
			hasilCUD("Data erhasil di Ubah");
			redirect('admin/user');
		}
	}
	function changepassword()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('newPassword', 'Password', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('password', 'Repeat Password', 'trim|required|min_length[3]|matches[newPassword]');

		if ($this->form_validation->run() == false) {
			$this->data['page']['title'] = 'Mengganti Password';
			$this->data['page']['description'] = 'Silahkan ubah password lama anda, gunakan karakter yang susah di tebak.!';
			// $this->data['page']['before'] = ['url' => base_url('admin/menu'), "title" => "Menu Access"];
			$this->data['page']['submenu'] = 'Ganti password';
			$this->template->load('admin', 'user/profile/changepassword', $this->data);
		} else {
			$oldPassword = $this->input->post('oldPassword');
			// cek kebenran password lama
			if (password_verify($oldPassword, $this->data['user']['password'])) {
				$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				$email = $this->session->userdata('email');
				$this->db->set('password', $password);
				$this->db->where('email', $email);
				$this->db->update('tbl_user');
				if ($this->db->affected_rows() > 0) {
					$this->session->unset_userdata('email');
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed! Please login.</div>');
					redirect('admin/auth');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal.!</div>');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password lama tidak cocok.!</div>');
				redirect('admin/user/changepassword');
			}
		}
	}



	public function laporan_pdf()
	{
		$this->load->model('publikasi_model', 'publikasi');
		$this->load->model('pendidikan_model', 'pendd');
		$this->load->model('jabatan_model', 'jabatan');
		$this->load->model('pelatihan_model', 'pelatihan');

		$this->data['get_publikasi'] = $this->publikasi->getId()->result_array();
		$this->data['get_jabatan'] = $this->jabatan->getId()->result_array();
		$this->data['get_pelatihan'] = $this->pelatihan->getId()->result_array();
		$this->data['get_pendd'] = $this->pendd->getId([
			'pendd_user.user_id' => $this->data['user']['id']
		])->result_array();

		$this->load->library('pdf');

		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = "laporan-petanikode.pdf";

		$html = $this->load->view('index2', $this->data);
		// $this->pdf->load_html($html);
		// $this->pdf->render();
		// $this->pdf->stream($this->pdf->filename, array("Attachment" => false));
	}
	function _create_thumbs($file_name)
	{
		// Image resizing config
		$config = array(
			// Large Image
			// array(
			//     'image_library' => 'GD2',
			//     'source_image'  => './assets/images/' . $file_name,
			//     'maintain_ratio' => FALSE,
			//     'width'         => 700,
			//     'height'        => 467,
			//     'new_image'     => './assets/images/large/' . $file_name
			// ),
			// Medium Image
			// array(
			//     'image_library' => 'GD2',
			//     'source_image'  => './assets/images/' . $file_name,
			//     'maintain_ratio' => FALSE,
			//     'width'         => 600,
			//     'height'        => 400,
			//     'new_image'     => './assets/images/medium/' . $file_name
			// ),
			// Small Image
			array(
				'image_library' => 'GD2',
				'source_image'  => './assets/img/profile/' . $file_name,
				'maintain_ratio' => FALSE,
				'width'         => 100,
				'height'        => 100,
				'new_image'     => './assets/img/thumbnail/profile_' . $file_name
			)
		);

		$this->load->library('image_lib', $config[0]);
		foreach ($config as $item) {
			$this->image_lib->initialize($item);
			if (!$this->image_lib->resize()) {
				return false;
			}
			$this->image_lib->clear();
		}
	}
	function notif()
	{
		$this->template->load('admin', 'admin/notif', $this->data);
	}
	function notif_action()
	{
		$link = 'admin/notif';
		$this->data['get_notif'] =  $this->notif_model->getId()->row_array();
		$read = $this->notif_model->read();
		$this->template->load('admin', 'admin/notif_action', $this->data);
	}

	function ad()
	{
		$this->load->model('pendidikan_model', 'pendd');
		$this->data['all_pendd'] = $this->pendd->get()->result_array();

		$where = [
			'pendd_user.user_id' => $this->data['user']['id']
		];
		$this->data['get_pendd'] = $this->pendd->getId($where)->result_array();

		$this->load->library('form_validation');
		if ($this->input->post('name_univ') || $this->input->post('name_univ')) {
			$this->form_validation->set_rules('name_univ', 'Name_univ', 'trim|required');
			$this->form_validation->set_rules('name_prodi', 'Name_prodi', 'trim|required');
		} else {
			$this->form_validation->set_rules('id_univ', 'idUniv', 'trim|required');
			$this->form_validation->set_rules('id_prodi', 'idProdi', 'trim|required');
		}
		$this->form_validation->set_rules('tahun_lulus', 'Tahun_lulus', 'trim|required');
		$this->form_validation->set_rules('id_pendd', 'Id_pendd', 'trim|required');
		$this->form_validation->set_rules('tahun_masuk', 'Tahun_Masuk', 'trim|required');
		if ($this->form_validation->run()) {
			echo 86876;
		} else {
			$this->template->load('admin', 'user/test', $this->data);
		}
	}
	function blocked()
	{ }
	function log()
	{ }
}
