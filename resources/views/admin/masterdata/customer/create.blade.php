<form id="add-form">
    @csrf
    <div class="row">
        <div class="col-lg-6">
            <div class="fv-row mb-7">
                <label class="required form-label fw-bold">Customer Type</label>
                <div class="col-lg-8">
                    <select class="form-select  form-select-solid mb-3 mb-lg-0 select-2" name="type_id" id="type_id"
                        required>
                        <option value="">Choose First</option>
                        @foreach ($type as $te)
                            <option value="{{ $te->id }}">{{ $te->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="fv-row mb-7">
                <label class="required fw-bold fs-6 mb-2">Code</label>
                <input type="text" name="code" id="code" class="form-control form-control-solid mb-3 mb-lg-0"
                    readonly required />
            </div>
            <div class="fv-row mb-7">
                <label class="required fw-bold fs-6 mb-2">Name</label>
                <input type="text" name="name" id="name" class="form-control form-control-solid mb-3 mb-lg-0"
                    required />
            </div>
            <div class="fv-row mb-7">
                <label class="required fw-bold fs-6 mb-2">Email</label>
                <input type="email" name="email" id="email" class="form-control form-control-solid mb-3 mb-lg-0"
                    required />
            </div>
            <div class="fv-row mb-7">
                <label class="required fw-bold fs-6 mb-2">Phone</label>
                <input type="number" name="phone" id="phone" class="form-control form-control-solid mb-3 mb-lg-0"
                    required />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="fv-row mb-7">
                <label class="required fw-bold fs-6 mb-2">Address</label>
                <textarea name="address" id="address" class="form-control form-control-solid mb-3 mb-lg-0" required></textarea>
            </div>
            <div class="fv-row mb-7">
                <label class="required fw-bold fs-6 mb-2">Bank</label>
                <div class="row">
                    <div class="col-lg-4">
                        <input type="text" name="bank_name" id="bank_name"
                            class="form-control form-control-solid mb-3 mb-lg-0" required />
                    </div>
                    <div class="col-lg-8">
                        <input type="text" name="bank_number" id="bank_number"
                            class="form-control form-control-solid mb-3 mb-lg-0" required />
                    </div>
                </div>
            </div>
            <div class="fv-row mb-7">
                <label class="required form-label fw-bold">Status</label>
                <select class="form-select  form-select-solid mb-3 mb-lg-0" name="status" id="status" required>
                    <option value="1">Active</option>
                    <option value="0">Not</option>
                </select>
            </div>


        </div>
    </div>

    <div class="d-flex justify-content-end" id="loadingnya">
        <button class="btn btn-sm btn-primary" id="btn-add">Add Customer</button>
    </div>
</form>

<script>
    $('.select-2').select2()
    $('#add-form').on('submit', function(e) {
        e.preventDefault();
        $('#btn-add').hide()
        $('#loadingnya').html(
            '<div class="spinner-grow text-success" role="status"><span class="sr-only"></span></div>')

        var form = $('#add-form')
        $.ajax({
            type: "POST",
            url: "{{ url('/admin/masterdata/customer/store') }}",
            data: $('#add-form').serialize(),
            dataType: 'json',
            success: function(response) {
                Swal.fire(
                    'Success',
                    response.success,
                    'success'
                )
                $('#mainmodal').modal('toggle');
                customerTable.ajax.reload(null, false);
            }
        })
    });

    $('#type_id').on('change', function() {
        var type_id = $('#type_id').val()
        $.ajax({
            type: 'get',
            url: "{{ url('/admin/masterdata/customer/getcode') }}/" + type_id,
            dataType: 'json',
            success: function(response) {
                $('#code').val(response.code.split(' ').join('-'));
            }
        })
    });
</script>
