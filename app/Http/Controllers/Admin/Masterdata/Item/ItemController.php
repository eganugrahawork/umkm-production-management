<?php
namespace App\Http\Controllers\Admin\Masterdata\Item;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
    public function index() {
        return view('admin.masterdata.item.index');
    }
    public function list() {
        return DataTables::of(Item::all())->addIndexColumn()
            ->addColumn('action', function ($model) {
                $action = "";
                if (Gate::allows('updated', ['/admin/masterdata/item'])) {
                    $action .= "<a onclick='editModal($model->id)' class='btn btn-sm btn-icon btn-warning btn-hover-rise me-1'><i class='bi bi-pencil-square'></i></a>";
                }
                if (Gate::allows('deleted', ['/admin/masterdata/item'])) {
                    $action .= " <a href='/admin/masterdata/partner/typepartner/delete/$model->id' class='btn btn-sm btn-icon btn-danger btn-hover-rise me-1' id='deletetypepartner'><i class='bi bi-trash'></i></a>";
                }
                return $action;
            })
            ->make(true);
    }

    public function create() {
        return view('admin.masterdata.item.create',);
    }

    public function store(Request $request) {
        TypePartner::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Type Partner Added']);
    }

    public function edit(Request $request) {
        return view('admin.masterdata.partner.typepartner.edit', ['typepartner' => TypePartner::where(['id' => $request->id])->first()]);
    }

    public function update(Request $request) {
        // dd($request);
        TypePartner::where(['id' => $request->id])->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Type Partner Updated']);
    }

    public function delete(Request $request) {
        TypePartner::where(['id' => $request->id])->delete();
        return response()->json(['success' => 'Type Partner Deleted']);
    }
}
