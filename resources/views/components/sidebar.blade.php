<nav id="sidebar" class="collapse d-lg-block sidebar collapse bg-white shadow-sm">
    <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
          <a
          href="{{ url('admin') }}"
            class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('admin.') ? 'active' : '' }}"
            aria-current="true"
          >
            <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
          </a>
          <a href="#" class="list-group-item list-group-item-action py-2 ripple">
            <i class="fas fa-user fa-fw me-3"></i><span>User</span>
          </a>
          <a href="{{ url('admin/stations') }}" class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('admin.stations.index') ? 'active' : '' }}"
            ><i class="fas fa-umbrella fa-fw me-3"></i><span>Weather Stations</span></a
          >
        </div>
    </div>
</nav>
