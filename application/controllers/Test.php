<?php
class Test  extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('template');
    }
    function index()
    {
        $data['nama'] = "Irsan Mansyur";
        $this->template->load('public', 'index', $data);
    }

    function submenu()
    {
        $data['nama'] = "Irsan Mansyur";
        if (!$this->session->userdata('email')) {
            redirect('test');
        }
        $this->load->model('admin/menu_m');
        $data['menu'] = $this->menu_m->getMenuRoleId()->result_array();
        $this->template->load('public', 'index', $data);
    }
}
