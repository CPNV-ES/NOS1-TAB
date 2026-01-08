### index — Liste des posts d’un profil
```
curl -X GET "http://127.0.0.1:8000/api/profils/11111111-1111-1111-1111-111111111111/posts" \
  -H "Accept: application/json"
```

### store — Créer un post avec image
```
curl -X POST "http://127.0.0.1:8000/api/profils/11111111-1111-1111-1111-111111111111/posts" \
  -H "Accept: application/json" \
  -F "description=Ceci est un post de Alice" \
  -F "image=@./tests/http/images/posts/cypher.jpg;type=image/jpeg"
```
### show — Afficher un post
```
curl -X GET "http://127.0.0.1:8000/api/profils/11111111-1111-1111-1111-111111111111/posts/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa" \
  -H "Accept: application/json"
```
### update — Mettre à jour un post avec nouvelle image
```
curl -X POST "http://127.0.0.1:8000/api/profils/11111111-1111-1111-1111-111111111111/posts/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa" \
  -H "Accept: application/json" \
  -F "_method=PUT" \
  -F "description=Updated paris" \
  -F "image=@./tests/http/images/posts/paris.jpg;type=image/jpeg"
```
### destroy — Supprimer un post (supprime aussi l’image)
```
curl -X DELETE "http://127.0.0.1:8000/api/profils/11111111-1111-1111-1111-111111111111/posts/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa" \
  -H "Accept: application/json"
```