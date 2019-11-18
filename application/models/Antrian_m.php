<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Antrian_m extends CI_Model
{
    private $table = 'data_antrian';
    private $idName = "id";
    private $lastId = '';

    public function __construct()
    {
        parent::__construct();
    }
    function getLastLoket()
    {
        $this->db->select_max("client");
        $this->db->from("client_antrian");
        $eks = $this->db->get()->row_array()['client'];
        $noUrut = (int) $eks;
        $noUrut++;
        return  $noUrut;
    }
    function getLastId()
    {
        $this->db->select_max($this->idName);
        $this->db->from($this->table);
        $eks = $this->db->get()->row_array()[$this->idName];
        $noUrut = (int) $eks;
        $noUrut++;
        $this->lastId = $noUrut;
        return  $this->lastId;
    }
    function deleteId($where)
    {
        $this->db->delete($this->table, $where);
    }
    function deleteLoket($where)
    {
        $this->db->delete("client_antrian", $where);
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
    function insertLoket($data)
    {
        $this->db->insert("client_antrian", $data);
    }
    function getActive()
    {
        $this->db->select($this->table . ".*");
        $this->db->from($this->table);
        $this->db->where([
            $this->table . '.status' => 1
        ]);
        $this->db->join("client_antrian", "client_antrian.client={$this->table}.counter", "right");
        $this->db->where([
            $this->table . '.status' => 1
        ]);
        $this->db->order_by('id', 'asc');
        return $this->db->get();
    }
    function getAntrian($status = 2, $loket = 0)
    {
        $this->db->where('status', $status);
        if ($status != 1) {
            $this->db->or_where('status', 3);
        } else {
            $this->db->where('counter', $loket);
        }
        $this->db->order_by('id', 'asc');
        return $this->db->get($this->table);
    }
    function getNext($status = 2)
    {
        $this->db->where('status', $status);
        $this->db->limit(1);
        $this->db->order_by('id', 'asc');
        return $this->db->get($this->table);
    }
    function getAllLoked()
    {
        $loket = $this->db->get('client_antrian');

        return $loket;
    }
    function getLoked($active = 1)
    {
        $loket = $this->db->get_where('client_antrian', [
            'status' => $active
        ]);

        return $loket;
    }
    function getLoketId($where)
    {
        $loket = $this->db->get_where('client_antrian', $where);

        return $loket;
    }
    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }
    function updateLoket($where, $data)
    {
        $this->db->where($where);
        $this->db->update("client_antrian", $data);
    }
    function jumlahLocket()
    {
        $this->db->select("count(*) as jumlah_loket");
        $this->db->from('client_antrian');
        return $this->db->get();
    }
}
