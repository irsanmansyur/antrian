<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Push extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("ci_pusher");
    }
    public function index()
    {
    }

    function PlayFinish()
    {
        $pusher = $this->ci_pusher->get();
        $data['playing'] = false;
        $pusher->trigger('my-channel', 'my-event', $data);
        $this->response([
            "message" => "Playing Stopped",
            "status" => true
        ]);
    }
    function playing()
    {
        $pusher = $this->ci_pusher->get();
        $data['playing'] = true;
        $pusher->trigger('my-channel', 'my-event', $data);
        $this->response([
            "message" => "Playing",
            "status" => true
        ]);
    }

    function response($data = null)
    {
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
