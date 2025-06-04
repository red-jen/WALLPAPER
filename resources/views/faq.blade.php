@extends('layouts.app')

@section('title', 'FAQ - Frequently Asked Questions - MurArt')

@push('styles')
<style>
    .pattern-bg {
        background-image: url('{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_3.jpg') }}');
        background-size: cover;
        background-position: center;
        opacity: 0.1;
    }
    
    .diagonal-slice {
        position: absolute;
        width: 100%;
        height: 100%;
        clip-path: polygon(0 0, 100% 20%, 100% 100%, 0 80%);
    }
    
    .faq-item {
        transition: all 0.3s ease;
    }
    
    .faq-item:hover {
        transform: translateX(5px);
    }
    
    .faq-category {
        transition: all 0.3s ease;
    }
    
    .faq-category:hover .category-icon {
        transform: scale(1.1);
        color: var(--primary-color);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative py-24 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 pattern-bg"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-heading font-bold mb-6 tracking-tight text-dark">Frequently Asked Questions</h1>
            <p class="text-xl text-gray-600 mb-10">Find answers to the most common questions about our products and services</p>
        </div>
    </div>
</section>

<!-- FAQ Categories Section -->
<section class="relative py-16 overflow-hidden">
    <!-- Diagonal Background -->
    <div class="diagonal-slice bg-secondary bg-opacity-5"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-heading font-bold mb-4 text-dark">Browse by Category</h2>
                <p class="text-gray-600">Select a category to find the answers you need</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="#products" class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300 faq-category">
                    <div class="inline-flex items-center justify-center h-14 w-14 rounded-full bg-primary bg-opacity-10 mb-4">
                        <i class="fas fa-box text-primary text-xl category-icon transition-all duration-300"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-lg">Products</h3>
                </a>
                
                <a href="#ordering" class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300 faq-category">
                    <div class="inline-flex items-center justify-center h-14 w-14 rounded-full bg-primary bg-opacity-10 mb-4">
                        <i class="fas fa-shopping-cart text-primary text-xl category-icon transition-all duration-300"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-lg">Ordering</h3>
                </a>
                
                <a href="#shipping" class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300 faq-category">
                    <div class="inline-flex items-center justify-center h-14 w-14 rounded-full bg-primary bg-opacity-10 mb-4">
                        <i class="fas fa-truck text-primary text-xl category-icon transition-all duration-300"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-lg">Shipping</h3>
                </a>
                
                <a href="#installation" class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300 faq-category">
                    <div class="inline-flex items-center justify-center h-14 w-14 rounded-full bg-primary bg-opacity-10 mb-4">
                        <i class="fas fa-tools text-primary text-xl category-icon transition-all duration-300"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-lg">Installation</h3>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Products FAQ Section -->
<section id="products" class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center mb-8">
                <div class="mr-4 bg-primary bg-opacity-10 rounded-full p-3">
                    <i class="fas fa-box text-primary"></i>
                </div>
                <h2 class="text-3xl font-heading font-bold">Product Questions</h2>
            </div>
            
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq1')">
                        <span class="font-medium">What types of wallpaper materials do you offer?</span>
                        <i id="faq1Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq1Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">We offer a variety of wallpaper materials to suit different needs and preferences:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                            <li>Non-woven - Breathable, tear-resistant, and easy to install/remove</li>
                            <li>Vinyl - Durable, washable, and moisture-resistant</li>
                            <li>Paper - Traditional and environmentally friendly</li>
                            <li>Fabric-backed vinyl - Extra durability with fabric texture</li>
                            <li>Eco-friendly - Made from sustainable materials</li>
                        </ul>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq2')">
                        <span class="font-medium">How do I clean and maintain my wallpaper?</span>
                        <i id="faq2Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq2Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">Cleaning and maintenance depend on the wallpaper material:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                            <li>Non-woven and vinyl: Can be wiped with a damp cloth and mild soap</li>
                            <li>Paper: Dust with a soft, dry cloth or use a wallpaper dough cleaner</li>
                            <li>For all types: Avoid harsh chemicals and excessive moisture</li>
                            <li>Remove stains promptly to prevent setting</li>
                            <li>Protect from direct sunlight to prevent fading</li>
                        </ul>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq3')">
                        <span class="font-medium">Can I order custom-sized wallpaper?</span>
                        <i id="faq3Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq3Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">Yes! We specialize in custom wallpaper solutions. You can order wallpaper in exact dimensions for your space. Our customization options include:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                            <li>Custom dimensions to fit your specific wall measurements</li>
                            <li>Pattern scaling to match your room size</li>
                            <li>Color adjustments to complement your decor</li>
                            <li>Material selection based on your specific needs</li>
                        </ul>
                        <p class="text-gray-600 mt-2">Simply use our online design tool or contact our design team for assistance with custom orders.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq4')">
                        <span class="font-medium">Are your wallpapers eco-friendly?</span>
                        <i id="faq4Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq4Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">We are committed to environmental responsibility. Many of our wallpapers are eco-friendly and we continue to expand our sustainable options:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                            <li>PVC-free options available</li>
                            <li>FSC-certified papers from responsibly managed forests</li>
                            <li>Water-based, non-toxic inks</li>
                            <li>Low VOC emissions that meet indoor air quality standards</li>
                            <li>Recyclable and biodegradable materials in select collections</li>
                        </ul>
                        <p class="text-gray-600 mt-2">Look for our "Eco-Friendly" label when browsing our collections.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ordering FAQ Section -->
<section id="ordering" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center mb-8">
                <div class="mr-4 bg-primary bg-opacity-10 rounded-full p-3">
                    <i class="fas fa-shopping-cart text-primary"></i>
                </div>
                <h2 class="text-3xl font-heading font-bold">Ordering Questions</h2>
            </div>
            
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq5')">
                        <span class="font-medium">How do I determine how much wallpaper I need?</span>
                        <i id="faq5Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq5Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">To calculate how much wallpaper you need:</p>
                        <ol class="list-decimal list-inside mt-2 space-y-1 text-gray-600">
                            <li>Measure the height and width of each wall in feet</li>
                            <li>Multiply width by height to get square footage</li>
                            <li>Add up the square footage of all walls</li>
                            <li>Subtract for doors and windows (approximately 14 sq ft for a door, 15 sq ft for a window)</li>
                            <li>Add 10% extra for pattern matching and mistakes</li>
                        </ol>
                        <p class="text-gray-600 mt-2">For easier calculation, use our <a href="#" class="text-primary hover:underline">wallpaper calculator tool</a>.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq6')">
                        <span class="font-medium">Can I order samples before purchasing a full roll?</span>
                        <i id="faq6Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq6Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">Yes, we highly recommend ordering samples before committing to a full purchase. Our sample service includes:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                            <li>8" x 10" swatches of your chosen designs</li>
                            <li>Up to 5 samples for $15 (credited to your account if you make a full purchase)</li>
                            <li>Samples shipped within 1-2 business days</li>
                            <li>Ability to see true colors and textures in your space</li>
                            <li>Option to test adhesion on your wall surface</li>
                        </ul>
                        <p class="text-gray-600 mt-2">Order samples directly from any product page by clicking the "Order Sample" button.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq7')">
                        <span class="font-medium">What payment methods do you accept?</span>
                        <i id="faq7Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq7Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">We accept a variety of secure payment methods for your convenience:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                            <li>Credit cards (Visa, Mastercard, American Express, Discover)</li>
                            <li>PayPal</li>
                            <li>Apple Pay</li>
                            <li>Google Pay</li>
                            <li>Bank transfers (for orders over $500)</li>
                        </ul>
                        <p class="text-gray-600 mt-2">All transactions are secured with industry-standard SSL encryption for your protection.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq8')">
                        <span class="font-medium">Can I cancel or modify my order?</span>
                        <i id="faq8Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq8Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">Order modifications and cancellations are possible under certain conditions:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                            <li>Orders can be modified or cancelled within 2 hours of placement</li>
                            <li>Custom designs that haven't entered production can be modified within 24 hours</li>
                            <li>Once production begins, orders cannot be cancelled or modified</li>
                            <li>Contact our customer service immediately if you need to make changes</li>
                        </ul>
                        <p class="text-gray-600 mt-2">For fastest service, call us at 1-800-123-4567 rather than emailing for cancellations or modifications.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Shipping FAQ Section -->
<section id="shipping" class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center mb-8">
                <div class="mr-4 bg-primary bg-opacity-10 rounded-full p-3">
                    <i class="fas fa-truck text-primary"></i>
                </div>
                <h2 class="text-3xl font-heading font-bold">Shipping & Delivery</h2>
            </div>
            
            <div class="space-y-6">
                <!-- Add similar FAQ items for Shipping section -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq9')">
                        <span class="font-medium">How long will it take to receive my order?</span>
                        <i id="faq9Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq9Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">Delivery times vary based on product type and shipping method:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                            <li><strong>Standard collection wallpapers:</strong> 3-5 business days production + shipping time</li>
                            <li><strong>Custom designs:</strong> 5-10 business days production + shipping time</li>
                            <li><strong>Sample orders:</strong> Ships within 1-2 business days</li>
                            <li><strong>Standard shipping:</strong> 3-7 business days in the continental US</li>
                            <li><strong>Express shipping:</strong> 2-3 business days</li>
                        </ul>
                        <p class="text-gray-600 mt-2">You'll receive tracking information via email once your order ships.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq10')">
                        <span class="font-medium">Do you ship internationally?</span>
                        <i id="faq10Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq10Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">Yes, we ship to most countries worldwide. International shipping details:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                            <li>International shipping typically takes 7-14 business days</li>
                            <li>Duties and taxes are the responsibility of the recipient</li>
                            <li>Shipping costs are calculated based on destination and order weight</li>
                            <li>Not all products are available for international shipping</li>
                            <li>International orders cannot be expedited at this time</li>
                        </ul>
                        <p class="text-gray-600 mt-2">For specific information about shipping to your country, please contact our customer service team.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Installation FAQ Section -->
