<?php

namespace App\Http\Controllers\Admin\Masterdata\Item;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Variant;
use App\Models\VariantOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ItemController extends Controller {
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

    public function getcode(Request $request) {
        $item = Item::latest()->first();
        if ($item) {
            $ujung = $item->id + 1;
            $code = '00' . $ujung;
        } else {
            $code = '001';
        }

        return response()->json(['code' => $code]);
    }

    public function create() {
        return view('admin.masterdata.item.create', ['category' => ItemCategory::all()]);
    }

    public function store(Request $request) {
        if (!$request->variant1) {
            $idItem = Item::create([
                'code' => $request->code,
                'name' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description
            ])->id;

            $idVariant = Variant::create([
                'item_id' => $idItem
            ])->id;



            VariantOption::create([
                'variant_id' => $idVariant,
                'price' => $request->price,
            ]);
        } else {
            $idItem = Item::create([
                'code' => $request->code,
                'name' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description
            ])->id;


            $idVariant1 = Variant::create([
                'item_id' => $idItem,
                'name' => $request->variant1,
            ])->id;


            if ($request->variant2) {
                $idVariant2 = Variant::create([
                    'item_id' => $idItem,
                    'parent' => $idVariant1,
                    'name' => $request->variant2,
                ])->id;

                $noPrice = 0;

                for ($i = 0; $i < count($request->option1); $i++) {

                    $idOption1 = VariantOption::create([
                        'variant_id' => $idVariant1,
                        'name' => $request->option1[$i],
                    ])->id;


                    for ($j = 0; $j < count($request->option2); $j++) {
                        VariantOption::create([
                            'variant_id' => $idVariant2,
                            'parent' => $idOption1,
                            'name' => $request->option2[$j],
                            'price' => $request->price[$noPrice],
                        ]);
                        $noPrice += 1;
                    }
                }
            } else {
                for ($i = 0; $i < count($request->option1); $i++) {
                    VariantOption::create([
                        'variant_id' => $idVariant1,
                        'name' => $request->option1[$i],
                        'price' => $request->price[$i],
                    ]);
                }
            }
        }
        return response()->json(['success' => 'Item Added']);
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
