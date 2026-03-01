<!-- Top Navbar -->
<script src="{{ asset('js/navi.js') }}"></script>

<div class="top-navbar">
    <button class="toggle-btn" id="sidebarToggle">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>
    <div class="top-title">Rajarata Sakura</div>

        <div class="top-right">
            <!-- Date & Time -->
            <div id="datetime">
                {{ now()->format('D, M d, Y | H:i:s') }}
            </div>

            <!-- Logout Button -->
            
        </div>
    
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <ul class="nav-links">
        <li>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                <i class="fas fa-home"></i>
                <span class="link-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="#" class="{{ request()->is('users*') ? 'active' : '' }}" data-tooltip="Users">
                <i class="fas fa-users"></i>
                <span class="link-text">Users</span>
            </a>
        </li>
        <li>
        <li class="has-submenu">
            <a href="#" data-tooltip="Category">
                <i class="fas fa-folder"></i>
                <span class="link-text">Category</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-plus-circle"></i> <span class="link-text">Add</span></a></li>
                <li><a href="#"><i class="fas fa-edit"></i> <span class="link-text">Manage</span></a></li>
                <li><a href="#"><i class="fas fa-eye"></i> <span class="link-text">View</span></a></li>
            </ul>
        </li>

        <li class="has-submenu">
            <a href="#" data-tooltip="Sub Category">
                <i class="fas fa-folder-open"></i>
                <span class="link-text">Sub Category</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-plus-circle"></i> <span class="link-text">Add</span></a></li>
                <li><a href="#"><i class="fas fa-edit"></i> <span class="link-text">Manage</span></a></li>
                <li><a href="#"><i class="fas fa-eye"></i> <span class="link-text">View</span></a></li>
            </ul>
        </li>

        <li class="has-submenu">
            <a href="#" data-tooltip="Item">
                <i class="fas fa-utensils"></i>
                <span class="link-text">Item</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-plus-circle"></i> <span class="link-text">Add</span></a></li>
                <li><a href="#"><i class="fas fa-edit"></i> <span class="link-text">Manage</span></a></li>
                <li><a href="#"><i class="fas fa-eye"></i> <span class="link-text">View</span></a></li>
            </ul>
        </li>
        <li>
            <a href="#" data-tooltip="Reports">
                <i class="fas fa-file-alt"></i>
                <span class="link-text">Reports</span>
            </a>
        </li>
        <li>
            <a href="#" data-tooltip="Settings">
                <i class="fas fa-cog"></i>
                <span class="link-text">Settings</span>
            </a>
        </li>
    </ul>

    <div class="logout-section">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span class="link-text">Logout</span>
            </button>
        </form>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
    });

    // Tooltip for collapsed sidebar
    document.querySelectorAll('.nav-links li a').forEach(link => {
        link.addEventListener('mouseenter', () => {
            if(sidebar.classList.contains('collapsed')){
                const tooltip = document.createElement('span');
                tooltip.classList.add('tooltip');
                tooltip.innerText = link.dataset.tooltip;
                link.appendChild(tooltip);
            }
        });
        link.addEventListener('mouseleave', () => {
            const tooltip = link.querySelector('.tooltip');
            if(tooltip) tooltip.remove();
        });
    });
</script>