<?php

class Home extends Controller
{
    public function index()
    {
        $this->view('home');
    }

    public function edit($id)
    {
        $this->view('home');
    }
}