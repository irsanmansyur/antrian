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
        $dataSelesai = [
            'status' => 3,
            'type' => "Antrian Tidak hadir"
        ];
        $this->antrian_m->update($id, $dataSelesai);

        if ($next) {
            $dataNext = [
                'status' => 1,
                'counter' => $counter,
                'type' => "Lagi Mengantri"
            ];
            $this->antrian_m->update($next['id'], $dataNext);
            hasilCUD("Antrian Dilewati Dan Di isi antrian baru.!");
        } else {
            $this->_kosongkanLoket($counter);
            hasilCUD("Antrian Baru Kosong..!");
        };
        redirect(base_url("admin/antrian/admin"));
    }
    function selesai($id)
    {
        $counter = $this->input->get('counter');

        $next = $this->antrian_m->getNext()->row_array();
        $dataSelesai = [
            'status' => 0,
            'type' => "Selesai Mengantri"
        ];
        $this->antrian_m->update($id, $dataSelesai);

        if ($next) {
            $dataNext = [
                'status' => 1,
                'counter' => $counter,
                'type' => "Selesai Mengantri"
            ];
            $this->antrian_m->update($next['id'], $dataNext);
            hasilCUD("Antrian Selesai Dan Di isi antrian baru.!");
        } else {
            $this->_kosongkanLoket($counter);
            hasilCUD("Antrian Baru Kosong..!");
        };
        redirect(base_url("admin/antrian/admin"));
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

    function _kosongkanLoket($loket = 0)
    {
        $where = [
            'client' => $loket
        ];
        $data = [
            'status' => 0
        ];
        $this->antrian_m->updateLoket($where, $data);
    }
    function getData()
    {
        $response = array(
            'content' => $this->antrian_m->getActive()->result()
        );

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
    function addAntrian()
    {
        $data = [
            'id' => $this->input->post('id'),
            'counter' => $this->input->post('client'),
            'waktu' => time(),
            'status' => 2,
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
