# Inertia.js + Vue 3 Migration Setup Guide

## Overview
This PR migrates the MurArt frontend from Blade templates to **Inertia.js + Vue 3 + Tailwind CSS v4** with a **mobile-first responsive design**.

## What Changed

### 1. **New Dependencies**

#### NPM Packages (already installed)
- `@inertiajs/vue3` - Inertia.js for Vue 3
- `vue@^3` - Vue 3 framework
- `@vitejs/plugin-vue` - Vite plugin for Vue SFCs

#### Composer Packages (need to be installed on deployment)
- `inertiajs/inertia-laravel` - Inertia server-side adapter
- `tightenco/ziggy` - Laravel routes in JavaScript (optional, currently disabled)

### 2. **Configuration Updates**

- **vite.config.js**: Added Vue plugin and alias configuration
- **bootstrap/app.php**: Registered `HandleInertiaRequests` middleware
- **resources/js/app.js**: Set up Inertia app with Vue 3
- **resources/views/app.blade.php**: New Inertia root template

### 3. **Converted Pages**

#### ✅ Converted to Inertia/Vue
- **Home** (`/`) - `resources/js/Pages/Home.vue`
- **Shop Index** (`/shop`) - `resources/js/Pages/Shop/Index.vue`

#### 🔄 Still Blade (can convert later)
- Shop show page (`/shop/{id}`)
- About, Contact pages
- All admin/designer/client dashboards
- Auth pages

### 4. **Mobile-First Design Improvements**

#### Navigation Changes
**Before (Mobile A06 Screenshot Problem):**
- Logo + Cart + "Connexion" + "Inscription" button + Hamburger all crammed on one row
- Search bar eating vertical space
- No touch-friendly spacing

**After (Fixed):**
- Clean navbar: Logo + Cart icon + Menu button (3 elements only)
- No visible search bar on small screens (in menu if needed)
- Mobile menu uses right-slide drawer pattern
- All touch targets ≥ 44px minimum height
- Typography scales from mobile (16px base) to desktop

#### Hero Section
- Reduced height on mobile
- Stacked buttons (not side-by-side until sm: breakpoint)
- Stats in 3-column grid that stacks nicely
- Hero image hidden on mobile, visible on desktop

#### Product Grids
- Mobile: 1 column
- Tablet (sm): 2 columns
- Desktop (lg): 3-4 columns
- Cards with proper aspect ratios (3:4 for products)

## Setup Instructions

### On Development (Local)

1. **Install Composer dependencies:**
   ```bash
   composer install
   ```

2. **Install NPM dependencies:**
   ```bash
   npm install
   ```

3. **Build frontend assets:**
   ```bash
   npm run build
   ```
   
   Or for development with hot reload:
   ```bash
   npm run dev
   ```

4. **Run migrations (if needed):**
   ```bash
   php artisan migrate
   ```

5. **Seed database:**
   ```bash
   php artisan db:seed
   ```

### On Wasmer Deployment

The `wasmer.toml` should already handle PHP. For this PR to work in production:

1. **Before deployment**, ensure these scripts run:
   ```bash
   composer install --no-dev --optimize-autoloader
   npm ci
   npm run build
   ```

2. **Add to deployment pipeline** (if not already present):
   - Composer autoload optimization
   - NPM production build
   - Laravel route cache: `php artisan route:cache`
   - Laravel config cache: `php artisan config:cache`

## Testing

### Manual Testing Checklist

- [ ] Home page loads at `/`
- [ ] Shop index loads at `/shop` with pagination
- [ ] Mobile nav drawer opens/closes cleanly
- [ ] Product cards display correctly on mobile (~360px width)
- [ ] Hero stats visible and readable on mobile
- [ ] Touch targets are ≥44px (buttons, nav items)
- [ ] Filters and sorting work on shop page
- [ ] Pagination works (desktop pagination + mobile page counter)
- [ ] Cart icon shows count badge
- [ ] User menu works (if authenticated)
- [ ] No JS console errors

### Browser Testing
- Chrome/Edge (desktop + mobile emulation)
- Safari iOS (test on real iPhone if possible)
- Samsung Internet (Android, especially A06-class devices)

## Known Limitations / Future Work

1. **Ziggy not integrated yet**: Currently disabled in `app.js`. When composer packages are installed, uncomment:
   ```js
   import { ZiggyVue } from '../../vendor/tightenco/ziggy';
   // In setup:
   .use(ZiggyVue)
   ```
   And add `@routes` directive to `app.blade.php` (already present).

2. **Other pages still Blade**: About, Contact, Auth pages, Admin/Designer/Client areas still use Blade. Convert as needed.

3. **Search functionality**: Currently not implemented in mobile nav. Can add to drawer menu.

4. **Shop show page**: Detail page still Blade. Should convert next for consistency.

## Routes Preserved

All existing Laravel routes remain the same:
- `/` → HomeController@index (now returns Inertia)
- `/shop` → ShopController@index (now returns Inertia)
- `/shop/{id}` → ShopController@show (still Blade)
- All other routes unchanged

## Design System

### Colors (Butterfly-inspired palette)
- Primary: `#4B7C9D` (cool wing-blue)
- Secondary: `#D4A04F` (warm copper-gold)
- Accent: `#9B6D94` (soft violet-mauve)
- Background: `#FAF9F7` (off-white)
- Dark: `#2A3240` (deep blue-gray)

### Fonts
- **Headings**: Playfair Display (serif)
- **Body**: Poppins (sans-serif)

### Breakpoints (Tailwind defaults)
- `sm`: 640px
- `md`: 768px
- `lg`: 1024px
- `xl`: 1280px

## File Structure

```
resources/
├── js/
│   ├── app.js                 # Inertia app entry
│   ├── bootstrap.js
│   ├── Layouts/
│   │   └── AppLayout.vue      # Main layout with nav/footer
│   ├── Pages/
│   │   ├── Home.vue           # Home page
│   │   └── Shop/
│   │       └── Index.vue      # Shop index
│   └── Components/            # (future shared components)
├── css/
│   └── app.css                # Tailwind directives
└── views/
    └── app.blade.php          # Inertia root template

app/Http/Middleware/
└── HandleInertiaRequests.php  # Inertia middleware

vite.config.js                 # Vue + Tailwind config
```

## Troubleshooting

### Build fails with "Cannot find module"
Run: `rm -rf node_modules package-lock.json && npm install`

### Pages not rendering / blank screen
1. Check browser console for errors
2. Ensure `npm run build` completed successfully
3. Verify `public/build/manifest.json` exists
4. Check that `app.blade.php` has `@vite` directive

### Styles not loading
1. Ensure Tailwind CSS v4 is installed
2. Check `resources/css/app.css` has `@tailwind` directives
3. Rebuild: `npm run build`

### Cart count not updating
Cart count is shared via Inertia middleware. Check `HandleInertiaRequests.php` is registered and `share()` method returns cart data.

## Support

For issues or questions about this migration, contact the development team or check:
- Inertia.js docs: https://inertiajs.com
- Vue 3 docs: https://vuejs.org
- Tailwind CSS v4 docs: https://tailwindcss.com
