<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDetails;
use App\Exports\UserDetailsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\AvailableSlotMail;

class UserListController extends Controller
{
    public function index()
    {
        $userlist = UserDetails::All();
        return $userlist;
    }

    public function downloadUserDetails()
    {
        return Excel::download(new UserDetailsExport, 'userdetails.csv');
    }

    public function districts()
    {
        $districts = UserDetails::select('district')
        ->groupBy('district')
        ->get();
        $mytime = date('d-m-Y');
        // dd($mytime);
        // $district = 302;
        foreach ($districts as $value){
            $district = $value->district;
            // echo $district;
            $response = Http::withHeaders([
                "User-Agent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36 Edg/90.0.818.56"
            ])->get("https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/calendarByDistrict?district_id=$district&date=$mytime")->body();
            
            $json = json_decode($response, true);

            // dd($json);

            foreach($json as $res) {
                foreach($res as $d){
                    $data = $d;
                }
            }

            $user_email = UserDetails::select('email')
                    ->where('district', $district)
                    ->get();
                    foreach ($user_email as $mail){
                        $email =  $mail->email;
                        Mail::to($email)->send(new AvailableSlotMail($data));
                    }
        }
    }
}
