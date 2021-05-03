# Api-symfony

This is a Rest Api using Symfony 5, FOSRest and JMSSerializer. It is just a sample code.

Therefore I did commit the .env so you can try it out locally too (root/no password). I made also some fixtures =)

Most of the configuration are default.

# Install

``` git clone ```

``` cd api-symfony ```

``` composer install ```

``` php bin/console doctrine:database:create ```

``` php bin/console doctrine:migrations:migrate ```

``` php bin/console doctrine:fixtures:load ```

# Routes + json sample

- GET /articles/4

- GET /articles?order=desc&limit=2&keyword=art

- POST /articles


```json
{
  "title": "New article ",
  "content": "Content of my new article.",
  "date_published": "2020-04-12T21:22:20P"
}
```

- PUT /articles/4

```json
{
    "title": "Update article",
    "content": "Updated article content",
    "date_published": "1980-01-01T12:34:56P",
    "tags": [
        {
            "id": 2
        },
        {
            "id": 4,
            "name": "Tag renamed"
        },
        {
            "name": "Tag 10"
        }
    ]
}
```
- DELETE /articles/4
