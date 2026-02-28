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