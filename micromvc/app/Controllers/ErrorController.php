<?php


class ErrorController extends Controller
{
    public function json($request) {
        switch($request->status()) {
            case 404:
            default:
                $response = ['msg' => 'Not Found!', 'status' => 404];
                break;
        }
        return $response;
    }
    
    public function html($request) {
        //Response::html(HTML::view('error.404', ));
        switch($request->status()) {
            case 404:
            default:
                $response = HTML::view('error.404', ['base_url' => base_url()]);
                break;
        }
        return $response;
    }
}