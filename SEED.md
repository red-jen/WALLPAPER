# MurArt Database Seeding

This document provides information about seeding the MurArt database with demo data.

## Quick Start

To seed the database with demo data, run:

```bash
php artisan db:seed --force
```

This command is idempotent and can be run multiple times safely. Existing records will not be duplicated.

## What Gets Seeded

### Users (5 demo accounts)
- **1 Admin**: Full system access
- **2 Designers**: Can create and manage designs
- **2 Customers**: Can browse and purchase wallpapers

### Categories (6)
- Geometric
- Floral
- Abstract
- Minimalist
- Vintage
- Textured

### Paper Types (6)
Various paper types with different finishes, thicknesses, and use cases:
- Premium Matte
- Glossy Premium
- Eco Recycled
- Silk Textured
- Canvas Effect
- Vinyl Durable

### Designs (10)
Designer-created wallpaper designs across all categories, each linked to recommended paper types.

### Wallpapers (12)
Ready-to-purchase wallpaper products with:
- Titles and descriptions
- Prices ($39.99 - $59.99)
- Stock quantities
- High-resolution dimensions
- Category associations
- Compatible paper types
- Primary images

## Demo Login Credentials

**All demo accounts use the password: `password`**

### Admin Account
```
Email: admin@murart.com
Password: password
Role: Administrator
```
Full access to admin dashboard, user management, and all system features.

### Designer Accounts
```
Email: designer@murart.com
Password: password
Role: Designer
Name: Emma Designer
```

```
Email: designer2@murart.com
Password: password
Role: Designer
Name: Lucas Artisan
```
Can create and manage wallpaper designs, upload artwork.

### Customer Accounts
```
Email: customer@murart.com
Password: password
Role: Client
Name: Sarah Customer
```

```
Email: customer2@murart.com
Password: password
Role: Client
Name: Mike Johnson
```
Can browse catalog, add items to cart, and make purchases.

## Seeder Details

### UserSeeder
Creates 5 user accounts with different roles:
- 1 admin for system management
- 2 designers for content creation
- 2 clients for customer simulation

Uses `firstOrCreate` to prevent duplicates on re-runs.

### CategorySeeder
Creates 6 wallpaper categories:
- Each with name, slug, and description
- Used to organize both designs and wallpapers

### PaperSeeder
Creates 6 different paper types:
- Includes specifications (thickness in GSM, size, finish)
- Pricing information
- Usage recommendations
- Active status for marketplace

### DesignSeeder
Creates 10 wallpaper designs:
- Distributed across all categories
- Assigned to designer users
- Each linked to 2-3 recommended paper types
- Uses placeholder image paths

### WallpaperSeeder
Creates 12 marketplace wallpaper products:
- Complete product information (title, description, price)
- Inventory management (stock levels)
- Status (published/featured)
- Dimensions for digital wallpapers
- Links to compatible paper types
- Primary images using stable placeholder URLs

## Database Requirements

Before seeding, ensure migrations have been run:

```bash
php artisan migrate --force
```

The seeder expects these tables to exist:
- users
- categories
- papers
- designs
- wallpapers
- wallpaper_images
- design_paper (pivot)
- paper_wallpaper (pivot)
- design_category (pivot)

## Re-seeding

The seeders use `firstOrCreate` which makes them safe to run multiple times:
- Existing records (matched by email/name) won't be duplicated
- New relationships will be created only if they don't exist
- Safe for both fresh databases and existing data

## Production Note

**⚠️ These are demo credentials with a simple password.**

For production deployments:
1. Do NOT run the seeder
2. Create real admin accounts with strong passwords
3. Remove or secure demo accounts
4. Use proper authentication and password policies

## Verifying Seeded Data

After seeding, you can verify the data:

```bash
# Count users
php artisan tinker
>>> User::count()
=> 5

# Check categories
>>> Category::pluck('name')
=> ["Geometric", "Floral", "Abstract", "Minimalist", "Vintage", "Textured"]

# Verify wallpapers
>>> Wallpaper::count()
=> 12
```

## Testing the Application

After seeding:

1. **Visit the homepage**: Browse the seeded wallpaper catalog
2. **Login as customer**: `customer@murart.com` / `password`
   - Browse `/papers` or `/shop`
   - View product details
   - Add items to cart
3. **Login as designer**: `designer@murart.com` / `password`
   - Access designer dashboard
   - View your designs
4. **Login as admin**: `admin@murart.com` / `password`
   - Access admin panel
   - Manage all content

## Image Placeholders

Wallpaper images use Lorem Picsum placeholder service with seeded hashes for consistency:
- Format: `https://picsum.photos/seed/{hash}/800/1200`
- Stable URLs based on wallpaper title
- Free, no API key required
- Suitable for demo/preview deployments

For production, replace with actual wallpaper images uploaded through the application.
