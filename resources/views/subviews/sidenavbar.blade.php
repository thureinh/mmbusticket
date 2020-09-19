<nav class="side-navbar">
  <!-- Sidebar Header-->
  <div class="sidebar-header d-flex align-items-center">
    <div class="avatar"><img src="{{asset('admin_template/img/avatar-1.jpg')}}" alt="..." class="img-fluid rounded-circle"></div>
    <div class="title">
      <h1 class="h4">Mark Stephen</h1>
      <p>Web Designer</p>
    </div>
  </div>
  <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
  <ul class="list-unstyled">
    <li class="{{ (request()->is('dashboard')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}"> <i class="icon-home"></i>Home </a></li>
    <li class="{{ (request()->is('locations*')) ? 'active' : '' }}"><a href="{{ route('locations.index') }}"><i class="fas fa-map-marked-alt"></i>Locations</a></li>
    <li class="{{ (request()->is('companies*')) ? 'active' : '' }}"><a href="{{ route('companies.index') }}"><i class="fas fa-building"></i>Companies</a></li>
    <li class="{{ (request()->is('buses*')) ? 'active' : '' }}"><a href="{{ route('buses.index') }}"><i class="fas fa-bus-alt"></i>Buses</a></li>
    <li><a href="#"><i class="fas fa-route"></i>Itineraries</a></li>
  </ul>
</nav>