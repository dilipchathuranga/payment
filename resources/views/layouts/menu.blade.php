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
        <a href="{{ route('supplier') }}" class="nav-link supplier_route">
        <i class="fas fa-table"></i>
            <p>&nbsp;Supplier</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('project') }}" class="nav-link project_route">
            <i class="fas fa-copy"></i>
            <p>&nbsp;Project</p>
        </a>
    </li>

    <!--Bank Section -->
    <li class="nav-item has-treeview bank_tree_open">
        <a href="#" class="nav-link bank_tree ">
            <i class="fas fa-university"></i>&nbsp;
            <p>Bank</p>
            <i class="right fas fa-angle-right"></i>
        </a>
        <ul class="nav nav-treeview">
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
        </ul>
    </li>
            <li class="nav-item">
                <p style="color: #C2C7D0; font-size: 15px; padding-top:10px">&nbsp;Payment Section</p>
            </li>
            <li class="nav-item">
                <a href="{{ route('payment_bill') }}" class="nav-link payment_bill_route">
                    <i class="fas fa-file-invoice"></i>
                    <p>&nbsp;Payment Bills</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('payment_schedule') }}" class="nav-link schedule_route">
                <i class="fas fa-file-alt"></i>
                    <p>&nbsp;Payment Schedule</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('payment_search') }}" class="nav-link payment_search_route">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <p>&nbsp;Payment Search</p>
                </a>
            </li>

        <!--user managment Section -->
        <li class="nav-item">
            <p style="color: #C2C7D0; font-size: 15px; padding-top:10px">&nbsp;User Management</p>
        </li>
        <li class="nav-item">
            <a href="{{ route('role') }}" class="nav-link role_route">
                <i class="fas fa-user-tie"></i>
                <p>&nbsp;Role</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user') }}" class="nav-link user_route">
            <i class="fas fa-file-alt"></i>
                <p>&nbsp;User</p>
            </a>
        </li>

