1. Matching request methods and paths to a specific route;
2. Handling all the errors we currently do;
3. Allowing named parameters in routes;
4. Build URLS from named routes and arguments;


# Whoosh website

To run the local development server, try:

```
export PHP_ENV=prod && php -S 127.0.0.1:8000 -t .
```

To make requests with cURL, try:

```
curl -X DELETE http://127.0.0.1:8000/old-home
```
