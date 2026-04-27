@include('layouts.headernavi')

<link href="{{ asset('css/footer.css') }}" rel="stylesheet">
<link href="{{ asset('css/header.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
body{
    background: linear-gradient(135deg,#fff7fb,#fffaf5);
    line-height: 1.35;
    color: #333;
}

/* PAGE WRAPPER */
.page-wrapper{
    max-width: 1200px;
    margin: 60px auto;
    padding: 0 20px;
}

/* NAVIGATION */
.sub-nav{
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:12px;
    margin-bottom:40px;
}

.sub-nav a{
    padding:12px 20px;
    background:#fff;
    border-radius:30px;
    text-decoration:none;
    color:#8d1558;
    font-weight:600;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    transition:.3s ease;
}

.sub-nav a:hover{
    background:#8d1558;
    color:#fff;
    transform: translateY(-2px);
}

/* SECTIONS */
.section-box{
    background:#fff;
    padding:45px;
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
    margin-bottom:40px;
}

/* TITLE */
.section-title{
    font-size:30px;
    margin-bottom:25px;
    color:#2e1a26;
    font-weight:800;
}

/* TEXT */
.section-box p{
    margin-bottom:10px;
    font-size:15.5px;
}

/* LIST STYLE */
.section-box ul{
    padding-left: 20px;
    margin-top: 10px;
    margin-bottom: 20px;
}

.section-box li{
    margin-bottom:12px;
    padding-left:5px;
}

/* BOX STYLES */
.note{
    background:#fff7fb;
    border-left:5px solid #b61e72;
    padding:18px;
    margin:20px 0;
    border-radius:10px;
}

.refund-box{
    background:#fff3f3;
    border-left:5px solid #e74c3c;
    padding:18px;
    margin:20px 0;
    border-radius:10px;
}

.info-box{
    background:#f7f9ff;
    border-left:5px solid #3f51b5;
    padding:18px;
    margin:20px 0;
    border-radius:10px;
}

/* STRONG TEXT */
.section-box strong{
    font-size:16px;
    color:#222;
}

/* SMALL TEXT */
small{
    color:#777;
}
</style>

<div class="page-wrapper">

    <!-- NAVIGATION -->
    <div class="sub-nav">
        <a href="#payment">Payment & Fees</a>
        <a href="#delivery">Delivery</a>
        <a href="#shipping">Shipping Fees</a>
        <a href="#terms">Terms</a>
        <a href="#refund">Refund</a>
        <a href="#license">Compliance</a>
    </div>

    <!-- PAYMENT -->
    <section id="payment" class="section-box">
        <div class="section-title">Payment Methods & Fees / お支払い方法・手数料</div>

        <p><strong>Available Payment Methods / お支払い方法</strong></p>
        <ul>
            <li>Bank Transfer / 銀行振込</li>
            <li>Cash on Delivery (COD) / 代金引換</li>
            <li>Convenience Store Prepayment / コンビニ前払い</li>
        </ul>

        <p><strong>Additional Charges / 追加手数料</strong></p>
        <ul>
            <li>Convenience Store Fee: ¥220 / コンビニ手数料：220円</li>
            <li>Cash on Delivery Fee: ¥330 / 代引き手数料：330円</li>
            <li>Bank Transfer Fee: Free / 銀行振込手数料：無料</li>
            <li>Consumption Tax: 8% (not included) / 消費税：8%（商品価格に含まれません）</li>
        </ul>

        <p><strong>Payment Deadline / 支払い期限</strong></p>
        <ul>
            <li>Within 3 days after order / ご注文から3日以内</li>
        </ul>
    </section>

    <!-- DELIVERY -->
    <section id="delivery" class="section-box">
        <div class="section-title">Delivery Information / 配送情報</div>

        <p><strong>Order Processing Time / 発送処理時間</strong></p>
        <ul>
            <li>Orders confirmed → Shipped within 1 business day / 注文確定後1営業日以内に発送</li>
            <li>Before 1:00 PM → Next day delivery / 13:00までの注文 → 翌日配送</li>
            <li>After 1:00 PM → Shipping within 1–2 business days / 13:00以降 → 1〜2営業日以内に発送</li>
        </ul>

        <div class="note">
            Tracking number will be sent by email after dispatch. / 発送後、追跡番号をメールでお送りします。
        </div>

        <p><strong>Delivery Partner / 配送業者</strong></p>
        <p>
            All deliveries are handled by Yamato Transport.  
            / 配送はヤマト運輸が担当します。
        </p>
    </section>

    <!-- SHIPPING -->
    <section id="shipping" class="section-box">
        <div class="section-title">Shipping Fees / 配送料</div>
        <div class="info-box">
            <strong>Standard Shipping Rates / 標準送料</strong>
        </div>
        <ul>
            <li>1–10kg → ¥330 / 1〜10kg → 330円</li>
            <li>10–20kg → ¥1,499 / 10〜20kg → 1,499円</li>
            <li>20–30kg → ¥1,999 / 20〜30kg → 1,999円</li>
        </ul>
        <p>
            <small>
                *Final shipping cost may vary depending on region and product category.  
                / 地域や商品カテゴリにより送料は異なる場合があります。
            </small>
        </p>
    </section>

    <!-- TERMS -->
    <section id="terms" class="section-box">
        <div class="section-title">Terms & Conditions / 利用規約</div>
        <p>
            By using this website, you agree to all stated terms and conditions.  
            / 本ウェブサイトをご利用いただくことで、以下の利用規約に同意したものとみなされます。
        </p>
        <p>
            Please read carefully before placing an order.  
            / ご注文前に必ず内容をご確認ください。
        </p>
        <p>
            We reserve the right to update these terms at any time without prior notice.  
            / 規約は予告なく変更される場合があります。
        </p>
    </section>

    <!-- REFUND -->
    <section id="refund" class="section-box">
        <div class="section-title">Refund Policy / 返金ポリシー</div>

        <div class="refund-box">
            Refunds are only applicable under the following conditions:  
            / 返金は以下の場合のみ適用されます：
            <ul>
                <li>Wrong item delivered / 誤った商品が配送された場合</li>
                <li>Damaged goods upon arrival / 商品が破損していた場合</li>
                <li>Missing items in order / 商品の不足があった場合</li>
            </ul>
        </div>

        <p>
            Shipping costs for defective products will be borne by the store.  
            / 商品不良時の送料負担は、店舗負担で対応いたします
        </p>
        <p>
            Refund requests must be submitted within 24 hours after delivery.  
            / 返金申請は配達後24時間以内にご連絡ください。
        </p>
        <p>
            All requests are subject to verification and approval.  
            / すべての申請は確認および承認の対象となります。
        </p>
        <p>
            Fresh and frozen items are non-refundable unless damaged during delivery.  
            / 生鮮食品・冷凍食品は配送時の破損を除き返金不可です。
        </p>
    </section>

    <!-- COMPLIANCE -->
    <section id="license" class="section-box">
        <div class="section-title">Business Compliance & Licenses / 法令遵守・許可証</div>

        <p><strong>Licenses & Certifications / 許可・認証</strong></p>
        <ul>
            <li>Restaurant Food Handling Permit / 飲食店営業許可</li>
            <li>Supermarket Operation License / スーパーマーケット営業許可</li>
            <li>Food Distribution Certification / 食品流通認証</li>
        </ul>

        <p><strong>Distributor Responsibility / 配送責任</strong></p>
        <p>
            We work with certified logistics partners to ensure safe, legal, and hygienic food distribution.  
            / 認可された物流パートナーと連携し、安全・合法・衛生的な食品配送を行っています。
        </p>
    </section>

</div>

@include('layouts.footer')