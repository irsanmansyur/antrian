<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting_m extends CI_Model
{
    private $table = 'tbl_setting';

    public function __construct()
    {
        parent::__construct();
    }
    function get()
    {
        return $this->db->order_by('name')->get($this->table)->result();
    }

    function update($where = [], $data = [])
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    function getSite()
    {
        $this->db->where([
            'site_id' => 1
        ]);
        return $this->db->get('tbl_site');
    }
    function site_update($data)
    {
        $this->db->where([
            'site_id' => 1
        ]);
        $this->db->update('tbl_site', $data);
        $eks = $this->db->affected_rows();
        if ($eks > 0) {
            $hasil = [
                'status' => true,
                'message' => "Sukses Mengedit " . $this->data['page']['id']
            ];
        } else {
            $hasil['message'] = 'Tidak Ada Data yang berubah';
        }
        return (object) $hasil;
    }

    private function apply_setting()
    {
        // if ($this->setting->timezone) {
        // 	date_default_timezone_set($this->setting->timezone); //ganti ke timezone lokal
        // 	# code...
        // }

        // Ambil google api key dari desa/config/config.php kalau tidak ada di database
        // if ($this->setting->google_key) {
        // 	$this->setting->google_key = config_item('google_key');
        // }
        // Ambil dev_tracker dari desa/config/config.php kalau tidak ada di database
        // if (empty($this->setting->dev_tracker)) {
        // 	$this->setting->dev_tracker = config_item('dev_tracker');
        // }
        // $this->setting->user_admin = config_item('user_admin');
        // Kalau folder tema ubahan tidak ditemukan, ganti dengan tema default
        if (!empty($this->setting->theme)) {
            $folder = FCPATH . "\/custom_theme/" . $this->setting->theme;
            if (!file_exists($folder)) {
                $this->db->where([
                    'name' => 'theme'
                ]);
                $this->db->update('setting_web', ['title' => 'default']);
                $this->setting->theme = "default";
            }
        }
        // $this->cek_migrasi();
    }


    public function update_slider()
    {
        $_SESSION['success'] = 1;
        $this->setting->sumber_gambar_slider = $this->input->post('pilihan_sumber');
        $outp = $this->db->where('key', 'sumber_gambar_slider')->update('setting_web', array('value' => $this->input->post('pilihan_sumber')));
        if (!$outp) $_SESSION['success'] = -1;
    }

    public function load_options()
    {
        foreach ($this->list_setting as $i => $set) {
            if ($set->jenis == 'option' or $set->jenis == 'option-value') {
                $this->list_setting[$i]->options = $this->get_options($set->id);
            }
        }
    }

    private function get_options($id)
    {
        $result = array();
        $rows = $this->db->select('id,value')
            ->where('id_setting', $id)
            ->get('setting_aplikasi_options')
            ->result();

        foreach ($rows as $row) {
            $result[$row->id] = $row->value;
        }

        return $result;
    }
}
