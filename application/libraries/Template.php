<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template
{

  public $theme_folder;
  private $ci;

  var $template_data = array();
  public $settings;
  public function __construct()
  {
    $this->ci = &get_instance();
    $this->loadSetting();
  }

  function loadSetting()
  {
    $this->ci->load->model('admin/setting_m');
    $pre = [];
    $pr = $this->ci->setting_m->get();
    foreach ($pr as $p) {
      $pre[addslashes($p->name)] = addslashes($p->title);
    }
    $this->settings = (object) $pre;
    $this->ci->setting = $this->settings;
  }

  // membaca thema jika tidak ditemukan set ke default
  function readTheme($type)
  {
    $theme = array();
    if ($type == 'admin') {
      $theme = ['theme_admin', $this->settings->theme_admin];
    } elseif ($type == 'public') {
      $theme = ['theme_public', $this->settings->theme_public];
    }
    // set theme folder
    if (!file_exists(FCPATH . "themes/{$type}/" . $theme[1])) {
      $where = [
        'name' => $theme[0]
      ];
      $data = [
        'title' => 'default'
      ];
      $this->ci->setting_m->update($where, $data);
      $this->loadSetting();
      return  "default";
    } else
      return $theme[1];
  }


  function load($template = '', $view = '', $view_data = array(), $return = FALSE)
  {
    // cek ketersediaan template
    if (!file_exists(FCPATH . "themes/{$template}")) {
      die("tidak ada template yang cocok");
    }
    // membaca jenis template dan nama tema
    $theme = $this->readTheme($template);

    // cek content ada tidak di tema yang di centang
    if (file_exists(FCPATH . "themes/{$template}/{$theme}/layout/{$view}.php")) { }
    // jika tidak ada maka akan di carikan content di tema defaultnya
    elseif (file_exists(FCPATH . "themes/{$template}/default/layout/{$view}.php")) {
      $theme = 'default';
    }
    // tampilkan content tidak di temukan di tema default pun
    else {
      $this->set_content('content', "Tidak ada layout content tersedia");
    }
    $this->set_content('thema_folder', base_url("themes/{$template}/" . $theme . '/'));
    $this->set_content('thema_load', "../../themes/{$template}/{$theme}/layout/");
    $this->set_content('thema_content', $this->ci->load->view("../../themes/{$template}/{$theme}/index", $view_data, true));
    return $this->ci->load->view("../../themes/{$template}/{$theme}/layout/" . $view, $this->template_data, $return);
  }
  // pendukun load
  function set_content($name, $value)
  {
    $this->template_data[$name] = $value;
  }


  function open_template($type = 'public')
  {
    $folder = "./themes/{$type}";
    if (!($buka_folder = opendir($folder)))
      die("eRorr... Tidak bisa membuka Folder");
    $file_array = array();
    while ($baca_folder = readdir($buka_folder)) {
      if (substr($baca_folder, 0, 1) != '.') {
        $file_array[] =  $baca_folder;
      }
    }
    return $file_array;
  }
}
