<form id="edit-form">
    @csrf
    <div class="row">
        <input type="hidden" name="id" value="{{ $type->id }}">
    <div class="col-lg-6">
        <div class="fv-row mb-7">
            <label class="required fw-bold fs-6 mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ $type->name }}" class="form-control form-control-solid mb-3 mb-lg-0"  required/>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="fv-row mb-7">
            <label class="required form-label fw-bold">Status</label>
                <select class="form-select  form-select-solid mb-3 mb-lg-0" name="status" id="status" required>
                    <option value="1" {{ $type->status == 1 ? 'selected' : ''; }}>Active</option>
                    <option value="0" {{ $type->status == 0 ? 'selected' : ''; }}>Not</option>
                </select>
        </div>


    </div>
</div>

        <div class="d-flex justify-content-end" id="loadingnya">
            <button class="btn btn-sm btn-primary" id="btn-update">Update Type</button>
        </div>
    </form>

    <script>
        $('#edit-form').on('submit', function(e){
            e.preventDefault();

            $('#btn-update').hide()
            $('#loadingnya').html('<div class="spinner-grow text-success" role="status"><span class="sr-only"></span></div>')

            var form = $('#edit-form')
            $.ajax({
                type: "POST",
                url: "{{ url('/admin/masterdata/customer/type/update') }}",
                data: $('#edit-form').serialize(),
                dataType: 'json',
                success:function(response){
                    Swal.fire(
                        'Success',
                        response.success,
                        'success'
                    )
                    $('#mainmodal').modal('toggle');
                    customerTypeTable.ajax.reload(null, false);
                }
            })
        });

    </script>
