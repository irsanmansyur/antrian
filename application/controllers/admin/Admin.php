<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends Admin_Controller
{
    function index()
    {
        $this->template->load('admin', 'backend/dashboard', $this->data);
    }
    function getAllUser()
    {
        $list = $this->user_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $log) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $log->nip;
            $row[] = $log->name;
            $row[] = $log->email;
            $row[] = $log->alamat;
            // $row[] = $log->image;
            $row[] = date("d M, Y,  H:i:s A", $log->date);
            $row[] = '<a href="' . base_url('admin/admin/delete/') . $log->nip . '"  class="badge badge-pill badge-primary">Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user_model->count_all(),
            "recordsFiltered" => $this->user_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }



    function role()
    {
        $this->load->library('form_validation');
        $this->data['page']['title'] = 'User Access Menu Permission';
        $this->data['page']['description'] = 'Silahkan Edit dan pilih user untuk mengakses menu menu tertentu saja.!';
        $this->data['page']['submenu'] = 'Role Access';
        $this->data['role'] = $this->menu_m->getRole();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('role', 'Name Role', 'trim|required');

        if ($this->form_validation->run()) {
            $this->db->insert('tbl_user_role', [
                'name' => $this->input->post('role')
            ]);
            hasilCUD("Sukses Menambahkan Role");
            header("Refresh:0");
        } else
            $this->template->load('admin', 'backend/role', $this->data);
    }
    function roleedit($id)
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('role', 'Name Role', 'trim|required');

        $this->template->load('admin', 'backend/role', $this->data);
        if ($this->form_validation->run()) {
            $this->db->where('id', $id);
            $this->db->update('tbl_user_role', [
                'name' => $this->input->post('role')
            ]);
            hasilCUD("Sukses Edit Role");
            redirect(base_url('admin/admin/role'));
        }
    }
    function roledelete($id)
    {
        $this->db->delete('tbl_user_role', [
            'id' => $id
        ]);
        hasilCUD("Sukses Menghapus Role");
        redirect(base_url('admin/admin/role'));
    }

    function roleaccess()
    {
        $this->load->library('form_validation');
        $this->data['page']['title'] = 'Role Acces changed';
        $this->data['page']['description'] = 'Silahkan menu tertentu untuk di akses.!';
        $this->data['page']['before'] = ['url' => base_url('admin/admin/role'), "title" => "Role Access"];
        $this->data['page']['submenu'] = 'Edit Role access Menu';

        $role_id =  $this->data['page']['id'];

        $this->data['role'] = $this->menu_m->getRoleId($role_id)->row_array();

        $this->data['menu'] = $this->menu_m->getMenu()->result_array();
        $this->template->load('admin', 'backend/role_changed', $this->data);
    }
    function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $where = [
            'role_id' => htmlspecialchars($role_id),
            'menu_id' => htmlspecialchars($menu_id)
        ];
        $result = $this->menu_m->getWhereAccessRoleId($where);

        if ($result->num_rows() < 1) {
            $this->menu_m->addAccessMenu($where);
        } else {
            $this->menu_m->deleteAccessMenu($where);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
        // echo json_encode($databack);
    }

    function setting()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('site_name', 'Site_name', 'trim|required');
        $this->form_validation->set_rules('site_title', 'Site_title', 'trim|required');
        $this->form_validation->set_rules('site_visi', 'Site_visi', 'trim|required');
        $this->form_validation->set_rules('site_misi', 'Site_misi', 'trim|required');
        $this->form_validation->set_rules('site_sejarah', 'Site_sejarah', 'trim|required');
        if ($this->form_validation->run()) {
            $data = [
                'site_visi' => $this->input->post('site_visi'),
                'site_misi' => $this->input->post('site_misi'),
                'site_sejarah' => $this->input->post('site_sejarah'),
                'site_name' => $this->input->post('site_name'),
                'site_title' => $this->input->post('site_title')
            ];
            $eks =  $this->setting_model->site_update($data);
            $message = ($eks->status) ? "success" : "danger";
            $this->session->set_flashdata('message', '<div class="alert alert-' . $message . ' alert-with-icon" data-notify="container"><i class="fa fa-volume-up" data-notify="icon"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle"></i></button><span data-notify="message">' . $eks->message . '</span></div>');
            redirect('admin/admin/setting');
        } else {
            $this->data['site_setting'] = $this->setting_model->getSite()->row_array();
            $this->template->load('admin', 'setting', $this->data);
        }
    }
    function _setting()
    {
        foreach ($_POST as $key => $value) {
            $where['name'] = htmlspecialchars($key);
            $data['title'] = htmlspecialchars($value);
        }
        $this->setting_model->update($where, $data);
    }
}
