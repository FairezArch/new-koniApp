@extends('backend.master')
@section('title', '- Edit Lisensi')
@section('content')
    <div class="container-fluid">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
            <h4>Edit Lisensi</h4>
            <form id="forminput" class="forminput mt-3 mb-3" >
                <div class="form-group row">
                    <label for="licence_name" class="col-sm-2 col-form-label">Nama Lisensi</label>
                    <div class="col-sm-10">
                        <input type="text" name="licence_name" value="{{$lists->licence_name}}" id="licence_name" class="form-control">
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('setting-jugde-referee-licence.index') }}" class="btn btn-danger p-2 rounded">Kembali</a>
                    <button class="btn btn-danger p-2 rounded" id="save_formData">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@section('script-footer')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#forminput').on('submit', function(e) {

            e.preventDefault();

            let elm = $('#save_formData');
            elm.attr('disabled', 'disabled');


            let formData = new FormData();
            formData.append('_method','PUT');
            formData.append('licence_name', $('#licence_name').val());

            $.ajax({
                url: "{{ route('setting-jugde-referee-licence.update',$lists->id) }}",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function() {
                    elm.html(
                        '<div class="spinner-border mr-2" style="width: 1rem!Important; height: 1rem!important;" role="status"><span class="sr-only"></span></div>Loading...'
                    )
                },
                success: function(res) {
                    if (res.success == true) {
                        window.location.href = "{{ route('setting-jugde-referee-licence.index') }}"
                    } else {
                        alert(res.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                        let errors = JSON.parse(xhr.responseText);
                        let msg;

                        $.each(errors.errors, function(key, value) {
                            $(`#${key}`).addClass('is-invalid');
                        })
                    }
                    elm.html('Simpan')
                    elm.removeAttr('disabled')
                    console.log(xhr.responseText)
                },
                complete: function() {
                    elm.html('Simpan')
                    elm.removeAttr('disabled')
                }
            })

        })
    </script>
@endsection
@endsection
