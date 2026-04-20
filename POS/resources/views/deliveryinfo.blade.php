@include('layouts.headernavi')

<link href="{{ asset('css/footer.css') }}" rel="stylesheet">
<link href="{{ asset('css/header.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
body{
    background: linear-gradient(135deg,#fff7fb,#fffaf5);
}

.page-wrapper{
    max-width: 1200px;
    margin: 50px auto;
    padding: 0 20px;
}

/* Navigation Tabs */
.sub-nav{
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:10px;
    margin-bottom:30px;
}

.sub-nav a{
    padding:10px 18px;
    background:#fff;
    border-radius:30px;
    text-decoration:none;
    color:#8d1558;
    font-weight:600;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    transition:.3s;
}

.sub-nav a:hover{
    background:#8d1558;
    color:#fff;
}

/* Sections */
.section-box{
    background:#fff;
    padding:40px;
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

.section-title{
    font-size:28px;
    margin-bottom:20px;
    color:#2e1a26;
    font-weight:800;
}

/* Highlight box */
.note{
    background:#fff7fb;
    border-left:5px solid #b61e72;
    padding:15px;
    margin:15px 0;
    border-radius:10px;
}

/* Refund box */
.refund-box{
    background:#fff3f3;
    border-left:5px solid #e74c3c;
    padding:15px;
    border-radius:10px;
}
</style>

<div class="page-wrapper">

    <!-- NAVIGATION -->
    <div class="sub-nav">
        <a href="#delivery">Delivery Information</a>
        <a href="#terms">Terms & Conditions</a>
        <a href="#refund">Refund Policy</a>
    </div>

    <!-- DELIVERY -->
    <section id="delivery" class="section-box">
        <div class="section-title">Delivery Information</div>

        <p><strong>Free Shipping Service (Japan Only)</strong></p>

        <div class="note">
            ⚠ Okinawa, Hokkaido, and Kyushu regions are excluded from free shipping
        </div>

        <ul>
            <li>¥15,000+ order → Free shipping up to 20kg (1 box)</li>
            <li>20kg – 30kg → ¥499 extra charge</li>
            <li>30kg – 40kg → ¥999 extra charge</li>
            <li>Above 40kg → ¥2000 extra charge</li>
        </ul>

        <p><strong>Delivery Time</strong></p>
        <ul>
            <li>Orders before 1:00 PM → Next day delivery</li>
            <li>Orders after 1:00 PM → Delivery in 2 days</li>
        </ul>

        <p>Tracking number will be sent to your registered email.</p>

        <p><strong>Frozen & Fresh Items</strong></p>
        <p>Orders can be placed via WhatsApp. Delivery is handled separately to ensure freshness.</p>
    </section>

    <!-- TERMS -->
    <section id="terms" class="section-box">
        <div class="section-title">Terms & Conditions</div>

        <p><strong>Product Terms</strong></p>
        <p>
            By using this website, you agree to all terms stated here. If you do not agree, please do not use the service.
        </p>

        <p><strong>Amendments</strong></p>
        <p>
            Terms may be updated anytime without prior notice.
        </p>

        <p><strong>Delivery Partner</strong></p>
        <p>
            We use Yamato Transport for delivery services.
        </p>
    </section>

    <!-- REFUND -->
    <section id="refund" class="section-box">
        <div class="section-title">Refund Policy</div>

        <div class="refund-box">
            Refunds are only applicable if:
            <ul>
                <li>Wrong product delivered</li>
                <li>Damaged product on arrival</li>
                <li>Missing items in order</li>
            </ul>
        </div>

        <p>
            Refund requests must be submitted within 24 hours of delivery.
            Approval will depend on verification.
        </p>

        <p>
            Fresh and frozen items are non-refundable unless damaged during transport.
        </p>
    </section>

</div>

@include('layouts.footer')