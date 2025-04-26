@extends('layouts.public')

@section('title', 'Contact Us')

@push('styles')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<style>
    .bg-navy { background-color: #0F3057; }
    .bg-sage { background-color: #8DAA9D; }
    .bg-gold { background-color: #D4B483; }
    .focus-navy:focus { border-color: #0F3057; }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="bg-navy py-16 text-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center text-center">
                <h1 class="text-5xl font-bold mb-6 font-heading">Contact Us</h1>
                <p class="text-xl mb-10 max-w-3xl">Have questions or need assistance? We're here to help with all your wallpaper and design needs.</p>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-3xl font-bold font-heading mb-6 text-navy">Get in Touch</h2>
                        <p class="text-lg mb-8">We'd love to hear from you. Whether you have a question about our products, need design advice, or want to discuss a custom project, our team is ready to assist.</p>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="mr-4 bg-sage bg-opacity-20 p-3 rounded-full">
                                    <svg class="h-6 w-6 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold mb-1">Address</h3>
                                    <p>123 Design Street<br>Art District, NYC 10001<br>United States</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="mr-4 bg-sage bg-opacity-20 p-3 rounded-full">
                                    <svg class="h-6 w-6 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold mb-1">Email</h3>
                                    <p><a href="mailto:info@murart.com" class="text-navy hover:underline">info@murart.com</a></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="mr-4 bg-sage bg-opacity-20 p-3 rounded-full">
                                    <svg class="h-6 w-6 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold mb-1">Phone</h3>
                                    <p><a href="tel:+12125551234" class="text-navy hover:underline">+1 (212) 555-1234</a></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="mr-4 bg-sage bg-opacity-20 p-3 rounded-full">
                                    <svg class="h-6 w-6 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold mb-1">Business Hours</h3>
                                    <p>Monday - Friday: 9am - 6pm<br>Saturday: 10am - 4pm<br>Sunday: Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Form -->
                    <div class="bg-white p-8 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold mb-6">Send Us a Message</h2>
                        <form class="space-y-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-navy" placeholder="John Doe" required>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-navy" placeholder="your@email.com" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-navy" placeholder="How can we help?">
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea id="message" name="message" rows="5" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-navy" placeholder="Your message here..." required></textarea>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" id="newsletter" name="newsletter" class="h-4 w-4 text-navy focus:ring-navy border-gray-300 rounded">
                                <label for="newsletter" class="ml-2 block text-sm text-gray-700">Subscribe to our newsletter for updates and special offers</label>
                            </div>
                            
                            <button type="submit" class="w-full bg-navy hover:bg-opacity-90 text-white font-bold py-3 px-6 rounded transition duration-300">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-16 bg-sage bg-opacity-10">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-2xl font-bold mb-6 text-center">Visit Our Showroom</h2>
                <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                    <!-- Replace with actual map embed -->
                    <div class="text-gray-600">
                        <p class="text-lg">Interactive map would be displayed here</p>
                        <p class="text-sm mt-2">123 Design Street, Art District, NYC 10001</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold font-heading mb-8 text-center">Frequently Asked Questions</h2>
                
                <div class="space-y-6">
                    <div class="border-b pb-4">
                        <h3 class="text-xl font-bold mb-2 text-navy">How do I place an order?</h3>
                        <p>You can place an order directly through our website by selecting your desired product, customizing options if available, and proceeding to checkout. If you need assistance, feel free to contact our customer service team.</p>
                    </div>
                    
                    <div class="border-b pb-4">
                        <h3 class="text-xl font-bold mb-2 text-navy">What payment methods do you accept?</h3>
                        <p>We accept all major credit cards, PayPal, and bank transfers for orders. For custom projects, we may require a deposit before beginning work.</p>
                    </div>
                    
                    <div class="border-b pb-4">
                        <h3 class="text-xl font-bold mb-2 text-navy">How long does shipping take?</h3>
                        <p>Standard shipping typically takes 3-5 business days within the continental US. International shipping times vary by location. Express shipping options are available at checkout.</p>
                    </div>
                    
                    <div class="border-b pb-4">
                        <h3 class="text-xl font-bold mb-2 text-navy">Do you offer custom designs?</h3>
                        <p>Yes! We collaborate with our customers to create custom wallpaper designs. Contact us with your ideas and requirements, and our design team will work with you to bring your vision to life.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 