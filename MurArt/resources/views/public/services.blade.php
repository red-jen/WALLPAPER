@extends('layouts.app')

@section('title', 'Our Services - MurArt')

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
    
    .grid-pattern {
        background-image: url('{{ asset('storage/wallpapers/1745908565_cafe-wallpaper_1.jpg') }}');
        background-size: 400px;
        opacity: 0.05;
    }
    
    .floating-card {
        transition: all 0.3s ease;
    }
    
    .floating-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .service-icon {
        transition: all 0.3s ease;
    }
    
    .floating-card:hover .service-icon {
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
            <h1 class="text-5xl md:text-6xl font-heading font-bold mb-6 tracking-tight text-dark">Our Services</h1>
            <p class="text-xl text-gray-600 mb-10">From selection to installation, we're here to help you transform your space with our premium wallpaper solutions</p>
        </div>
    </div>
</section>

<!-- Overview Section with Diagonal Background -->
<section class="relative py-20 overflow-hidden">
    <!-- Diagonal Background -->
    <div class="diagonal-slice bg-secondary bg-opacity-5"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-xl p-8 mb-12">
                <h2 class="text-3xl font-heading font-bold mb-4 text-dark">How to Use Our Wallpapers</h2>
                <p class="text-lg text-gray-600 mb-6">At MurArt, we believe that the right wallpaper can completely transform a room. Our wallpapers are designed to be both beautiful and practical, making them perfect for any space in your home or office.</p>
                <p class="text-gray-600">Below, you'll find comprehensive guides on how to select, install, and care for your MurArt wallpapers.</p>
            </div>
        </div>
    </div>
</section>

<!-- Selection Guide Section -->
<section class="relative py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-primary px-6 py-4">
                    <h3 class="text-2xl font-heading font-bold text-white">Step 1: Selecting the Perfect Wallpaper</h3>
                </div>
                
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-xl font-heading font-semibold mb-4 text-gray-800">Consider Your Space</h4>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-check text-green-600 text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Room Purpose:</span> Different rooms have different vibes. Choose patterns that match the mood you want to create.
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-check text-green-600 text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Lighting:</span> Consider how much natural light the room receives. Darker patterns work well in well-lit spaces, while lighter patterns can brighten darker rooms.
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-check text-green-600 text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Room Size:</span> Large patterns can make small rooms feel smaller, while small patterns can make large rooms feel busy.
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-check text-green-600 text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Existing Décor:</span> Choose wallpapers that complement your existing furniture and accessories.
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="text-xl font-heading font-semibold mb-4 text-gray-800">Browse Our Collections</h4>
                            <p class="mb-4">Our wallpapers are organized into categories to help you find the perfect match:</p>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-paint-brush text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Artistic:</span> Unique designs created by our talented artists
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-leaf text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Nature-Inspired:</span> Botanical and landscape patterns
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-building text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Modern & Minimalist:</span> Clean lines and contemporary patterns
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-palette text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Vintage & Retro:</span> Classic designs with a nostalgic feel
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-child text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Kids & Playful:</span> Fun patterns perfect for children's rooms
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mt-8 rounded-r">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-blue-700"><span class="font-medium">Pro Tip:</span> Order a sample before making your final decision. This allows you to see how the wallpaper looks in your space with your lighting.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Installation Guide Section -->
<section class="relative py-16 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 grid-pattern"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-primary px-6 py-4">
                    <h3 class="text-2xl font-heading font-bold text-white">Step 2: Installation Guide</h3>
                </div>
                
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h4 class="text-xl font-heading font-semibold mb-4 text-gray-800">Preparation</h4>
                            <ol class="space-y-3 list-decimal list-inside">
                                <li class="text-gray-700">Remove all furniture from the room or cover it with drop cloths.</li>
                                <li class="text-gray-700">Clean the walls thoroughly with a mild detergent and water. Allow to dry completely.</li>
                                <li class="text-gray-700">Fill any holes or cracks with spackling compound and sand smooth.</li>
                                <li class="text-gray-700">Apply a wallpaper primer to ensure proper adhesion.</li>
                                <li class="text-gray-700">Measure your walls and calculate how many rolls you'll need (add 10% for waste).</li>
                            </ol>
                        </div>
                        
                        <div>
                            <h4 class="text-xl font-heading font-semibold mb-4 text-gray-800">Tools You'll Need</h4>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-secondary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-tools text-secondary text-sm"></i>
                                    </span>
                                    <div>Wallpaper paste and tray</div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-secondary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-tools text-secondary text-sm"></i>
                                    </span>
                                    <div>Smoothing brush or roller</div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-secondary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-tools text-secondary text-sm"></i>
                                    </span>
                                    <div>Utility knife and extra blades</div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-secondary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-tools text-secondary text-sm"></i>
                                    </span>
                                    <div>Level and measuring tape</div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-secondary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-tools text-secondary text-sm"></i>
                                    </span>
                                    <div>Sponge and clean cloth</div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-secondary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-tools text-secondary text-sm"></i>
                                    </span>
                                    <div>Step ladder</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <h4 class="text-xl font-heading font-semibold mb-4 text-gray-800">Installation Steps</h4>
                    <div class="mb-8 space-y-4">
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleAccordion('step1')">
                                <span class="text-lg font-medium">1. Start with a Plumb Line</span>
                                <i id="step1Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                            </button>
                            <div id="step1Content" class="px-6 py-4 bg-white">
                                <p class="text-gray-600">Use a level to draw a vertical plumb line on the wall. This will be your guide to ensure the wallpaper is hung straight. Start from the most prominent corner of the room.</p>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleAccordion('step2')">
                                <span class="text-lg font-medium">2. Cut and Prepare the Wallpaper</span>
                                <i id="step2Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                            </button>
                            <div id="step2Content" class="hidden px-6 py-4 bg-white">
                                <p class="text-gray-600">Unroll the wallpaper and cut it to the appropriate length, adding a few inches at the top and bottom for trimming. If your wallpaper has a pattern, make sure to match the pattern when cutting subsequent strips.</p>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleAccordion('step3')">
                                <span class="text-lg font-medium">3. Apply Paste and Book the Paper</span>
                                <i id="step3Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                            </button>
                            <div id="step3Content" class="hidden px-6 py-4 bg-white">
                                <p class="text-gray-600">Apply wallpaper paste to the back of the strip using a roller or brush. Fold the pasted sides together (but don't crease) and let it "book" for the time specified on the wallpaper instructions (usually 5-10 minutes).</p>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleAccordion('step4')">
                                <span class="text-lg font-medium">4. Hang the Wallpaper</span>
                                <i id="step4Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                            </button>
                            <div id="step4Content" class="hidden px-6 py-4 bg-white">
                                <p class="text-gray-600">Unfold the top portion of the strip and align it with your plumb line. Smooth it onto the wall using a smoothing brush or roller, working from the center outward to remove air bubbles. Continue unrolling and smoothing as you go down.</p>
                            </div>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="flex justify-between items-center w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 focus:outline-none" onclick="toggleAccordion('step5')">
                                <span class="text-lg font-medium">5. Trim and Clean Up</span>
                                <i id="step5Icon" class="fas fa-chevron-down transform transition-transform duration-200"></i>
                            </button>
                            <div id="step5Content" class="hidden px-6 py-4 bg-white">
                                <p class="text-gray-600">Use a utility knife to trim the excess wallpaper at the top and bottom. Wipe away any excess paste with a damp sponge. Repeat the process for subsequent strips, making sure to match the pattern.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-yellow-700"><span class="font-medium">Important:</span> If you're not confident in your wallpaper installation skills, we recommend hiring a professional. Incorrect installation can lead to bubbling, peeling, and other issues.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Care and Maintenance Section -->
<section class="relative py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-primary px-6 py-4">
                    <h3 class="text-2xl font-heading font-bold text-white">Step 3: Care and Maintenance</h3>
                </div>
                
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-xl font-heading font-semibold mb-4 text-gray-800">Regular Cleaning</h4>
                            <p class="mb-4 text-gray-600">To keep your wallpaper looking beautiful for years to come, follow these cleaning guidelines:</p>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-broom text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Dust Regularly:</span> Use a soft, dry cloth or a feather duster to remove dust from your wallpaper.
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-spray-can text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Spot Clean:</span> For small stains, use a slightly damp sponge with mild soap. Always test in an inconspicuous area first.
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-wind text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Avoid Direct Sunlight:</span> Prolonged exposure to direct sunlight can cause fading. Consider using curtains or blinds.
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-temperature-high text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Control Humidity:</span> Maintain proper ventilation to prevent mold growth behind the wallpaper.
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="text-xl font-heading font-semibold mb-4 text-gray-800">Repair and Maintenance</h4>
                            <p class="mb-4 text-gray-600">Occasional maintenance can help extend the life of your wallpaper:</p>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-tools text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Fix Bubbles:</span> If small bubbles appear, use a pin to puncture them and smooth with a roller.
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-cut text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Repair Tears:</span> For small tears, carefully align the edges and apply a small amount of wallpaper paste.
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-paint-brush text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Touch Up:</span> Keep a small piece of wallpaper for future touch-ups if needed.
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 h-6 w-6 rounded-full bg-primary bg-opacity-20 flex items-center justify-center mr-3">
                                        <i class="fas fa-sync-alt text-primary text-sm"></i>
                                    </span>
                                    <div>
                                        <span class="font-medium">Replace When Needed:</span> Most wallpapers last 10-15 years with proper care. Plan for replacement when signs of wear appear.
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional Services Section -->
<section class="relative py-20 overflow-hidden">
    <!-- Diagonal Background -->
    <div class="diagonal-slice bg-secondary bg-opacity-5"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-heading font-bold mb-4 text-dark">Additional Services</h2>
            <div class="w-24 h-1 bg-primary mx-auto mb-6"></div>
            <p class="text-gray-600 max-w-3xl mx-auto">We offer a range of complementary services to ensure you get the most out of your MurArt wallpaper</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden floating-card">
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary bg-opacity-10 mb-4">
                        <i class="fas fa-calculator text-primary text-2xl service-icon"></i>
                    </div>
                    <h4 class="text-xl font-heading font-bold mb-4 text-gray-800">Wallpaper Calculator</h4>
                    <p class="text-gray-600 mb-6">Use our online calculator to determine exactly how many rolls you need for your space.</p>
                    <a href="#" class="inline-block px-6 py-2 border border-primary text-primary font-medium rounded-md hover:bg-primary hover:text-white transition duration-300">Calculate Now</a>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden floating-card">
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary bg-opacity-10 mb-4">
                        <i class="fas fa-user-tie text-primary text-2xl service-icon"></i>
                    </div>
                    <h4 class="text-xl font-heading font-bold mb-4 text-gray-800">Professional Installation</h4>
                    <p class="text-gray-600 mb-6">Connect with our network of certified installers for professional wallpaper installation.</p>
                    <a href="#" class="inline-block px-6 py-2 border border-primary text-primary font-medium rounded-md hover:bg-primary hover:text-white transition duration-300">Find an Installer</a>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden floating-card">
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary bg-opacity-10 mb-4">
                        <i class="fas fa-palette text-primary text-2xl service-icon"></i>
                    </div>
                    <h4 class="text-xl font-heading font-bold mb-4 text-gray-800">Design Consultation</h4>
                    <p class="text-gray-600 mb-6">Schedule a consultation with our design experts to find the perfect wallpaper for your space.</p>
                    <a href="#" class="inline-block px-6 py-2 border border-primary text-primary font-medium rounded-md hover:bg-primary hover:text-white transition duration-300">Book Consultation</a>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-6 mt-12 max-w-5xl mx-auto">
            <div class="flex flex-col md:flex-row items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-full p-3 mb-4 md:mb-0 md:mr-6">
                    <i class="fas fa-headset text-green-500 text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-medium mb-2">Need Help?</h4>
                    <p class="text-gray-600">Our customer service team is available Monday-Friday, 9am-5pm EST to answer any questions about our wallpapers and services. Contact us at <a href="mailto:support@murart.com" class="text-primary hover:underline">support@murart.com</a> or call <a href="tel:1-800-123-4567" class="text-primary hover:underline">1-800-123-4567</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function toggleAccordion(id) {
        const content = document.getElementById(id + 'Content');
        const icon = document.getElementById(id + 'Icon');
        
        // Toggle content visibility
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
    
    // Initialize first accordion item as open
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('step1Content').classList.remove('hidden');
        document.getElementById('step1Icon').classList.add('rotate-180');
    });
</script>
@endpush
@endsection