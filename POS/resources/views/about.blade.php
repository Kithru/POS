@include('layouts.headernavi')

<link href="{{ asset('css/footer.css') }}" rel="stylesheet">
<link href="{{ asset('css/header.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
/* ================= PREMIUM ABOUT PAGE ================= */

body{
    background: linear-gradient(135deg,#fff7fb,#fffaf5);
}

/* Main Container */
.about-wrapper{
    max-width: 1250px;
    margin: 50px auto;
    padding: 0 20px;
}

/* Hero Section */
.about-hero{
    position: relative;
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 20px 45px rgba(0,0,0,0.12);
}

.about-hero img{
    width: 100%;
    height: 520px;
    object-fit: cover;
}

.about-overlay{
    position: absolute;
    inset: 0;
    background: linear-gradient(to right,rgba(30,10,20,0.82),rgba(120,30,80,0.35));
    display: flex;
    align-items: center;
    padding: 60px;
}

.about-overlay-content{
    max-width: 650px;
    color: #fff;
}

.about-overlay-content h1{
    font-size: 48px;
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.2;
}

.about-overlay-content p{
    font-size: 18px;
    line-height: 1.9;
    opacity: .95;
}

.tag-line{
    display: inline-block;
    background: rgba(255,255,255,.15);
    padding: 10px 18px;
    border-radius: 50px;
    margin-bottom: 18px;
    font-size: 14px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* Cards */
.info-grid{
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(280px,1fr));
    gap: 25px;
    margin-top: 40px;
}

.card-box{
    background: #fff;
    padding: 30px;
    border-radius: 22px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.08);
    transition: 0.3s ease;
}

.card-box:hover{
    transform: translateY(-8px);
}

.card-box h3{
    color: #8d1558;
    font-size: 24px;
    margin-bottom: 15px;
}

.card-box p{
    color: #555;
    line-height: 1.9;
    margin: 0;
}

/* Details Section */
.details-wrap{
    background: #fff;
    margin-top: 40px;
    padding: 40px;
    border-radius: 25px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
}

.section-title{
    text-align: center;
    font-size: 34px;
    color: #2e1a26;
    margin-bottom: 35px;
    font-weight: 800;
}

.detail-list{
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(320px,1fr));
    gap: 25px;
}

.detail-item{
    background: #fff7fb;
    border-left: 5px solid #b61e72;
    padding: 22px;
    border-radius: 18px;
}

.detail-item i{
    color: #b61e72;
    margin-right: 10px;
    width: 24px;
}

.detail-item strong{
    color: #2e1a26;
}

