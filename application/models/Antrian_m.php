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

    function getAntrianClient($where)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where($where);
        $this->db->where("(status!=0 AND status!=3 AND status!=4)", NULL, FALSE);
        $this->db->limit(1);
        $this->db->order_by('id', 'asc');
        return $this->db->get();
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
    function getAntrian($where = array())
    {
        if (count($where))
            $this->db->where($where);
        $this->db->where("(status!=0 AND status!=1 AND status!=2)", NULL, FALSE);
        $this->db->order_by('id', 'asc');
        return $this->db->get($this->table);
    }
    function getNext($status = 3)
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

    function getAntrianAwal()
    {
        $this->db->select($this->table . ".*");
        $this->db->from("client_antrian");
        $this->db->join($this->table, "{$this->table}.counter=client_antrian.client", 'left');
        $this->db->limit(2);
        $this->db->order_by('client_antrian.client', 'asc');
        return $this->db->get();
    }
    function getLoketId($where)
    {
        $this->db->select("*");
        $this->db->from("client_antrian");
        $this->db->where($where);
        $this->db->limit(1);
        $this->db->order_by('id', 'asc');
        $loket = $this->db->get();
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
