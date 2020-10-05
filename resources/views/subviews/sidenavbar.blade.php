<nav class="side-navbar">
  <!-- Sidebar Header-->
  <div class="sidebar-header d-flex align-items-center">
    <div class="avatar"><img src="{{asset('admin_template/img/avatar-12.jpg')}}" alt="#" class="img-fluid rounded-circle"></div>
    <div class="title">
      <h1 class="h4">{{ Auth::user()->name }}</h1>
      <p>{{ Auth::user()->getRoleNames()->first() }}</p>
    </div>
  </div>
  <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
  <ul class="list-unstyled">
      <li class="{{ (request()->is('dashboard')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}"> <i class="icon-home"></i>Home </a></li>
    @hasrole('admin')
      <li class="{{ (request()->is('locations*')) ? 'active' : '' }}"><a href="{{ route('locations.index') }}"><i class="fas fa-map-marked-alt"></i>Locations</a></li>
      <li class="{{ (request()->is('companies*')) ? 'active' : '' }}"><a href="{{ route('companies.index') }}"><i class="fas fa-building"></i>Companies</a></li>
    @endhasrole
    @hasrole('company-manager')
      <li class="{{ (request()->is('buses*')) ? 'active' : '' }}"><a href="{{ route('buses.index') }}"><i class="fas fa-bus-alt"></i>Buses</a></li>
      <li class="{{ (request()->is('itineraries*')) ? 'active' : '' }}"><a href="{{ route('itineraries.index') }}"><i class="fas fa-route"></i>Itineraries</a></li>
      <li class="{{ (request()->is('bookings*')) ? 'active' : '' }}"><a href="{{ route('bookings.index') }}"><i class="fas fa-book"></i>Bookings</a></li>
    @endhasrole
  </ul>
</nav>