<form id="update-form">
    @csrf
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-bordered">
                <div class="card-header bg-info">
                    <h3 class="card-title text-white">Information <i class="bi bi-lightbulb"></i></h3>
                    <div class="card-toolbar">

                    </div>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Masukan nama Produk yang sesuai atau <span class="fw-bold">TIDAK</span> dengan nama kategori
                            atau nama varian. Contoh : Daster Polos (Benar). Contoh : Daster Polos Hitam (Salah)</li>
                        <li>Pastikan produk yang <span class="fw-bold">sama TIDAK</span> diunggah lebih dari 1x.</li>
                        <li>Pastikan <span class="fw-bold">FIELD TIDAK ADA</span> yang <span
                                class="fw-bold">KOSONG</span></li>
                    </ul>
                </div>
                <div class="card-footer">
                    Made By E.N
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <div class="fv-row mb-7 col-lg-8">
                <label class="required fw-bold fs-6 mb-2">Code</label>
                <input type="text" name="code" id="code" value="{{ $item->code }}" readonly
                    class="form-control form-control-solid mb-3 mb-lg-0" required />
            </div>
            <div class="fv-row mb-7 col-lg-8">
                <label class="required fw-bold fs-6 mb-2">Name</label>
                <input type="text" name="name" id="name" value="{{ $item->name }}"
                    class="form-control form-control-solid mb-3 mb-lg-0" required />
            </div>
            <div class="fv-row mb-7 col-lg-8">
                <label class="required form-label fw-bold">Category</label>
                <select class="form-select  form-select-solid mb-3 mb-lg-0 select-2" name="category_id" id="category_id"
                    required>
                    @foreach ($category as $ct)
                        <option value="{{ $ct->id }}" {{ $item->category_id == $ct->id ? 'selected' : '' }}>
                            {{ $ct->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fv-row mb-7 col-lg-8">
                <label class="required fw-bold fs-6 mb-2">Description</label>
                <textarea name="description" class="form-control form-control-solid mb-3 mb-lg-0" id="" cols="30"
                    rows="5" required>{{ $item->description }}</textarea>
            </div>

            @if ($is_variant === 0)
                <input type="hidden" name="is_variant" value="0">
                <div id="activeVariant">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="fv-row mb-7">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <p class="fw-bold fs-6 mb-2">Variant : </p>
                                    </div>
                                    <div class="col-lg-9">
                                        <button type="button"
                                            class="btn btn-sm btn-outline btn-outline-dashed btn-outline-info btn-active-light-info"
                                            onclick="activeVariant()"><i
                                                class="bi bi-plus-circle-dotted"></i>Variant</button>
                                    </div>
                                </div>
                            </div>
                            <div id="variant">
                                <div class="col-lg-6 fv-row mb-7">
                                    <input type="hidden" name="variant_id" value="{{ $detail_item[0]->variant_id }}">
                                    <input type="hidden" name="option_id" value="{{ $detail_item[0]->option_id }}">
                                    <label class="required fw-bold fs-6 mb-2">Price (Hpp)</label>
                                    <input type="number" name="price" id="price"
                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                        value="{{ $detail_item[0]->price }}" required />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($is_variant === 1)
                <input type="hidden" name="is_variant" value="1">
                <div id="activeVariant">
                    <div class="fv-row mb-7">
                        <div class="row">
                            <div class="col-lg-1">
                                <p class="fw-bold fs-6 mb-2">Variant : </p>
                            </div>
                            <div class="col-lg-11 bg-gray-100 rounded py-4">
                                <div class="fv-row mb-7 col-lg-6"><label class="required fw-bold fs-6 mb-2">Variant
                                        1</label>
                                    <div class="col-lg-6 d-flex">
                                        <input type="hidden" name="variant1_id"
                                            value="{{ $detail_item[0]->variant_id }}">
                                        <input type="text" name="variant1" id="variant1"
                                            onchange="columnDetailVarian(this)"
                                            class="form-control form-control-white mb-3 mb-lg-0"
                                            value="{{ $detail_item[0]->variant_name }}" required />
                                        <div class="p-2">
                                            <button type="button" class="btn btn-sm btn-outline btn-outline-primary"
                                                onclick="addOptionRow()">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row"><label class="required fw-bold fs-6 mb-2">Option</label>
                                    <div class="row" id="optionrow">
                                        @php
                                            $i = 142;
                                        @endphp
                                        @foreach ($detail_item as $di)
                                            <div class="fv-row mb-7 col-lg-3">
                                                <input type="hidden" name="id_option1[]"
                                                    value="{{ $di->option_id }}">
                                                <div class="input-group"><input type="text" name="option1[]"
                                                        value="{{ $di->option_name }}"
                                                        id="option_key1_{{ $i++ }}"
                                                        onchange="addTableColumn(this,1)"
                                                        class="form-control form-control-white mb-3 mb-lg-0 option-varian1"
                                                        required /><button type="button"
                                                        class="btn btn-sm btn-icon btn-danger input-group-text"
                                                        onclick="deleteOptionRow(this,1)"><i
                                                            class="bi bi-trash"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="fv-row mb-7 row" id="variant2Content"><label
                                        class="required fw-bold fs-6 mb-2">Variant 2</label>
                                    <div class="col-lg-3"><button type="button" onclick="activeVariant2()"
                                            class="btn btn-sm btn-outline btn-outline-dashed btn-outline-info btn-active-light-info"><i
                                                class="bi bi-plus-circle-dotted"></i>Active</button></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end"><button
                                class="btn btn-sm btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger"
                                onclick="unActiveVariant()">Cancel Variant</div>
                    </div>
                </div>

                <div class="py-4 col-lg-8" id="tableVarian">
                    <div class="fv-row mb-7 col-lg-6"><label class="fw-bold fs-6 mb-2">Price for All</label>
                        <div class="input-group"> <input type="text" id="priceForAll"
                                class="form-control form-control-solid mb-3 mb-lg-0" /> <button type="button"
                                class="btn btn-sm btn-primary input-group-text"
                                onclick="changeAllPrice()">Change</button> </div>
                    </div>
                    <table class="table table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr id="columnDetailVarian"
                                class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th id="th_variant_1">{{ $detail_item[0]->variant_name }}</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody id="contentTable">
                            @php
                                $i = 142;
                            @endphp
                            @foreach ($detail_item as $di)
                                <tr>
                                    <td id="content_option_key1_{{ $i++ }}">{{ $di->option_name }}</td>
                                    <td><input type="text" name="price[]"
                                            class="form-control price form-control-solid mb-3 mb-lg-0"
                                            value="{{ $di->price }}" required /></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @endif

            @if ($is_variant === 2)
                <input type="hidden" name="is_variant" value="2">
                <div id="activeVariant">
                    <div class="fv-row mb-7">
                        <div class="row">
                            <div class="col-lg-1">
                                <p class="fw-bold fs-6 mb-2">Variant : </p>
                            </div>
                            <div class="col-lg-11 bg-gray-100 rounded py-4">
                                <div class="fv-row mb-7 col-lg-6"><label class="required fw-bold fs-6 mb-2">Variant
                                        1</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="variant1" id="variant1"
                                            onchange="columnDetailVarian(this)"
                                            class="form-control form-control-white mb-3 mb-lg-0"
                                            value="{{ $detail_item['variant_1'][0]->variant_name }}" required />
                                    </div>
                                </div>
                                <div class="row"><label class="required fw-bold fs-6 mb-2">Option</label>
                                    <div class="row" id="optionrow">
                                        @foreach ($detail_item['variant_1'] as $di)
                                            <div class="fv-row mb-7 col-lg-3">
                                                <div class="input-group"><input type="text" name="option1[]"
                                                        onchange="addOptionRow()" value="{{ $di->option_name }}"
                                                        id="option"
                                                        class="form-control form-control-white mb-3 mb-lg-0 option-varian1"
                                                        required /><button type="button"
                                                        class="btn btn-sm btn-icon btn-danger input-group-text"
                                                        onclick="deleteOptionRow(this)"><i
                                                            class="bi bi-trash"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="fv-row mb-7 row" id="variant2Content">
                                    <div class="fv-row mb-7 col-lg-6"><label
                                            class="required fw-bold fs-6 mb-2">Variant 2</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="variant2" id="variant2"
                                                class="form-control  form-control-white mb-3 mb-lg-0"
                                                value="{{ $detail_item['variant_2'][0]->variant_name }}" required />
                                        </div>
                                    </div>
                                    <div class="row"><label class="required fw-bold fs-6 mb-2">Option</label>
                                        <div class="row" id="option2row">
                                            @foreach ($detail_item['variant_2'] as $item)
                                                <div class="fv-row mb-7 col-lg-3">
                                                    <div class="input-group">
                                                        <input type="text" name="option2[]"
                                                            onchange="addOption2Row()"
                                                            value="{{ $item->option_name }}"
                                                            id="option2"class="form-control  option-varian2 form-control-white mb-3 mb-lg-0"
                                                            required />
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-danger input-group-text"
                                                            onclick="deleteOptionRow(this,2)">
                                                            <i class="bi bi-trash"></i></button>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end"><button
                                class="btn btn-sm btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger"
                                onclick="unActiveVariant()">Cancel Variant</div>
                    </div>
                </div>

                <div class="py-4 col-lg-8" id="tableVarian">
                    <div class="fv-row mb-7 col-lg-6"><label class="fw-bold fs-6 mb-2">Price for All</label>
                        <div class="input-group"> <input type="text" id="priceForAll"
                                class="form-control form-control-solid mb-3 mb-lg-0" /> <button type="button"
                                class="btn btn-sm btn-primary input-group-text"
                                onclick="changeAllPrice()">Change</button> </div>
                    </div>
                    <table class="table table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr id="columnDetailVarian"
                                class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th>{{ $detail_item['variant_1'][0]->variant_name }}</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody id="contentTable">
                            @foreach ($detail_item['variant_1'] as $di)
                                <tr>
                                    <td>{{ $di->option_name }}
                                        <input type="hidden" name="option1_id[]" value="{{ $di->option_id }}">
                                    </td>
                                    <td>
                                        @php
                                            $variant_2 = DB::select('select * from variant_options a where a.parent = ' . $di->option_id);
                                        @endphp

                                        @foreach ($variant_2 as $item)
                                            <div class="py-2">
                                                <label class="required fw-bold fs-6 mb-2">{{ $item->name }}
                                                    <span class="fs-8">
                                                    </span></label>
                                                <input type="hidden" name="option2_id[]"
                                                    value="{{ $item->id }}">
                                                <input type="text" name="price[]" value="{{ $item->price }}"
                                                    class="form-control price form-control-solid mb-3 mb-lg-0"
                                                    required />
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
        </div>

        @endif



    </div>
    </div>


    <div class="d-flex justify-content-end" id="loadingnya">
        <div class="px-2">
            <button type="button" class="btn btn-sm btn-secondary" onclick="tutupModal()">Close</button>
        </div>
        <div class="px-2">
            <button class="btn btn-sm btn-primary" id="btn-update">Update Item</button>
        </div>
    </div>
</form>

<script>
    $('.select-2').select2();
    var infoVarian1 = false;
    var infoVarian2 = false;


    var option_key_1 = 2399;
    var option_key_2 = 2988;

    $('#update-form').on('submit', function(e) {
        e.preventDefault();

        $('#btn-update').hide()
        $('#loadingnya').html(
            '<div class="spinner-grow text-success" role="status"><span class="sr-only"></span></div>')

        var form = $('#update-form')
        $.ajax({
            type: "POST",
            url: "{{ url('/admin/masterdata/item/update') }}",
            data: $('#update-form').serialize(),
            dataType: 'json',
            success: function(response) {
                Swal.fire(
                    'Success',
                    response.success,
                    'success'
                )
                $('#mainmodal').modal('toggle');
                itemTable.ajax.reload(null, false);
            }
        })
    });


    function unActiveVariant() {
        var unvariant =
            '<div class="row"><div class="col-lg-6"><div class="fv-row mb-7"> <div class="row"><div class="col-lg-3"> <p class="fw-bold fs-6 mb-2">Variant : </p> </div> <div class="col-lg-9"><button type="button" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-info btn-active-light-info" onclick="activeVariant()"><i class="bi bi-plus-circle-dotted"></i>Variant</button> </div> </div> </div> <div id="variant"> <div class="col-lg-6 fv-row mb-7"><label class="required fw-bold fs-6 mb-2">Price (Hpp)</label> <input type="number" name="price" id="price" class="form-control form-control-solid mb-3 mb-lg-0" required /> </div></div> </div></div>';
        $('#tableVarian').remove()
        $('#activeVariant').html(unvariant);
        infoVarian2 = false;
    }

    function activeVariant() {
        var variant =
            '<div class="fv-row mb-7"> <div class="row"><div class="col-lg-1"><p class="fw-bold fs-6 mb-2">Variant : </p></div><div class="col-lg-11 bg-gray-100 rounded py-4">  <div class="row col-lg-6">  <div class="fv-row mb-7 col-lg-6"><label class="required fw-bold fs-6 mb-2">Variant 1</label><input type="text" name="variant1" id="variant1" onchange="coloumnDetailVarian(this)" class="form-control form-control-white mb-3 mb-lg-0" required /> </div><div class="col-lg-6"><div class="fv-row mb-7"><label class="required fw-bold fs-6 mb-2">Tambah Opsi</label> <div class="">   <button type="button" class="btn btn-sm btn-outline btn-outline-primary" onclick="addOptionRow()">+</button></div></div> </div>  </div>  <div class="row"><label class="required fw-bold fs-6 mb-2">Option</label>                    <div class="row" id="optionrow"><div class="fv-row mb-7 col-lg-3"><input type="text" name="option1[]" id="option_key1_' +
            option_key_1 +
            '" onchange="addTableColumn(this, 1)"  class="form-control form-control-white mb-3 mb-lg-0 option-varian1" required /></div></div></div><div class="fv-row mb-7 row" id="variant2Content"><label class="required fw-bold fs-6 mb-2">Variant 2</label><div class="col-lg-3"><button type="button" onclick="activeVariant2()"   class="btn btn-sm btn-outline btn-outline-dashed btn-outline-info btn-active-light-info"><i class="bi bi-plus-circle-dotted"></i>Active</button></div></div></div><div><div class="d-flex justify-content-end"><button class="btn btn-sm btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger" onclick="unActiveVariant()">Cancel Variant</div>    </div>';

        var table =
            '<div class="py-4 col-lg-8" id="tableVarian"> <div class="fv-row mb-7 col-lg-6"><label class="fw-bold fs-6 mb-2">Price for All</label> <div class="input-group"> <input type="text"  id="priceForAll" class="form-control form-control-solid mb-3 mb-lg-0" /> <button type="button" class="btn btn-sm btn-primary input-group-text" onclick="changeAllPrice()">Change</button> </div> </div> <table class="table table-row-dashed fs-6 gy-5"><thead><tr id="coloumnDetailVarian" class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0"><th id="th_variant_1"></th><th>Price</th></tr></thead><tbody id="contentTable"></tbody></table></div>'
        $('#activeVariant').html(variant);
        $('#activeVariant').after(table);
    }

    function addOptionRow() {
        option_key_1 += 1;
        var option =
            '<div class="fv-row mb-7 col-lg-3"><div class="input-group"><input type="text" name="option1[]" id="option_key1_' +
            option_key_1 +
            '" onchange="addTableColumn(this,1)" class="form-control form-control-white mb-3 mb-lg-0 option-varian1" required /><button type="button" class="btn btn-sm btn-icon btn-danger input-group-text" onclick="deleteOptionRow(this,1)"><i class="bi bi-trash"></i></button></div></div>'
        $('#optionrow').append(option)
    }

    function deleteOptionRow(e, val) {
        if (infoVarian2) {
            if (val == 1) {

                $('#content_' + $(e).prev().attr('id')).parent().nextUntil('tr.content_option_1').remove()
                $('#content_' + $(e).prev().attr('id')).parent().remove()
                $(e).parent().parent().remove();

            } else {
                $('.content_' + $(e).prev().attr('id')).parent().remove()
                $(e).parent().parent().remove();

                var rowspan = 1;
                $('.option-varian2').each(function() {
                    rowspan += 1;
                })

                $('.content_option_1').each(function() {
                    $(this).find('th').attr('rowspan', rowspan)
                })
            }
        } else {
            $(e).parent().parent().remove();
            $('#content_' + $(e).prev().attr('id')).parent().remove()
        }
    }

    function activeVariant2() {

        var option =
            '<div class="row col-lg-6"> <div class="col-lg-6"><div class="fv-row mb-7"><label class="required fw-bold fs-6 mb-2">Variant 2</label><input type="text" name="variant2" id="variant2" class="form-control  form-control-white mb-3 mb-lg-0" required onchange="columnDetailVariant2(this)" /></div></div> <div class="col-lg-6"><div class="fv-row mb-7"><label class="required fw-bold fs-6 mb-2">Tambah Opsi 2</label><div class=""><button type="button" class="btn btn-sm btn-outline btn-outline-primary"        onclick="addOption2Row()">+</button></div>    </div>        </div>    </div>    <div class="row"><label class="required fw-bold fs-6 mb-2">Option</label><div class="row" id="option2row">        <div class="fv-row mb-7 col-lg-3"><input type="text" name="option2[]" id="option_key2_' +
            option_key_2 +
            '"  class="form-control form-control-white mb-3 mb-lg-0 option-varian2" onchange="addTableColumn(this,2)" required />      </div>  </div>';

        $('#variant2Content').html(option)
        infoVarian2 = true

        var rowspan = 1;
        $('#contentTable').html('')

        $('.option-varian1').each(function() {
            rowspan += 1;
        })

        $('.option-varian1').each(function() {
            $('#contentTable').append("<tr class='content_option_1'><th id='content_" + $(this).attr('id') +
                "' rowspan='" + rowspan + "'>" + $(this).val() + "</th></tr>")
        })

    }

    function addOption2Row() {
        option_key_2 += 1
        var option =
            '<div class="fv-row mb-7 col-lg-3"><div class="input-group"><input type="text" name="option2[]" id="option_key2_' +
            option_key_2 +
            '" class="form-control  option-varian2 form-control-white mb-3 mb-lg-0" onchange="addTableColumn(this,2)" required /><button type="button" class="btn btn-sm btn-icon btn-danger input-group-text" onclick="deleteOptionRow(this,2)"><i class="bi bi-trash"></i></button></div></div>'
        $('#option2row').append(option)

    }

    function columnDetailVarian(e) {
        $('#th_variant_1').html($(e).val());
    }

    function columnDetailVarian2(e) {
        if ($('#th_variant_1').parent().find('#th_variant_2')) {
            $('#th_variant_1').parent().find('#th_variant_2').remove()
        }
        $('#th_variant_1').after("<th id='th_variant_2'>" + $(e).val() + "</th>");
    }

    function addTableColumn(e, val) {
        if (infoVarian2) {
            if (val == 2) {
                if ($('.content_' + $(e).attr('id')).length >= 1) {
                    $('.content_' + $(e).attr('id')).html($(e).val());
                } else {
                    var rowspan = 1;
                    $('.option-varian2').each(function() {
                        rowspan += 1;
                    })

                    $('.content_option_1').each(function() {
                        $(this).find('th').attr('rowspan', rowspan)
                    })

                    $('.content_option_1').each(function() {
                        $(this).after("<tr><th class='content_" + $(e).attr('id') +
                            "'>" + $(e).val() +
                            "</th><th><input type='number' class='form-control form-control-solid price' name='price[]'></th></tr>"
                        )
                    })
                }
            } else {
                if ($('#content_' + $(e).attr('id')).length >= 1) {
                    $('#content_' + $(e).attr('id')).html($(e).val());
                } else {
                    var rowspan = 1;
                    $('.option-varian2').each(function() {
                        rowspan += 1;
                    })

                    $('.content_option_1').each(function() {
                        $(this).find('th').attr('rowspan', rowspan)
                    })

                    $('#contentTable').append("<tr class='content_option_1'><th id='content_" + $(e).attr('id') +
                        "' rowspan='" + rowspan + "'>" + $(e).val() + "</th></tr>")

                    pelengkap('content_' + $(e).attr('id'))

                }
            }
        } else {
            if ($('#content_' + $(e).attr('id')).length >= 1) {
                $('#content_' + $(e).attr('id')).html($(e).val());
            } else {
                var content = "<tr><th id='content_" + $(e).attr('id') + "'>" + $(e).val() +
                    "</th><th><input type='number' class='form-control form-control-solid price' name='price[]'></th></tr>"
                $('#contentTable').append(content)
            }
        }
    }

    function changeAllPrice() {
        $('.price').each(function() {
            $(this).val($('#priceForAll').val())
        })
    }
</script>
