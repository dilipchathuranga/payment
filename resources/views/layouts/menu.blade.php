<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link dashboard_route">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <p style="color: #C2C7D0; font-size: 15px; padding-top:10px">&nbsp;Master</p>
</li>
<li class="nav-item">
  <a href="{{ route('bank') }}" class="nav-link bank_route">
   <i class="fas fa-money-check-alt"></i>
    <p>&nbsp;Bank</p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ route('branch') }}" class="nav-link branch_route">
   <i class="fas fa-code-branch"></i>
    <p>&nbsp;&nbsp;Branch</p>
  </a>
</li>
<li class="nav-item">
  <a href="{{ route('bank_account') }}" class="nav-link bank_account_route">
    <i class="fas fa-file-invoice-dollar"></i>
    <p>&nbsp;Bank Account</p>
  </a>
</li>
<li class="nav-item">
    <p style="color: #C2C7D0; font-size: 15px; padding-top:10px">&nbsp;Payment Section</p>
</li>
<li class="nav-item">
  <a href="{{ route('payment_bill') }}" class="nav-link payment_bill_route">
    <i class="fas fa-file-invoice-dollar"></i>
    <p>&nbsp;Payment Bills</p>
  </a>
</li>
