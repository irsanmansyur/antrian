<?php

function deleteImg($folder, $img)
{
    if (is_file(FCPATH . "assets/img/" . $folder . "/" . $img)) {
        unlink(FCPATH . "assets/img/" . $folder . "/" . $img);
    }
}

function upload_file($name, $folder = '')
{
    $data = [
        'status' => false,
        'name' => ''
    ];
    $ci = get_instance();
    $config['allowed_types'] = 'gif|jpg|png|pdf';
    $config['max_size']      = '2048';
    $config['upload_path'] = './assets/img/' . $folder . '/';
    $ci->load->library('upload', $config);
    if ($ci->upload->do_upload($name)) {
        $data['status'] = true;
        $data['name'] = $ci->upload->data('file_name');
    } else {
        $data['name'] = $ci->upload->display_errors();
    }
    return $data;
}

function getThumb($img)
{
    $ci = get_instance();
    $imgb = 'img/thumbnail/default.png';
    if (is_file($ci->assets . 'img/thumbnail/' . $img)) {
        $imgb = 'img/thumbnail/' . $img;
    }
    return $ci->assets . $imgb;
}
function getProfile($img, $type = null)
{
    $ci = get_instance();

    $imgb = 'img/profile/' . $img;
    $dir = FCPATH . 'assets/img/profile/' . $img;

    if ($type == 'thumbnail') {
        $dir = FCPATH . 'assets/img/thumbnail/profile_' . $img;
        $imgb = 'img/thumbnail/profile_' . $img;
    }
    if (!is_file($dir)) {
        $imgb = 'img/thumbnail/default.png';
    }
    return base_url('assets/')  . $imgb;
}
function getImg($img, $type = null)
{
    $ci = get_instance();
    $imgb = 'img/thumbnails/default.png';
    if (is_file(FCPATH . 'assets/img/' . $img)) {
        $imgb = 'img/' . $img;
        if ($type == 'thumbnail') {
            $imgb = 'img/thumbnails/' . $img;
        }
    }
    return $ci->assets . $imgb;
}
