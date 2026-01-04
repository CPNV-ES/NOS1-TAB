### GET comments of a post
```
curl -X GET "http://127.0.0.1:8000/api/posts/cccccccc-cccc-cccc-cccc-cccccccccccc/comments" \
  -H "Accept: application/json"
```
### ADD comment
```
curl -X POST "http://127.0.0.1:8000/api/posts/cccccccc-cccc-cccc-cccc-cccccccccccc/comments" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "from_id": "22222222-2222-2222-2222-222222222222",
    "text": "Test comment envoyé par Bob"
  }'
```
### DELETE comment
```
curl -X DELETE "http://127.0.0.1:8000/api/posts/cccccccc-cccc-cccc-cccc-cccccccccccc/comments/c018" \
  -H "Accept: application/json"
```


