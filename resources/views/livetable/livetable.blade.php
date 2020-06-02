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
                <b>
                    <h4 class="card-title">Frame Formulasi</h4>
                </b>
                <form class="form-sample">
                    {{-- <p class="card-description"> Personal info </p> --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal</label>
                                <div class="col-sm-9">
                                    <select class="form-control">
                                        <option>1/12/2020</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">No PC</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="PC-0002/01/2020">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project No</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="DV-0001/01/2020">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Chemist</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="Rachma Amelinda">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Project Type</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="Development">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Qty</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" value="1115.3">
                                </div>
                                <label class="col-form-label">No-Reff</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" value="PC-0001/01">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Project</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Due Date</label>
                                <div class="col-sm-9">
                                    <select class="form-control">
                                        <option>1/12/2020</option>
                                        <option>4/11/2020</option>
                                    </select>
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
                                    <textarea name="" id="" class="form-control" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 float-right">
                        <button type="submit" class="form-control btn btn-primary">Next</button>
                    </div>
                </form>
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
