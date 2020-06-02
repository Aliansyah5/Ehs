@section('js')

<script>
    // $.ajaxSetup({
    // headers: {
    //     'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    $(function () {
      $('#formMobil').submit(function (event) {
        var data = $('#spreadsheet').jexcel('getData');
        $('#data').val(JSON.stringify(data));
      });
    });

    $('#spreadsheet').jexcel({
      data: {!! old('data', json_encode($items)) !!},
      columns: [
        {type: 'text', readOnly: true, title: 'ID'},
        {type: 'text', title: 'Mobil', width: 200},
        {type: 'numeric', title: 'Harga', width: 300, mask: 'Rp#.##', decimal: ','},
      ]
    });

    @if(!old('data') && $items->isEmpty())
    $('#spreadsheet').jexcel('insertRow', 10, 0);
    @endif

    //setInterval(sync, 10000);

    function sync() {
      var data = $('#spreadsheet').jexcel('getData');
      $('#status').html('Saving...');

      $.post("{{ route('mobil.store') }}", {data: JSON.stringify(data), _token: "{{ csrf_token() }}"})
        .done(function (data) {
          $('#status').html('Saved');
          $('#spreadsheet').jexcel('setData', data);
        })
        .fail(function () {
          $('#status').html('Error');
        })
        .always(function () {
          setTimeout(function () {
            $('#status').html('');
          }, 3000)
        });
    }

</script>
@stop

@extends('layouts.app')

@section('content')

<form method="POST" id="formMobil" action="{{ route('mobil.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tambah Excel baru</h4>
                            <input type="hidden" name="data" id="data">
                            <h2 class="ui header">Daftar Mobil <span style="font-weight: normal; font-style: italic"
                                    id="status"></span></h2>
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