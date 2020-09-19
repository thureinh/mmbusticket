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
      <li class="breadcrumb-item active">Companies</li>
    </ul>
  </div>
  <!-- Forms Section-->
  <div class="container-fluid my-3">
    <div class="row bg-white has-shadow">
      <div class="container my-3">
        <button onclick="location.href='{{route('companies.create')}}';" type="button" class="btn btn-success btn-lg d-block mb-4 ml-auto">
          <i class="fas fa-plus-square"></i>&nbsp;Add Company</button>
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
          <div class="card-header d-flex align-items-center">
            <h3 class="h4">Edit Company Form</h3>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-center mb-3">
              <img src="{{ asset('static/images/default-placeholder-200x200.png') }}" alt="" width="200px" height="200px" id="company_image" class="img-thumbnail">
            </div>
            <form id="update-form" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                  <label for="fileInput">File input</label>
                  <input id="fileInput" name="image" type="file" class="form-control-file">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                  <label for="company_name">Company Name</label>
                  <input type="text" id="company_name" name="company_name" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                  <label for="name">Manager Name</label>
                  <input id="name" type="text" class="form-control" name="name" required autocomplete="name">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input id="email" type="email" class="form-control" name="email"  required autocomplete="email">
                    <div class="invalid-feedback"></div>
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
    data: @json($companies),
    columns: [
        {
          data: null,
          render: function(data,type,row){
               return '<div class="d-flex justify-content-center"><img src="' + data.logo + '",width=60px, height=60px /></div>'},
          orderable: false,
          searchable: false
        },
        { 
          title: "Company Name",
          class: "text-center",
          data: "name",
          searchable: true,
          orderable: true
        },
        {
          title: "Manager Name",
          class: "text-center",
          data: "user.name",
          searchable: true,
          orderable: true
        },
        {
          title: "Manager Email",
          class: "text-center",
          data: "user.email",
          searchable: true,
          orderable: true
        },
        {
          title: "Email Verification",
          class: "text-center",
          data: null,
          render: function(data,type,row){
            if(type == 'sort')
            {
              return data.user.email_verified_at ? 'true' : 'false'
            }
            else
            {
              let button = "";
              if(data.user.email_verified_at)
                button = '<button type="button" class="btn btn-success" disabled>Verified</button>'
              else
                button = '<button type="button" class="btn btn-warning" disabled>Not Verified</button>'
              return button
            }
          },
          orderable: true,
          searchable: false
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
      $('#company_name').val(json.name)
      $('#name').val(json.user.name)
      $('#email').val(json.user.email)
      $('#btn-update').data('url', json.url)
      $('#btn-update').data('id', json.id)
      $('#company_image').attr('src', json.logo)
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
            $('#company_image').attr('src', e.target.result);
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
        if(json.errors.company_name)
        {
          $('#company_name').addClass('is-invalid')
          $('#company_name').siblings('.invalid-feedback')
          .removeClass('d-none').addClass('d-block').text(json.errors.company_name)
        }
        if(json.errors.name)
        {
          $('#name').addClass('is-invalid')
          $('#name').siblings('.invalid-feedback')
          .removeClass('d-none').addClass('d-block').text(json.errors.name)
        }
        if(json.errors.email)
        {
          $('#email').addClass('is-invalid')
          $('#email').siblings('.invalid-feedback')
          .removeClass('d-none').addClass('d-block').text(json.errors.email)
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