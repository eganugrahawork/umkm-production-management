<?php

namespace App\Http\Controllers\Admin\Masterdata\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(){
        return view('admin.masterdata.partner.index');
    }
}
