<?php

namespace App\Http\Controllers\Admin\Masterdata\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\TypePartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class PartnerController extends Controller {
    public function index() {
        return view('admin.masterdata.partner.index');
    }
    public function list() {
        return DataTables::of(Partner::all())->addIndexColumn()
            ->addColumn('action', function ($model) {
                $action = "<a onclick='infoModal($model->id)' class='btn btn-sm btn-icon btn-info btn-hover-rise me-1'><i class='bi bi-info-square'></i></a>";
                if (Gate::allows('updated', ['/admin/masterdata/partner'])) {
                    $action .= "<a onclick='editModal($model->id)' class='btn btn-sm btn-icon btn-warning btn-hover-rise me-1'><i class='bi bi-pencil-square'></i></a>";
                }
                if (Gate::allows('deleted', ['/admin/masterdata/partner'])) {
                    $action .= " <a href='/admin/masterdata/partner/delete/$model->id' class='btn btn-sm btn-icon btn-danger btn-hover-rise me-1' id='deletepartners'><i class='bi bi-trash'></i></a>";
                }
                return $action;
            })
            ->make(true);
    }

    public function create() {
        return view('admin.masterdata.partner.create', ['typepartner' => TypePartner::all()]);
    }

    public function store(Request $request) {
        dd($request);
    }
}
