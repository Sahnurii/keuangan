<?php
class ErrorController extends Controller
{
    // public function forbidden()
    // {
    //     $this->view('error/forbidden');
    // }

    public function notFound()
    {
        http_response_code(404); // Set status HTTP
        $this->view('error/notfound');
    }

    public function index()
    {
        $data['judul'] = 'Error Forbidden';
        $this->view('error/index', $data);
    }
}
