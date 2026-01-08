# NOS1‑TAB
This API is used by the mobile application of this project:
https://github.com/CPNV-ES/GUI2-TAB

# Laravel API Setup
```bash
git clone git@github.com:CPNV-ES/NOS1-TAB.git
```

Move to the project root
```bash
cd NOS1-TAB/DuckDuckAPI
```

Environment file
```bash
cp .env.example .env
```

Edit the following values:
```bash
NEO4J_SCHEME=bolt
NEO4J_HOST= #[your address]
NEO4J_PORT=7687
NEO4J_USERNAME=neo4j
NEO4J_DATABASE=neo4j
NEO4J_PASSWORD= #[your password]
```

Install dependencies:
```bash
composer install
```

Generate the application key:
```bash
php artisan key:generate
```

## Images
Create the storage directory:
```bash
mkdir storage/app/public/
```
> **ℹ️ Important**
> 
>Copy the profil and post image folders from tests/http/image into:
storage/app/public/

Create the symbolic link to public/storage:
```bash
php artisan storage:link
```

Reload configuration
```bash
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
```

## Neo4j Setup
- Start your Neo4j instance
- Click the three dots
- Open → neo4j.conf
- Add the following lines around line 100:
```bash
dbms.default_listen_address=0.0.0.0
dbms.connector.bolt.enabled=true
dbms.connector.bolt.listen_address=:7687
```
> **ℹ️ Important**
>
>Then run the script tests/http/inserts.cypher inside Neo4j to insert test data.

## Test the Neo4j Connection
```bash
php artisan tinker
```
```bash
collect(app('neo4j')->run('RETURN 1 AS test')->toArray())->map->toArray();
```

Expected output:
```bash
= Illuminate\Support\Collection {
    all: [
      [
        "test" => 1,
      ],
    ],
  }
```


## Test Requests to Neo4j
> **ℹ️ Info**
>  
>All test curl commands are available in tests/http/.

Start the server:
```bash
php artisan serve
```

Example request:
```bash
curl -X GET "http://127.0.0.1:8000/api/profils/11111111-1111-1111-1111-111111111111" \
  -H "Accept: application/json"
```
Example response:
```bash
{
    "id": "11111111-1111-1111-1111-111111111111",
    "name": "Alice",
    "image_url": "http://10.0.2.2:8000/storage/profils/alice.jpg",
    "hash": "$2y$12$abcdefghijklmnopqrstuv",
    "created_at": "2024-10-01T00:00:00.000Z",
    "updated_at": "2024-10-01T00:00:00.000Z"
}
```