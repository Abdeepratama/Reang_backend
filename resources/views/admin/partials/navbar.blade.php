<nav class="topnav navbar navbar-light bg-white shadow-sm fixed-top">
  <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
    <i class="fe fe-menu navbar-toggler-icon"></i>
  </button>
  <ul class="nav ml-auto">
    <li class="nav-item">
      <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
        <i class="fe fe-sun fe-16"></i>
      </a>
    </li>

    <!-- @if (Auth::guard('admin')->check() &&
    (Auth::guard('admin')->user()->role === 'superadmin'))
    <li class="nav-item">
      <a class="nav-link text-muted my-2" href="{{ route('admin.fitur.index') }}">
        <span class="fe fe-grid fe-16"></span>
      </a>
    </li>
    @endif -->

    <!-- Notifikasi -->
    <li class="nav-item dropdown">
      <a class="nav-link text-muted my-2 dropdown-toggle" href="#" id="notifDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="fe fe-bell fe-16"></span>
        <span class="dot dot-md bg-success"></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="notifDropdown">
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

    <!-- User -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink"
        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="avatar avatar-sm d-inline-flex align-items-center justify-content-center 
                 rounded-circle bg-secondary text-white"
          style="width: 30px; height: 30px; font-size: 18px;">
          {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
        </span>
        <span class="text-primary">{{ ucwords(Auth::guard('admin')->user()->name) }}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="{{ route('admin.accounts.profile') }}">
          Profile
        </a>

        @if(Auth::guard('admin')->user()->role === 'superadmin')
        <a class="dropdown-item" href="{{ route('admin.accounts.index') }}">Akun</a>
        @endif

        @if(Auth::guard('admin')->user()->role !== 'puskesmas')
        <a class="dropdown-item" href="{{ route('admin.setting.index') }}">Settings</a>
        @endif

        <a class="dropdown-item" href="#"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Logout
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </li>
  </ul>
</nav>