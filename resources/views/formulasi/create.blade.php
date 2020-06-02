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
      data: {!! old('data', json_encode($formula)) !!},
      columns: [
        {
          //form id hidden
            type: 'text',
            autocomplete: 'true',
            title: 'No',
            width: '1',
            readOnly: true,
            align: 'left'
        },
        {
            type: 'text',
            title: ' ',
            width: '100',
            align: 'left',
            readOnly: true
            
        },
        {
            type: 'text',
            title: ' ',
            width: '150',
            align: 'left', readOnly: true
            
        },
        {
            type: 'text',
            title: ' ',
            width: '150',
            align: 'left',
            
        },
        {
            type: 'text',
            title: 'WT',
            width:'70',
            align: 'right',
            readOnly: true
        },
        {
            type: 'text',
            title: '% WT',
            width:'70',
            align: 'right',
            readOnly: true
        },
        {
            type: 'text',
            title: 'WT',
            width:'70',
            align: 'right',
        },
        {
            type: 'text',
            title: '% WT',
            width:'200',
            align: 'right'
        },
        {
            type: 'text',
            title: ' ',
            width:'20',
            align: 'right'
        },
        // {
        //     type: 'checkbox',
        //     title: 'Stock c',
        //     width:'100'
        // },
        // {
        //     type: 'checkbox',
        //     title: 'Stock d',
        //     width:'100'
        // },
    ],
    nestedHeaders:[
        [
          {
                title: 'frmid',
                colspan: '1',
            },
           {
                title: 'Kode Item',
                colspan: '1',
                rowspan: '2',
            },
            {
                title: 'Description',
                colspan: '1',
            },
            {
                title: 'STANDART',
                colspan: '2'
            },
            {
                title: 'PERCOBAAN',
                colspan: '2'
            },
            {
                title: 'Note',
                colspan: '1'
            },
        ]
    ],
    tableOverflow:true,
    });

    @if(!old('data') && $formula->isEmpty())
    $('#spreadsheet').jexcel('insertRow', 10, 0);
    @endif

  //  setInterval(sync, 10000);

    function sync() {
      var data = $('#spreadsheet').jexcel('getData');
      $('#status').html('Saving...');

      $.post("{{ route('formulasi.store') }}", {data: JSON.stringify(data), _token: "{{ csrf_token() }}"})
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

    $('.c1').hide(); 
</script>
@stop

@extends('layouts.app')

@section('content')


<form method="POST" id="formMobil" action="{{ route('formulasi.store') }}" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="card">
    <div class="card-body">
      @if (Session::has('message'))
      <div class="alert alert-{{ Session::get('message_type') }}" id="waktu2" style="margin-top:10px;">
        {{ Session::get('message') }}</div>
      @endif
      <h1>Frame Formulasi</h1>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Tanggal</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" value="{{date('d-m-Y', strtotime($formulaHeader[0]->TglForm))}}"
                readonly>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">No PC</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" value="{{ $formulaHeader[0]->NoForm }}" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Project No</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" value="{{ $formulaHeader[0]->NoProject }}" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Chemist</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" value="{{ $formulaHeader[0]->Chemist }}" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Project Type</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" value="{{ $formulaHeader[0]->TipeProject }}" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Qty</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" value="{{ $formulaHeader[0]->Qty }}" readonly>
            </div>
            <label class="col-form-label">No-Reff</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" value="{{ $formulaHeader[0]->NoReff }}" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Nama Project</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" value="{{ $formulaHeader[0]->NamaProject }}" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Due Date</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" value="{{date('d-m-Y', strtotime($formulaHeader[0]->Duedate))}}"
                readonly>

            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Tujuan
              /Target</label>
            <div class="col-sm-9">
              <textarea name="" id="" class="form-control" rows="4" readonly>{{ $formulaHeader[0]->Tujuan }}</textarea>
            </div>
          </div>
          {{-- untuk debug input hidden formid dan idx --}}
          {{-- <input type="text" name="formId" value="{{ $formulaHeader[0]->formID }}">
          <input type="text" name="idx" value="{{ $formulaHeader[0]->ProjectIdx }}"> --}}
        </div>
      </div>
      <div class="row">
        <div class="container">
          <ul class="nav nav-pills mt-3">
            <li class="nav-item">
              <a href="#home" class="nav-link active" data-toggle="tab">Formulasi</a>
            </li>
            <li class="nav-item">
              <a href="#production" class="nav-link" data-toggle="tab">Parameter Uji</a>
            </li>
          </ul>
          <div class="tab-content  mt-3">
            <div id="home" class="tab-pane active">
              <input type="hidden" name="data" id="data">
              <h2 class="ui header">Formulasi <span style="font-weight: normal; font-style: italic" id="status"></span>
              </h2>
              <div class="table-responsive">
                <div class="table" id="spreadsheet"></div>
              </div>
              <div class="ui divider hidden"></div>
              <button type="submit" class="btn btn-primary mt-3" id="submit">
                OK
              </button>
              <a href="{{route('formulasi.index')}}" class="btn btn-warning pull-right mt-3">Kembali</a>
            </div>
            <div id="production" class="tab-pane fade">
              <h3>Menu 1</h3>
              <p>Some content in menu 1.</p>
            </div>
            <div id="menu2" class="tab-pane fade">
              <h3>Menu 2</h3>
              <p>Some content in menu 2.</p>
            </div>
          </div>
        </div>
        {{-- <button type="reset" class="btn btn-danger mt-3">
          Reset
        </button> --}}
      </div>
    </div>
  </div>

</form>
@endsection