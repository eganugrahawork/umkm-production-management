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
            <div class="fv-row mb-7 col-lg-8">
                <label class="required fw-bold fs-6 mb-2">Code</label>
                <input type="text" name="code" id="code" value="{{ $item->code }}" readonly
                    class="form-control form-control-solid mb-3 mb-lg-0" required />
            </div>
            <div class="fv-row mb-7 col-lg-8">
                <label class="required fw-bold fs-6 mb-2">Name</label>
                <input type="text" name="name" id="name" onchange="getCode()" value="{{ $item->name }}"
                    class="form-control form-control-solid mb-3 mb-lg-0" required />
            </div>
            <div class="fv-row mb-7 col-lg-8">
                <label class="required form-label fw-bold">Category</label>
                <select class="form-select  form-select-solid mb-3 mb-lg-0 select-2" onchange="getCode()"
                    name="category_id" id="category_id" required>
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
                                        <input type="hidden" name="variant1_id" value="{{ $detail_item[0]->variant_id }}">
                                        <input type="text" name="variant1" id="variant1"
                                            onchange="coloumnDetailVarian(this)"
                                            class="form-control form-control-white mb-3 mb-lg-0"
                                            value="{{ $detail_item[0]->variant_name }}" required /></div>
                                </div>
                                <div class="row"><label class="required fw-bold fs-6 mb-2">Option</label>
                                    <div class="row" id="optionrow">
                                        @foreach ($detail_item as $di)
                                            <div class="fv-row mb-7 col-lg-3">
                                                <input type="hidden" name="id_option1[]" value="{{ $di->option_id }}">
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
                            <tr id="coloumnDetailVarian"
                                class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th>{{ $detail_item[0]->variant_name }}</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody id="contentTable">
                            @foreach ($detail_item as $di)
                                <tr>
                                    <td>{{ $di->option_name }}</td>
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
                <div id="activeVariant">
                </div>
            @endif



        </div>
    </div>


    <div class="d-flex justify-content-end" id="loadingnya">
        <div class="px-2">
            <button type="button" class="btn btn-sm btn-secondary" onclick="tutupModal()">Close</button>
        </div>
        <div class="px-2">
            <button class="btn btn-sm btn-primary" id="btn-add">Add Item</button>
        </div>
    </div>
</form>

