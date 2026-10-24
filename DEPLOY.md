# Deploying MurArt to Wasmer Edge

This guide explains how to deploy the MurArt Laravel wallpaper ecommerce application to Wasmer Edge - a free Laravel hosting platform that requires no credit card.

## Prerequisites

- A [Wasmer](https://wasmer.io) account (free, no credit card required)
- This repository on GitHub: https://github.com/red-jen/WALLPAPER

## Quick Deploy with Wasmer Edge

### Step 1: Connect GitHub Repository

1. Go to [Wasmer Dashboard](https://wasmer.io/products/edge)
2. Sign up or log in (no credit card required)
3. Click **New App** or **Deploy**
4. Select **Connect GitHub Repository**
5. Authorize Wasmer and select the **WALLPAPER** repository
6. Choose branch: `cursor/railway-deployment-c148` (or `main` after PR merge)

### Step 2: Configure Deployment

Wasmer will auto-detect the Laravel application and:
- ✅ Detect `wasmer.toml` configuration
- ✅ Install Composer dependencies automatically
- ✅ Build frontend assets with npm/Vite
- ✅ Configure PHP 8.3 runtime

**No manual configuration needed** - Wasmer handles everything!

### Step 3: Add Database (Optional)

Wasmer Edge provides database add-ons:

#### Option A: Use Wasmer Database (Recommended)

1. In your app dashboard, click **Add-ons** or **Database**
2. Select database type:
   - **MySQL** (most common on Wasmer free tier)
   - **PostgreSQL** (if available)
3. Wasmer will automatically inject environment variables:
   - `DB_HOST`
   - `DB_PORT`
   - `DB_DATABASE`
   - `DB_USERNAME`
   - `DB_PASSWORD`

#### Option B: External Database

Use a free external PostgreSQL database:
- [Neon](https://neon.tech) (free tier, PostgreSQL)
- [Supabase](https://supabase.com) (free tier, PostgreSQL)
- [ElephantSQL](https://www.elephantsql.com) (free tier, PostgreSQL)

Add the connection details manually in Wasmer environment variables.

### Step 4: Configure Environment Variables

Add these in the Wasmer Edge dashboard under **Settings** → **Environment Variables**:

#### Required Variables

```bash
# Application
APP_NAME=MurArt
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_GENERATED_KEY_HERE

# Important: APP_URL will be auto-set by Wasmer
# Format: https://your-app.wasmer.app

# Database - Choose MySQL OR PostgreSQL based on your setup
DB_CONNECTION=mysql  # or 'pgsql' for PostgreSQL
# DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
# (auto-injected if using Wasmer database add-on)

# Cache, Session, Queue
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

#### Generate APP_KEY

Run locally or use an online generator:
```bash
php -r "echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
```

Or if you have PHP/Laravel CLI access:
```bash
php artisan key:generate --show
```

### Step 5: Database Connection Setup

**⚠️ Important**: The app's `.env.example` uses `DB_CONNECTION=pgsql` (PostgreSQL), but Wasmer's free database may be MySQL.

#### If Using MySQL (Wasmer Default)

Set in environment variables:
```bash
DB_CONNECTION=mysql
```

No code changes needed - Laravel supports both!

#### If Using PostgreSQL

Keep:
```bash
DB_CONNECTION=pgsql
```

This works with external PostgreSQL providers or if Wasmer offers PostgreSQL add-ons.

### Step 6: Deploy

1. Click **Deploy** in Wasmer dashboard
2. Wasmer will:
   - Install Composer dependencies
   - Run `npm install && npm run build` for Vite assets
   - Configure PHP 8.3 runtime
   - Start the application

3. Deployment takes ~2-5 minutes

### Step 7: Run Migrations

After first deployment:

1. Go to your app dashboard in Wasmer
2. Open **Console** or **Shell** (if available)
3. Run migrations:
   ```bash
   php artisan migrate --force
   ```

**Note**: If Wasmer doesn't provide a console, you may need to:
- Add a migration command to your deployment process
- Use a one-time startup script
- Check Wasmer docs for automated migration support

### Step 8: Verify Deployment

Your app will be available at:
```
https://your-app-name.wasmer.app
```

Or a custom pattern provided by Wasmer.

Check these endpoints:
- `/` - Home page
- `/papers` - Browse wallpapers/papers catalog
- `/shop` - Shop/storefront
- `/health` - Health check (should return "OK")

### Step 9: Seed Sample Data (Optional)

To populate with sample wallpapers:

```bash
php artisan db:seed
```

Run via Wasmer console/shell if available.

## Architecture on Wasmer Edge

- **PHP 8.3**: Served via Wasmer's WebAssembly runtime
- **Public Directory**: `/app/public` mounted as web root
- **File System**: Application code mounted at `/app`
- **Database**: MySQL (Wasmer add-on) or external PostgreSQL
- **Assets**: Vite-compiled CSS/JS in `public/build`

## Environment Variables Reference

### Auto-Set by Wasmer

```bash
APP_URL=https://your-app.wasmer.app  # Auto-generated
```

### Required (Must Set Manually)

```bash
APP_NAME=MurArt
APP_KEY=base64:...  # Generate this!
APP_ENV=production
APP_DEBUG=false

DB_CONNECTION=mysql  # or pgsql
DB_HOST=...          # From Wasmer add-on or external
DB_PORT=3306         # 3306 for MySQL, 5432 for PostgreSQL
DB_DATABASE=murart
DB_USERNAME=...
DB_PASSWORD=...

CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

### Optional

```bash
# Stripe (for payments)
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...

# Mail (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS=noreply@murart.com
MAIL_FROM_NAME=MurArt
```

## Updating the Application

To deploy updates:

```bash
git add .
git commit -m "Your update message"
git push origin main  # or your deployment branch
```

Wasmer Edge auto-deploys when you push to the connected branch.

## Troubleshooting

### Build Fails

- **Composer errors**: Check that `composer.json` is valid and dependencies are compatible
- **npm errors**: Verify `package.json` and that Vite build succeeds locally
- **Check Wasmer build logs** for specific error messages

### Database Connection Issues

- Verify `DB_CONNECTION` matches your database type (`mysql` or `pgsql`)
- Check that database add-on is active and environment variables are injected
- Ensure database credentials are correct

### 500 Internal Server Error

- Verify `APP_KEY` is set and not empty
- Check that database migrations ran successfully
- Review application logs in Wasmer dashboard
- Ensure storage directories are writable

### Assets Not Loading (CSS/JS)

- Verify Vite build completed successfully in build logs
- Check that `APP_URL` is set correctly
- Ensure `public/build` directory exists
- Check asset paths in browser developer console

### Migrations Not Running

Wasmer may not auto-run migrations. Options:
1. Run manually via Wasmer console: `php artisan migrate --force`
2. Add a post-deploy hook if Wasmer supports it
3. Use a Laravel package for auto-migrations
4. Check Wasmer Edge documentation for deployment hooks

## Performance & Limitations

### Wasmer Edge Free Tier

- ✅ **No credit card required**
- ✅ Free hosting for Laravel applications
- ✅ Automatic builds from GitHub
- ✅ SSL/HTTPS included
- ⚠️ May have resource limits (check Wasmer docs)
- ⚠️ Database storage limits on free tier

### Optimizations

The app includes Laravel optimizations:
- Config caching: `php artisan config:cache`
- Route caching: `php artisan route:cache`
- View caching: `php artisan view:cache`

Run these if Wasmer provides console access.

## MySQL vs PostgreSQL

### Differences for This App

The app is designed for PostgreSQL (`DB_CONNECTION=pgsql`), but works with MySQL with one change:

**Switch to MySQL**:
```bash
DB_CONNECTION=mysql
```

**Laravel handles the rest automatically!** No code changes needed.

### Migration Compatibility

All migrations in `database/migrations/` are compatible with both MySQL and PostgreSQL.

## Security Considerations

- ✅ Set `APP_DEBUG=false` in production
- ✅ Use strong `APP_KEY` (32 random bytes, base64-encoded)
- ✅ Keep database credentials in environment variables (never commit to Git)
- ✅ Use HTTPS (Wasmer provides this automatically)
- ✅ Regularly update dependencies

## Getting Help

### Resources

- **Wasmer Docs**: [wasmer.io/docs](https://wasmer.io/docs)
- **Wasmer Edge Docs**: Check for Laravel-specific deployment guides
- **Laravel Docs**: [laravel.com/docs](https://laravel.com/docs)
- **This Repository**: Open an issue for app-specific questions

### Common Commands

If Wasmer provides console/shell access:

```bash
# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Check application status
php artisan about

# Open Tinker REPL
php artisan tinker
```

---

## Alternative: Render Deployment

If you prefer Render, the included `render.yaml` Blueprint provides one-click deployment:

### Quick Render Deploy

1. Go to [Render Dashboard](https://dashboard.render.com)
2. Click **New** → **Blueprint**
3. Select the MurArt repository
4. Click **Apply** to create services (web + PostgreSQL)
5. Update `APP_URL` to your Render domain

**Render Advantages**:
- ✅ One-click Blueprint deployment
- ✅ Auto-provisions PostgreSQL (matches `.env.example`)
- ✅ Free tier: 750 hours/month
- ✅ Starter plan: $7/service

See `render.yaml` for configuration details.

---

## Alternative: Railway Deployment

If you prefer Railway, the included `railway.toml` provides similar functionality:

### Quick Railway Deploy

1. Install Railway CLI: `npm i -g @railway/cli`
2. Login: `railway login`
3. Initialize: `railway init`
4. Add PostgreSQL: `railway add -d postgres`
5. Deploy: `railway up`
6. Set `APP_KEY` and `APP_URL` in Railway Dashboard

**Railway Advantages**:
- ✅ PostgreSQL support (matches `.env.example`)
- ✅ Great CLI experience
- ✅ Automatic deployments
- ✅ $5/month includes $5 credit

See `railway.toml` for configuration details.

---

## Platform Comparison

| Feature | Wasmer Edge | Render | Railway |
|---------|-------------|--------|---------|
| **Free Tier** | ✅ Yes, no card | ✅ 750 hrs/mo | ❌ (trial only) |
| **Database** | MySQL/add-on | PostgreSQL | PostgreSQL |
| **Auto-detect Laravel** | ✅ Yes | ⚠️ Via Blueprint | ⚠️ Via config |
| **GitHub Deploy** | ✅ Yes | ✅ Yes | ✅ Yes |
| **SSL/HTTPS** | ✅ Included | ✅ Included | ✅ Included |
| **Shell Access** | Check docs | ✅ Yes | ✅ Yes |
| **Cost (paid)** | TBD | $14/mo | $8-15/mo |

**Recommendation**: Try Wasmer Edge first (free, no card). If you need PostgreSQL or more features, consider Render or Railway.
