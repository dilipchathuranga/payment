<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link dashboard_route">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>
<br>
<p style="color:white; font-size: 17px">Master</p>
<li class="nav-item has-treeview bank_treeview">
    <a href="#" class="nav-link">
      &nbsp;&nbsp;<i class="fas fa-city"></i>&nbsp;&nbsp;
      <p> Bank</p>
      <i class="right fas fa-angle-right"></i>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('bank') }}" class="nav-link bank_route">
            &nbsp;&nbsp;&nbsp;<i class="fas fa-money-check-alt"></i>
            <p>&nbsp;Bank</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('branch') }}" class="nav-link branch_route">
            &nbsp;&nbsp;&nbsp;<i class="fas fa-code-branch"></i>
            <p>&nbsp;Branch</p>
          </a>
        </li>
    </ul>
</li>
