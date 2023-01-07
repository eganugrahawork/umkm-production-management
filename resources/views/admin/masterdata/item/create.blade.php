<form id="add-form">
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
                <input type="text" name="code" id="code" readonly
                    class="form-control form-control-solid mb-3 mb-lg-0" required />
            </div>
            <div class="fv-row mb-7 col-lg-8">
                <label class="required fw-bold fs-6 mb-2">Name</label>
                <input type="text" name="name" id="name" class="form-control form-control-solid mb-3 mb-lg-0"
                    required />
            </div>
            <div class="fv-row mb-7 col-lg-8">
                <label class="required form-label fw-bold">Category</label>
                <select class="form-select  form-select-solid mb-3 mb-lg-0 select-2" name="category_id" id="category_id"
                    required>
                    @foreach ($category as $ct)
                        <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="fv-row mb-7 col-lg-8">
                <label class="required fw-bold fs-6 mb-2">Description</label>
                <textarea name="description" class="form-control form-control-solid mb-3 mb-lg-0" id="" cols="30"
                    rows="5" required></textarea>
            </div>
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
                                <label class="required fw-bold fs-6 mb-2">Price (Hpp)</label>
                                <input type="number" name="price" id="price"
                                    class="form-control form-control-solid mb-3 mb-lg-0" required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    var option_key_1 = 111;
    var option_key_2 = 211;

    $('#add-form').on('submit', function(e) {
        e.preventDefault();

        $('#btn-add').hide()
        $('#loadingnya').html(
            '<div class="spinner-grow text-success" role="status"><span class="sr-only"></span></div>')

        var form = $('#add-form')
        $.ajax({
            type: "POST",
            url: "{{ url('/admin/masterdata/item/store') }}",
            data: $('#add-form').serialize(),
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
        infoVarian2 = false
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

    function coloumnDetailVarian(e) {
        $('#th_variant_1').html($(e).val());
    }

    function columnDetailVariant2(e) {
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

    function pelengkap(idkey) {
        console.log(idkey);
        $('.option-varian2').each(function() {
            $('#' + idkey).parent().after("<tr><th class='content_" + $(this).attr('id') +
                "'>" + $(this).val() +
                "</th><th><input type='number' class='form-control form-control-solid price' name='price[]'></th></tr>"
            )
        })
    }

    function changeAllPrice() {
        $('.price').each(function() {
            $(this).val($('#priceForAll').val())
        })
    }

    getCode()

    function getCode() {
        $.ajax({
            type: 'get',
            url: "{{ url('/admin/masterdata/item/getcode') }}",
            dataType: 'json',
            success: function(response) {

                $('#code').val(response.code);
            }
        })
    }
</script>
