@section('js')

<script type="text/javascript">
     $(function () {
        $('#formExcel').submit(function (event) {
          var data = $('#spreadsheet').jexcel('getData');
          $('#data').val(JSON.stringify(data));
        });
      });

      $('#spreadsheet').jexcel({
        data: [],
        columns: [
        {type: 'text', title: 'Nama', width: 200},
        {type: 'text', title: 'Email', width: 300},
         ]
      });

      $('#spreadsheet').jexcel('insertRow', 10, 0);
</script>
@stop

@extends('layouts.app')

@section('content')

<form method="POST" id='formExcel' action="{{ route('inline.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tambah Excel baru</h4>
                            <input type="hidden" name="data" id="data">
                            <h2 class="ui header">Daftar Mobil</h2>
                            <div id="spreadsheet"></div>
                            <div class="ui divider hidden"></div>
                            <button type="submit" class="btn btn-primary" id="submit">
                                Submit
                            </button>
                            <button type="reset" class="btn btn-danger">
                                Reset
                            </button>
                            <a href="{{route('buku.index')}}" class="btn btn-light pull-right">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection