<?php

namespace App\Http\Controllers\Admin\Masterdata\Item;

use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ItemCategoryController extends Controller
{
    public function index(){
        return view('admin.masterdata.item.itemcategory.index');
    }
    public function list() {
        return DataTables::of(ItemCategory::all())->addIndexColumn()
            ->addColumn('action', function ($model) {
                $action = "";
                if (Gate::allows('updated', ['/admin/masterdata/item/category'])) {
                    $action .= "<a onclick='editModal($model->id)' class='btn btn-sm btn-icon btn-warning btn-hover-rise me-1'><i class='bi bi-pencil-square'></i></a>";
                }
                if (Gate::allows('deleted', ['/admin/masterdata/item/category'])) {
                    $action .= " <a href='/admin/masterdata/item/category/delete/$model->id' class='btn btn-sm btn-icon btn-danger btn-hover-rise me-1' id='deletetypepartner'><i class='bi bi-trash'></i></a>";
                }
                return $action;
            })
            ->make(true);
    }

    public function create() {
        return view('admin.masterdata.item.itemcategory.create',);
    }

    public function store(Request $request) {
        ItemCategory::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Category Added']);
    }

    public function edit(Request $request) {
        return view('admin.masterdata.item.itemcategory.edit', ['category' => ItemCategory::where(['id' => $request->id])->first()]);
    }

    public function update(Request $request) {
        // dd($request);
        ItemCategory::where(['id' => $request->id])->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return response()->json(['success' => 'Category Updated']);
    }

    public function delete(Request $request) {
        ItemCategory::where(['id' => $request->id])->delete();
        return response()->json(['success' => 'Category Deleted']);
    }
}
