<!-- TOP NAVBAR -->
<div class="top-navbar">
    <button class="toggle-btn" id="sidebarToggle">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>

    <div class="top-title">Rajarata Sakura</div>

    <div class="top-right">
        <div id="datetime">
            {{ now()->format('D, M d, Y | H:i:s') }}
        </div>
    </div>
</div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <ul class="nav-links">

        <li>
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span class="link-text">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="#" class="{{ request()->is('users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span class="link-text">Users</span>
            </a>
        </li>

        <!-- CATEGORY -->
        <li class="has-submenu">
            <a href="#">
                <i class="fas fa-folder"></i>
                <span class="link-text">Category</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="submenu">
                <li><a href="{{ route('category.add') }}"><i class="fas fa-plus"></i> Add</a></li>
                <li><a href="{{ route('category.manage') }}"><i class="fas fa-edit"></i> Manage</a></li>
                <!-- <li><a href="#"><i class="fas fa-eye"></i> View</a></li> -->
            </ul>
        </li>

        <!-- SUB CATEGORY -->
        <li class="has-submenu">
            <a href="#">
                <i class="fas fa-folder-open"></i>
                <span class="link-text">Sub Category</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="submenu"> 
                <li><a href="{{ route('subcategory.create') }}"><i class="fas fa-plus-square"></i> Add</a></li>
                <li><a href="#"><i class="fas fa-tasks"></i> Manage</a></li>
                <li><a href="#"><i class="fas fa-eye"></i> View</a></li>
            </ul>
        </li>

        <!-- ITEM -->
        <li class="has-submenu">
            <a href="#">
                <i class="fas fa-archive"></i> <!-- Updated icon -->
                <span class="link-text">Item</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="submenu">
                <li><a href="#"><i class="fas fa-plus-circle"></i> Add</a></li>
                <li><a href="#"><i class="fas fa-pen"></i> Manage</a></li>
                <li><a href="#"><i class="fas fa-eye"></i> View</a></li>
            </ul>
        </li>

        <li>
            <a href="#">
                <i class="fas fa-file-alt"></i>
                <span class="link-text">Reports</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fas fa-cog"></i>
                <span class="link-text">Settings</span>
            </a>
        </li>
    </ul>

    <!-- LOGOUT -->
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

<!-- OVERLAY (MOBILE ONLY) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    // Sidebar toggle
    toggleBtn.addEventListener('click', function () {

        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        } else {
            sidebar.classList.toggle('collapsed');
        }

    });

    // Close on overlay click (mobile)
    overlay.addEventListener('click', function () {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });

    document.querySelectorAll('.has-submenu > a').forEach(menu => {
    menu.addEventListener('click', function (e) {
        e.preventDefault();

        const parent = this.parentElement;

        document.querySelectorAll('.has-submenu').forEach(item => {
            if (item !== parent) {
                item.classList.remove('open');
            }
        });

        parent.classList.toggle('open');
    });
});

});
</script>