<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    /**
     *  data ke tampilan view
     */
    public $data;


    public $time_lock;

    /**
     * Constructor 
     */
    function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        parent::__construct();
        $this->apply_setting();
    }


    function apply_setting()
    {
        // set Class
        // set method
        // set id1
        // set id2
        $folder = APPPATH . "controllers/";
        for ($i = 1; $i < 7; $i++) {
            for ($a = $i; $a <= $i; $a++) {
                $class = $folder . ucwords($this->uri->segment($i)) . ".php";
                if (file_exists($class)) {
                    $this->data['page'] = [
                        'url' => 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"],
                        'class' => ucwords($this->uri->segment($i)),
                        'method' =>  $this->uri->segment($i + 1),
                        'id' => $this->uri->segment($i + 2),
                        'id2' => $this->uri->segment($i + 3),
                        'description' => "Ini adalah Description Default, Selamat datang.!",
                        'submenu' => "Ini Adalah contoh Menu active",
                        'before' => [],
                        'title' => "Controller  " . $this->uri->segment($i) . ", Dengan Method " . $this->uri->segment($i + 1)
                    ];
                    break;
                } else {
                    $folder .= $this->uri->segment($i) . "/";
                }
            }
        }
    }
}


/**
 *
 * Admin Controller
 */
class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $email = $this->session->userdata('email');
        $role_id = $this->session->userdata('role_id');

        $this->load->helper('my_helper');

        if (!$this->session->userdata('email')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-with-icon" data-notify="container"><i class="fa fa-volume-up" data-notify="icon"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle"></i></button><span data-notify="message">Menu yang anda akses sebelumnya dilarang!</span></div>');
            redirect('admin/auth');
        }

        // setting role
        $this->load->model('admin/menu_m');
        $this->data['menu_all'] = $this->menu_m->getMenuRoleId()->result_array();

        $hak_akses = $this->menu_m->role()->num_rows();
        // die(var_dump($hak_akses));
        if ($hak_akses > 0) {
            $url = $this->data['page']['url'];
            $this->session->set_userdata('url', $url);
            if (time() >= (int) $this->session->userdata('time')) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-with-icon" data-notify="container"><i class="fa fa-volume-up" data-notify="icon"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle"></i></button><span data-notify="message">Menu yang anda akses sebelumnya dilarang!</span></div>');
                redirect('admin/auth/lock');
            }
        } else {
            redirect('admin/user/blocked');
        }

        $this->load->model('user_model');
        $this->data['user'] = $this->user_model->getUser($this->session->userdata('email'))->row_array();
    }
}
