<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Rajarata Sakura Restaurant</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', sans-serif;
    min-height: 100vh;
    background: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5') center/cover no-repeat;
    background-attachment: fixed;
    position: relative;
    display: flex;
    flex-direction: column;
}

/* Gradient overlay */
body::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(rgba(20,20,30,0.65), rgba(40,20,50,0.75));
    z-index: 0;
}

/* Container */
.container {
    position: relative;
    z-index: 1;
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
    flex: 1;
}

/* HERO */
.hero-section {
    text-align: center;
    padding: 40px 20px 20px;
    color: #fff;
}

.welcome-text {
    font-size: 38px;
    font-weight: 700;
    transition: opacity 0.4s ease;
    min-height: 80px; /* reserve extra space so greeting text doesn't push buttons */
}

.restaurant-name {
    font-size: 24px;
    margin-top: 8px;
    color: #ffd6f2;
    font-weight: 600;
}

.sub-text {
    margin-top: 10px;
    font-size: 16px;
    color: rgba(255,255,255,0.9);
}

/* CATEGORY GRID */
.category-section {
    margin-top: 20px; /* small space between greeting and categories */
    padding-bottom: 40px;
}

.category-container {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    justify-content: center; /* horizontal alignment for desktop */
}

.category-box {
    width: 180px;  /* fixed width */
    height: 110px; /* fixed height */
    border-radius: 14px;
    background: linear-gradient(145deg, rgba(255,110,180,0.3), rgba(166,77,255,0.3));
    border: 2px solid rgba(255,255,255,0.3);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    font-weight: 600;
    text-align: center;
    padding: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.25);
}

.category-box:hover {
    background: linear-gradient(145deg, rgba(255,110,180,0.5), rgba(166,77,255,0.5));
    transform: translateY(-4px) scale(1.03);
    box-shadow: 0 8px 25px rgba(0,0,0,0.4);
}

/* FOOTER */
.footer {
    background: rgba(0,0,0,0.85);
    color: #fff;
    padding: 40px 20px;
    text-align: center;
    font-size: 14px;
    line-height: 1.6;
    border-top: 2px solid rgba(255,255,255,0.2);
    margin-top: auto; /* stick to bottom */
}

.footer h3 {
    margin-bottom: 12px;
    color: #ffd6f2;
    font-size: 18px;
}

.footer strong {
    color: #ffccf0;
}

/* TABLET */
@media (max-width: 768px) {
    .welcome-text { font-size: 32px; min-height: 80px; }
    .restaurant-name { font-size: 20px; }
    .category-box { width: 180px; height: 110px; font-size: 14px; } /* fixed size */
}

/* MOBILE */
@media (max-width: 480px) {
    .hero-section { padding: 30px 15px 20px; }
    .welcome-text { font-size: 26px; min-height: 80px; }
    .sub-text { font-size: 14px; }
    .category-container {
        flex-direction: column; /* stack vertically on mobile */
        align-items: center;
        gap: 12px;
    }
    .category-box { width: 180px; height: 110px; font-size: 13px; } /* fixed size */
}
</style>
</head>

<body>

<div class="container">

    <!-- HERO -->
    <div class="hero-section">
        <div class="welcome-text" id="welcomeText">Welcome. !!!</div>
        <div class="restaurant-name">Rajarata Sakura Restaurant</div>
        <div class="sub-text">Select a category to begin your order</div>
    </div>

    <!-- CATEGORIES -->
    <div class="category-section" id="categories">
        <div class="category-container">
            @foreach($categories as $category)
                <a href="{{ route('select.category', $category->category_id) }}" style="text-decoration:none;">
                    <div class="category-box">{{ $category->category_name }}</div>
                </a>
            @endforeach
        </div>
    </div>

</div>

<!-- FOOTER -->
<div class="footer">
    <h3>Our Address</h3>
    110-65, FUNYU, CHIKUSEI SHI, IBARAKI KEN, JAPAN.<br><br>

    <h3>Contact Us</h3>
    Hot Line: +81 80-1756-2569<br>
    TEL: 0296 48 6606<br>
    Email: rajaratasakura@gmail.com<br>
    Mon-Wed, Fri-Sun: 10:00 AM - 10:00 PM<br>
    <strong>Closed on Thursdays</strong>
</div>

<script>
const greetings = [
    "Welcome !!!",
    "අපගේ වෙළඳසැලට පිළිගනිමු !!!",
    "私たちの店へようこそ !!!"
];

let index = 0;
const el = document.getElementById("welcomeText");

// Reserve fixed height so category buttons do not move
el.style.minHeight = "80px"; // enough space for long greetings

setInterval(() => {
    el.style.opacity = 0;
    setTimeout(() => {
        index = (index + 1) % greetings.length;
        el.innerText = greetings[index];
        el.style.opacity = 1;
    }, 200);
}, 3000);
</script>

</body>
</html>