/* Contact Box */
.contact-box{
    margin-top: 40px;
    background: linear-gradient(135deg,#8d1558,#5d123e);
    color: #fff;
    padding: 40px;
    border-radius: 25px;
    box-shadow: 0 15px 35px rgba(141,21,88,.28);
}

.contact-grid{
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap: 20px;
}

.contact-grid div{
    background: rgba(255,255,255,0.08);
    padding: 20px;
    border-radius: 18px;
}

/* Social */
.social-links{
    text-align: center;
    margin-top: 35px;
}

.social-links a{
    display: inline-block;
    margin: 0 12px;
    color: #ffffff;
    font-size: 28px;
    transition: 0.3s ease;
    text-decoration: none;
}

.social-links a:hover{
    color: #ffd6ea;
    transform: translateY(-5px) scale(1.15);
}

/* Map */
.map-box{
    margin-top: 40px;
    overflow: hidden;
    border-radius: 25px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
}

.map-box iframe{
    width: 100%;
    height: 450px;
    border: 0;
}

/* Responsive */
@media(max-width:768px){

    .about-overlay{
        padding: 30px;
    }

    .about-overlay-content h1{
        font-size: 34px;
    }

    .about-hero img{
        height: 430px;
    }

    .details-wrap,
    .contact-box{
        padding: 25px;
    }

    .section-title{
        font-size: 28px;
    }
}
</style>

<div class="about-wrapper">

    <!-- HERO -->
    <section class="about-hero">
        <img src="{{ asset('images/about.jpg') }}" alt="Rajarata Sakura Restaurant">

        <div class="about-overlay">
            <div class="about-overlay-content">
                <span class="tag-line">Authentic Japanese Experience</span>

                <h1>About Rajarata Sakura Restaurant</h1>

                <p>
                    Welcome to Rajarata Sakura Restaurant — where authentic Japanese flavors,
                    premium ingredients, elegant hospitality, and unforgettable dining moments
                    come together in perfect harmony.
                </p>
            </div>
        </div>
    </section>

    <!-- MISSION -->
    <div class="info-grid">

        <div class="card-box">
            <h3>Our Story</h3>
            <p>
                Since our beginning, Rajarata Sakura Restaurant has proudly delivered
                high-quality Japanese cuisine with a modern touch. Every dish is crafted
                with passion, precision, and freshness.
            </p>
        </div>

        <div class="card-box">
            <h3>Our Mission</h3>
            <p>
                To provide a world-class dining experience through exceptional food,
                warm service, and a peaceful atmosphere inspired by Japanese culture.
            </p>
        </div>

        <div class="card-box">
            <h3>Our Vision</h3>
            <p>
                To become one of the most trusted and loved Japanese restaurants,
                recognized for quality, innovation, and customer satisfaction.
            </p>
        </div>

    </div>

<section class="details-wrap">

    <h2 class="section-title">Company Information</h2>
    <p style="text-align:center; color:#666; margin-top:-15px; margin-bottom:35px;">
        Official business and restaurant details of Rajarata Sakura Restaurant.
    </p>

    <div class="detail-list">

        <div class="detail-item">
            <p>
                <i class="fas fa-user-tie"></i>
                <strong>Company Representative</strong><br>
                Loku Singamkutti Kankanamalage Hemachandra Upali
            </p>
        </div>

        <div class="detail-item">
            <p>
                <i class="fas fa-user-cog"></i>
                <strong>Manager</strong><br>
                Loku Singamkutti Kankanamalage Hemachandra Upali
            </p>
        </div>

        <!-- Company Location -->
        <div class="detail-item">
            <p>
                <i class="fas fa-city"></i>
                <strong>Company Location</strong><br>
                837-5, Nunogawa,<br>
                Chikusei Shi, Ibaraki Ken,<br>
                Japan
            </p>
        </div>

        <!-- Shop Location -->
        <div class="detail-item">
            <p>
                <i class="fas fa-store"></i>
                <strong>Shop Location</strong><br>
                110-65, Funyu,<br>
                Chikusei Shi, Ibaraki Ken,<br>
                Japan
            </p>
        </div>

        <div class="detail-item">
            <p>
                <i class="fas fa-building"></i>
                <strong>Dealer</strong><br>
                Uni Lanka Exports
            </p>
        </div>

    </div>

</section>


<!-- CONTACT -->
<section class="contact-box" id="contactus">

    <h2 class="section-title" style="color:#fff; margin-bottom:10px;">Contact Us</h2>
    <p style="text-align:center; color:rgba(255,255,255,.85); margin-bottom:30px;">
        We are always happy to hear from you. Reach us anytime.
    </p>

    <div class="contact-grid">

        <div>
            <p style="font-size:18px; margin-bottom:12px;">
                <i class="fas fa-phone-volume"></i>
                <strong>Call Us</strong>
            </p>

            <p style="margin:8px 0;">0296-48-6606</p>
            <p style="margin:8px 0;">080-1756-2569</p>
        </div>

        <div>
            <p style="font-size:18px; margin-bottom:12px;">
                <i class="fas fa-envelope"></i>
                <strong>Email Us</strong>
            </p>

            <p style="margin:8px 0; word-break:break-word;">
                rajaratasakurarestaurant@gmail.com
            </p>
        </div>

        <div>
            <p style="font-size:18px; margin-bottom:12px;">
                <i class="fas fa-clock"></i>
                <strong>Opening Hours</strong>
            </p>

            <p style="margin:8px 0;">Mon - Wed, Fri - Sun</p>
            <p style="margin:8px 0;">10:00 AM - 10:00 PM</p>
            <p style="margin:8px 0;"><strong>Closed on Thursdays</strong></p>
        </div>

    </div>

    <div class="social-links">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
    </div>

</section>

    <!-- MAP -->
    <section class="map-box">

        <h2 class="section-title" style="padding-top:30px;">Visit Our Shop</h2>

        <iframe
            src="https://www.google.com/maps?q=110-65+Funyu,+Chikusei,+Ibaraki,+Japan&output=embed"
            loading="lazy"
            allowfullscreen>
        </iframe>

    </section>

</div>

@include('layouts.footer')