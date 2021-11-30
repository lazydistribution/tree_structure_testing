<?php


class PostController extends Controller
{
    public function index($request) {
        return ['msg' => $this->Service->index(), 'status' => 200];
    }

    public function update($request) {
        return ['msg' => $request->input('route'), 'status' => 200];
    }
}