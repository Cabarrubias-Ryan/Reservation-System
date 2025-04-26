<?php

namespace App\Http\Controllers\product;

use App\Models\Log;
use App\Models\Photo;
use App\Models\Venue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  public function index()
  {
      $venues = Venue::with('picture')
          ->whereNull('deleted_at')
          ->get();

      return view('content.products.site-product', compact('venues'));
  }

  public function store(Request $request){

    $logData = [
      'users_id' => Auth::id(),
      'action' => 'Add',
      'tablename' => 'Venues',
      'description' => 'Added a venue',
      'ip_address' => '127.0.0.1:8000',
      'created_at' => now(),
    ];

    $resultLogs = Log::create($logData);

    $venue = Venue::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'category' => $request->category,
        'created_at' => now(),
        'updated_at' => now(),
        'logs_id' => $resultLogs->id
    ]);

    if ($request->hasFile('imagesData')) {
      foreach ($request->file('imagesData') as $image) {
          $path = $image->store('public/uploads');
            Photo::create([
                'v_code' => $request->code,
                'path' => Storage::url($path),
                'created_at' => now(),
                'updated_at' => now(),
                'venues_id' => $venue->id,
            ]);
        }
    }

    return response()->json(['Error' => 0, 'Message' => 'Successfully added a data']);
  }
  public function delete(Request $request){

    $logData = [
      'users_id' => Auth::id(),
      'action' => 'Delete',
      'tablename' => 'Venues',
      'description' => 'Delete a venue',
      'ip_address' => '127.0.0.1:8000',
      'created_at' => now(),
    ];

    $resultLogs = Log::create($logData);

    $venue = [
      'deleted_at' => now()
    ];

    $resultvenue = Venue::where('id', Crypt::decryptString($request->id))->update($venue);

    if($resultvenue){
      return response()->json(['Error' => 0, 'Message' => 'Successfully delete a data']);
    }
  }
  public function update(Request $request){
    return response()->json(['Error' => 0, 'Message' => 'Successfully update a data']);
  }
  public function filter(Request $request){
    return response()->json(['Error' => 0, 'Message' => 'Successfully added a data']);
  }
}
