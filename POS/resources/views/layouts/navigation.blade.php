<!-- Top Navbar -->
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

        <!-- Category submenu -->
        <li class="has-submenu">
            <a href="#" data-tooltip="Category">
                <i class="fas fa-folder"></i>
                <span class="link-text">Category</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-plus-circle"></i> Add</a></li>
                <li><a href="#"><i class="fas fa-edit"></i> Manage</a></li>
                <li><a href="#"><i class="fas fa-eye"></i> View</a></li>
            </ul>
        </li>

        <!-- Sub Category submenu -->
        <li class="has-submenu">
            <a href="#" data-tooltip="Sub Category">
                <i class="fas fa-folder-open"></i>
                <span class="link-text">Sub Category</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-plus-circle"></i> Add</a></li>
                <li><a href="#"><i class="fas fa-edit"></i> Manage</a></li>
                <li><a href="#"><i class="fas fa-eye"></i> View</a></li>
            </ul>
        </li>

        <!-- Item submenu -->
        <li class="has-submenu">
            <a href="#" data-tooltip="Item">
                <i class="fas fa-utensils"></i>
                <span class="link-text">Item</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-plus-circle"></i> Add</a></li>
                <li><a href="#"><i class="fas fa-edit"></i> Manage</a></li>
                <li><a href="#"><i class="fas fa-eye"></i> View</a></li>
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

    <!-- Logout -->
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

<!-- Inline JS -->
<script>
    // Sidebar collapse toggle
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

    // Submenu toggle
    document.querySelectorAll('.has-submenu > a').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const parent = link.parentElement;

            // Toggle clicked submenu
            parent.classList.toggle('open');

            // Close other submenus
            document.querySelectorAll('.has-submenu').forEach(item => {
                if(item !== parent){
                    item.classList.remove('open');
                }
            });
        });
    });

    // Date & time update
    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
        const dateStr = now.toLocaleDateString('en-US', options);
        const timeStr = now.toLocaleTimeString('en-US', { hour12: false });
        const dateTimeEl = document.getElementById('datetime');
        if(dateTimeEl) dateTimeEl.innerText = `${dateStr} | ${timeStr}`;
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>