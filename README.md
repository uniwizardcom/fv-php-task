
## Uruchomienie aplikacji
Aplikacja posiada konfigurację obrazów dockerowych 
```
# zbudowanie obrazu i uruchomienie kontenera aplikacji
docker-compose up -d

# lista uruchomionych kontenerów, na liście jest CONTAINER ID
docker ps

# wejście do bash kontenera 
docker exec -it {CONTAINER ID} bash
```

### Testy
```
bin/phpunit tests/Unit/
```