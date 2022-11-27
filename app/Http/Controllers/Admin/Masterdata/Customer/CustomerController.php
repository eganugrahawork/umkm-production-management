<?php

namespace App\Http\Controllers\Admin\Masterdata\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerType;
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
                $action = "<a onclick='infoModal($model->id)' class='btn btn-sm btn-icon btn-info btn-hover-rise me-1'><i class='bi bi-info-square'></i></a>";
                if (Gate::allows('updated', ['/admin/masterdata/customer'])) {
                    $action .= "<a onclick='editModal($model->id)' class='btn btn-sm btn-icon btn-warning btn-hover-rise me-1'><i class='bi bi-pencil-square'></i></a>";
                }
                if (Gate::allows('deleted', ['/admin/masterdata/customer'])) {
                    $action .= " <a href='/admin/masterdata/customer/delete/$model->id' class='btn btn-sm btn-icon btn-danger btn-hover-rise me-1' id='deletecustomertype'><i class='bi bi-trash'></i></a>";
                }
                return $action;
            })
            ->make(true);
    }

    public function getcode(Request $request) {
        $customer_type = CustomerType::where(['id' => $request->id])->first();
        $customer = Customer::where(['type_id' => $request->id])->latest()->first();
        if ($customer) {
            $ujung = $customer->id + 1;
            $code = $customer_type->name . '00' . $ujung;
        } else {
            $code = $customer_type->name . '001';
        }

        return response()->json(['code' => $code]);
    }

    public function create() {
        return view('admin.masterdata.customer.create',['type' => CustomerType::all()]);
    }

    public function store(Request $request) {
        Customer::create([
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

        return response()->json(['success' => 'Customer Added']);
    }

    public function edit(Request $request) {
        return view('admin.masterdata.customer.edit', ['customer' => Customer::where(['id' => $request->id])->first(),'type' => CustomerType::all()]);
    }

    public function update(Request $request) {
        // dd($request);
        Customer::where(['id' => $request->id])->update([
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

        return response()->json(['success' => 'Type Partner Updated']);
    }

    public function delete(Request $request) {
        Customer::where(['id' => $request->id])->delete();
        return response()->json(['success' => 'Customer Deleted']);
    }
}
