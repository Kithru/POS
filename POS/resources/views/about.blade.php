
@include('layouts.headernavi')

<link href="{{ asset('css/footer.css') }}" rel="stylesheet">
<link href="{{ asset('css/header.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
    /* ---------------- About Page Styling ---------------- */

#receipt-content {
    max-width: 900px;
    margin: 50px auto; /* space from top */
    padding: 40px 20px;
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #444;
    text-align: center;
}

#receipt-content h1 {
    color: #2e1a26; /* Dark plum */
    font-size: 32px;
    margin-bottom: 20px;
}

#receipt-content p {
    font-size: 16px;
    line-height: 1.8;
    margin-bottom: 20px;
}

#receipt-content img {
    width: 100%;
    max-width: 800px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    margin: 30px 0;
}

/* Mission & Vision Section */
#receipt-content .mission-vision {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    gap: 30px;
    margin-top: 40px;
    text-align: left;
}

#receipt-content .mission-vision div {
    flex: 1 1 300px;
}

#receipt-content .mission-vision h3 {
    color: #f3c1d8; /* Sakura pink */
    margin-bottom: 10px;
}

#receipt-content .mission-vision p {
    color: #444;
}

/* Social Media Section */
#receipt-content .social-icons {
    margin-top: 40px;
    text-align: center;
}

#receipt-content .social-icons a {
    color: #f3c1d8;
    margin: 0 10px;
    font-size: 28px;
    transition: 0.3s;
}

#receipt-content .social-icons a:hover {
    color: #7a0f5c; /* Wine purple */
    transform: scale(1.2);
}

/* ---------------- Responsive ---------------- */
@media(max-width:768px) {
    #receipt-content {
        padding: 30px 15px;
    }

    #receipt-content .mission-vision {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }

    #receipt-content .mission-vision div {
        flex: 1 1 auto;
    }
}
</style>

<div class="receipt-container" id="receipt-content" style="padding: 50px 20px; max-width: 900px; margin: auto; text-align: center;">

    <h1 style="color: #2e1a26; margin-bottom: 20px;">About Rajarata Sakura Restaurant</h1>
    
    <p style="font-size: 16px; line-height: 1.8; color: #444;">
        Welcome to <strong>Rajarata Sakura</strong>, your premier destination for authentic Japanese cuisine in Sri Lanka.
        We are passionate about serving fresh, high-quality dishes prepared with care and tradition.
    </p>

    <p style="font-size: 16px; line-height: 1.8; color: #444;">
        Since our founding in 2015, we have strived to bring the flavors of Japan to every table,
        blending traditional recipes with a modern dining experience. Our chefs are trained in
        the art of sushi, ramen, and other Japanese delicacies to ensure every bite delights.
    </p>

    <!-- Image Section -->
    <div style="margin: 30px 0;">
        <img src="{{ asset('images/about.jpg') }}" 
             alt="Rajarata Sakura Restaurant" 
             style="width: 100%; max-width: 800px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.2);">
    </div>

    <!-- Mission & Vision -->
    <div style="display: flex; flex-wrap: wrap; justify-content: space-around; gap: 30px; margin-top: 40px; text-align: left;">
        <div style="flex: 1 1 300px;">
            <h3 style="color: #aa2b66;">Our Mission</h3>
            <p style="color: #444;">To deliver an authentic Japanese dining experience with fresh ingredients, friendly service, and a welcoming ambiance.</p>
        </div>
        <div style="flex: 1 1 300px;">
            <h3 style="color: #aa2b66;">Our Vision</h3>
            <p style="color: #444;">To be recognized as the leading Japanese restaurant in the region, celebrated for quality, innovation, and customer satisfaction.</p>
        </div>
    </div>

        <!-- Address Section -->
    <div style="margin-top: 50px; text-align: center;">
        <h2 style="color: #aa2b66; margin-bottom: 20px;">Our Address</h2>
        <div style="display: inline-block; background: #fff0f5; padding: 25px 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); max-width: 500px;">
            <p style="font-size: 16px; color: #444; margin: 10px 0;">
                <i class="fas fa-map-marker-alt" style="color: #aa2b66; margin-right: 10px;"></i>
                110-65, 
                FUNYU, 
                CHIKUSEI SHI, 
                IBARAKI KEN, 
                JAPAN.
            </p>
        </div>
    </div>

    <!-- Contact Section -->
    <div style="margin-top: 40px; text-align: center;">
        <h2 style="color: #aa2b66; margin-bottom: 20px;">Contact Us</h2>
        <div style="display: inline-block; background: #fff0f5; padding: 25px 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); max-width: 500px;">
            <p style="font-size: 16px; color: #444; margin: 10px 0;">
                <i class="fas fa-phone-volume" style="color: #aa2b66; margin-right: 10px;"></i>
                Hot Line: +81 80-1756-2569
            </p>

            <!-- Landline -->
            <p style="font-size: 16px; color: #444; margin: 10px 0;">
                <i class="fas fa-phone" style="color: #aa2b66; margin-right: 10px;"></i>
                TEL: 0296 48 6606
            </p>
            <p style="font-size: 16px; color: #444; margin: 10px 0;">
                <i class="fas fa-envelope" style="color: #aa2b66; margin-right: 10px;"></i>
                rajaratasakura@gmail.com
            </p>
            <p style="font-size: 16px; color: #444; margin: 10px 0;">
                <i class="fas fa-clock" style="color: #aa2b66; margin-right: 10px;"></i>
                Mon-Wed, Fri-Sun: 10:00 AM - 10:00 PM <br>
                <strong>Closed on Thursdays</strong>
            </p>
        </div>
    </div>

    <!-- Location Map Section -->
    <div style="margin-top: 40px; text-align: center;">
        <h2 style="color: #aa2b66; margin-bottom: 20px;">Find Us Here</h2>
        <iframe 
            src="https://www.google.com/maps?q=Sakura+Sri+Lanka+restaurant,+110-65+Funyu,+Chikusei,+Ibaraki+308-0111&output=embed" 
            width="100%" 
            height="400" 
            style="border:0; border-radius:15px;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>


    <!-- Social Media -->
    <div style="margin-top: 40px;">
        <h3 style="color: #2e1a26;">Follow Us</h3>
        <div style="margin-top: 15px;">
            <a href="#" style="color:#aa2b66; margin:0 10px; font-size: 24px;"><i class="fab fa-facebook-f"></i></a>
            <a href="#" style="color:#aa2b66; margin:0 10px; font-size: 24px;"><i class="fab fa-instagram"></i></a>
            <a href="#" style="color:#aa2b66; margin:0 10px; font-size: 24px;"><i class="fab fa-youtube"></i></a>
        </div>
    </div>

</div>

@include('layouts.footer')