<script>
    $('.select-2').select2();
    var infoVarian1 = false;
    var infoVarian2 = false;
    $('#update-form').on('submit', function(e) {
        e.preventDefault();

        $('#btn-add').hide()
        $('#loadingnya').html(
            '<div class="spinner-grow text-success" role="status"><span class="sr-only"></span></div>')

        var form = $('#update-form')
        $.ajax({
            type: "POST",
            url: "{{ url('/admin/masterdata/item/store') }}",
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
            '<div class="fv-row mb-7"><div class="row"><div class="col-lg-1"><p class="fw-bold fs-6 mb-2">Variant : </p></div><div class="col-lg-11 bg-gray-100 rounded py-4"><div class="fv-row mb-7 col-lg-6"><label class="required fw-bold fs-6 mb-2">Variant 1</label><div class="col-lg-4"><input type="text" name="variant1" id="variant1" onchange="coloumnDetailVarian(this)" class="form-control form-control-white mb-3 mb-lg-0" required /></div></div><div class="row"><label class="required fw-bold fs-6 mb-2">Option</label><div class="row" id="optionrow"><div class="fv-row mb-7 col-lg-3"><input type="text" name="option1[]" onchange="addOptionRow()" id="option" class="form-control form-control-white mb-3 mb-lg-0 option-varian1" required /></div></div></div><div class="fv-row mb-7 row" id="variant2Content"><label class="required fw-bold fs-6 mb-2">Variant 2</label><div class="col-lg-3"><button type="button" onclick="activeVariant2()" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-info btn-active-light-info"><i class="bi bi-plus-circle-dotted"></i>Active</button></div></div></div> </div><div class="d-flex justify-content-end"><button class="btn btn-sm btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger" onclick="unActiveVariant()">Cancel Variant</div></div> </div>';

        var table =
            '  <div class="py-4 col-lg-8" id="tableVarian"> <div class="fv-row mb-7 col-lg-6"><label class="fw-bold fs-6 mb-2">Price for All</label> <div class="input-group"> <input type="text"  id="priceForAll" class="form-control form-control-solid mb-3 mb-lg-0" /> <button type="button" class="btn btn-sm btn-primary input-group-text" onclick="changeAllPrice()">Change</button> </div> </div> <table class="table table-row-dashed fs-6 gy-5"><thead><tr id="coloumnDetailVarian" class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0"><th>Price</th></tr></thead><tbody id="contentTable"></tbody></table></div>'
        $('#activeVariant').html(variant);
        $('#activeVariant').after(table);
    }

    function addOptionRow() {
        var option =
            '<div class="fv-row mb-7 col-lg-3"><div class="input-group"><input type="text" name="option1[]" onchange="addOptionRow()" id="option"class="form-control form-control-white mb-3 mb-lg-0 option-varian1" required /><button type="button" class="btn btn-sm btn-icon btn-danger input-group-text" onclick="deleteOptionRow(this)"><i class="bi bi-trash"></i></button></div></div>'
        $('#optionrow').append(option)
        addRowColoumn()
    }

    function deleteOptionRow(e) {
        $(e).parent().parent().remove();
        addRowColoumn()
    }

    function activeVariant2() {
        var option =
            '<div class="fv-row mb-7 col-lg-6"><label class="required fw-bold fs-6 mb-2">Variant 2</label><div class="col-lg-4"><input type="text" name="variant2" id="variant2" class="form-control  form-control-white mb-3 mb-lg-0" required /></div></div><div class="row"><label class="required fw-bold fs-6 mb-2">Option</label><div class="row" id="option2row"><div class="fv-row mb-7 col-lg-3"><input type="text" name="option2[]" onchange="addOption2Row()" id="option2" class="form-control form-control-white mb-3 mb-lg-0 option-varian2" required /></div></div>';

        $('#variant2Content').html(option)
        infoVarian2 = true


    }

    function addOption2Row() {
        var option =
            '<div class="fv-row mb-7 col-lg-3"><div class="input-group"><input type="text" name="option2[]" onchange="addOption2Row()" id="option2"class="form-control  option-varian2 form-control-white mb-3 mb-lg-0" required /><button type="button" class="btn btn-sm btn-icon btn-danger input-group-text" onclick="deleteOptionRow(this)"><i class="bi bi-trash"></i></button></div></div>'
        $('#option2row').append(option)

        addRowColoumn()
    }

    function coloumnDetailVarian(e) {
        var coloumn = '<th id="coloumn1">' + $(e).val() + '</th>';
        $('#coloumnDetailVarian').prepend(coloumn);
    }

    function addRowColoumn() {
        var isi = '';
        if (infoVarian2 === true) {
            $('.option-varian1').each(function() {
                isi += '<tr><td>' + $(this).val() +
                    '</td><td>';
                $('.option-varian2').each(function() {
                    isi +=
                        '<div class="py-2">  <label class="required fw-bold fs-6 mb-2">' + $(this)
                        .val() + ' <span class="fs-8">(' + $('#variant2').val() +
                        ')</span</label><input type="text" name="price[]" class="form-control price form-control-solid mb-3 mb-lg-0" required /></div>';
                })
                isi += '</td></tr>'
            })


        } else {

            $('.option-varian1').each(function() {
                isi += '<tr><td>' + $(this).val() +
                    '</td><td><input type="text" name="price[]" class="form-control price form-control-solid mb-3 mb-lg-0" required /></td></tr>';
            })
        }
        $('#contentTable').html(isi);
    }

    function changeAllPrice() {
        $('.price').each(function() {
            $(this).val($('#priceForAll').val())
        })
    }

    function getCode() {
        var theCode = $('#name').val().split(' ').join('-');

        $.ajax({
            type: 'get',
            url: "{{ url('/admin/masterdata/item/getcode') }}",
            dataType: 'json',
            success: function(response) {
                theCode = theCode + response.code;
                $('#code').val(theCode);
            }
        })
    }
</script>
