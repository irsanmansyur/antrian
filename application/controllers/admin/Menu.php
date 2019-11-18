<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['page']['title'] = 'Menu Management Acces';
        $this->data['page']['description'] = 'Silahkan edit menu Atau Tambahkan Menu.!';
        // $this->data['page']['before'] = ['url' => base_url('admin/admin/role'), "title" => "Role Access"];
        $this->data['page']['submenu'] = 'Menu Management Access';

        $this->load->library('form_validation');

        $this->data['menu'] = $this->menu_m->getMenu()->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');
        if ($this->form_validation->run() == false) {
            $this->template->load('admin', 'menu_management/index', $this->data);
        } else {
            $data = [
                'menu' => $this->input->post('menu')
            ];
            $eks = $this->menu_m->addMenu($data);
            hasilCUD("Sukses Menambahkan Menu");
            redirect('admin/menu');
        }
    }


    public function edit()
    {
        $data = [
            'menu' => $this->input->post('menu')
        ];
        $this->menu_m->updateMenuId($this->data['page']['id'], $data);
        hasilCUD("Sukses Update Menu");
        redirect('admin/menu');
    }
    public function delete()
    {
        $this->menu_m->deleteMenuId($this->data['page']['id']);
        hasilCUD("Menu Berhasil Di hapus.!");
        redirect('admin/menu');
    }
    public function editsubmenu($id)
    {
        $this->load->library('form_validation');

        $this->data['page']['title'] = 'Edit Submenu Management';
        $data = [
            'title' => $this->input->post('title'),
            'menu_id' => $this->input->post('menu_id'),
            'url' => $this->input->post('url'),
            'class' => $this->input->post('class'),
            'method' => $this->input->post('method'),
            'icon_id' => $this->input->post('icon'),
            'is_active' => $this->input->post('is_active')
        ];
        $this->db->where('id', $id);
        $this->db->update('tbl_user_sub_menu', $data);
        hasilCUD("Submenu berhasil di ubah.!");
        redirect('admin/menu/submenu');
    }

    public function deletesubmenu($id)
    {
        $this->db->delete('tbl_user_sub_menu', [
            'id' => $id
        ]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Delete sub menu!</div>');
        redirect('admin/menu/submenu');
    }
    public function submenu()
    {
        $this->data['page']['title'] = 'Sub Menu Management Acces';
        $this->data['page']['description'] = 'Silahkan tambakan sub menu tertentu untuk pada menu pilihan anda</br>Anda juga bisa edit dan pilih icon submenu anda.!';
        $this->data['page']['before'] = ['url' => base_url('admin/menu'), "title" => "Menu Access"];
        $this->data['page']['submenu'] = 'Sub Menu Management Access';

        $this->load->library('form_validation');

        $this->data['subMenu'] = $this->menu_m->getSubMenu()->result_array();
        $this->data['menu'] = $this->db->get('tbl_user_menu')->result_array();
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');


        if ($this->form_validation->run() ==  false) {
            $this->template->load('admin', 'menu_management/submenu', $this->data);
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'class' => $this->input->post('class'),
                'method' => $this->input->post('method'),
                'icon_id' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('tbl_user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New sub menu added!</div>');
            redirect('admin/menu/submenu');
        }
    }
}
