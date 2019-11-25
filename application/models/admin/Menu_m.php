<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_m extends CI_Model
{
    private $table = 'tbl_user_menu';
    private $idName = 'id_menu';
    private $role_id = null;
    public function __construct()
    {
        parent::__construct();
        $this->role_id = $this->session->userdata('role_id');
    }


    // hak akses user berdasarkn menu submenu 
    function role()
    {
        $this->db->select('tbl_user_sub_menu' . ".*");
        $this->db->from($this->table);
        $this->db->join('tbl_user_sub_menu', "tbl_user_sub_menu.menu_id=tbl_user_menu.id_menu");

        $this->db->join('tbl_user_access_menu', "tbl_user_access_menu.menu_id=tbl_user_menu.id_menu");
        $this->db->join('tbl_user', "tbl_user.role_id = tbl_user_access_menu.role_id ");
        $this->db->where([
            'tbl_user_sub_menu.class' => $this->router->fetch_class(),
            "tbl_user_access_menu.role_id" => $this->role_id
        ]);

        return $this->db->get();
    }

    function getMenuRoleId()
    {
        $this->db->select($this->table . ".*");
        $this->db->from($this->table);
        $this->db->join('tbl_user_access_menu', "tbl_user_access_menu.menu_id=tbl_user_menu.id_menu");
        $this->db->join('tbl_user', "tbl_user.role_id = tbl_user_access_menu.role_id ");
        $this->db->where([
            'tbl_user.menu_active' => "yes",
            "tbl_user_access_menu.role_id" => $this->role_id
        ]);
        return $this->db->get();
    }
    function getMenu()
    {
        $data = "id_menu !='1' AND id_menu !='2'";
        return $this->db->order_by('id_menu')->get_where($this->table, $data);
    }

    function get_submenuIdMenu($menu_id)
    {
        $this->db->select("tbl_user_sub_menu.*,tbl_icons.code as icon");
        $this->db->from('tbl_user_sub_menu');
        $this->db->join("tbl_icons", "tbl_icons.id=tbl_user_sub_menu.icon_id");
        $this->db->where([
            'tbl_user_sub_menu.akses' => "no",
            "tbl_user_sub_menu.menu_id"  => $menu_id
        ]);
        return $this->db->get();
    }

    function getSubmenu()
    {
        $this->db->select("tbl_user_menu.menu,tbl_icons.code AS icon,tbl_user_sub_menu.*");
        $this->db->from("tbl_user_sub_menu");
        $this->db->join('tbl_user_menu', "tbl_user_menu.id_menu=tbl_user_sub_menu.menu_id");
        $this->db->join('tbl_icons', "tbl_icons.id=tbl_user_sub_menu.icon_id");
        $this->db->order_by("tbl_user_menu.menu");
        return $this->db->get();
    }

    function getRole()
    {
        return $this->db->get("tbl_user_role")->result_array();
    }

    function getRoleId($role_id)
    {
        return $this->db->get_where('tbl_user_role', [
            "id" => $role_id
        ]);
    }

    function getWhereAccessRoleId($where)
    {
        return $this->db->get_where("tbl_user_access_menu", $where);
    }


    // add menu
    function addMenu($data)
    {
        $this->db->insert($this->table, $data);
    }
    // add acces menu
    function addAccessMenu($data)
    {
        $this->db->insert("tbl_user_access_menu", $data);
    }

    // delete acces menu
    function deleteAccessMenu($where)
    {
        $this->db->delete("tbl_user_access_menu", $where);
    }
    // delete menu id
    function deleteMenuId($id)
    {
        $this->db->delete($this->table, [
            $this->idName => $id
        ]);
    }

    function updateMenuId($menu_id, $data = [])
    {
        $this->db->where([
            $this->idName => $menu_id
        ]);
        $this->db->update($this->table, $data);
    }
    function insert($data)
    {
        $this->db->insert('user_sub_menu', $data);
        return $this->db->affected_rows();
        $this->row;
    }
}
