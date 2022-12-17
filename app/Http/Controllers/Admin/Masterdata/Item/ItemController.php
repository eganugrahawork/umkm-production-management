<?php

namespace App\Http\Controllers\Admin\Masterdata\Item;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Ordering;
use App\Models\Variant;
use App\Models\VariantOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ItemController extends Controller {
    public function index() {
        return view('admin.masterdata.item.index');
    }
    public function list() {
        return DataTables::of(DB::select('SELECT a.*, b.name AS category_name FROM items a JOIN item_categories b ON a.category_id = b.id'))->addIndexColumn()
            ->addColumn('action', function ($model) {
                $action = "";
                if (Gate::allows('updated', ['/admin/masterdata/item'])) {
                    $action .= "<a onclick='editModal($model->id)' class='btn btn-sm btn-icon btn-warning btn-hover-rise me-1'><i class='bi bi-pencil-square'></i></a>";
                }
                if (Gate::allows('deleted', ['/admin/masterdata/item'])) {
                    $action .= " <a href='/admin/masterdata/item/delete/$model->id' class='btn btn-sm btn-icon btn-danger btn-hover-rise me-1' id='deletetypepartner'><i class='bi bi-trash'></i></a>";
                }
                return $action;
            })
            ->make(true);
    }

    public function getcode(Request $request) {
        $ordering = Ordering::where(['name' => 'Item'])->first();
        $seq = $ordering->sequence + 1;
        $code = $ordering->begin_code . date("Ymd") . $ordering->middle_code . $seq;

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
                'item_id' => $idItem,
                'have_variant' => 0
            ])->id;



            VariantOption::create([
                'variant_id' => $idVariant,
                'price' => $request->price
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

        $ordering = Ordering::where(['name' => 'Item'])->first();
        $newSeq = $ordering->sequence + 1;
        Ordering::where(['name' => 'Item'])->update(['sequence' => $newSeq]);
        return response()->json(['success' => 'Item Added']);
    }

    public function edit(Request $request) {
        $item = Item::where(['id' => $request->id])->first();

        $variant = Variant::where(['item_id' => $item->id])->first();
        $variant2 = Variant::where(['item_id' => $item->id, 'parent' => $variant->id])->first();

        if ($variant2) {
            $is_variant = 2;
            $detail_item['variant_1'] = DB::select("SELECT b.`variant_id`, a.name AS variant_name, b.`id` AS option_id, b.`name` AS option_name, b.price
            FROM variants a
            JOIN variant_options b ON a.id = b.variant_id
            WHERE a.item_id = $item->id and b.parent =0");

            $detail_item['variant_2'] = VariantOption::select('variant_options.name as option_name', 'variant_options.id as option_id', 'variant_options.price', 'variants.name as variant_name', 'variants.id as variant_id')->where('variant_options.parent', $detail_item['variant_1'][0]->option_id)->join('variants', 'variant_options.variant_id', '=', 'variants.id')->get();
        } else {
            $is_variant = 1;
            $detail_item = DB::select("SELECT b.`variant_id`, a.name AS variant_name, b.`id` AS option_id, b.`name` AS option_name, b.price
            FROM variants a
            JOIN variant_options b ON a.id = b.variant_id
            WHERE a.item_id = $item->id");
        }

        if ($variant->have_variant === 0) {
            $is_variant = 0;
            $detail_item = DB::select('SELECT b.`variant_id`, b.`id` AS option_id, b.price FROM variants a JOIN variant_options b ON a.id = b.variant_id WHERE a.item_id = ' . $item->id);
        }

        // dd($detail_item);

        return view('admin.masterdata.item.edit', ['item' => Item::where(['id' => $request->id])->first(), 'category' => ItemCategory::all(), 'is_variant' => $is_variant,  'detail_item' => $detail_item]);
    }

    public function update(Request $request) {

        if ($request->is_variant == 0) {
            if (!$request->variant1) {

                Item::where(['id' => $request->item_id])->update([
                    'name' => $request->name,
                    'category_id' => $request->category_id,
                    'description' => $request->description
                ]);


                VariantOption::where(['id' => $request->option_id])->update([
                    'price' => $request->price
                ]);
            } else {
                Item::where(['id' => $request->item_id])->update([
                    'name' => $request->name,
                    'category_id' => $request->category_id,
                    'description' => $request->description
                ]);


                $query = "DELETE a, b FROM variants AS a JOIN variant_options AS b ON a.id = b.variant_id WHERE a.item_id = $request->item_id";

                DB::delete($query);

                $idVariant1 = Variant::create([
                    'item_id' => $request->item_id,
                    'name' => $request->variant1,
                ])->id;


                if ($request->variant2) {
                    $idVariant2 = Variant::create([
                        'item_id' => $request->item_id,
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
        } elseif ($request->is_variant == 1) {

            Item::where(['id' => $request->item_id])->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description
            ]);

            if (!$request->variant1) {
                $query = "DELETE a, b FROM variants AS a JOIN variant_options AS b ON a.id = b.variant_id WHERE a.item_id = $request->item_id";
                DB::delete($query);
                $idVariant = Variant::create([
                    'item_id' => $request->item_id,
                    'have_variant' => 0
                ])->id;

                VariantOption::create([
                    'variant_id' => $idVariant,
                    'price' => $request->price
                ]);
            } else {
                if ($request->variant2) {
                    Variant::where(['item_id' => $request->item_id])->update(['name' => $request->variant1]);
                    $idVariant1 = Variant::where(['item_id' => $request->item_id])->first();
                    $inOption = VariantOption::where(['variant_id' => $idVariant1->id])->get();
                    $idVariant2 = Variant::create([
                        'item_id' => $request->item_id,
                        'parent' => $idVariant1->id,
                        'name' => $request->variant2,
                    ])->id;
                    if (count($inOption) == count($request->option1)) {
                        $noPrice = 0;
                        for ($i = 0; $i < count($request->option1); $i++) {
                            // jangan sampai edit ini mengganggu penjualan
                            VariantOption::where('id', $inOption[$i]->id)->update([
                                'name' => $request->option1[$i],
                                'price' => 0,
                            ]);
                            for ($j = 0; $j < count($request->option2); $j++) {
                                VariantOption::create([
                                    'variant_id' => $idVariant2,
                                    'parent' => $inOption[$i]->id,
                                    'name' => $request->option2[$j],
                                    'price' => $request->price[$noPrice],
                                ]);
                                $noPrice += 1;
                            }
                        }
                    } else {
                        if (count($inOption) > count($request->option1)) {
                            $noPrice =0;
                            for ($i = 0; $i < count($inOption); $i++) {
                                // jangan sampai edit ini mengganggu penjualan
                                if (isset($request->option1[$i])) {
                                    VariantOption::where(['id' => $inOption[$i]->id])->update([
                                        'name' => $request->option1[$i],
                                        'price' => $request->price[$i]
                                    ]);

                                    for ($j = 0; $j < count($request->option2); $j++) {
                                        VariantOption::create([
                                            'variant_id' => $idVariant2,
                                            'parent' => $inOption[$i]->id,
                                            'name' => $request->option2[$j],
                                            'price' => $request->price[$noPrice],
                                        ]);
                                        $noPrice += 1;
                                    }

                                } else {
                                    VariantOption::where(['id' => $inOption[$i]->id])->delete();
                                }
                            }
                        } else {
                            $noPrice = 0;
                            for ($i = 0; $i < count($request->option1); $i++) {
                                // jangan sampai edit ini mengganggu penjualan
                                if (isset($inOption[$i])) {
                                    VariantOption::where('id', $inOption[$i]->id)->update([
                                        'name' => $request->option1[$i],
                                        'price' => $request->price[$i],
                                    ]);
                                    for ($j = 0; $j < count($request->option2); $j++) {
                                        VariantOption::create([
                                            'variant_id' => $idVariant2,
                                            'parent' => $inOption[$i]->id,
                                            'name' => $request->option2[$j],
                                            'price' => $request->price[$noPrice],
                                        ]);
                                        $noPrice += 1;
                                    }
                                } else {
                                   $idParent2nya = VariantOption::create([
                                        'variant_id' => $idVariant1->id,
                                        'name' => $request->option1[$i],
                                        'price' => $request->price[$i],
                                    ])->id;

                                    for ($j = 0; $j < count($request->option2); $j++) {
                                        VariantOption::create([
                                            'variant_id' => $idVariant2,
                                            'parent' => $idParent2nya,
                                            'name' => $request->option2[$j],
                                            'price' => $request->price[$noPrice],
                                        ]);
                                        $noPrice += 1;
                                    }
                                }

                            }
                        }
                    }
                } else {
                    Variant::where(['item_id' => $request->item_id])->update(['name' => $request->variant1]);
                    $idVariant1 = Variant::where(['item_id' => $request->item_id])->first();
                    $inOption = VariantOption::where(['variant_id' => $idVariant1->id])->get();
                    if (count($inOption) == count($request->option1)) {

                        for ($i = 0; $i < count($request->option1); $i++) {
                            // jangan sampai edit ini mengganggu penjualan
                            VariantOption::where('id', $inOption[$i]->id)->update([
                                'name' => $request->option1[$i],
                                'price' => $request->price[$i],
                            ]);
                        }
                    } else {
                        if (count($inOption) > count($request->option1)) {
                            for ($i = 0; $i < count($inOption); $i++) {
                                // jangan sampai edit ini mengganggu penjualan
                                if (isset($request->option1[$i])) {
                                    VariantOption::where(['id' => $inOption[$i]->id])->update([
                                        'name' => $request->option1[$i],
                                        'price' => $request->price[$i]
                                    ]);
                                } else {
                                    VariantOption::where(['id' => $inOption[$i]->id])->delete();
                                }
                            }
                        } else {
                            for ($i = 0; $i < count($request->option1); $i++) {
                                // jangan sampai edit ini mengganggu penjualan
                                if (isset($inOption[$i])) {
                                    VariantOption::where('id', $inOption[$i]->id)->update([
                                        'name' => $request->option1[$i],
                                        'price' => $request->price[$i],
                                    ]);
                                } else {
                                    VariantOption::create([
                                        'variant_id' => $idVariant1->id,
                                        'name' => $request->option1[$i],
                                        'price' => $request->price[$i],
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        } elseif ($request->is_variant == 2) {

        }

        return response()->json(['success' => 'Item Updated']);
    }

    public function delete(Request $request) {
        $query = "DELETE a, b, c FROM items AS a JOIN variants AS b ON a.id = b.item_id JOIN variant_options AS c ON b.id = c.variant_id WHERE a.id = $request->id";
        DB::delete($query);

        return response()->json(['success' => 'Items Deleted']);
    }
}
