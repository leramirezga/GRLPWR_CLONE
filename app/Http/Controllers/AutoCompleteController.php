<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class AutoCompleteController extends Controller
{
    function index()
    {
        return view('autocomplete');
    }

    function fetch(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = DB::table('tags')
                ->where('descripcion', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative; text-align: center">';
            foreach ($data as $row) {
                $output .= '<li>' . $row->descripcion . '</li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}
