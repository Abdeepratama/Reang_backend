<nav class="topnav navbar navbar-light">
  <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
    <i class="fe fe-menu navbar-toggler-icon"></i>
  </button>
  <form class="form-inline mr-auto searchform text-muted">
    <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Type something..." aria-label="Search">
  </form>
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
        <i class="fe fe-sun fe-16"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-muted my-2" href="{{ route('admin.fitur.index') }}">
        <span class="fe fe-grid fe-16"></span>
      </a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link text-muted my-2 dropdown-toggle" href="#" id="notifDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="fe fe-bell fe-16"></span>
        <span class="dot dot-md bg-success"></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="notifDropdown">
        <li>
          <h6 class="dropdown-header">Notifikasi</h6>
        </li>
        @forelse($notifikasiAktivitas as $notif)
        <li>
          <a class="dropdown-item" href="{{ route('admin.notifikasi.baca.satu', $notif->id) }}">
            {{ $notif->keterangan }}<br>
            <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
          </a>
        </li>
        @empty
        <li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>
        @endforelse
      </ul>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="avatar avatar-sm mt-2">
          <img src="./assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
        </span>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="#">Profile</a>
        <a class="dropdown-item" href="{{ route('admin.setting.index') }}">Settings</a>
        <a class="dropdown-item" href="#">Activities</a>
        <a class="dropdown-item" href="#"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   Logout
</a>

<!-- Form logout tersembunyi -->
<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>
      </div>
    </li>
  </ul>
</nav>