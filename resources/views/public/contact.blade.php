@extends('layouts.app')

@section('title', 'Contact Us - MurArt')

@push('styles')
<style>
    .diagonal-slice {
        position: absolute;
        width: 100%;
        height: 100%;
        clip-path: polygon(0 0, 100% 20%, 100% 100%, 0 80%);
    }
    
    .pattern-bg {
        background-image: url('{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_3.jpg') }}');
        background-size: cover;
        background-position: center;
        opacity: 0.1;
    }
    
    .contact-card {
        transition: all 0.3s ease;
    }
    
    .contact-card:hover {
        transform: translateY(-5px);
    }
    
    .contact-icon {
        transition: all 0.3s ease;
    }
    
    .contact-card:hover .contact-icon {
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
            <h1 class="text-5xl md:text-6xl font-heading font-bold mb-6 tracking-tight text-dark">Contact Us</h1>
            <p class="text-xl text-gray-600 mb-10">Have questions or need assistance? We're here to help with all your wallpaper and design needs.</p>
        </div>
    </div>
</section>

<!-- Contact Cards Section -->
<section class="relative py-16 overflow-hidden bg-secondary bg-opacity-5">
    <!-- Diagonal Background -->
    <div class="diagonal-slice bg-white"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Email Card -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center contact-card">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary bg-opacity-10 mb-6">
                        <i class="fas fa-envelope text-primary text-2xl contact-icon"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold mb-2">Email Us</h3>
                    <p class="text-gray-600 mb-4">For any inquiries or support</p>
                    <a href="mailto:contact@murart.com" class="text-primary font-medium hover:underline">contact@murart.com</a>
                </div>
                
                <!-- Call Card -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center contact-card">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary bg-opacity-10 mb-6">
                        <i class="fas fa-phone-alt text-primary text-2xl contact-icon"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold mb-2">Call Us</h3>
                    <p class="text-gray-600 mb-4">Mon-Fri: 9am-6pm | Sat: 10am-4pm</p>
                    <a href="tel:+33123456789" class="text-primary font-medium hover:underline">+33 1 23 45 67 89</a>
                </div>
                
                <!-- Visit Card -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center contact-card">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary bg-opacity-10 mb-6">
                        <i class="fas fa-map-marker-alt text-primary text-2xl contact-icon"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold mb-2">Visit Us</h3>
                    <p class="text-gray-600 mb-4">Our showroom is open to the public</p>
                    <p class="text-gray-800">123 Creation Street,<br>75001 Paris, France</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Left Column: Get in Touch -->
                <div>
                    <h2 class="text-3xl font-heading font-bold mb-6 text-dark">Get in Touch</h2>
                    <p class="text-lg text-gray-600 mb-8">We'd love to hear from you. Whether you have a question about our products, need design advice, or want to discuss a custom project, our team is ready to assist.</p>
                    
                    <div class="space-y-6">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="font-heading font-bold text-xl mb-4">Follow Us</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-400 hover:text-primary transition bg-gray-100 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-primary transition bg-gray-100 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-primary transition bg-gray-100 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="fab fa-pinterest-p"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-primary transition bg-gray-100 w-10 h-10 rounded-full flex items-center justify-center">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="font-heading font-bold text-xl mb-4">Customer Support Hours</h3>
                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <i class="fas fa-clock mr-3 text-primary"></i>
                                    <span>Monday - Friday: 9:00 AM - 6:00 PM</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-clock mr-3 text-primary"></i>
                                    <span>Saturday: 10:00 AM - 4:00 PM</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-clock mr-3 text-primary"></i>
                                    <span>Sunday: Closed</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Contact Form -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-heading font-bold mb-6">Send Us a Message</h2>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form action="" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" id="name" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" id="email" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                value="{{ old('email') }}">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" name="subject" id="subject" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                value="{{ old('subject') }}">
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea name="message" id="message" rows="5" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full bg-primary hover:bg-opacity-90 text-white py-3 px-4 rounded-md font-medium transition duration-300">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-3xl font-heading font-bold mb-8 text-dark text-center">Visit Our Showroom</h2>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="h-96 bg-gray-200">
                    <!-- Replace with actual map embed -->
                    <div class="w-full h-full flex items-center justify-center text-gray-500">
                        <div class="text-center">
                            <i class="fas fa-map-marked-alt text-4xl mb-4"></i>
                            <p class="text-lg">Interactive map would be displayed here</p>
                            <p class="text-sm mt-2">123 Creation Street, 75001 Paris, France</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Preview Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-heading font-bold mb-8 text-dark text-center">Frequently Asked Questions</h2>
            
            <div class="space-y-4 mb-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b">
                        <h3 class="text-xl font-heading font-bold text-gray-800">How do I place an order?</h3>
                        <p class="mt-2 text-gray-600">You can place an order directly through our website by selecting your desired product, customizing options if available, and proceeding to checkout. If you need assistance, feel free to contact our customer service team.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b">
                        <h3 class="text-xl font-heading font-bold text-gray-800">What payment methods do you accept?</h3>
                        <p class="mt-2 text-gray-600">We accept all major credit cards, PayPal, and bank transfers for orders. For custom projects, we may require a deposit before beginning work.</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-heading font-bold text-gray-800">How long does shipping take?</h3>
                        <p class="mt-2 text-gray-600">Standard shipping typically takes 5-7 business days within Europe, and 7-14 business days for international orders. Custom orders may require additional production time.</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="{{ route('faq') }}" class="inline-flex items-center text-primary hover:text-primary-dark font-medium transition">
                    View All FAQs <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection