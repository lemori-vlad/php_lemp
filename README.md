# How to start

## DEV

### Configure the project first (optional)
cp .env.local.example .env

### Build and run containers
docker compose up -d

### Build and force recreate containers
> In case if you changed containers/

docker compose up -d --build

### Stop container
docker compose down
### Stop container and destroy the data (optional)
> Warning: All named volumes including database data will be destroyed!

docker compose down -v

### Run migrations and seed the database (optional)
php artisan migrate --seed


## PROD
