<?php

namespace App\Http\Controllers\Admin\Masterdata\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;


class CustomerTypeController extends Controller
{
    public function index(){
        return view('admin.masterdata.customer.customertype.index');
    }
    public function list() {
        return DataTables::of(CustomerType::all())->addIndexColumn()
            ->addColumn('action', function ($model) {
                $action = "";
                if (Gate::allows('updated', ['/admin/masterdata/customer/type'])) {
                    $action .= "<a onclick='editModal($model->id)' class='btn btn-sm btn-icon btn-warning btn-hover-rise me-1'><i class='bi bi-pencil-square'></i></a>";
                }
                if (Gate::allows('deleted', ['/admin/masterdata/customer/type'])) {
                    $action .= " <a href='/admin/masterdata/customer/type/delete/$model->id' class='btn btn-sm btn-icon btn-danger btn-hover-rise me-1' id='deletetypepartner'><i class='bi bi-trash'></i></a>";
                }
                return $action;
            })
            ->make(true);
    }

    public function create() {
        return view('admin.masterdata.customer.customertype.create',);
    }

    public function store(Request $request) {
        CustomerType::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Type Customer Added']);
    }

    public function edit(Request $request) {
        return view('admin.masterdata.customer.customertype.edit', ['type' => CustomerType::where(['id' => $request->id])->first()]);
    }

    public function update(Request $request) {
        // dd($request);
        CustomerType::where(['id' => $request->id])->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Type Customer Updated']);
    }

    public function delete(Request $request) {
        CustomerType::where(['id' => $request->id])->delete();
        return response()->json(['success' => 'Type Customer Deleted']);
    }
}
