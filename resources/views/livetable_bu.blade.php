@section('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {

        fetch_data();

        function fetch_data() {
            $.ajax({
                url: "/livetable/fetch_data",
                dataType: "json",
                success: function (data) {
                    var html = '';
                    html += '<tr>';
                    html += '<td contenteditable id="first_name"></td>';
                    html += '<td contenteditable id="last_name"></td>';
                    html +=
                        '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
                    for (var count = 0; count < data.length; count++) {
                        html += '<tr>';
                        html +=
                            '<td contenteditable class="column_name" data-column_name="first_name" data-id="' +
                            data[count].id + '">' + data[count].first_name + '</td>';
                        html +=
                            '<td contenteditable class="column_name" data-column_name="last_name" data-id="' +
                            data[count].id + '">' + data[count].last_name + '</td>';
                        html +=
                            '<td><button type="button" class="btn btn-danger btn-xs delete" id="' +
                            data[count].id + '">Delete</button></td></tr>';
                    }
                    $('tbody').html(html);
                }
            });
        }

        var _token = $('input[name="_token"]').val();

        $(document).on('click', '#add', function () {
            var first_name = $('#first_name').text();
            var last_name = $('#last_name').text();
            if (first_name != '' && last_name != '') {
                $.ajax({
                    url: "/livetable/add_data",
                    method: "POST",
                    data: {
                        first_name: first_name,
                        last_name: last_name,
                        _token: _token
                    },
                    success: function (data) {
                        $('#message').html(data);
                        fetch_data();
                    }
                });
            } else {
                $('#message').html("<div class='alert alert-danger'>Both Fields are required</div>");
            }
        });

        $(document).on('blur', '.column_name', function () {
            var column_name = $(this).data("column_name");
            var column_value = $(this).text();
            var id = $(this).data("id");

            if (column_value != '') {
                $.ajax({
                    url: "/livetable/update_data",
                    method: "POST",
                    data: {
                        column_name: column_name,
                        column_value: column_value,
                        id: id,
                        _token: _token
                    },
                    success: function (data) {
                        $('#message').html(data);
                    }
                })
            } else {
                $('#message').html("<div class='alert alert-danger'>Enter some value</div>");
            }
        });

        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to delete this records?")) {
                $.ajax({
                    url: "/livetable/delete_data",
                    method: "POST",
                    data: {
                        id: id,
                        _token: _token
                    },
                    success: function (data) {
                        $('#message').html(data);
                        fetch_data();
                    }
                });
            }
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
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item"><a href="#">Library</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                  </nav>
                <div class="h1">Ini Live Data Edit</div>
                <div class="container box">
                    <h3 align="center">Live Table Production</h3><br />
                    <div class="panel panel-default">
                        <div class="panel-heading">Sample Data</div>
                        <div class="panel-body">
                            <div id="message"></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                {{ csrf_field() }}
                            </div>
                        </div>
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

@endsection
