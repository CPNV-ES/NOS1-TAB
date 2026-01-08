### GET friends of a profil
```
curl -X GET "http://127.0.0.1:8000/api/profils/11111111-1111-1111-1111-111111111111/friends" \
  -H "Accept: application/json"
```
### ADD friend
```
curl -X POST "http://127.0.0.1:8000/api/profils/22222222-2222-2222-2222-222222222222/friends/11111111-1111-1111-1111-111111111111" \
  -H "Accept: application/json"
```
### REMOVE friend
```
curl -X DELETE "http://127.0.0.1:8000/api/profils/22222222-2222-2222-2222-222222222222/friends/11111111-1111-1111-1111-111111111111" \
  -H "Accept: application/json"
```