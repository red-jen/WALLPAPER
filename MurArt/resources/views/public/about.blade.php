@extends('layouts.client')

@section('title', 'About Us')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">About MurArt</h1>
            
            <div class="card mb-5">
                <div class="card-body">
                    <h2 class="card-title">Our Story</h2>
                    <p class="lead">Transforming spaces with artistic wallpapers since 2020</p>
                    <p>MurArt was founded with a simple mission: to bring high-quality, artistic wallpapers to homes and businesses around the world. We believe that walls are more than just boundaries—they're canvases waiting to be transformed into expressions of your unique style and personality.</p>
                    <p>Our team of designers and artists work tirelessly to create stunning, durable wallpapers that not only look beautiful but are also easy to install and maintain. We source the finest materials and use cutting-edge printing technology to ensure that every wallpaper meets our exacting standards.</p>
                </div>
            </div>
            
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">Our Mission</h2>
                            <p>To provide premium quality wallpapers that inspire creativity and transform living spaces into beautiful, personalized environments. We aim to make artistic wallpapers accessible to everyone, offering a wide range of designs at competitive prices.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title">Our Values</h2>
                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> <strong>Quality:</strong> We never compromise on the materials or printing process.</li>
                                <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> <strong>Sustainability:</strong> Our products are eco-friendly and responsibly sourced.</li>
                                <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> <strong>Innovation:</strong> We continuously explore new designs and technologies.</li>
                                <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> <strong>Customer Satisfaction:</strong> Your happiness is our top priority.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-5">
                <div class="card-body">
                    <h2 class="card-title">Our Products</h2>
                    <p>At MurArt, we offer a diverse collection of wallpapers to suit every style and space:</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-paint-brush fa-3x text-primary mb-3"></i>
                                    <h3 class="card-title">Artistic Designs</h3>
                                    <p class="card-text">Unique patterns and illustrations created by our talented artists.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-leaf fa-3x text-primary mb-3"></i>
                                    <h3 class="card-title">Nature-Inspired</h3>
                                    <p class="card-text">Bring the beauty of nature into your space with our botanical and landscape designs.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-building fa-3x text-primary mb-3"></i>
                                    <h3 class="card-title">Modern & Minimalist</h3>
                                    <p class="card-text">Clean lines and contemporary patterns for a sophisticated look.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Our Team</h2>
                    <p>Behind every beautiful wallpaper is a team of passionate individuals dedicated to bringing art to your walls. Our designers, artists, and customer service representatives work together to ensure that you get the perfect wallpaper for your space.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-light mx-auto mb-3" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user fa-3x text-primary"></i>
                                    </div>
                                    <h4>Sarah Johnson</h4>
                                    <p class="text-muted">Founder & Creative Director</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-light mx-auto mb-3" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user fa-3x text-primary"></i>
                                    </div>
                                    <h4>Michael Chen</h4>
                                    <p class="text-muted">Lead Designer</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-light mx-auto mb-3" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user fa-3x text-primary"></i>
                                    </div>
                                    <h4>Emma Rodriguez</h4>
                                    <p class="text-muted">Customer Experience Manager</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-light mx-auto mb-3" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user fa-3x text-primary"></i>
                                    </div>
                                    <h4>David Kim</h4>
                                    <p class="text-muted">Production Manager</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection