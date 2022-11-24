<form id="add-form">
    @csrf
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-bordered">
                <div class="card-header bg-info">
                    <h3 class="card-title text-white">Information</h3>
                    <div class="card-toolbar">

                    </div>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Masukan nama Produk yang sesuai atau <span class="fw-bold">TIDAK</span> dengan nama kategori atau nama varian. Contoh : Daster Polos (Benar). Contoh : Daster Polos Hitam (Salah)</li>
                        <li>Pastikan produk yang <span class="fw-bold">sama TIDAK</span> diunggah lebih dari 1x.</li>
                    </ul>
                </div>
                <div class="card-footer">
                    Dont be mad to offer help
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="fv-row mb-7">
                <label class="required fw-bold fs-6 mb-2">Code</label>
                <input type="text" name="code" id="code" readonly
                    class="form-control form-control-solid mb-3 mb-lg-0" required />
            </div>
            <div class="fv-row mb-7">
                <label class="required fw-bold fs-6 mb-2">Name</label>
                <input type="text" name="name" id="name" class="form-control form-control-solid mb-3 mb-lg-0"
                    required />
            </div>
            <div class="fv-row mb-7">
                <label class="required form-label fw-bold">Category</label>
                <select class="form-select  form-select-solid mb-3 mb-lg-0" name="category_id" id="category_id"
                    required>
                    <option>Choose Category</option>
                </select>
            </div>
            <div class="fv-row mb-7">
                <label class="required fw-bold fs-6 mb-2">Description</label>
                <input type="text" name="name" id="name" class="form-control form-control-solid mb-3 mb-lg-0"
                    required />
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="fv-row mb-7">
                        <div class="row">
                            <div class="col-lg-3 d-flex flex-row-fluid flex-center">
                                <p class="fw-bold fs-6 mb-2">Variant : </p>
                            </div>
                            <div class="col-lg-9">
                                <button type="button"
                                    class="btn btn-sm btn-outline btn-outline-dashed btn-outline-info btn-active-light-info"><i
                                        class="bi bi-plus-circle-dotted"></i>Variant</button>
                            </div>
                        </div>
                    </div>
                    <div id="variant">
                        <div class="col-lg-fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Price (Hpp)</label>
                            <input type="text" name="name" id="name"
                                class="form-control form-control-solid mb-3 mb-lg-0" required />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end" id="loadingnya">
        <button class="btn btn-sm btn-primary" id="btn-add">Add Item</button>
    </div>
</form>

<script>
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

    $('#type_id').on('change', function() {
        var type_id = $('#type_id').val()
        $.ajax({
            type: 'get',
            url: "{{ url('/admin/masterdata/partner/getcode') }}/" + type_id,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#code').val(response.code);
            }
        })
    });
</script>
