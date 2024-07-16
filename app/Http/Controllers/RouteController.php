<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\User;

class RouteController extends Controller
{
    public function dashboard(){
    	session_start();

        $user = User::where('user_id', $_SESSION["rapidx_user_id"])->first();

        if($user != null) {
            $_SESSION["sr_iss_staff"] = $user->iss_staff;
            $_SESSION["sr_admin"] = $user->admin;
        }
        else {
            $_SESSION["sr_iss_staff"] = 0;
            $_SESSION["sr_admin"] = 0;
        }

        if(isset($_SESSION["rapidx_user_id"])){
			return view('admin_dashboard');
    	}
    	else{
    		return redirect()->route('session_expired');
    	}
    }

    public function users(){
        session_start();
        if(isset($_SESSION["rapidx_user_id"])){
            return view('users');
        }
        else{
            return redirect()->route('session_expired');
        }
    }

    public function service_types(){
        session_start();
        if(isset($_SESSION["rapidx_user_id"])){
            return view('service_types');
        }
        else{
            return redirect()->route('session_expired');
        }
    }

    public function ticketing(){
        session_start();
        if(isset($_SESSION["rapidx_user_id"])){
            return view('tickets');
        }
        else{
            return redirect()->route('session_expired');
        }
    }

    public function my_tickets(){
        session_start();
        if(isset($_SESSION["rapidx_user_id"])){
            return view('my_tickets');
        }
        else{
            return redirect()->route('session_expired');
        }
    }

    public function holidays(){
        session_start();
        if(isset($_SESSION["rapidx_user_id"])){
            return view('holidays');
        }
        else{
            return redirect()->route('session_expired');
        }
    }
}
