<header class="sticky top-0 z-40 bg-white/0 shadow-custom">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="font-heading font-bold text-2xl text-primary">
                Wall<span class="text-secondary">Art</span>
            </div>
            
            <nav class="hidden md:block">
                <ul class="flex gap-8">
                    <li><a href="#" class="font-medium text-dark hover:text-primary transition-colors">Accueil</a></li>
                    <li><a href="#" class="font-medium text-dark hover:text-primary transition-colors">Catalogue</a></li>
                    <li><a href="#" class="font-medium text-dark hover:text-primary transition-colors">Personnalisation</a></li>
                    <li><a href="#" class="font-medium text-dark hover:text-primary transition-colors">Designers</a></li>
                    <li><a href="#" class="font-medium text-dark hover:text-primary transition-colors">Communauté</a></li>
                </ul>
            </nav>
            
            <div class="flex items-center gap-6">
                <input type="text" class="hidden md:block px-5 py-2 border border-gray-300 rounded-full w-48 focus:outline-none focus:border-primary focus:w-56 transition-all" placeholder="Rechercher...">
                <button class="hidden md:block px-6 py-2 rounded-full font-semibold border-2 border-primary text-primary hover:bg-primary hover:text-white transition-all transform hover:-translate-y-0.5">Connexion</button>
                <button class="px-6 py-2 rounded-full font-semibold bg-primary text-white hover:bg-primary/90 transition-all transform hover:-translate-y-0.5">Inscription</button>
                
                <!-- Mobile menu button -->
                <button class="md:hidden text-dark" id="mobile-menu-button">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div class="hidden bg-white shadow-md py-4 md:hidden" id="mobile-menu">
        <div class="container mx-auto px-4">
            <ul class="flex flex-col gap-4">
                <li><a href="#" class="block py-2 font-medium text-dark hover:text-primary transition-colors">Accueil</a></li>
                <li><a href="#" class="block py-2 font-medium text-dark hover:text-primary transition-colors">Catalogue</a></li>
                <li><a href="#" class="block py-2 font-medium text-dark hover:text-primary transition-colors">Personnalisation</a></li>
                <li><a href="#" class="block py-2 font-medium text-dark hover:text-primary transition-colors">Designers</a></li>
                <li><a href="#" class="block py-2 font-medium text-dark hover:text-primary transition-colors">Communauté</a></li>
                <li>
                    <input type="text" class="mt-2 px-5 py-2 border border-gray-300 rounded-full w-full focus:outline-none focus:border-primary transition-all" placeholder="Rechercher...">
                </li>
                <li>
                    <button class="mt-2 px-6 py-2 rounded-full font-semibold border-2 border-primary text-primary hover:bg-primary hover:text-white transition-all w-full">Connexion</button>
                </li>
            </ul>
        </div>
    </div>
</header>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>
@endpush