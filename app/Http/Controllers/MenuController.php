<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(){
      $venues = Venue::with('picture')
      ->whereNull('deleted_at')
      ->get();
      return view('content.menu.menu',compact('venues'));
    }
}
