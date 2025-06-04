<!-- Footer Component -->
<footer class="bg-dark text-white pt-12 pb-6 mt-auto">
    <div class="container mx-auto px-4">
        <!-- Footer Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
            <!-- Brand Info -->
            <div>
                <div class="mb-6">
                    <img src="{{ asset('imgs/logo.png') }}" alt="MurArt Logo" class="h-16 mb-4 rounded bg-white p-1">
                    <p class="text-gray-400">Connecting designers and decoration enthusiasts to create unique and customized wallpapers.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-primary transition bg-gray-800 w-9 h-9 rounded-full flex items-center justify-center">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition bg-gray-800 w-9 h-9 rounded-full flex items-center justify-center">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition bg-gray-800 w-9 h-9 rounded-full flex items-center justify-center">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition bg-gray-800 w-9 h-9 rounded-full flex items-center justify-center">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="font-heading font-medium text-lg mb-5 border-b border-gray-700 pb-2">Quick Links</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('designs.index') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Designs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('artworks.create') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Create Wallpaper
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Become a Designer
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Information -->
            <div>
                <h3 class="font-heading font-medium text-lg mb-5 border-b border-gray-700 pb-2">Information</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('faq') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>FAQ
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Shipping
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('returns') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Returns
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Terms & Conditions
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Contact Information -->
            <div>
                <h3 class="font-heading font-medium text-lg mb-5 border-b border-gray-700 pb-2">Contact Us</h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i>
                        <span class="text-gray-400">123 Creation Street, 75001 Paris, France</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt mr-3 text-primary"></i>
                        <span class="text-gray-400">+33 1 23 45 67 89</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3 text-primary"></i>
                        <span class="text-gray-400">contact@murart.com</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-clock mr-3 text-primary"></i>
                        <span class="text-gray-400">Mon-Fri: 9am-6pm | Sat: 10am-4pm</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Newsletter Subscription -->
        <div class="bg-gray-800 rounded-lg p-6 mb-10">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    <h3 class="text-xl font-heading font-medium mb-2">Stay Informed</h3>
                    <p class="text-gray-400">Receive our latest collections and exclusive offers</p>
                </div>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="w-full md:w-1/2 flex">
                    @csrf
                    <input type="email" name="email" placeholder="Your email address" required class="flex-grow py-3 px-4 rounded-l-md focus:outline-none text-dark">
                    <button type="submit" class="bg-primary hover:bg-opacity-90 py-3 px-6 rounded-r-md font-heading font-medium transition">Subscribe</button>
                </form>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="border-t border-gray-800 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">&copy; {{ date('Y') }} MurArt. All rights reserved.</p>
                <div class="flex space-x-6">
                    <img src="{{ asset('images/payment/visa.png') }}" alt="Visa" class="h-8">
                    <img src="{{ asset('images/payment/mastercard.png') }}" alt="Mastercard" class="h-8">
                    <img src="{{ asset('images/payment/paypal.png') }}" alt="PayPal" class="h-8">
                    <img src="{{ asset('images/payment/applepay.png') }}" alt="Apple Pay" class="h-8">
                </div>
            </div>
        </div>
    </div>
</footer>