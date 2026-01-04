### index — Liste des profils
```
curl -X GET "http://127.0.0.1:8000/api/profils" \
  -H "Accept: application/json"
```
### store
```
curl -X POST "http://127.0.0.1:8000/api/profils" \
  -H "Accept: application/json" \
  -F "name=Max" \
  -F "password=secret" \
  -F "image=@./tests/http/images/profils/max.jpg;type=image/jpeg"
```
### show
```
curl -X GET "http://127.0.0.1:8000/api/profils/11111111-1111-1111-1111-111111111111" \
  -H "Accept: application/json"
```
### update — Mettre à jour un profil avec nouvelle image
```
curl -X POST "http://127.0.0.1:8000/api/profils/11111111-1111-1111-1111-111111111111" \
  -H "Accept: application/json" \
  -F "_method=PUT" \
  -F "name=Alice Updated" \
  -F "image=@./tests/http/images/profils/alice_updated.jpg;type=image/jpeg"
  ```

### destroy — Supprimer un profil (supprime aussi l’image)
```
curl -X DELETE "http://127.0.0.1:8000/api/profils/11111111-1111-1111-1111-111111111111" \
  -H "Accept: application/json"
```