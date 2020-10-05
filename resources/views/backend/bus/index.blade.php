@extends('layouts.backendtemplate')
@section('title', 'Buses')
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
      <li class="breadcrumb-item active">Bus</li>
    </ul>
  </div>
  <!-- Forms Section-->
  <div class="container-fluid my-3">
    <div class="row bg-white has-shadow">
      <div class="container my-3">
        <button onclick="location.href='{{route('buses.create')}}';" type="button" class="btn btn-success btn-lg d-block mb-4 ml-auto">
          <i class="fas fa-plus-square"></i>&nbsp;Add Bus</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Gallery</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <div id="gallery_carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">

        </ol>
        <div class="carousel-inner">

        </div>
        <a class="carousel-control-prev" href="#gallery_carousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#gallery_carousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    data: @json($buses),
    columnDefs: [ {
        "searchable": false,
        "orderable": false,
        "targets": 0,
        "width": "5%"
    } ],
    columns: [
        {
          data:null,
          class: "text-center"
        },
        { 
          title: "License",
          class: "text-center",
          data: "license",
          searchable: true,
          orderable: true
        },
        {
          title: "Company Name",
          class: "text-center",
          data: "company.name",
          searchable: true,
          orderable: true
        },
        {
          title: "Bus Type",
          class: "text-center",
          data: function(data, type, dataToSet){
            return "English: " + data.bustype.en_name + " | Myanmar: " + data.bustype.mm_name; 
          },
          searchable: true,
          orderable: true
        },
        {
          title: "Seats",
          class: "text-center",
          data: "nos",
          searchable: true,
          orderable: true
        },
        {
          title: "Gallery",
          class: "text-center",
          data: null,
          render: function(data,type,row){
               return '<button type="button" data-photos=\'' + JSON.stringify(data.photos) + '\' class="btn btn-info btn_view"><i class="fas fa-eye"></i></button>'},
          orderable: false,
          searchable: false
        },
        {
          title: "Edit",
          class: "text-center",
          data: null,
          render: function(data,type,row){
               return '<button type="button" onclick="location.href=\'' + data.url + '/' + data.id + '/edit' + '\';" class="btn btn-warning"><i class="fas fa-edit"></i></button>'},
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
  datatable.on( 'order.dt search.dt', function () {
        datatable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
  } ).draw();
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
  $('#location_table').on('click', '.btn_view', function (e){
    let photos = $(this).data('photos')
    var indicators = "" 
    var carousel_items = ""
    for (let i = 0; i < photos.length; i++) {
      indicators += "<li data-target='#gallery_carousel' data-slide-to='" + i + "' class='" + 
                      ((i === 0) ? 'active' : '') + "'></li>"

      carousel_items += `<div class="carousel-item ${(i === 0) ? 'active' : ''}">
                              <img class="d-block w-100" height="500px" src="${photos[i]}">
                            </div>`
    }
    $('#gallery_carousel').find('ol.carousel-indicators').html(indicators)
    $('#gallery_carousel').find('div.carousel-inner').html(carousel_items)
    $('#information').modal('show')
  })
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