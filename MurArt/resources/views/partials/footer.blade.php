<!-- Footer Component -->
<footer class="bg-dark text-white pt-12 pb-6 mt-auto">
    <div class="container mx-auto px-4">
        <!-- Footer Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
            <!-- Brand Info -->
            <div>
                <div class="flex items-center mb-4">
                    <svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2">
                        <path d="M20 0C8.954 0 0 8.954 0 20C0 31.046 8.954 40 20 40C31.046 40 40 31.046 40 20C40 8.954 31.046 0 20 0ZM20 6C25.514 6 30 10.486 30 16C30 21.514 25.514 26 20 26C14.486 26 10 21.514 10 16C10 10.486 14.486 6 20 6Z" fill="#6C9BCF"/>
                        <path d="M20 12C17.791 12 16 13.791 16 16C16 18.209 17.791 20 20 20C22.209 20 24 18.209 24 16C24 13.791 22.209 12 20 12Z" fill="#FFA500"/>
                    </svg>
                    <h2 class="text-xl font-heading font-bold">Mur<span class="text-primary">Art</span></h2>
                </div>
                <p class="text-gray-400 mb-6">La plateforme qui connecte designers et amateurs de décoration pour créer des papiers peints uniques et personnalisés.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-primary transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition">
                        <i class="fab fa-pinterest-p"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="font-heading font-medium text-lg mb-5">Liens Rapides</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Accueil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>À propos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('designs.index') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Designs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('artworks.create') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Créer un papier peint
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Devenir designer
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Information -->
            <div>
                <h3 class="font-heading font-medium text-lg mb-5">Informations</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('faq') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>FAQ
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Livraison
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('returns') }}" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Retours
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Politique de confidentialité
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-primary transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2"></i>Conditions générales
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Contact Information -->
            <div>
                <h3 class="font-heading font-medium text-lg mb-5">Contact</h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i>
                        <span class="text-gray-400">123 Rue de la Création, 75001 Paris, France</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt mr-3 text-primary"></i>
                        <span class="text-gray-400">+33 1 23 45 67 89</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3 text-primary"></i>
                        <span class="text-gray-400">contact@murart.fr</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-clock mr-3 text-primary"></i>
                        <span class="text-gray-400">Lun-Ven: 9h-18h | Sam: 10h-16h</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Newsletter Subscription -->
        <div class="bg-gray-800 rounded-lg p-6 mb-10">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    <h3 class="text-xl font-heading font-medium mb-2">Restez informé</h3>
                    <p class="text-gray-400">Recevez nos dernières collections et offres exclusives</p>
                </div>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="w-full md:w-1/2 flex">
                    @csrf
                    <input type="email" name="email" placeholder="Votre adresse email" required class="flex-grow py-3 px-4 rounded-l-md focus:outline-none text-dark">
                    <button type="submit" class="bg-primary hover:bg-opacity-90 py-3 px-6 rounded-r-md font-heading font-medium transition">S'inscrire</button>
                </form>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="border-t border-gray-800 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">&copy; {{ date('Y') }} MurArt. Tous droits réservés.</p>
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