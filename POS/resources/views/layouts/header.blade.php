<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modern Header with Animated Menu</title>
<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Header -->
<header class="header">
    <div class="logo">Rajarata Sakura</div>

    <div class="search-box">
        <input type="text" placeholder="Search products..." id="searchInput">
        <span class="search-icon">🔍</span>
    </div>

    <div class="hamburger" id="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </div>
</header>

<!-- Animated Side Menu -->
<nav class="menu closed" id="sideMenu">
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
                <li class="menu-item"><a href="#0">BBQ kabobs</a></li>
                <li class="menu-item"><a href="#0">Summer kabobs</a></li>
            </ol>
        </li>
        <li class="menu-item"><a href="#0">Contact</a></li>
    </ol>
    <footer><button aria-label="Toggle Menu">Toggle</button></footer>
</nav>

<script>

// Hamburger toggle for menu
const hamburger = document.getElementById('hamburger');
const sideMenu = document.getElementById('sideMenu');
const closeBtn = document.getElementById('closeMenu');

hamburger.addEventListener('click', () => {
    sideMenu.classList.toggle('active');
});
closeBtn.addEventListener('click', () => {
    sideMenu.classList.remove('active');
});

// Animated menu logic
var $els = $('#sideMenu a, #sideMenu header');
var count = $els.length;
var grouplength = Math.ceil(count/3);
var groupNumber = 0;
var i = 1;
$('#sideMenu').css('--count', count);
$els.each(function(j){
    if (i > grouplength) { groupNumber++; i=1; }
    $(this).attr('data-group', groupNumber);
    i++;
});

$('#sideMenu footer button').on('click', function(e){
    e.preventDefault();
    $els.each(function(j){
        $(this).css('--top', $(this)[0].getBoundingClientRect().top + ($(this).attr('data-group') * -15) - 20);
        $(this).css('--delay-in', j*.1+'s');
        $(this).css('--delay-out', (count-j)*.1+'s');
    });
    $('#sideMenu').toggleClass('closed');
    e.stopPropagation();
});

// Run animation once for demo
setTimeout(function(){
    $('#sideMenu footer button').click();
    setTimeout(function(){
        $('#sideMenu footer button').click();
    }, (count * 100) + 500 );
}, 1000);

</script>
</body>
</html>