<section id="installation" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center mb-8">
                <div class="mr-4 bg-primary bg-opacity-10 rounded-full p-3">
                    <i class="fas fa-tools text-primary"></i>
                </div>
                <h2 class="text-3xl font-heading font-bold">Installation Questions</h2>
            </div>
            
            <div class="space-y-6">
                <!-- Add similar FAQ items for Installation section -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq11')">
                        <span class="font-medium">How difficult is it to install wallpaper myself?</span>
                        <i id="faq11Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq11Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">The difficulty of DIY wallpaper installation depends on several factors:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                            <li>Our peel-and-stick wallpapers are the easiest to install with no paste required</li>
                            <li>Non-woven wallpapers are also user-friendly with paste-the-wall application</li>
                            <li>Traditional papers require more skill and precision</li>
                            <li>Small rooms with few obstacles are easier for beginners</li>
                            <li>Pattern matching adds complexity to the installation process</li>
                        </ul>
                        <p class="text-gray-600 mt-2">We provide detailed installation guides with every order, and our <a href="{{ route('services') }}" class="text-primary hover:underline">Services page</a> has step-by-step instructions and video tutorials.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item">
                    <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleFaq('faq12')">
                        <span class="font-medium">Do you offer professional installation services?</span>
                        <i id="faq12Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                    </button>
                    <div id="faq12Content" class="hidden px-6 py-4">
                        <p class="text-gray-600">Yes, we can connect you with professional installers in many areas:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                            <li>We maintain a network of certified wallpaper installers</li>
                            <li>Installation services are available in most major US cities</li>
                            <li>Pricing varies based on location, room size, and complexity</li>
                            <li>Professional installation includes surface preparation</li>
                            <li>All installers are vetted for quality and reliability</li>
                        </ul>
                        <p class="text-gray-600 mt-2">To book installation services, visit our <a href="#" class="text-primary hover:underline">Find an Installer</a> page or contact our customer service team.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-heading font-bold mb-6">Still Have Questions?</h2>
            <p class="text-gray-600 mb-8">We're here to help! Contact our customer support team and we'll get back to you as soon as possible.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ route('contact') }}" class="bg-primary hover:bg-opacity-90 text-white py-3 px-8 rounded-md font-heading font-medium text-center transition duration-300">Contact Us</a>
                <a href="tel:1-800-123-4567" class="bg-secondary hover:bg-opacity-90 text-white py-3 px-8 rounded-md font-heading font-medium text-center transition duration-300">Call 1-800-123-4567</a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function toggleFaq(id) {
        const content = document.getElementById(id + 'Content');
        const icon = document.getElementById(id + 'Icon');
        
        // Close all FAQs
        document.querySelectorAll('[id$="Content"]').forEach(el => {
            if (el.id !== id + 'Content') el.classList.add('hidden');
        });
        document.querySelectorAll('[id$="Icon"]').forEach(el => {
            if (el.id !== id + 'Icon') el.classList.remove('rotate-180');
        });
        
        // Toggle current FAQ
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>
@endpush
@endsection
