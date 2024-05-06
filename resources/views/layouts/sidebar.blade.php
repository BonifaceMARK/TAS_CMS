@if (Auth::user()->role == 0)
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link " href="{{route('dashboard')}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->
  </li><!-- End Tables Nav -->
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">Contested Case</li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav"  href="{{route('tas.view')}}">
        <i class="bi bi-layout-text-window-reverse"></i><span>View TAS</span>
      </a>
    </li><!-- End Tables Nav -->
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">Admitted Case</li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav"  href="{{route('admitted.view')}}">
        <i class="bi bi-layout-text-window-reverse"></i><span>View TAS</span>
      </a>
    </li><!-- End Tables Nav -->
  </ul>
</aside><!-- End Sidebar-->


@elseif (Auth::user()->role == 1)
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link " href="{{route('dashboard')}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav" href="{{route ('see.vio')}}">
          <i class="bi bi-file-earmark-text"></i><span> Add Violation</span>
      </a>
    </li>
    <li class="nav-heading">Contested Case</li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav"  href="{{route('tas.manage')}}">
      <i class="bi bi-menu-button"></i><span>Add Contested Case</span>
      </a>
    </li><!-- End Tables Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav"  href="{{route('tas.view')}}">
      <i class="bi bi-menu-button"></i><span>View Contested Cases</span>
      </a>
    </li><!-- End Tables Nav -->
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">Admitted Case</li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav"  href="{{route('admitted.manage')}}">
      <i class="bi bi-file-earmark-check"></i><span>Add Admitted Case</span>
      </a>
    </li><!-- End Tables Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav"  href="{{route('admitted.view')}}">
      <i class="bi bi-file-earmark-check"></i><span>View Admitted Cases</span>
      </a>
    </li><!-- End Tables Nav -->
 
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">Manage Users</li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('profile', ['id' => Auth::id()]) }}">
        <i class="bi bi-person"></i>
        <span>Profile</span>
      </a>
    </li><!-- End Profile Page Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{route('user_management')}}">
        <i class="bi bi-person-fill-add"></i>
        <span>User Management</span>
      </a>
    </li><!-- End Profile Page Nav -->

    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{route('case.view')}}">
      <i class="bi bi-file-earmark-zip-fill"></i>
        <span>Case Archives</span>
      </a>
    </li><!-- End Profile Page Nav -->
  </ul>
</aside><!-- End Sidebar-->
@else
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link " href="{{route('dashboard')}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->
  </ul>
</aside><!-- End Sidebar-->
@endif


