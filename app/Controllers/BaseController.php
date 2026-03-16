<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\My_Model;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = ['url'];
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
    }

    //recuperation des segments
    public function urichk()
    {
        $data['menu']= $this->request->uri->getSegment(1); 
        $data['sousmenu']= $this->request->uri->getSegment(2); 
        return $data;
    }

    public function save($table,$datacolumsinsert)
    {
        return $this->My_Model->create($table,$datacolumsinsert);
    }

    public function update($table,$critere,$data)
    {
        $this->My_Model->update_data($table,$critere,$data);
    }
}
