@extends('backend.master')
@section('title', '- Edit Support')
@section('content')
    <div class="container-fluid">
        <div class="shadow-sm p-3 mb-5 bg-white rounded">
            <h4>Edit Support</h4>
            <form id="forminput" class="forminput mt-3 mb-3" >
                <div class="form-group row">
                    <label for="support_name" class="col-sm-2 col-form-label">Nama support</label>
                    <div class="col-sm-10">
                        <input type="text" name="support_name" value="{{$lists->support_name}}" id="support_name" class="form-control">
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('setting-certificate-trainner.index') }}" class="btn btn-danger p-2 rounded">Kembali</a>
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
            formData.append('support_name', $('#support_name').val());

            $.ajax({
                url: "{{ route('setting-support-trainner.update',$lists->id) }}",
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
                        window.location.href = "{{ route('setting-support-trainner.index') }}"
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
