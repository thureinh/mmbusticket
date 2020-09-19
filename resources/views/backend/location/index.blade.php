@extends('layouts.backendtemplate')
@section('title', 'create')
@section('content')
  <!-- Page Header-->
  <header class="page-header">
    <div class="container-fluid">
      <h2 class="no-margin-bottom">Forms</h2>
    </div>
  </header>
  <!-- Breadcrumb-->
  <div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Locations</li>
    </ul>
  </div>
  <!-- Forms Section-->
  <div class="container-fluid my-3">
    <div class="row bg-white has-shadow">
      <div class="container my-3">
        <button onclick="location.href='{{route('locations.create')}}';" type="button" class="btn btn-success btn-lg d-block mb-4 ml-auto">
          <i class="fas fa-plus-square"></i>&nbsp;Add Location</button>
        <table id="location_table" class="table table-striped table-bordered" width="100%"></table>
      </div>
    </div>
  </div>
  <!-- Page Footer-->
  <footer class="main-footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <p>Your company &copy; 2017-2020</p>
        </div>
        <div class="col-sm-6 text-right">
          <p>Design by <a href="https://bootstrapious.com/p/admin-template" class="external">Bootstrapious</a></p>
          <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
        </div>
      </div>
    </div>
  </footer>


<div class="modal fade" id="information" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="d-flex justify-content-center" id="spinner">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h3 class="h4 text-center">Edit Location Form</h3><br/>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-center mb-3">
                <img src="#" alt="" width="200px" height="200px" id="location_image" class="img-thumbnail">
              </div>
              <form class="form-horizontal" id="update-form">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group row">
                  <label for="fileInput" class="col-sm-3 form-control-label">File input</label>
                  <div class="col-sm-9">
                    <input id="fileInput" name="image" type="file" class="form-control-file">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">Location Name [English&nbsp;<img src="{{asset('admin_template/img/flag_icons/united-kingdom.svg')}}" alt="" width="32" height="32" title="Bootstrap">]</label>
                  <div class="col-sm-9">
                    <input type="text" name="location_name_eng" id="location_name_eng" class="form-control"><small class="help-block-none">Write location name in English</small>
                      <div class="invalid-feedback d-none"></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 form-control-label">Location Name [Myanmar&nbsp;<img src="{{asset('admin_template/img/flag_icons/myanmar.svg')}}" alt="" width="32" height="32" title="Bootstrap">]</label>
                  <div class="col-sm-9">
                    <input type="text" id="location_name_mm" name="location_name_mm" class="form-control"><small class="help-block-none">Write location name in Myanmar</small>
                      <div class="invalid-feedback d-none"></div>
                  </div>
                </div>
              </form>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-update">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('javascript')
<script type="text/javascript" src="{{ asset('admin_template/js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {  
  var datatable = $('#location_table').DataTable( {
    data: @json($locations),
    columns: [
        {
          data: null,
          render: function(data,type,row){
               return '<div class="d-flex justify-content-center"><img src="' + data.image + '",width=60px, height=60px /></div>'},
          orderable: false,
          searchable: false
        },
        { 
          title: "Name in English",
          class: "text-center",
          data: "name.en",
          searchable: true,
          orderable: true
        },
        {
          title: "Name in Myanmar",
          class: "text-center",
          data: "name.mm",
          searchable: true,
          orderable: true
        },
        {
          title: "Edit",
          class: "text-center",
          data: null,
          render: function(data,type,row){
               return '<button type="button" data-url="' + data.url + '/' + data.id + '/edit' + '" class="btn btn-warning btn_edit"><i class="fas fa-edit"></i></button>'},
          orderable: false,
          searchable: false
        },
        {
          title: "Delete",
          class: "text-center",
          data: null,
          render: function(data,type,row){
               return '<button type="button" data-url="' + data.url + '/' + data.id + '" class="btn btn-danger btn_delete"><i class="fas fa-trash-alt"></i></button>'},
          orderable: false,
          searchable: false          
        }
    ]
  });
  const deleteLocation = url => {
    return fetch(url, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })
  }
  const getLocation = url => {
    return fetch(url, {
      method: 'GET',
      headers: {
        "Content-type": "application/json",
        "Accept": "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })   
  }
  const putLocation = (url, data) => {
    return fetch(url, {
      method: 'POST',
      body: data,
      headers: {
        "Accept": "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      }
    })     
  }
  $('#location_table').on('click', '.btn_edit', function (e){
    $('#information').find('div.card').hide()
    $('#spinner').find('div.spinner-border').show()
    let url = $(this).data('url')
    getLocation(url)
    .then(response => response.json())
    .then(json => {
      $('#location_name_eng').val(json.name.en)
      $('#location_name_mm').val(json.name.mm)
      $('#btn-update').data('url', json.url)
      $('#btn-update').data('id', json.id)
      $('#location_image').attr('src', json.image)
      $('#information').find('div.card').show()
      $('#spinner').find('div.spinner-border').hide()
    })
    .catch(err => {
      $('#location_name_eng').addClass('is-invalid');
      $
    })
    $('#information').modal('show')
  })
  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#location_image').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
  }
  $("#fileInput").change(function(){
      readURL(this);
  });
  $('#btn-update').on('click', function () {
    let id = $(this).data('id')
    let form = document.getElementById('update-form');
    let fd = new FormData(form);
    let serialized = $('#update-form').serialize()
    putLocation($(this).data('url') + '/' + id, fd)
    .then(resp => resp.json())
    .then(json => {
      if(json.errors){ 
        if(json.errors.location_name_mm)
        {
          $('#location_name_mm').addClass('is-invalid')
          $('#location_name_mm').siblings('.invalid-feedback')
          .removeClass('d-none').addClass('d-block').text(json.errors.location_name_mm)
        }
        if(json.errors.location_name_eng)
        {
          $('#location_name_eng').addClass('is-invalid')
          $('#location_name_eng').siblings('.invalid-feedback')
          .removeClass('d-none').addClass('d-block').text(json.errors.location_name_eng)
        }
        return
      }
      new Swal({
        position: 'top-end',
        icon: 'success',
        title: 'Your change has been updated',
        showConfirmButton: false,
        timer: 1500
      })
      $('#information').modal('hide')
      datatable.clear().rows.add(json).draw();
    })
    .catch(err => { console.log(err) })
  });
  $('#location_table').on('click', '.btn_delete', function (e){
    let url = $(this).data('url')
    let id = $(this).data('id')
    new Swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        deleteLocation(url)
        .then(resp => resp.json())
        .then(json => {
            datatable.clear().rows.add(json).draw();
            Swal.fire(
            'Deleted!',
            'Record has been deleted.',
            'success'
            )
        })
        .catch(err => { console.log(err) })
      }
    })
  });
});
</script>
@endsection
