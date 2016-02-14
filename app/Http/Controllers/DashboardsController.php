<?php

namespace App\Http\Controllers;

use App\Tindang;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Debugbar;
class DashboardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function user()
    {
        if(Auth::user()->is('admin')){
            return redirect('/');
        }
        $tindang_saves = Auth::user()->save_tindangs()
                                     ->orderBy('created_at', 'desc')
                                     ->paginate(5);

        $tindangs = DB::table('tindangs')
            ->select('tindangs.*', 'users.hoten', 'users.SDT')
            ->join('users', 'tindangs.user_id', '=',  'users.id')
            ->orderBy('ngaydang', 'desc')
            ->where('users.id', '=', Auth::user()->id)
            ->paginate(5);


        return view('dashboard', compact('tindangs', 'tindang_saves'));
    }
}