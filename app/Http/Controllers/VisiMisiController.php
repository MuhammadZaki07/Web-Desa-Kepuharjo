<?php

namespace App\Http\Controllers;


class VisiMisiController extends Controller
{
    public function index()
    {
        $title = 'Visi Misi';

        return view('pages.VisiMisi', compact(
            'title'
        ));
    }
}
