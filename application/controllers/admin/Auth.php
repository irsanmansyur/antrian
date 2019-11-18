<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    private $emailS = null;
    function permission()
    {
        if ($this->session->userdata('email')) {
            if ($this->time_lock < time()) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-with-icon" data-notify="container"><i class="fa fa-volume-up" data-notify="icon"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle"></i></button><span data-notify="message">Waktu Login habis!</span></div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-with-icon" data-notify="container"><i class="fa fa-volume-up" data-notify="icon"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle"></i></button><span data-notify="message">Anda Sudah Login!</span></div>');
            }
            redirect($this->session->userdata('url'));
        }
    }
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('my_helper');
        $this->load->model('user_model');
        $this->load->library('form_validation');
    }
    public function index()
    {
        $this->permission();
        $this->data['page']['title'] = 'Login Page';
        $this->data['form']['action_login'] = base_url('admin/auth');


        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');


        if ($this->form_validation->run() == false) {
            $this->template->load('admin', 'user/login', $this->data);
        } else {
            // validasinya success
            $this->_login();
        }
    }


    function lock()
    {
        if (!$this->session->userdata('email')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-with-icon" data-notify="container"><i class="fa fa-volume-up" data-notify="icon"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle"></i></button><span data-notify="message">You Must Login.!!</span></div>');
            redirect(base_url('admin/auth'));
        } elseif (time() < $this->time_lock)
            redirect($this->session->userdata('url'));

        $this->data['user'] = $this->user_model->getUser($this->session->userdata('email'))->row_array();
        $this->data['page']['title'] = 'Your Session must Unlock';
        $this->data['form']['action'] = base_url('admin/auth/lock');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run()) {
            $this->_login();
        }

        $this->template->load('admin', 'user/lock', $this->data);
    }
    function unlock()
    { }



    function not_found()
    {
        $this->template->load('admin', 'error', $this->data);
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->load->model('user_model');
        $user = $this->user_model->cekUser($email)->row_array();
        // jika usernya ada
        if ($user) {
            // jika usernya aktif
            if ($user['is_active'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'time' => time() + (60 * 60),
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('notif', '<div class="alert alert-succes" role="alert">Succes Login!</div>');
                    if ($this->session->userdata('url')) {
                        redirect($this->session->userdata('url'));
                    } else
                        redirect('admin/user');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!</div>');
                    if ($this->session->userdata('email')) {
                        redirect('admin/auth/lock');
                    } else
                        redirect('admin/auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This email has not been activated!</div>');
                redirect('admin/auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered!</div>');
            redirect('admin/auth');
        }
    }


    public function registration()
    {
        $this->permission();
        $this->data['page']['title'] = 'Portofolio User Registration';

        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[4]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('tgl_lahir', 'Tgl Lahir', 'required|trim');

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tbl_user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password_confirm', 'Password', 'required|trim|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->template->load('admin', 'user/register', $this->data);
        } else {
            // simpang data user ke database
            $eks = $this->user_model->add();
            if ($eks->status) {
                // mengirim token ke email
                $token =  uniqid(); //random token
                $send  = $this->_sendEmail($token, 'verify');

                if ($send) {

                    //menyiapkan token
                    $email = $this->input->post('email', true);
                    $user_token = [
                        'email' => $email,
                        'token' => $token,
                        'date_created' => time()
                    ];
                    $eksT = $this->user_model->sendToken($user_token);
                    if (!$eksT) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-with-icon" data-notify="container"><i class="fa fa-volume-up" data-notify="icon"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle"></i></button><span data-notify="message">Kesalahan Sistem .!</br></span></div>');
                        redirect('admin/auth/registration');
                    }
                    redirect('admin/auth/verify?email=' . $email);
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-with-icon" data-notify="container"><i class="fa fa-volume-up" data-notify="icon"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle"></i></button><span data-notify="message">' . $eks->message . '</span></div>');
                redirect(base_url('admin/auth/registration'));
            }
            $this->data = null;
        }
    }


    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'berkominfo@gmail.com',
            'smtp_pass' => 'ichaNK01',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->load->library('email');
        $this->email->initialize($config);

        $this->email->from('berkominfo@gmail.com', 'Berkominfo');
        if ($this->emailS == null) {
            $this->email->to($this->input->post('email'));
        } else
            $this->email->to($this->emailS);

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Your Token : ' . $token . ' ,</br>Click this link to verify you account : <a href="' . base_url() . 'admin/auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Your Token : ' . $token . ' ,</br>Click this link to reset your password : <a href="' . base_url() . 'admin/auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die();
        }
    }

    function send_token()
    {
        $this->emailS = $this->input->get('email');
        $unique = ['email' => $this->emailS];
        if (!$this->user_model->getUserU($unique)) {
            redirect(base_url('admin/auth/verify?email=' . $this->emailS));
        } else {
            $token =  uniqid(); //random token
            if ($this->_sendEmail($token, 'verify')) {
                $this->user_model->updateToken($this->emailS, $token);
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-with-icon" data-notify="container"><i class="fa fa-volume-up" data-notify="icon"></i><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times-circle"></i></button><span data-notify="message">Sistem Sudah Mengirim ulang Token</span></div>');
                redirect(base_url('admin/auth/verify?email=' . $this->emailS));
            }
        }
    }
    public function verify()
    {
        $this->permission();
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $submit = $this->input->get('submit');

        $dt = $this->user_model->getUser($email)->row_array();
        if (!$dt) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Wrong email.</div>');
            redirect('admin/auth');
        } elseif ($dt['is_active'] == 1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email Anda Terdaftar, Silahkan Login.</div>');
            redirect('admin/auth');
        } else {
            if ($submit == '' || $submit == null) {
                $this->template->load('admin', 'user/verify', $this->data);
            } else {
                $user_token = $this->db->get_where('tbl_user_token', ['token' => $token])->row_array();
                if ($user_token) {
                    if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                        $this->db->set('is_active', 1);
                        $this->db->where('email', $email);
                        $this->db->update('tbl_user');
                        $this->db->delete('tbl_user_token', ['email' => $email]);
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' has been activated! Please login.</div>');
                        redirect('admin/auth');
                    } else {
                        $this->db->delete('user', ['email' => $email]);
                        $this->db->delete('user_token', ['email' => $email]);
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Token expired.</div>');
                        redirect('admin/auth');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Wrong token.</div>');
                    redirect('admin/auth/verify?email=' . $email);
                }
            }
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('time');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('url');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('admin/auth');
    }


    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $this->data['title'] = 'Forgot Password';
            $this->load->view('templates/admin/auth_header', $this->data);
            $this->load->view('admin/auth/forgot-password');
            $this->load->view('templates/admin/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                $token = uniqid();
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset your password!</div>');
                redirect('admin/auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered or activated!</div>');
                redirect('admin/auth/forgotpassword');
            }
        }
    }


    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong token.</div>');
                redirect('admin/auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong email.</div>');
            redirect('admin/auth');
        }
    }
}
