<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Antrian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("ci_pusher");
        $this->load->model("antrian_m");
    }
    public function index()
    {
    }

    public function getDataLoket($id = null)
    {
        // status antrian                   Status LOket
        // 0 = success                      0 = Tutup
        // 1 = process                      1 = process
        // 2 = waiting                      2 = Buka/waiting
        // 3 = wait/belum dipanggil
        // 4 = pending 

        //data semua loket
        $allLoket = $this->antrian_m->getLoked($id);
        $antrian = $this->antrian_m->getAntrian()->result_array();

        // cek next
        $next = $this->antrian_m->getNext()->row();
        if ($next)
            $next = $next;
        else $next = ["id" => null];


        $this->response([
            "status" => true,
            "message" => "Data di Temukan",
            "data" => [
                'nextAntri' => $next,
                'loket' => $allLoket->result(),
                "antrians" => $antrian
            ]
        ]);
    }

    function memanggil($id, $idLoket = null)
    {
        if (!$id)
            $this->response();
        $this->db->where('id', $id);
        $this->db->update("data_antrian", [
            'status' => 2
        ]);
        if ($idLoket) {
            $this->antrian_m->updateLoket(['id' => $idLoket], ['client' => $id, "status" => 1]);
        }
        $pusher = $this->ci_pusher->get();
        $data['antrianChange'] = true;
        $data['playing'] = true;
        $pusher->trigger('my-channel', 'my-event', $data);
        $this->getDataLoket($idLoket);
    }

    function telahdipanggil()
    {
        if (!$_SERVER['REQUEST_METHOD'] === "POST") {
            $this->response();
        }
        $id = $this->input->post("id");
        $this->antrian_m->setAntrian($id, [
            'status' => 1
        ]);
        $pusher = $this->ci_pusher->get();
        $data['playing'] = false;
        $pusher->trigger('my-channel', 'my-event', $data);
        $this->response([
            "status" => true,
            "message" => "data berubah"
        ]);
    }
    function loketopen($id)
    {
        $this->antrian_m->updateLoket(["id" => $id], ['status' => 2]);
        $pusher = $this->ci_pusher->get();
        $data['antrianChange'] = true;
        $pusher->trigger('my-channel', 'my-event', $data);
        $this->getDataLoket($id);
    }
    function loketclose($id)
    {
        $this->antrian_m->updateLoket(["id" => $id], ['status' => 0]);
        $pusher = $this->ci_pusher->get();
        $data['antrianChange'] = true;
        $pusher->trigger('my-channel', 'my-event', $data);
        $this->getDataLoket($id);
    }
    function listAntri()
    {
        $antrian = $this->antrian_m->getAntrian()->result_array();
        $this->response([
            "status" => true,
            "data" => $antrian
        ]);
    }
    function selesai($id, $idLoket = null)
    {
        if (!$id || !$idLoket) {
            $this->response();
        }
        $where = ['id' => $idLoket];
        $data = ["status" => 2];
        $this->antrian_m->updateLoket($where, $data);
        $this->antrian_m->updateAntrian(["id" => $id], ['status' => 0]);
        $next = $this->antrian_m->getNext()->row_array();
        if (!$next) {
            $this->db->update("client_antrian", ["status" => 0], ["id" => $idLoket]);
        }
        $pusher = $this->ci_pusher->get();
        $data['antrianChange'] = true;
        $pusher->trigger('my-channel', 'my-event', $data);
        $this->getDataLoket($idLoket);
    }
    function antrianStagged($id, $idLoket = null)
    {
        $this->antrian_m->updateAntrian(["id" => $id], ["status" => 1]);
        $pusher = $this->ci_pusher->get();
        $data['antrianChange'] = true;
        $pusher->trigger('my-channel', 'my-event', $data);
        $this->getDataLoket($idLoket);
    }
    function lewati($id, $loket)
    {
        $dataSelesai = [
            'status' => 4,
            'type' => "Antrian Tidak hadir"
        ];
        $this->antrian_m->update($id, $dataSelesai);
        $next = $this->antrian_m->getNext()->row_array();
        if ($next) {
            $dataNext = [
                'status' => 2,
                'counter' => $loket,
                'type' => "Waiting"
            ];
            $this->antrian_m->update($next['id'], $dataNext);
            $this->db->update("client_antrian", ['client' => $next['id']], ["id" => $loket]);
        }

        $pusher = $this->ci_pusher->get();
        $data['antrianChange'] = true;
        $pusher->trigger('my-channel', 'my-event', $data);
        $this->getDataLoket($loket);
    }

    function response($data = null)
    {
        header('Content-Type: application/json');
        $master = [
            "status" => false,
            "message" => "i'm not bad.!",
            "data" => [],
            "error" => []
        ];
        if ($data && is_array($data)) {
            foreach ($data as $key => $value) {
                $master[$key] = $value;
            }
        }
        echo json_encode($master, JSON_PRETTY_PRINT);
        die();
    }
}
