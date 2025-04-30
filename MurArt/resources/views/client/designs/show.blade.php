@extends('layouts.app')

@section('title', $design->title . ' - MurArt')

@section('content')
<div class="bg-neutral min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-charcoal/70">
                <a href="{{ route('home') }}" class="hover:text-navy">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('designs.index') }}" class="hover:text-navy">Designs</a>
                <span class="mx-2">/</span>
                <span class="text-charcoal">{{ $design->title }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Design Image -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="aspect-[4/5] w-full relative overflow-hidden">
                    <img src="{{ asset('storage/' . $design->image_path) }}" 
                        alt="{{ $design->title }}" 
                        class="w-full h-full object-cover">
                    
                    @if($design->featured)
                        <div class="absolute top-0 right-0 bg-gold text-navy text-xs font-bold px-3 py-1 m-2 rounded">
                            Featured
                        </div>
                    @endif
                </div>
            </div>

            <!-- Design Details -->
            <div class="space-y-6">
                <!-- Title and Meta -->
                <div>
                    <h1 class="text-3xl font-heading font-bold text-charcoal mb-4">{{ $design->title }}</h1>
                    
                    <div class="flex flex-wrap gap-3 mb-6">
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-neutral-100 text-charcoal/70 rounded-full text-sm">
                            <i class="fas fa-tag"></i>
                            {{ $design->category->name ?? 'Uncategorized' }}
                        </span>
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-neutral-100 text-charcoal/70 rounded-full text-sm">
                            <i class="fas fa-eye"></i>
                            {{ $design->views ?? 0 }} views
                        </span>
                    </div>
                </div>

                <!-- Designer Info -->
                <div class="flex items-center gap-4 p-4 bg-neutral-50 rounded-xl">
                    <div class="w-12 h-12 bg-navy text-white rounded-full flex items-center justify-center text-lg font-medium">
                        {{ substr($design->designer->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <p class="font-medium text-charcoal">{{ $design->designer->name ?? 'Unknown Designer' }}</p>
                        <p class="text-sm text-charcoal/60">Designer</p>
                    </div>
                </div>

                <!-- Description -->
                @if($design->description)
                    <div class="prose max-w-none">
                        <h3 class="text-xl font-heading font-semibold text-charcoal mb-3">About this Design</h3>
                        <p class="text-charcoal/80">{{ $design->description }}</p>
                    </div>
                @endif

                <!-- Call to Action -->
                <div class="bg-gradient-to-br from-white to-neutral-50 rounded-xl p-6 border border-neutral-200">
                    <h3 class="text-xl font-heading font-semibold text-charcoal mb-4">Create Your Custom Wallpaper</h3>
                    <p class="text-charcoal/70 mb-6">Transform this design into your perfect wallpaper. Customize dimensions, paper type, and more to match your space.</p>
                    
                    <a href="{{ route('designs.create-artwork', $design) }}" 
                        class="block w-full bg-gold text-navy font-medium py-3 px-6 rounded-lg text-center hover:bg-gold/90 transition-colors">
                        Use This Design
                    </a>
                </div>

                <!-- How It Works -->
                <div class="bg-white rounded-xl p-6 border border-neutral-200">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fas fa-info-circle text-gold text-xl"></i>
                        <h3 class="text-xl font-heading font-semibold text-charcoal">How It Works</h3>
                    </div>
                    <ol class="space-y-3 text-charcoal/80">
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-gold/10 text-gold rounded-full flex items-center justify-center text-sm font-medium">1</span>
                            <span>Select this design to start your wallpaper project</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-gold/10 text-gold rounded-full flex items-center justify-center text-sm font-medium">2</span>
                            <span>Choose your preferred paper type and dimensions</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-gold/10 text-gold rounded-full flex items-center justify-center text-sm font-medium">3</span>
                            <span>Submit your request for a preview</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-gold/10 text-gold rounded-full flex items-center justify-center text-sm font-medium">4</span>
                            <span>Approve the preview and place your order</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Similar Designs -->
        @if(count($similarDesigns) > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-heading font-bold text-charcoal mb-8">You Might Also Like</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($similarDesigns as $similarDesign)
                        <a href="{{ route('designs.show', $similarDesign) }}" class="block h-full group">
                            <div class="h-full bg-white rounded-xl shadow-sm overflow-hidden border border-gray-50 transition duration-300 ease-in-out hover:-translate-y-1 hover:shadow-lg flex flex-col">
                                <div class="aspect-[4/5] w-full relative overflow-hidden">
                                    <img src="{{ asset('storage/' . $similarDesign->image_path) }}" 
                                        class="w-full h-full object-cover transition duration-500 ease-in-out group-hover:scale-105" 
                                        alt="{{ $similarDesign->title }}">
                                    
                                    @if($similarDesign->featured)
                                        <div class="absolute top-0 right-0 bg-gold text-navy text-xs font-bold px-3 py-1 m-2 rounded">
                                            Featured
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5 flex-1 flex flex-col">
                                    <h3 class="font-semibold text-base leading-tight text-gray-800 mb-2 truncate">
                                        {{ $similarDesign->title }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-3">
                                        By {{ $similarDesign->designer->name ?? 'Unknown Designer' }}
                                    </p>
                                    
                                    <div class="mt-auto flex items-center justify-between">
                                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-neutral-100 text-charcoal/70 rounded-full text-xs">
                                            <i class="fas fa-tag"></i>
                                            {{ $similarDesign->category->name ?? 'Uncategorized' }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-xs text-charcoal/60">
                                            <i class="fas fa-eye"></i>
                                            {{ $similarDesign->views ?? 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 