@section('js')
<script type="text/javascript">
    // step 3: ubah data dari Controller menjadi JSON
     var data = @json($data);

    // step 4: instansiasi jExcel dan definisikan kolom      
    $('#spreadsheet').jexcel({
    data: data,
    columns: [
        {type: 'text', title: 'Nama', width: 200},
        {type: 'text', title: 'Email', width: 300},
    ]
    });
</script>
@stop
@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-2">
        <a href="#" class="btn btn-primary btn-rounded btn-fw"><i class="fa fa-plus"></i>
            Tambah
            Anggota</a>
    </div>
    <div class="col-lg-12">
        @if (Session::has('message'))
        <div class="alert alert-{{ Session::get('message_type') }}" id="waktu2" style="margin-top:10px;">
            {{ Session::get('message') }}</div>
        @endif
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Inline Editable</h4>
                <div id="spreadsheet"></div>
            </div>
        </div>
    </div>
</div>
@endsection