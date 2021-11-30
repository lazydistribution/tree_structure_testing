<?php


class LandingPageController extends Controller 
{
    public function index($request) {
        return HTML::view('index.index', [
            'base_url' => base_url()
        ]);
    }
}