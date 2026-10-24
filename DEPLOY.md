# Deploying MurArt to Railway

This guide explains how to deploy the MurArt Laravel wallpaper ecommerce application to Railway with PostgreSQL.

## Prerequisites

- A [Railway](https://railway.app) account
- Railway CLI installed (optional, for local testing)

## Quick Deploy

### Step 1: Connect Your Repository

1. Go to [Railway Dashboard](https://railway.app/dashboard)
2. Click **New Project**
3. Choose **Deploy from GitHub repo**
4. Select your MurArt repository
5. Railway will automatically detect the Dockerfile and build configuration

### Step 2: Add PostgreSQL Database

1. In your Railway project, click **New** → **Database** → **Add PostgreSQL**
2. Railway will automatically provision a PostgreSQL database and inject the `DATABASE_URL` environment variable

### Step 3: Configure Environment Variables

Add the following environment variables in your Railway project settings:

#### Required Variables

```bash
# Application
APP_NAME=MurArt
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app  # Update after deployment

# Generate a secure key (32 characters)
APP_KEY=base64:YOUR_GENERATED_KEY_HERE

# Database (Railway automatically provides DATABASE_URL)
# Laravel will parse it automatically, but you can also set these:
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}

# Cache, Session, Queue (using database)
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

#### Optional Variables

```bash
# Stripe (if using payment features)
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key

# Mail (configure if you need email)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@murart.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 4: Generate Application Key

If you don't have an `APP_KEY`, generate one:

**Option A: Using Railway CLI**
```bash
railway run php artisan key:generate --show
```

**Option B: Using PHP locally**
```bash
php -r "echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
```

Copy the generated key and add it to Railway's `APP_KEY` environment variable.

### Step 5: Deploy

1. Railway will automatically deploy when you push to your main branch
2. The deployment includes:
   - Building frontend assets with Vite
   - Installing PHP dependencies
   - Running database migrations
   - Caching config, routes, and views
   - Starting PHP-FPM, Nginx, and queue workers

### Step 6: Verify Deployment

1. Once deployed, Railway will provide a public URL (e.g., `https://your-app.railway.app`)
2. Visit the URL to see your application
3. Check these endpoints:
   - `/` - Home page
   - `/papers` - Browse wallpapers/papers
   - `/shop` - Shop/catalog

### Step 7: Seed Sample Data (Optional)

To populate your database with sample data:

```bash
# Using Railway CLI
railway run php artisan db:seed
```

Or add a one-time startup command in Railway's settings.

## Architecture

### Services

The deployment runs the following services:
- **Nginx**: Web server (port 8080)
- **PHP-FPM**: PHP application server
- **Laravel Queue Worker**: Background job processing
- **PostgreSQL**: Database (managed by Railway)

### Build Process

1. **Frontend Build Stage**: Compiles Vite assets (CSS, JS)
2. **Production Stage**: Installs PHP dependencies and serves the application

### Health Checks

The application includes a `/health` endpoint for Railway's health monitoring.

## Troubleshooting

### Build Fails

- Check that `composer.json` and `package.json` are valid
- Verify Dockerfile paths are correct
- Check Railway build logs for specific errors

### Database Connection Issues

- Ensure PostgreSQL service is added to your Railway project
- Verify `DATABASE_URL` is available in environment variables
- Check that `DB_CONNECTION=pgsql` is set

### 500 Errors

- Check that `APP_KEY` is set
- Verify database migrations ran successfully
- Check Railway logs: `railway logs`

### Assets Not Loading

- Verify Vite build completed successfully
- Check that `APP_URL` matches your Railway domain
- Ensure `public/build` directory exists after build

## Updating the Application

To deploy updates:

```bash
git add .
git commit -m "Your update message"
git push origin main
```

Railway will automatically rebuild and redeploy.

## Railway CLI Commands

Install Railway CLI: `npm i -g @railway/cli` or `brew install railway`

```bash
# Link to your project
railway link

# Run commands in Railway environment
railway run php artisan migrate
railway run php artisan db:seed
railway run php artisan tinker

# View logs
railway logs

# Open project dashboard
railway open
```

## Database Management

### Running Migrations

Migrations run automatically on each deployment via the `startCommand` in `railway.toml`.

To run migrations manually:
```bash
railway run php artisan migrate --force
```

### Backup Database

Use Railway's PostgreSQL backup features or:
```bash
railway run pg_dump > backup.sql
```

## Security Notes

- Never commit `.env` files with secrets
- Use Railway's environment variables for all sensitive configuration
- Keep `APP_DEBUG=false` in production
- Regularly update dependencies: `composer update` and `npm update`

## Support

For issues specific to:
- **Railway**: Check [Railway Docs](https://docs.railway.app)
- **Laravel**: Check [Laravel Docs](https://laravel.com/docs)
- **This App**: Open an issue in the repository

## Cost Estimate

Railway pricing (as of 2026):
- **Starter Plan**: $5/month includes $5 credit
- **Developer Plan**: $20/month includes $20 credit
- Estimated usage: ~$8-15/month for small to medium traffic

Resources used:
- 1 Web service (Docker container)
- 1 PostgreSQL database
- Outbound data transfer
