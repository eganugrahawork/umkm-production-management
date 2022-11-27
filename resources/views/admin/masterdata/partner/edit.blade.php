<form id="edit-form">
    @csrf
    <div class="row">
    <div class="col-lg-6">
        <div class="fv-row mb-7">
            <input type="hidden" name="id" value="{{ $partner->id }}">
            <input type="hidden" name="type_id" value="{{ $partner->type_id }}">
            <label class="required form-label fw-bold">Partner Type</label>
            <div class="col-lg-8">
                <select class="form-select  form-select-solid mb-3 mb-lg-0" name="type_id" id="type_id" disabled required>
                    <option value="">Choose Partner</option>
                    @foreach ($typepartner as $pt)
                    <option value="{{ $pt->id }}" {{ $partner->type_id == $pt->id  ? 'selected' : ''; }}>{{ $pt->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="fv-row mb-7">
            <label class="required fw-bold fs-6 mb-2">Code</label>
            <input type="text" name="code" id="code" value="{{ $partner->code }}" class="form-control form-control-solid mb-3 mb-lg-0" readonly required/>
        </div>
        <div class="fv-row mb-7">
            <label class="required fw-bold fs-6 mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ $partner->name }}" onchange="changeCode()" class="form-control form-control-solid mb-3 mb-lg-0"  required/>
        </div>
        <div class="fv-row mb-7">
            <label class="required fw-bold fs-6 mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ $partner->email }}" class="form-control form-control-solid mb-3 mb-lg-0"  required/>
        </div>
        <div class="fv-row mb-7">
            <label class="required fw-bold fs-6 mb-2">Phone</label>
            <input type="number" name="phone" id="phone" value="{{ $partner->phone }}" class="form-control form-control-solid mb-3 mb-lg-0"  required/>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="fv-row mb-7">
            <label class="required fw-bold fs-6 mb-2">Address</label>
            <textarea  name="address" id="address" class="form-control form-control-solid mb-3 mb-lg-0"  required>{{ $partner->address }}</textarea>
        </div>
        <div class="fv-row mb-7">
            <label class="required fw-bold fs-6 mb-2">Bank</label>
            <div class="row">
                <div class="col-lg-4">
                    <input type="text" name="bank_name" id="bank_name" value="{{ $partner->bank_name }}" class="form-control form-control-solid mb-3 mb-lg-0"  required/>
                </div>
                <div class="col-lg-8">
                    <input type="text" name="bank_number" id="bank_number" value="{{ $partner->bank_number }}" class="form-control form-control-solid mb-3 mb-lg-0"  required/>
                </div>
            </div>
        </div>
        <div class="fv-row mb-7">
            <label class="required form-label fw-bold">Status</label>
                <select class="form-select  form-select-solid mb-3 mb-lg-0" name="status" id="status" required>
                    <option value="1" {{ $partner->status == 1 ? 'selected' : ''; }}>Active</option>
                    <option value="0" {{ $partner->status == 0 ? 'selected' : ''; }}>Not</option>
                </select>
        </div>


    </div>
</div>

        <div class="d-flex justify-content-end" id="loadingnya">
            <button class="btn btn-sm btn-primary" id="btn-update">Update Partner</button>
        </div>
    </form>

    <script>
        $('#edit-form').on('submit', function(e){
            e.preventDefault();


            $('#btn-update').hide()
            $('#loadingnya').html('<div class="spinner-grow text-success" role="status"><span class="sr-only"></span></div>')

            $.ajax({
                type: "POST",
                url: "{{ url('/admin/masterdata/partner/update') }}",
                data: $('#edit-form').serialize(),
                dataType: 'json',
                success:function(response){
                    Swal.fire(
                        'Success',
                        response.success,
                        'success'
                    );
                    $('#mainmodal').modal('toggle');
                    partnerTable.ajax.reload(null,false);
                }
            })

        });

        function changeCode(){
            var code = $('#name').val().split(' ').join('-')
            $.ajax({
                type:'get',
                url: "{{ url('/admin/masterdata/partner/getcode') }}",
                dataType: 'json',
                success:function(response){
                    code = code + response.code
                    $('#code').val(code);
                }
            })
        };
    </script>
