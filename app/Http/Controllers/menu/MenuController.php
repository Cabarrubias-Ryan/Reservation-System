<?php

namespace App\Http\Controllers\menu;

use App\Models\Venue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class MenuController extends Controller
{
    public function index(){
      $venues = Venue::with('picture')
      ->whereNull('deleted_at')
      ->get();
      return view('content.menu.menu',compact('venues'));
    }
    public function viewDetails($id){
      $venue = Venue::with('picture')
      ->where('id',Crypt::decryptString($id))
      ->first();

      return view('content.menu.details',compact('venue'));
    }
}
