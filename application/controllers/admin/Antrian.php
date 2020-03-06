<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Antrian extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('antrian_m');
    }
    function index()
    {
        $this->template->load('admin', 'backend/dashboard', $this->data);
    }
    function petugas()
    {

        $this->_cekSession();
        $data = [
            'id' => $this->session->userdata('id_loket')
        ];
        $this->data['s_loket'] = $this->antrian_m->getLoketId($data)->row_array();

        $where = [
            'counter' =>  $this->data['s_loket']['client']
        ];
        $this->data['s_antrian'] = $this->antrian_m->getAntrianClient($where)->row_array();

        $this->data['antrian_next'] = $this->antrian_m->getNext()->row_array();
        $this->data['list_antrian'] = $this->antrian_m->getAntrian()->result_array();


        $this->template->load('admin', 'antrian/petugas', $this->data);
    }

    function _cekSession()
    {
        if ($this->session->userdata('email') != $this->session->userdata('petugas')) {
            redirect('admin/antrian/pin');
        }
    }

    function pin()
    {
        $this->session->unset_userdata('petugas');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pin', 'pin', 'required');
        if ($this->form_validation->run()) {
            $data = [
                'pin' => $this->input->post('pin')
            ];
            $loket = $this->antrian_m->getLoketId($data)->row_array();

            if ($loket) {
                $session = [
                    "id_loket" => $loket['id'],
                    "petugas" => $this->session->userdata('email')
                ];
                $this->session->set_userdata($session);
                redirect('admin/antrian/petugas');
            }
        } else {
            $this->template->load('admin', 'antrian/pin', $this->data);
        }
    }



    function admin()
    {
        $this->_cekLoketKosong();
        $this->data['antrian_active'] = $this->antrian_m->getActive()->result_array();
        $this->data['antrian_next'] = $this->antrian_m->getNext()->row_array();
        $this->data['list_antrian'] = $this->antrian_m->getAntrian()->result_array();
        $this->data['list_loket'] = $this->antrian_m->getAllLoked()->result_array();
        $this->data['jumlah_loket'] = $this->antrian_m->getNext()->row_array();
        $this->template->load('admin', 'antrian/admin', $this->data);
    }
    function lewati($id)
    {
        $counter = $this->input->get('counter');
        $next = $this->antrian_m->getNext()->row_array();

        if ($next) {
            $dataNext = [
                'status' => 2,
                'counter' => $counter,
                'type' => "Waiting"
            ];
            $this->antrian_m->update($next['id'], $dataNext);
            hasilCUD("Antrian Dilewati Dan Di isi antrian baru.!");
        } else {
            $this->_kosongkanLoket($counter);
            hasilCUD("Antrian Baru Kosong..!");
        };
        $dataSelesai = [
            'status' => 4,
            'type' => "Antrian Tidak hadir"
        ];
        $this->antrian_m->update($id, $dataSelesai);

        redirect(base_url("admin/antrian/petugas"));
    }

    function panggillagi($id)
    {
        $this->load->library("ci_pusher");
        $this->db->where([
            'id' => $id
        ]);
        $this->db->update("data_antrian", [
            'status' => 2
        ]);
        $pusher = $this->ci_pusher->get();
        $data['message'] = 'notif';
        $pusher->trigger('my-channel', 'my-event', $data);
        redirect('admin/antrian/petugas');
    }
    function updateLoket()
    {
        // status loket di ubah jadi 1
        $this->db->where('client', $this->input->post('client'));
        $this->db->update("client_antrian", [
            'status' => $this->input->post('status')
        ]);
        if ($this->input->post('status') == 1) {
            $content = "Loket {$this->input->post('client')} dalam antrian";
        } elseif ($this->input->post('status') == 2)
            $content = "Loket {$this->input->post('client')} Dibuka";
        else
            $content = "Loket {$this->input->post('client')} Ditutup";

        hasilCUD($content);
        echo true;
    }

    function selesai($id)
    {
        $counter = $this->input->get('counter');
        $next = $this->antrian_m->getNext()->row_array();
        if ($next) {
            $dataNext = [
                'status' => 2,
                'counter' => $counter,
                'type' => "Waiting"
            ];
            $this->antrian_m->update($next['id'], $dataNext);
            hasilCUD("Antrian Selesai Dan Di isi antrian baru.!");
        } else {
            $this->_kosongkanLoket($counter);
            hasilCUD("Antrian Baru Kosong..!");
        };

        $dataSelesai = [
            'status' => 0,
            'type' => "Selesai Mengantri"
        ];
        $this->antrian_m->update($id, $dataSelesai);
        redirect(base_url("admin/antrian/petugas"));
    }
    function _cekLoketKosong()
    {
        $cekLoketKosong = $this->antrian_m->getLoked(0)->result_array();
        if ($cekLoketKosong) {
            // die('ada kosong');

            foreach ($cekLoketKosong as $row) {
                $next = $this->antrian_m->getNext()->row_array();
                if ($next) {
                    $dataNext = [
                        'status' => 1,
                        'counter' => $row['client']
                    ];
                    $this->antrian_m->update($next['id'], $dataNext);

                    $where = [
                        'id' => $row['id']
                    ];
                    $data = [
                        'status' => 1
                    ];
                    $this->antrian_m->updateLoket($where, $data);
                }
            }
        } else {
            // die('tidak ada kosong');
            $cekLoketKosong = $this->antrian_m->getLoked()->result_array();
            if ($cekLoketKosong) {
                foreach ($cekLoketKosong as $row) {
                    $antri = $this->antrian_m->getAntrian(1, $row['client'])->result_array();
                    if (!$antri) {
                        $where = [
                            'id' => $row['id']
                        ];
                        $data = [
                            'status' => 0
                        ];
                        $this->antrian_m->updateLoket($where, $data);

                        header("Refresh : 0");
                    }
                }
            }
        }
    }

    function _kosongkanLoket($loket = 0, $status = 2)
    {
        $where = [
            'client' => $loket
        ];
        $data = [
            'status' => $status
        ];
        $this->antrian_m->updateLoket($where, $data);
    }

    function addAntrian()
    {
        $data = [
            'id' => $this->input->post('id'),
            'counter' => $this->input->post('client'),
            'waktu' => time(),
            'status' => 3,
            'type' => 0
        ];
        $this->antrian_m->insert($data);
        hasilCUD("Berhasil Insert Data Antrian baru");
        echo true;
    }
    function addLoket()
    {
        $data = [
            'client' => $this->input->post('id'),
            'status' => 0
        ];
        $this->antrian_m->insertLoket($data);
        hasilCUD("Berhasil Insert Data Loket baru");
        echo true;
    }
    function editloket($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('client', 'Client Number', 'trim|required|numeric');
        $where = [
            'id' => $id
        ];
        if ($this->form_validation->run()) {
            $data = [
                'client' => $this->input->post('client'),
                'status' => ($this->input->post('status') == 1) ? 1 : 0
            ];
            $this->antrian_m->updateLoket($where, $data);
            hasilCUD("Sukses Mengedit");
            redirect(base_url('admin/antrian/loket'));
        } else {
            $this->data['loket'] = $this->antrian_m->getLoketId($where)->row_array();
            $this->template->load('admin', 'antrian/edit_loket', $this->data);
        }
    }

    function loket()
    {
        $this->data['list_loket'] = $this->antrian_m->getAllLoked()->result_array();
        $this->template->load('admin', 'antrian/loket', $this->data);
    }

    function delete($id)
    {
        $where = [
            'id' => $id
        ];
        $this->antrian_m->deleteId($where);
        hasilCUD("Berhasil Delete " . $id);
        redirect('admin/antrian/admin');
    }
    function deleteLoket($id)
    {
        $where = [
            'id' => $id
        ];
        $this->antrian_m->deleteLoket($where);
        hasilCUD("Berhasil Delete loket Dengan Id  " . $id);
        redirect('admin/antrian/loket');
    }
}
