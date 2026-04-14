<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class SessionsController extends Controller
{
    
    public function create()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'num_eco' => 'required',
            'nip' => 'required',
        ]);


        if (Auth::attempt($validated)) {
            
            $request->session()->regenerate();

            return redirect()->intended('/'); // Redirect to intended page after login   
        }


        return back()->withErrors([
            'num_eco' => 'Número económico o NIP incorrecto.',
        ])->onlyInput('num_eco');

    }

//
}
