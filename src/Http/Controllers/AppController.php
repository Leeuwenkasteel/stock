<?php

namespace Leeuwenkasteel\Stock\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Leeuwenkasteel\Templates\Models\Apps;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AppController extends Controller implements HasMiddleware
{  
    public static function middleware(): array
    {
        return [
            //new Middleware('permission:stock.index', only: ['index']),
			//new Middleware('app.auth:stock', except: ['index', 'login']),
        ];
    }
    public function index(){
		$page = 'stock';
		$app = Apps::whereSlug($page)->get()->first();
        return view('templates::pages.install', compact('app'));
    }
	
	public function login(){
		return view('stock::login');
	}
	
	public function home(){
		return view('stock::home');
	}
	
	public function scan(){
		return view('stock::scan');
	}
	
}