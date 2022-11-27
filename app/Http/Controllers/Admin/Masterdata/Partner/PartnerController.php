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

    public function getcode(Request $request) {
        $partner = Partner::latest()->first();
        if ($partner) {
            $ujung = $partner->id + 1;
            $code = '00' . $ujung;
        } else {
            $code = '001';
        }

        return response()->json(['code' => $code]);
    }

    public function create() {
        return view('admin.masterdata.partner.create', ['typepartner' => TypePartner::all()]);
    }

    public function store(Request $request) {
        Partner::create([
            'code' => $request->code,
            'name' => $request->name,
            'type_id' => $request->type_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'bank_name' => $request->bank_name,
            'bank_number' => $request->bank_number,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Partner Added']);
    }

    public function edit(Request $request) {
        return view('admin.masterdata.partner.edit', ['typepartner' => TypePartner::all(), 'partner' => Partner::where(['id' => $request->id])->first()]);
    }

    public function update(Request $request) {
        // dd($request);
        Partner::where(['id' => $request->id])->update([
            'code' => $request->code,
            'name' => $request->name,
            'type_id' => $request->type_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'bank_name' => $request->bank_name,
            'bank_number' => $request->bank_number,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Partner Updated']);
    }

    public function delete(Request $request){
        Partner::where(['id' => $request->id])->delete();
        return response()->json(['success' => 'Partner Deleted']);
    }
}
