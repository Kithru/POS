<footer class="footer">

    <div class="footer-container">

        <div class="footer-col">
            <h3>Info</h3>
            <p><a href="#" class="footer-link">Contact Us</a></p>
            <p><a href="#" class="footer-link">About Us</a></p>
            <p><a href="#" class="footer-link">Site Map</a></p>
        </div>

        <div class="footer-col">
            <h3>Quick Links</h3>

            @if(isset($categories) && $categories->count() > 0)
                <ul class="footer-category-list">
                    @foreach($categories as $category)
                        @if($category->category_id) {{-- Safety check --}}
                                <a class="footer-link" style="margin-bottom: 5px;" href="{{ route('items.byCategory', $category->category_id) }}">
                                    {{ $category->category_name }}
                                </a>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="footer-col">
            <h3>Keep in touch</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
        © 2026 Rajarata Sakura. All rights reserved | Concept Designed and Developed by KV
    </div>

</footer>