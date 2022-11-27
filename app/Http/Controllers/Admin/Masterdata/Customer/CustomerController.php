<?php

namespace App\Http\Controllers\Admin\Masterdata\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index(){
        return view('admin.masterdata.customer.index');
    }
    public function list() {
        return DataTables::of(Customer::all())->addIndexColumn()
            ->addColumn('action', function ($model) {
                $action = "";
                if (Gate::allows('updated', ['/admin/masterdata/customer'])) {
                    $action .= "<a onclick='editModal($model->id)' class='btn btn-sm btn-icon btn-warning btn-hover-rise me-1'><i class='bi bi-pencil-square'></i></a>";
                }
                if (Gate::allows('deleted', ['/admin/masterdata/customer'])) {
                    $action .= " <a href='/admin/masterdata/customer/delete/$model->id' class='btn btn-sm btn-icon btn-danger btn-hover-rise me-1' id='deletetypepartner'><i class='bi bi-trash'></i></a>";
                }
                return $action;
            })
            ->make(true);
    }

    public function create() {
        return view('admin.masterdata.customer.create',);
    }

    public function store(Request $request) {
        Customer::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Customer Added']);
    }

    public function edit(Request $request) {
        return view('admin.masterdata.customer.edit', ['customer' => Customer::where(['id' => $request->id])->first()]);
    }

    public function update(Request $request) {
        // dd($request);
        Customer::where(['id' => $request->id])->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Type Partner Updated']);
    }

    public function delete(Request $request) {
        Customer::where(['id' => $request->id])->delete();
        return response()->json(['success' => 'Customer Deleted']);
    }
}
