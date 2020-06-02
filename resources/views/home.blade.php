@section('js')
<script type="text/javascript">
  $(document).ready(function () {
    $('#table').DataTable({
      "iDisplayLength": 50
    });

  });
</script>
@stop
@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h1>Dashboard Manufacturing</h1>
        <ul class="nav nav-pills mt-3">
          <li class="nav-item">
              <a href="#home" class="nav-link active" data-toggle="tab">ALL</a>
          </li>
          <li class="nav-item">
              <a href="#production" class="nav-link" data-toggle="tab">Production</a>
          </li>
          <li class="nav-item">
              <a href="#messages" class="nav-link" data-toggle="tab">Shipment</a>
          </li>
          <li class="nav-item">
              <a href="#messages" class="nav-link" data-toggle="tab">Actual Production vs Shipment</a>
          </li>
          <li class="nav-item">
            <a href="#messages" class="nav-link" data-toggle="tab">Outstanding Shipment</a>
          </li>
          <li class="nav-item">
            <a href="#messages" class="nav-link" data-toggle="tab">Back Order</a>
          </li>
          <li class="nav-item">
            <a href="#messages" class="nav-link" data-toggle="tab">Inventory Ratio < 0.3</a>
          </li>
          <li class="nav-item">
            <a href="#messages" class="nav-link" data-toggle="tab">Inventory Ratio < 0.3 - 0/7</a>
          </li>
      </ul>
      <div class="tab-content mt-3">
          <div class="tab-pane fade show active" id="home">
            <div class="row">
              <div class="col-md-4">
                <div class="card text-black mb-6 ">
                  <div class="card-header">Production Chart</div>
                  <div class="card-body">{!! $chart_ForecastActual->render() !!}</div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="card text-black mb-6">
                  <div class="card-header">Detail Production APP (Ton)</div>
                  <div class="card-body">{!! $chart_DetailProduction->render() !!}</div> 
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade active" id="production">
              <div class="row">
                <div class="col-md-6">
                  <div class="card text-black mb-6">
                    <div class="card-header">
                      Chart Production
                    </div>
                    <div class="card-body">{!! $chart_qDashboardProdKategori->render() !!}</div> 
                  </div>
                  <div class="text-center">
                    <button type="button" onclick="toggleAAP()" class="btn btn-primary">AAP</button>
                    <button type="button" onclick="toggleAAS()" class="btn btn-success">AAS</button>
                    <button type="button" onclick="toggleAAM()" class="btn btn-danger">AAM</button>
                    </div>
                </div>
                <div id="cardAAP" class="col-md-6 d-none">
                  <div class="card text-black mb-6">
                    <div class="card-header">Chart Production Detail AAP</div>
                    <div class="card-body">{!! $chart_qDashboardProdKategoriAAP->render() !!}</div> 
                  </div>
                </div>
                <div id="cardAAS" class="col-md-6 d-none">
                  <div class="card text-black mb-6">
                    <div class="card-header">Chart Production Detail AAS</div>
                    <div class="card-body">{!! $chart_qDashboardProdKategoriAAS->render() !!}</div> 
                  </div>
                </div>
                <div id="cardAAM" class="col-md-6 d-none">
                  <div class="card text-black mb-6">
                    <div class="card-header">Chart Production Detail AAM</div>
                    <div class="card-body">{!! $chart_qDashboardProdKategoriAAM->render() !!}</div> 
                  </div>
                </div>
              </div>
          </div>
          <div class="tab-pane fade" id="messages">
              <h4 class="mt-2">Messages tab content</h4>
              <p>Donec vel placerat quam, ut euismod risus. Sed a mi suscipit, elementum sem a, hendrerit velit. Donec at erat magna. Sed dignissim orci nec eleifend egestas. Donec eget mi consequat massa vestibulum laoreet. Mauris et ultrices nulla, malesuada volutpat ante. Fusce ut orci lorem. Donec molestie libero in tempus imperdiet. Cum sociis natoque penatibus et magnis.</p>
          </div>
      </div>
        
      </div>
    </div>
  </div>
  {{-- <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body d-flex flex-column">
        <ul>
          {!! $chart_dua->render() !!}
        </ul>
      </div>
    </div>
  </div> --}}
</div>
{{-- <div class="row">
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="clearfix">
          <div class="float-left">
            <i class="mdi mdi-poll-box text-danger icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Transaksi</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{$transaksi->count()}}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0">
          <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Total seluruh transaksi
        </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="clearfix">
          <div class="float-left">
            <i class="mdi mdi-receipt text-warning icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Sedang Pinjam</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{$transaksi->where('status', 'pinjam')->count()}}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0">
          <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> sedang dipinjam
        </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="clearfix">
          <div class="float-left">
            <i class="mdi mdi-book text-success icon-lg" style="width: 40px;height: 40px;"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Buku</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{$buku->count()}}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0">
          <i class="mdi mdi-book mr-1" aria-hidden="true"></i> Total judul buku
        </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="clearfix">
          <div class="float-left">
            <i class="mdi mdi-account-location text-info icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Anggota</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{$anggota->count()}}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0">
          <i class="mdi mdi-account mr-1" aria-hidden="true"></i> Total seluruh anggota
        </p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">

      <div class="card-body">
        <h4 class="card-title">Data Transaksi sedang pinjam</h4>

        <div class="table-responsive">
          <table class="table table-striped" id="table">
            <thead>
              <tr>
                <th>
                  Kode
                </th>
                <th>
                  Buku
                </th>
                <th>
                  Peminjam
                </th>
                <th>
                  Tgl Pinjam
                </th>
                <th>
                  Tgl Kembali
                </th>
                <th>
                  Status
                </th>
                <th>
                  Action
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach($datas as $data)
              <tr>
                <td class="py-1">
                  <a href="{{route('transaksi.show', $data->id)}}">
                    {{$data->kode_transaksi}}
                  </a>
                </td>
                <td>

                  {{$data->buku->judul}}

                </td>

                <td>
                  {{$data->anggota->nama}}
                </td>
                <td>
                  {{date('d/m/y', strtotime($data->tgl_pinjam))}}
                </td>
                <td>
                  {{date('d/m/y', strtotime($data->tgl_kembali))}}
                </td>
                <td>
                  @if($data->status == 'pinjam')
                  <label class="badge badge-warning">Pinjam</label>
                  @else
                  <label class="badge badge-success">Kembali</label>
                  @endif
                </td>
                <td>
                  <form action="{{ route('transaksi.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <button class="btn btn-info btn-sm"
                      onclick="return confirm('Anda yakin data ini sudah kembali?')">Sudah Kembali
                    </button>
                  </form>

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div> --}}
@endsection
