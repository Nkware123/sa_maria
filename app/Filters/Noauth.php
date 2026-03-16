<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Noauth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('isLoggedIn')) {

            if (session()->get('role') == "") {
                return redirect()->to(base_url('admin'));
            }

            if (session()->get('role') == "") {
                return redirect()->to(base_url('assistant'));
            }

            if (session()->get('role') == "") {
                return redirect()->to(base_url('beneficiaire'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (session()->get('level') == 1) {
            return redirect()->to(base_url('admin'));
        }

        if (session()->get('level') == 2) {
            return redirect()->to(base_url('assistant'));
        }

        if (session()->get('level') == 3) {
            return redirect()->to(base_url('beneficiaire'));
        }
    }
}
