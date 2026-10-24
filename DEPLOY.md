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
   - `DB_NAME` ⚠️ (Wasmer injects this, but Laravel reads `DB_DATABASE`)
   - `DB_USERNAME`
   - `DB_PASSWORD`

**⚠️ IMPORTANT - Database Name Variable**: Wasmer injects `DB_NAME`, but Laravel reads `DB_DATABASE`. You must **manually add** `DB_DATABASE` environment variable:

```bash
DB_DATABASE=${DB_NAME}  # Copy the value from DB_NAME
# Or set it to the same database name directly:
DB_DATABASE=murart
```

Without this mapping, Laravel won't find your database and migrations will fail.

#### Option B: External Database

Use a free external PostgreSQL database:
- [Neon](https://neon.tech) (free tier, PostgreSQL)
- [Supabase](https://supabase.com) (free tier, PostgreSQL)
- [ElephantSQL](https://www.elephantsql.com) (free tier, PostgreSQL)

Add the connection details manually in Wasmer environment variables.

### Step 4: Configure Environment Variables

Add these in the Wasmer Edge dashboard under **Settings** → **Environment Variables**:

#### ⚠️ CRITICAL: APP_KEY Required

**You MUST set APP_KEY before deploying** or the app will fail with encryption errors.

Generate APP_KEY locally:
```bash
php -r "echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
```

Example output:
```
base64:XvK8jNW5rM3pQ7sT9wZ2bC4dE6fG7hJ8iK9lM0nO1pQ=
```

Or if you have PHP/Laravel CLI access:
```bash
php artisan key:generate --show
```

**⚠️ Never commit APP_KEY to Git** - only set it in Wasmer environment variables.

#### Required Variables

```bash
# Application (REQUIRED!)
APP_NAME=MurArt
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_GENERATED_KEY_HERE  # CRITICAL - Generate this first!

# Important: APP_URL will be auto-set by Wasmer
# Format: https://your-app.wasmer.app

# Database - Choose MySQL OR PostgreSQL based on your setup
DB_CONNECTION=mysql  # or 'pgsql' for PostgreSQL

# IMPORTANT: Wasmer injects DB_NAME, but Laravel reads DB_DATABASE
# You MUST manually set DB_DATABASE to the same value as DB_NAME
DB_DATABASE=murart  # Set to match your Wasmer DB_NAME value

# DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD
# (auto-injected by Wasmer database add-on)

# Cache, Session, Queue
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
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

### Step 6: Deploy and Configure Non-Interactive Migrations

**CRITICAL**: Wasmer's Anybuild always injects `after_deploy: php artisan migrate` (without `--force`), which hangs on production's "Are you sure? (yes/no)" prompt.

#### How Wasmer Anybuild Actually Works

Wasmer Anybuild for Laravel:
1. Detects Laravel from `composer.json`
2. Runs `composer install --no-scripts --no-interaction` ⚠️ (composer scripts are disabled!)
3. Runs `npm install && npm run build`
4. **Always injects** `after_deploy: php artisan migrate` (no --force)
5. Starts the application

**Problem**: The injected `after_deploy` command prompts "Do you really wish to run this command?" with no TTY, causing deployment to hang.

#### Solution: Override after_deploy in app.yaml

This repository includes an `app.yaml` file that **overrides** Wasmer's default `after_deploy`:

```yaml
after_deploy:
  - php artisan migrate --force --no-interaction
  - php artisan config:cache
  - php artisan route:cache
  - php artisan view:cache
```

**How to Apply**:

1. This `app.yaml` is already in the repository
2. After connecting GitHub, go to **Wasmer Dashboard** → Your App
3. Navigate to **Settings** → **Yaml** (or **Build Configuration**)
4. You should see the `app.yaml` content auto-loaded
5. If not, paste the content from `app.yaml` and save
6. Trigger a new deployment

The `after_deploy` override runs migrations with `--force --no-interaction`, preventing the hang.

#### Emergency Workaround (If Yaml Override Doesn't Work)

If Wasmer still ignores the `app.yaml` override:

**Temporary Fix**: Set environment variable to bypass production prompt:
```bash
APP_ENV=staging  # Laravel only prompts when APP_ENV=production
```

This allows plain `php artisan migrate` to run without prompting. Change back to `APP_ENV=production` after migrations complete.

**Better Fix**: Use Dashboard Start Command (runs migrations before starting):
```bash
php artisan migrate --force --no-interaction && php artisan config:cache && php -S 0.0.0.0:8080 -t public/
```

But note: Wasmer's `after_deploy` may still run separately and hang. The `app.yaml` override is the proper solution.

#### Deploy Steps

1. Click **Deploy** in Wasmer dashboard
2. Wasmer Anybuild will:
   - Detect Laravel application
   - Run `composer install --no-scripts --no-interaction`
   - Run `npm install && npm run build`
   - Execute custom `after_deploy` from `app.yaml` (with --force ✅)
   - Start: `php -S 0.0.0.0:8080 -t public/`

3. Monitor build logs for:
   - ✅ "Running after_deploy"
   - ✅ "php artisan migrate --force --no-interaction"
   - ✅ Migration output showing tables created
   - ❌ NO "Do you really wish to run this command?" prompt

4. Deployment takes ~2-5 minutes

### Step 7: Verify Migrations

After deployment:

1. Visit your app at `https://wallpaper-red-jen.wasmer.app`
2. Should return 200 OK (not HTTP 500)
3. Check endpoints:
   - `/` - Home page
   - `/papers` - Wallpaper catalog
   - `/shop` - Storefront
   - `/health` - Health check

If HTTP 500 errors persist:
- Check Wasmer build logs - did after_deploy run with --force?
- Verify `app.yaml` is loaded in Settings → Yaml
- Try emergency APP_ENV=staging workaround
- Run manually via console: `php artisan migrate --force --no-interaction`

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

### Database Connection Fails

**Symptom**: Migrations fail with:
```
SQLSTATE[HY000] [1049] Unknown database 'murart'
```
or similar "unknown database" error.

**Cause**: Wasmer injects `DB_NAME` environment variable, but Laravel reads `DB_DATABASE`.

**Solution**:
1. Go to Wasmer Dashboard → Your App → **Settings** → **Environment Variables**
2. Check if `DB_NAME` exists (injected by Wasmer)
3. Add a new variable: `DB_DATABASE` with the same value as `DB_NAME`
   ```bash
   DB_DATABASE=murart  # Use the same value as DB_NAME
   ```
4. Save and redeploy

**Verification**:
```bash
# Via Wasmer console
php artisan tinker
>>> DB::connection()->getDatabaseName()
=> "murart"  # Should show your database name
```

### Migration Foreign Key Errors

**Symptom**: Migration fails with:
```
SQLSTATE[HY000]: General error: 1824 Failed to open the referenced table 'artworks'
```

**Cause**: Migration tried to create a foreign key before the referenced table exists. This has been **fixed in this repository** by reordering migrations.

**Migration Order (Correct)**:
1. `2025_03_16_063551_artworks.php` - Creates `artworks` table FIRST
2. `2025_03_17_063827_tags.php` - Creates `artwork_tag` pivot with FK to artworks

If you still see this error, ensure you're deploying from the latest commit where migration order is fixed.

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

### Deployment Hangs on Migration Prompt

**Symptom**: Wasmer build logs show:
```
Running after_deploy: php artisan migrate
**************************************
*     Application In Production!     *
**************************************

Do you really wish to run this command? (yes/no) [no]:
```
Then deployment hangs and times out.

**Root Cause**: 
- Wasmer Anybuild **always injects** `after_deploy: php artisan migrate` (without `--force`)
- Laravel prompts for confirmation when `APP_ENV=production`
- No TTY available to provide input
- Deployment hangs indefinitely

**Solution 1: app.yaml Override (PRIMARY)**

Override the injected `after_deploy` command in `app.yaml`:

```yaml
after_deploy:
  - php artisan migrate --force --no-interaction
  - php artisan config:cache
  - php artisan route:cache
  - php artisan view:cache
```

**This repository includes the corrected `app.yaml`.**

To apply:
1. Go to Wasmer Dashboard → Your App → **Settings** → **Yaml**
2. Verify `app.yaml` content is loaded (should show after_deploy with --force)
3. If not auto-loaded, copy from repository and paste
4. Save and redeploy

**Solution 2: Emergency APP_ENV Workaround**

If app.yaml override doesn't work:

Set temporary environment variable:
```bash
APP_ENV=staging  # or local, testing - anything except "production"
```

**Why this works**: Laravel only prompts "Are you sure?" when `APP_ENV=production`. With any other environment, `php artisan migrate` runs without prompting.

**Important**: Change back to `APP_ENV=production` after migrations complete for proper security settings.

**Solution 3: Dashboard Start Command (Partial)**

Set Start Command to run migrations first:
```bash
php artisan migrate --force --no-interaction && php artisan config:cache && php -S 0.0.0.0:8080 -t public/
```

**Note**: This runs migrations before starting the app, but Wasmer's `after_deploy` may still run separately and hang. Use app.yaml override for complete fix.

### HTTP 500 Error - Empty Database

**Symptom**: App loads at https://wallpaper-red-jen.wasmer.app but shows HTTP 500 errors.

**Likely Cause**: Migrations hung and never completed, so database tables don't exist.

**Solution**:
1. Check Wasmer build logs - did migrations hang on yes/no prompt?
2. Apply app.yaml override (Solution 1 above)
3. Or use APP_ENV=staging workaround temporarily
4. Redeploy
5. Or run manually via console:
   ```bash
   php artisan migrate --force --no-interaction
   ```

### Composer Scripts Don't Run

**Fact**: Wasmer runs `composer install --no-scripts --no-interaction`.

This means:
- ❌ `post-install-cmd` in `composer.json` **never runs** on Wasmer
- ❌ `post-update-cmd` doesn't run
- ❌ Any custom composer scripts are disabled

**Why**: Wasmer uses `--no-scripts` flag to prevent arbitrary code execution during build.

**Implication**: Cannot rely on `composer.json` scripts for migrations on Wasmer. Must use `app.yaml` override.

**Note**: The `post-install-cmd` in this repository's `composer.json` is kept for compatibility with other platforms (Render, Railway, local development) but has no effect on Wasmer.

### Migrations Not Running

**Primary Solution**: Override `after_deploy` in `app.yaml`.

If migrations still don't run:
1. Check Wasmer build logs - look for "Running after_deploy"
2. Verify `app.yaml` is recognized (Settings → Yaml)
3. Ensure `APP_KEY` is set (migrations fail without it)
4. Verify database connection (check `DB_*` environment variables)
5. Check for migration errors in logs
6. Run manually via console: `php artisan migrate --force --no-interaction`

### Anybuild Behavior (Actual)

**What Wasmer Anybuild Actually Does**:
1. Auto-detects Laravel from `composer.json`
2. Runs `composer install --no-dev --optimize-autoloader --no-scripts --no-interaction`
3. Runs `npm install && npm run build` (if package.json exists)
4. **Injects and runs** `after_deploy: php artisan migrate` ⚠️ (no --force)
5. Starts application with configured start command

**Files That Wasmer Respects**:
- ✅ `app.yaml` - **PRIMARY CONFIG** - Settings → Yaml in dashboard
- ✅ `package.json` - npm dependencies and build scripts
- ✅ `composer.json` - PHP dependencies (but scripts are disabled with --no-scripts)
- ⚠️ `Procfile` - May work but not confirmed for Wasmer
- ⚠️ `wasmer.toml` - Basic package definition only

**Files That DON'T Work on Wasmer**:
- ❌ `composer.json` scripts (disabled with --no-scripts flag)
- ❌ Custom deployment hooks in wasmer.toml (unsupported keys)

**The Fix**: Override `after_deploy` in `app.yaml` to add `--force --no-interaction` flags.

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
