<?php
function is_active($class, $method = 'index')
{
    $ci = get_instance();
    if ($class == $ci->router->fetch_class() && $method == $ci->router->fetch_method()) {
        return "active";
    } else return "";
}


function is_access($role_id, $menu_id)
{
    $back =  false;
    $ci = get_instance();
    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('tbl_user_access_menu');
    if ($result->num_rows() > 0) {
        $back = true;
    }
    return $back;
}

//pesan aksi
function hasilCUD($message = "Sukses.!")
{
    $ci = get_instance();
    $hasil = [
        'status' => true,
        'message' => $message,
    ];
    if ($ci->db->affected_rows() < 1) {
        $hasil['status'] = false;
        $hasil['message'] = ($ci->db->error()['message'] == "") ? "Tidak Ada Yang Berubah" : $ci->db->error()['message'];
    }
    $alert = $hasil['status'] ? "success" : "danger";
    $ci->session->set_flashdata('message', "<div class='mb-5 alert alert-{$alert}' role='alert'>{$hasil['message']}.!</div>");
    return (object) $hasil;
}
