Hero Section for WallArt Landing Page
<div class="relative h-screen overflow-hidden bg-ivory" x-data="{ activeSlide: 0 }"
     x-init="setInterval(() => { activeSlide = (activeSlide + 1) % {{ count($wallpapers) > 0 ? count($wallpapers) : 1 }}; }, 7000)">
    
    {{-- Background Image Slider --}}
    @if(count($wallpapers) > 0)
        @foreach($wallpapers->take(3) as $index => $wallpaper)
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                 :class="{ 'opacity-100': activeSlide === {{ $index }}, 'opacity-0': activeSlide !== {{ $index }} }">
                @if($wallpaper->primaryImage)
                    <img src="{{ asset('storage/' . $wallpaper->primaryImage->image_path) }}" 
                         alt="{{ $wallpaper->title }}" 
                         class="object-cover w-full h-full">
                @else
                    <div class="w-full h-full bg-navy/10"></div>
                @endif
                
                {{-- Gradient Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-r from-navy/80 via-navy/60 to-transparent"></div>
            </div>
        @endforeach
    @else
        <div class="absolute inset-0">
            <div class="w-full h-full bg-navy/10"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-navy/80 via-navy/60 to-transparent"></div>
        </div>
    @endif

    {{-- Content --}}
    <div class="relative container mx-auto px-6 flex flex-col justify-center h-full text-ivory">
        <div class="max-w-3xl" 
             x-data="{show: false}"
             x-init="setTimeout(() => show = true, 500)"
             :class="{ 'translate-y-0 opacity-100': show, 'translate-y-8 opacity-0': !show }"
             class="transition-all duration-1000 ease-out">
            
            {{-- Decorative Line + Tagline --}}
            <div class="flex items-center mb-6">
                <div class="w-16 h-px bg-gold"></div>
                <span class="ml-4 text-gold font-sans uppercase tracking-widest text-sm font-medium">Papiers Peints Exclusifs</span>
            </div>
            
            {{-- Main Heading --}}
            <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl leading-tight mb-6">
                Créez le Papier Peint de <span class="text-gold italic">vos Rêves</span>
            </h1>
            
            {{-- Subheading --}}
            <p class="text-lg text-ivory/90 max-w-2xl mb-10 font-light leading-relaxed">
                Découvrez notre plateforme de personnalisation avancée pour concevoir des papiers peints uniques qui reflètent votre style et votre personnalité.
            </p>
            
            {{-- CTA Buttons --}}
            <div class="flex flex-wrap gap-4 mb-16">
                <a href="{{ route('designs.index') }}" 
                   class="px-8 py-3 bg-gold text-navy font-medium tracking-wide transition-all duration-300 hover:bg-gold/90 hover:-translate-y-0.5 hover:shadow-lg rounded-sm">
                    Explorer le Catalogue
                </a>
                <a href="#customization" 
                   class="px-8 py-3 bg-transparent border border-ivory text-ivory font-medium tracking-wide transition-all duration-300 hover:bg-ivory/10 hover:-translate-y-0.5 rounded-sm">
                    Personnaliser
                </a>
            </div>
            
            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-8 max-w-xl">
                <div>
                    <p class="font-serif text-3xl text-gold font-medium mb-1">{{ App\Models\Wallpaper::count() }}+</p>
                    <p class="text-sm text-ivory/70 uppercase tracking-wider">Motifs Exclusifs</p>
                </div>
                <div>
                    <p class="font-serif text-3xl text-gold font-medium mb-1">{{ App\Models\User::where('role', 'designer')->count() }}+</p>
                    <p class="text-sm text-ivory/70 uppercase tracking-wider">Designers</p>
                </div>
                <div>
                    <p class="font-serif text-3xl text-gold font-medium mb-1">{{ App\Models\Paper::count() }}</p>
                    <p class="text-sm text-ivory/70 uppercase tracking-wider">Types de Papier</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Slider Navigation --}}
    @if(count($wallpapers) > 1)
        <div class="absolute bottom-10 right-10 flex space-x-2">
            @foreach($wallpapers->take(3) as $index => $wallpaper)
                <button @click="activeSlide = {{ $index }}"
                        class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="{ 'bg-gold w-8': activeSlide === {{ $index }}, 'bg-ivory/50': activeSlide !== {{ $index }} }">
                </button>
            @endforeach
        </div>
    @endif
    
    {{-- Scroll Indicator --}}
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 text-center hidden lg:block">
        <div class="animate-bounce text-gold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
        <p class="text-xs uppercase tracking-widest mt-2 text-ivory/70">Découvrir</p>
    </div>
</div>

{{-- You'll need Alpine.js for the animations --}}
{{-- Add this in your layout file if not already there: --}}
{{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}