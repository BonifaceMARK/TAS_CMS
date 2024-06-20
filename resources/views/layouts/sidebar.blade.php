<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link dashboard collapsed" href="{{ route('dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
      <a class="nav-link analytics collapsed" data-bs-target="#tables-nav" href="{{ route('analytics.index') }}">
        <i class="bi bi-graph-up-arrow"></i><span>Analytics</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link chat collapsed" data-bs-target="#tables-nav" href="{{ route('chat.index') }}">
        <i class="bi bi-chat-left-text"></i><span>Chat</span>
      </a>
    </li>
    @if (Auth::user()->role == 9)
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">
  AO/Violation
</li>

    <li class="nav-item">
      <a class="nav-link violation collapsed" data-bs-target="#tables-nav" href="{{ route('see.vio') }}">
        <i class="bi bi-file-earmark-text"></i><span>Add Violation</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link violation collapsed" data-bs-target="#tables-nav" href="{{ route('see.offi') }}">
        <i class="bi bi-person-fill-add"></i><span>Add Apprehending Officer</span>
      </a>
    </li>
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">Contested Case</li>
    <li class="nav-item">
      <a class="nav-link contested collapsed" data-bs-target="#tables-nav" href="{{ route('tas.manage') }}">
        <i class="bi bi-menu-button"></i><span>Add Contested Case</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link contested collapsed" data-bs-target="#tables-nav" href="{{ route('tas.view') }}">
        <i class="bi bi-menu-button"></i><span>View Contested Cases</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link contested collapsed" data-bs-target="#tables-nav" href="{{ route('update.contest.index') }}">
        <i class="bi bi-file-arrow-up"></i><span>Update Contested Cases</span>
      </a>
    </li>
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">Admitted Case</li>
    <li class="nav-item">
      <a class="nav-link admitted collapsed" data-bs-target="#tables-nav" href="{{ route('admitted.manage') }}">
        <i class="bi bi-file-earmark-check"></i><span>Add Admitted Case</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link admitted collapsed" data-bs-target="#tables-nav" href="{{ route('admitted.view') }}">
        <i class="bi bi-file-earmark-check"></i><span>View Admitted Cases</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link admitted collapsed" data-bs-target="#tables-nav" href="{{ route('edit.admit') }}">
        <i class="bi bi-pencil-square"></i><span>Update Admitted Cases</span>
      </a>
    </li>
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-item">
      <a class="nav-link archives collapsed" href="{{ route('case.view') }}">
        <i class="bi bi-file-earmark-zip-fill"></i><span>Case Archives</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link archives collapsed" href="{{ route('history.index') }}">
        <i class="bi bi-clock-history"></i><span>History</span>
      </a>
    </li>
    @elseif (Auth::user()->role == 2)
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">AO/Violation</li>
    <li class="nav-item">
      <a class="nav-link violation collapsed" data-bs-target="#tables-nav" href="{{ route('see.vio') }}">
        <i class="bi bi-file-earmark-text"></i><span>Add Violation</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link violation collapsed" data-bs-target="#tables-nav" href="{{ route('see.offi') }}">
        <i class="bi bi-person-fill-add"></i><span>Add Apprehending Officer</span>
      </a>
    </li>
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">Contested Case</li>
    <li class="nav-item">
      <a class="nav-link contested collapsed" data-bs-target="#tables-nav" href="{{ route('tas.manage') }}">
<span class="bi bi-plus-circle">  Add</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link contested collapsed" data-bs-target="#tables-nav" href="{{ route('tas.view') }}">
      <span class="bi bi-eye">  View</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link contested collapsed" data-bs-target="#tables-nav" href="{{ route('update.contest.index') }}">
   <span class="bi bi-pencil-square"> Update</span>
      </a>
    </li>
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">Admitted Case</li>
    <li class="nav-item">
      <a class="nav-link admitted collapsed" data-bs-target="#tables-nav" href="{{ route('admitted.manage') }}">
       <span class="bi bi-plus-circle">  Add</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link admitted collapsed" data-bs-target="#tables-nav" href="{{ route('admitted.view') }}">
        <span class="bi bi-eye">  View</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link admitted collapsed" data-bs-target="#tables-nav" href="{{ route('edit.admit') }}">
      <span class="bi bi-pencil-square">  Update</span>
      </a>
    </li>
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-item">
      <a class="nav-link archives collapsed" href="{{ route('case.view') }}">
        <i class="bi bi-file-earmark-zip-fill"></i><span>Case Archives</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link archives collapsed" href="{{ route('history.index') }}">
        <i class="bi bi-clock-history"></i><span>History</span>
      </a>
    </li>
    @else

    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">Contested Case</li>
    <li class="nav-item">
      <a class="nav-link contested collapsed" href="{{ route('tas.view') }}">
        <i class="bi bi-layout-text-window-reverse"></i><span>View TAS</span>
      </a>
    </li>
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-heading">Admitted Case</li>
    <li class="nav-item">
      <a class="nav-link admitted collapsed" href="{{ route('admitted.view') }}">
        <i class="bi bi-layout-text-window-reverse"></i><span>View TAS</span>
      </a>
    </li>
    <li class="nav-heading" style="border-bottom: 1px solid #000;"></li>
    <li class="nav-item">
      <a class="nav-link archives collapsed" href="{{ route('case.view') }}">
        <i class="bi bi-file-earmark-zip-fill"></i><span>Case Archives</span>
      </a>
    </li>
    @endif
  </ul>
</aside><!-- End Sidebar -->