@extends('layouts.client')

@section('title', 'Services')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Our Services</h1>
            
            <div class="card mb-5">
                <div class="card-body">
                    <h2 class="card-title">How to Use Our Wallpapers</h2>
                    <p class="lead">From selection to installation, we're here to help you transform your space</p>
                    <p>At MurArt, we believe that the right wallpaper can completely transform a room. Our wallpapers are designed to be both beautiful and practical, making them perfect for any space in your home or office. Below, you'll find comprehensive guides on how to select, install, and care for your MurArt wallpapers.</p>
                </div>
            </div>
            
            <!-- Selection Guide -->
            <div class="card mb-5">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Step 1: Selecting the Perfect Wallpaper</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Consider Your Space</h4>
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> <strong>Room Purpose:</strong> Different rooms have different vibes. Choose patterns that match the mood you want to create.</li>
                                <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> <strong>Lighting:</strong> Consider how much natural light the room receives. Darker patterns work well in well-lit spaces, while lighter patterns can brighten darker rooms.</li>
                                <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> <strong>Room Size:</strong> Large patterns can make small rooms feel smaller, while small patterns can make large rooms feel busy.</li>
                                <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> <strong>Existing Décor:</strong> Choose wallpapers that complement your existing furniture and accessories.</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4>Browse Our Collections</h4>
                            <p>Our wallpapers are organized into categories to help you find the perfect match:</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-paint-brush text-primary me-2"></i> <strong>Artistic:</strong> Unique designs created by our talented artists</li>
                                <li class="list-group-item"><i class="fas fa-leaf text-primary me-2"></i> <strong>Nature-Inspired:</strong> Botanical and landscape patterns</li>
                                <li class="list-group-item"><i class="fas fa-building text-primary me-2"></i> <strong>Modern & Minimalist:</strong> Clean lines and contemporary patterns</li>
                                <li class="list-group-item"><i class="fas fa-palette text-primary me-2"></i> <strong>Vintage & Retro:</strong> Classic designs with a nostalgic feel</li>
                                <li class="list-group-item"><i class="fas fa-child text-primary me-2"></i> <strong>Kids & Playful:</strong> Fun patterns perfect for children's rooms</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle me-2"></i> <strong>Pro Tip:</strong> Order a sample before making your final decision. This allows you to see how the wallpaper looks in your space with your lighting.
                    </div>
                </div>
            </div>
            
            <!-- Installation Guide -->
            <div class="card mb-5">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Step 2: Installation Guide</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Preparation</h4>
                            <ol class="list-group list-group-numbered mb-4">
                                <li class="list-group-item">Remove all furniture from the room or cover it with drop cloths.</li>
                                <li class="list-group-item">Clean the walls thoroughly with a mild detergent and water. Allow to dry completely.</li>
                                <li class="list-group-item">Fill any holes or cracks with spackling compound and sand smooth.</li>
                                <li class="list-group-item">Apply a wallpaper primer to ensure proper adhesion.</li>
                                <li class="list-group-item">Measure your walls and calculate how many rolls you'll need (add 10% for waste).</li>
                            </ol>
                        </div>
                        <div class="col-md-6">
                            <h4>Tools You'll Need</h4>
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item"><i class="fas fa-tools text-primary me-2"></i> Wallpaper paste and tray</li>
                                <li class="list-group-item"><i class="fas fa-tools text-primary me-2"></i> Smoothing brush or roller</li>
                                <li class="list-group-item"><i class="fas fa-tools text-primary me-2"></i> Utility knife and extra blades</li>
                                <li class="list-group-item"><i class="fas fa-tools text-primary me-2"></i> Level and measuring tape</li>
                                <li class="list-group-item"><i class="fas fa-tools text-primary me-2"></i> Sponge and clean cloth</li>
                                <li class="list-group-item"><i class="fas fa-tools text-primary me-2"></i> Step ladder</li>
                            </ul>
                        </div>
                    </div>
                    
                    <h4 class="mt-4">Installation Steps</h4>
                    <div class="accordion" id="installationSteps">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    1. Start with a Plumb Line
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#installationSteps">
                                <div class="accordion-body">
                                    <p>Use a level to draw a vertical plumb line on the wall. This will be your guide to ensure the wallpaper is hung straight. Start from the most prominent corner of the room.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    2. Cut and Prepare the Wallpaper
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#installationSteps">
                                <div class="accordion-body">
                                    <p>Unroll the wallpaper and cut it to the appropriate length, adding a few inches at the top and bottom for trimming. If your wallpaper has a pattern, make sure to match the pattern when cutting subsequent strips.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    3. Apply Paste and Book the Paper
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#installationSteps">
                                <div class="accordion-body">
                                    <p>Apply wallpaper paste to the back of the strip using a roller or brush. Fold the pasted sides together (but don't crease) and let it "book" for the time specified on the wallpaper instructions (usually 5-10 minutes).</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    4. Hang the Wallpaper
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#installationSteps">
                                <div class="accordion-body">
                                    <p>Unfold the top portion of the strip and align it with your plumb line. Smooth it onto the wall using a smoothing brush or roller, working from the center outward to remove air bubbles. Continue unrolling and smoothing as you go down.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    5. Trim and Clean Up
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#installationSteps">
                                <div class="accordion-body">
                                    <p>Use a utility knife to trim the excess wallpaper at the top and bottom. Wipe away any excess paste with a damp sponge. Repeat the process for subsequent strips, making sure to match the pattern.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning mt-4">
                        <i class="fas fa-exclamation-triangle me-2"></i> <strong>Important:</strong> If you're not confident in your wallpaper installation skills, we recommend hiring a professional. Incorrect installation can lead to bubbling, peeling, and other issues.
                    </div>
                </div>
            </div>
            
            <!-- Care Instructions -->
            <div class="card mb-5">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Step 3: Care and Maintenance</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Regular Cleaning</h4>
                            <p>To keep your wallpaper looking beautiful for years to come, follow these cleaning guidelines:</p>
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item"><i class="fas fa-broom text-primary me-2"></i> <strong>Dust Regularly:</strong> Use a soft, dry cloth or a feather duster to remove dust from your wallpaper.</li>
                                <li class="list-group-item"><i class="fas fa-spray-can text-primary me-2"></i> <strong>Spot Clean:</strong> For small stains, use a slightly damp sponge with mild soap. Always test in an inconspicuous area first.</li>
                                <li class="list-group-item"><i class="fas fa-wind text-primary me-2"></i> <strong>Avoid Direct Sunlight:</strong> Prolonged exposure to direct sunlight can cause fading. Consider using curtains or blinds.</li>
                                <li class="list-group-item"><i class="fas fa-temperature-high text-primary me-2"></i> <strong>Control Humidity:</strong> Maintain proper ventilation to prevent mold growth behind the wallpaper.</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4>Repair and Maintenance</h4>
                            <p>Occasional maintenance can help extend the life of your wallpaper:</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-tools text-primary me-2"></i> <strong>Fix Bubbles:</strong> If small bubbles appear, use a pin to puncture them and smooth with a roller.</li>
                                <li class="list-group-item"><i class="fas fa-cut text-primary me-2"></i> <strong>Repair Tears:</strong> For small tears, carefully align the edges and apply a small amount of wallpaper paste.</li>
                                <li class="list-group-item"><i class="fas fa-paint-brush text-primary me-2"></i> <strong>Touch Up:</strong> Keep a small piece of wallpaper for future touch-ups if needed.</li>
                                <li class="list-group-item"><i class="fas fa-sync-alt text-primary me-2"></i> <strong>Replace When Needed:</strong> Most wallpapers last 10-15 years with proper care. Plan for replacement when signs of wear appear.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Services -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Additional Services</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-calculator fa-3x text-primary mb-3"></i>
                                    <h4 class="card-title">Wallpaper Calculator</h4>
                                    <p class="card-text">Use our online calculator to determine exactly how many rolls you need for your space.</p>
                                    <a href="#" class="btn btn-outline-primary mt-3">Calculate Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-tie fa-3x text-primary mb-3"></i>
                                    <h4 class="card-title">Professional Installation</h4>
                                    <p class="card-text">Connect with our network of certified installers for professional wallpaper installation.</p>
                                    <a href="#" class="btn btn-outline-primary mt-3">Find an Installer</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-palette fa-3x text-primary mb-3"></i>
                                    <h4 class="card-title">Design Consultation</h4>
                                    <p class="card-text">Schedule a consultation with our design experts to find the perfect wallpaper for your space.</p>
                                    <a href="#" class="btn btn-outline-primary mt-3">Book Consultation</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-success mt-4">
                        <i class="fas fa-headset me-2"></i> <strong>Need Help?</strong> Our customer service team is available Monday-Friday, 9am-5pm EST to answer any questions about our wallpapers and services. Contact us at <a href="mailto:support@murart.com" class="alert-link">support@murart.com</a> or call <a href="tel:1-800-123-4567" class="alert-link">1-800-123-4567</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 