<?php

use Config\Email;

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $table = 'tbl_user';
    private $idName = 'id_user';
    private $lastId = null;
    public function __construct()
    {
        parent::__construct();
    }

    // mengambil id akhir untuk penambahan
    function getLastId()
    {
        $this->db->select_max($this->idName);
        $this->db->from($this->table);
        $eks = $this->db->get()->row_array()[$this->idName];
        $noUrut = (int) $eks;
        $noUrut++;
        $kodeName = 'user_';
        $this->lastId = $kodeName . sprintf("%03s", $noUrut);
        return  $this->lastId;
    }

    function _deleteCount()
    {

        $user = $this->db->get_where($this->table, [
            "is_active" => 0
        ])->result_array();
        foreach ($user as $row) {
            // jika lebih seminggu tidak aktivasi hitung detik
            if (time() - $row['date_created'] >= 302400) {
                $this->delete($row['id']);
            }
        }
    }


    function getCount()
    {
        return $this->db->get($this->table)->num_rows();
    }
    function newUser()
    {
        $hari = time() + (60 * 24) * 7;
        $eks = $this->db->get($this->table)->result_array();
        $i = 0;
        foreach ($eks as $row) {
            if ($row['date_created'] + (60 * 24) * 7 < time()) {
                $i += 1;
            }
        }
        return $i;
    }
    function cekUser($email)
    {
        return $this->db->get_where($this->table, ['email' => $email]);
    }

    function getUser($email)
    {
        $this->db->select('tbl_user.*,tbl_user_about.*,tbl_user_role.name AS role_name');
        $this->db->from($this->table);
        $this->db->join('tbl_user_about', "{$this->table}.{$this->idName} = tbl_user_about.user_id");
        $this->db->join('tbl_user_role', "{$this->table}.role_id = tbl_user_role.id");
        $this->db->where([
            'email' => $email
        ]);
        return $this->db->get();
    }

    function getIdRole($id = 2)
    {
        $cekId = $this->db->get_where('tbl_user_role', [
            'id' => $id
        ])->num_rows();
        $this->idRole = 2;
        if ($cekId > 0) {
            $this->idRole = $id;
        }
    }
    function add()
    {
        $this->getIdRole();
        $data = [
            $this->idName => $this->getLastId(),
            'email' => htmlspecialchars($this->input->post('email')),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role_id' => $this->idRole,
            'is_active' => 0,
            'date_created' => time()
        ];

        // cek koneksi internet
        $connected = @fsockopen('www.google.com', 80);
        $hasil = [
            'status' => false,
            'message' => "gagal Menambahkan.! Tidak Ada Koneksi Internet"
        ];
        if ($connected) {
            $this->db->insert($this->table, $data);

            //cek keberhasilan
            $eks = $this->db->affected_rows();
            if ($eks > 0) {

                // save ke user user_about
                $dt = [
                    'no_hp' => htmlspecialchars($this->input->post('no_hp')),
                    'name' => htmlspecialchars($this->input->post('name')),
                    'image' => htmlspecialchars($this->input->post('image')),
                    'alamat' => htmlspecialchars($this->input->post('alamat')),
                    'tgl_lahir' => strtotime($this->input->post('tgl_lahir')),
                    'user_id' => $this->lastId
                ];
                $this->db->insert('tbl_user_about', $dt); //
                $hasil = [
                    'status' => true,
                    'message' => "Sukses Menambahkan " . $this->input->post('name') . "  Silahkan verifikasi, dengan link yang kami kirim ke email anda"
                ];
            } else {
                $hasil['message'] = "gagal Menambahkan.!" . $this->db->_error_message();
            }
        }
        return (object) $hasil;
    }
    function sendToken($data)
    {
        $this->db->insert('tbl_user_token', $data);
        $eks = $this->db->affected_rows();
        if ($eks > 0) {
            return true;
        } else  return false;
    }
    function delete($id)
    {
        $this->db->delete($this->table, [
            $this->idName => $id
        ]);
        return $this->db->affected_rows();
    }

    function update($data)
    {
        $this->table = 'tbl_user_about';
        $this->db->where('user_id', $this->data['user']['user_id']);
        $this->db->update("tbl_user_about", $data);
    }


    function updateToken($email, $token)
    {
        $data = [
            'token' => $token
        ];
        $this->db->where([
            'email' => $email
        ]);
        $this->db->update('user_token', $data);
    }
    function getAllUser()
    {
        $this->db->select("*,user.{$this->idName} AS 'id'");
        $this->db->from($this->table);
        $this->db->where([
            'user.role_id !=' => "1"
        ]);
        $this->db->join('user_about', "user.{$this->idName} = user_about.user_id");
        return $this->db->get();
    }
    function getUserId($id)
    {
        $this->db->select("*,user.{$this->idName} AS 'id'");
        $this->db->from($this->table);
        $this->db->join('user_about', "user.{$this->idName} = user_about.user_id");
        $this->db->where([
            'user.id' => $id
        ]);
        return $this->db->get();
    }




    // start datatables
    var $column_order = array(null, 'name', 'no_hp', 'alamat', 'tgl_lahir'); //set column field database for datatable orderable

    var $column_search = array('name', 'no_hp', 'alamat'); //set column field database for datatable searchable
    var $order = [
        "id" => 'asc'
    ]; // default order

    private function _get_datatables_query()
    {
        $this->db->select('user_about.*');
        $this->db->from($this->table);
        $this->db->join('user_about', "user_about.user_id=user.id");
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        $this->db->where([
            'user.id !=' => "user_001"
        ]);
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all()
    {
        $this->db->from($this->table);
        $this->db->where([
            'user.id !=' => "user_001"
        ]);
        return $this->db->count_all_results();
    }
    // end datatables

}
