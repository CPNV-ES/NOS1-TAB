# NOS1-TAB

## Configurer Neo4j
1. run instance
2. clique sur les trois petits points
3. open -> neo4j.conf
4. ajouter ces lignes en ligne 100
```
dbms.default_listen_address=0.0.0.0
dbms.connector.bolt.enabled=true
dbms.connector.bolt.listen_address=:7687
```
### test
 `ipconfig` sur powershell, tu as :
Carte Ethernet vEthernet (WSL (Hyper-V firewall)) Adresse IPv4 : your address
**C’est cette IP que WSL utilise pour joindre Windows**
Dans WSL:
```
nc -zv [your address] 7687
```
Connection to [your address] 7687 port [tcp/*] succeeded!
# configurer Laravel

### ce mettre à la racine
```
cd NOS1-TAB/DuckDuckAPI
```

```
composer require laudis/neo4j-php-client
```
### .env
```
cp .env.example .env
```
modifié:
```
DB_CONNECTION=none

NEO4J_SCHEME=bolt
NEO4J_HOST= #[your adresse] si WSL sinon localhost
NEO4J_PORT=7687
NEO4J_USERNAME=neo4j
NEO4J_DATABASE=neo4j
NEO4J_PASSWORD= #[your password]
```

```
php artisan migrate
```
### Recharge la config
```
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
```
### Test connection à neo4j
```
php artisan tinker
```
```
collect(app('neo4j')->run('RETURN 1 AS test')->toArray())->map->toArray();
```
retourn 
```
= Illuminate\Support\Collection {#5339
    all: [
      [
        "test" => 1,
      ],
    ],
  }
```
# images
créer et mettre les images de test/http/image dans:
```
storage/app/public/
```
Puis tu crées un lien symbolique vers : public/storage avec:
```
php artisan storage:link
```
