<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rajarata Sakura')</title>

    <!-- Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<header class="header">
    <div class="logo">Rajarata Sakura</div>
    <div class="search-box">
        <input type="text" placeholder="Search menu..." id="searchInput">
        <span class="search-icon"><i class="fa fa-search"></i></span>
    </div>
    <div class="hamburger" id="hamburger">
        <div class="bar top"></div>
        <div class="bar middle"></div>
        <div class="bar bottom"></div>
    </div>
</header>

<nav class="menu" id="sideMenu">
    <header>Menu <span id="closeMenu">×</span></header>

    <ol>
        <li class="menu-item"><a href="#0">Home</a></li>
        <li class="menu-item"><a href="#0">About</a></li>
        <li class="menu-item">
            <a href="#0">Widgets</a>
            <ol class="sub-menu">
                <li class="menu-item"><a href="#0">Big Widgets</a></li>
                <li class="menu-item"><a href="#0">Bigger Widgets</a></li>
                <li class="menu-item"><a href="#0">Huge Widgets</a></li>
            </ol>
        </li>
        <li class="menu-item">
            <a href="#0">Kabobs</a>
            <ol class="sub-menu">
                <li class="menu-item"><a href="#0">Shishkabobs</a></li>
                <li class="menu-item"><a href="#0">BBQ Kabobs</a></li>
                <li class="menu-item"><a href="#0">Summer Kabobs</a></li>
            </ol>
        </li>
        <li class="menu-item"><a href="#0">Contact</a></li>
        <li class="menu-item"><a href="{{ route('login.post') }}">Login</a></li>
    </ol>
</nav>

<main>
    <div class="content">
        @yield('content')
    </div>
</main>

<script>
const hamburger = document.getElementById('hamburger');
const sideMenu = document.getElementById('sideMenu');
const closeBtn = document.getElementById('closeMenu');

// Toggle menu
hamburger.addEventListener('click', () => {
    sideMenu.classList.toggle('active');
    hamburger.classList.toggle('active');
});
closeBtn.addEventListener('click', () => {
    sideMenu.classList.remove('active');
    hamburger.classList.remove('active');
});

// Submenu toggle
document.querySelectorAll('#sideMenu > ol > li > a').forEach(link => {
    link.addEventListener('click', function(e) {
        const parent = this.parentElement;
        if(parent.querySelector('.sub-menu')) {
            e.preventDefault();
            parent.classList.toggle('show-sub');
        }
    });
});

// Search & highlight
document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    document.querySelectorAll('#sideMenu li').forEach(li => {
        const link = li.querySelector('a');
        if(link.textContent.toLowerCase().includes(query) && query.length>0) {
            li.classList.add('highlight');
            let parent = li.parentElement.closest('li');
            if(parent) parent.classList.add('show-sub');
            li.scrollIntoView({behavior:'smooth', block:'nearest'});
        } else {
            li.classList.remove('highlight');
        }
    });
});

// Close menu on outside click
document.addEventListener('click', function(e){
    if(!sideMenu.contains(e.target) && !hamburger.contains(e.target)){
        sideMenu.classList.remove('active');
        hamburger.classList.remove('active');
    }
});
</script>

</body>
</html>
