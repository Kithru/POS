<footer class="footer">

    <div class="footer-container">

        <div class="footer-col">
            <h3>Info</h3>
            <p><a href="{{ route('home') }}" class="footer-link">Home</a></p>
            <p><a href="{{ route('about') }}" class="footer-link">About Us</a></p>
        </div>

        <div class="footer-col">
            <h3>Quick Links</h3>
            @if(isset($categories) && $categories->count() > 0)
                <div class="footer-category-list">
                    @foreach($categories as $category)
                        @if($category->category_id)
                            <a class="footer-link" href="{{ route('items.byCategory', $category->category_id) }}">
                                {{ $category->category_name }}
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <div class="footer-col">
            <h3>Keep in touch</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <p class="footer-contact">Hot Line: +8180-1756-2569</p>
            <p class="footer-contact">TEL: 0296 48 6606</p>
        </div>

    </div>

    <div class="footer-bottom">
        © 2026 Rajarata Sakura Restaurant. All rights reserved | Concept Designed and Developed by KV
    </div>

</footer>