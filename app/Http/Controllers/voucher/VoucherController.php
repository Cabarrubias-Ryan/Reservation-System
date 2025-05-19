<?php

namespace App\Http\Controllers\voucher;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Models\VoucherDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class VoucherController extends Controller
{
    public function index()
    {
      $today = now()->toDateString(); // e.g. '2025-05-16'

      $voucher = Voucher::whereNull('deleted_at')
          ->orderBy('created_at', 'desc')
          ->get()
          ->map(function ($item) use ($today) {
              $item->is_expired = $item->expire_date < $today;
              return $item;
          });
      return view('content.voucher.voucher', compact('voucher'));
    }
    public function store(Request $request)
    {
      $data = [
        'code' => $request->voucherCode,
        'name' => $request->voucherName,
        'description' => $request->voucherDescription,
        'requirements' => $request->voucherRequirements,
        'discount' => $request->voucherDiscount,
        'expire_date' => $request->voucherExpire,
        'use' => 0,
        'created_at' => now()
      ];

      $result = Voucher::insert($data);

      if($result){
        return response()->json(['Error' => 0, 'Message' => 'Successfully added a vouchers']);
      }
    }
    public function update(Request $request) {
      $data = [
        'code' => $request->voucherCode,
        'name' => $request->voucherName,
        'description' => $request->voucherDescription,
        'requirements' => $request->voucherRequirements,
        'discount' => $request->voucherDiscount,
        'expire_date' => $request->voucherExpire,
      ];

      $result = Voucher::where('id', Crypt::decryptString($request->id))->update($data);

      if($result){
        return response()->json(['Error' => 0, 'Message' => 'Successfully updated the vouchers']);
      }
    }
    public function delete(Request $request) {
      $data = [
        'deleted_at' => now()
      ];

      $result = Voucher::where('id', Crypt::decryptString($request->id))->update($data);

      if($result){
        return response()->json(['Error' => 0, 'Message' => 'Successfully deleted the vouchers']);
      }
    }
    // voucher list
    public function display(){
      $userId = Auth::id();

      $voucher = Voucher::with('details')
          ->whereNull('deleted_at')
          ->whereDoesntHave('details', function ($query) use ($userId) {
              $query->where('users_id', $userId);
          })
          ->orderBy('created_at', 'desc')
          ->get();

      return view('content.voucher.voucher-list', compact('voucher'));
    }
    // claim Voucher
    public function myVouchersList() {
      $today = now()->toDateString();

      $voucher = VoucherDetails::leftJoin('vouchers', 'vouchers.id', '=', 'vouchers_details.vouchers_id')
          ->whereNull('deleted_at')
          ->where('vouchers_details.users_id', '=', Auth::id())
          ->select('vouchers.*', 'vouchers_details.*', 'vouchers_details.use as used')
          ->get()
          ->map(function ($item) use ($today) {
              $item->is_expired = $item->expire_date < $today;
              return $item;
          });

      return view('content.voucher.voucher-user',compact('voucher'));
    }
    // Voucher add
    public function addVouchers(Request $request){
      $voucher = Voucher::where('id', Crypt::decryptString($request->id))->first();

      $data = [
        'start_at' => now(),
        'expired_at' => $voucher->expire_date,
        'users_id' => Auth::id(),
        'vouchers_id' => Crypt::decryptString($request->id),
        'use' => 0
      ];
      $result = VoucherDetails::insert($data);

      if($result){
        return redirect()->route('vouchers-list')->with('claim', 'Voucher successfully Claim.');
      }
    }
}
