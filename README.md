## Pour avoir les données du back en local

TO COMPLETE

1. **Cloner** le repo

2. Installer **composer** et ses dépendances

` composer install `

3. Configurer le **.env** ( copier le fichier en .env.local et remplacer dans DATABASE_URL par ses identifiants BDD)

4. Créer la **BDD**, appliquer les migrations et exécuter les fixtures s'il y en a

```shell

- bin/console doctrine:database:create
- bin/console doctrine:migrations:migrate
- bin/console doctrine:fixtures:load

```

## Routes = endpoints de l'API'

NBpour s'aider pour le back , faire ce tableau (adapter si besoin)mais pour la doc de l'API ne pas tout mettre, mettre juste le endpoints et ce à quoi il mène et un exemple

### Pour la création des routes du back

On a les mêmes routes pour chaque entité : Textiles, Embroideries, Customers,Users, Products,Contracts
Exemple avec Textiles

| URL | HTTP Method | Controller | Method | Content |  
|--|--|--|--|--|
| `/api/textiles/` | `GET` | `TextileController` | `index` | liste des textiles|
| `/api/textiles/id=integer` | `GET` | `TextileController` |`show`| voir un textile depuis son id |
| `/api/textiles/delete/id=integer` | `GET` | `TextileController` |`delete`| effacer un textile depuis son id |
| `/api/textiles/create` | `GET` | `TextileController` |`create`| créer un nouveau textile|
| `/api/textiles/edit/id=integer` | `GET` | `TextileController` |`edit`| voir les infos du textile à modifier|
| `/api/textiles/update/id=integer` | `PUT` | `TextileController` |`update`| envoyer les infos du textile à modifier|

### Pour la doc de l'API

| Endpoint | Content | Examples|  
|--|--|--|
| `/api/contracts/` |all the contracts | /api/contracts/|
| `/api/contracts/id=integer`  | contracts with id 1| /api/contracts/1|  
| `/api/contracts/delete/id=integer`  | contracts with id 1| /api/contracts/delete/1|  
| `/api/contracts/create/id=integer`  | contracts with id 1| /api/contracts/create/1|

### Exemples de JSON  

- Contract show :  

``` json

{
    "id": 1,
    "type": "quotation",
    "ordered_at": "2024-03-20T00:00:00+00:00",
    "invoiced_at": "2024-03-22T00:00:00+00:00",
    "delivery_address": "65 chemin de ruine",
    "status": "deleted",
    "comment": "Je veux un chiot dessiné sur la casquette",
    "created_at": "2024-03-25T22:47:42+00:00",
    "updated_at": null,
    "user": {
        "id": 1,
        "pseudo": "user",
        "roles": [
            "ROLE_USER"
        ],
        "password": "$2y$13$TCgsTs1oXrivRNbt9FCLUO2JYeepdfm0AVmhB1ClVFA9xYltZmicy",
        "created_at": "2024-03-23T06:22:01+00:00",
        "updated_at": null
    },
    "customer": {
        "id": 5,
        "name": "Eva Adroite",
        "address": "21 rue de la noix",
        "email": "theophile@free.fr",
        "contact": "Mrs Chen",
        "phone_number": "0952345423",
        "created_at": "2024-03-24T04:11:07+00:00",
        "updated_at": null
    },
    "products": [
        {
            "id": 11,
            "name": "debarderur shirt fleuri paillettes",
            "quantity": 67,
            "price": "91.099",
            "delivery_at": null,
            "manufacturing_delay": 6,
            "product_order": 2,
            "comment": "très fragile",
            "created_at": "2024-03-29T09:32:43+00:00",
            "updated_at": null,
            "embroidery": []
        }
    ]
}

```

- Contract format on edit endpoint:
  
``` json
{
    "id": 1,
    "type": "quotation",
    "ordered_at": "2024-03-20T00:00:00+00:00",
    "invoiced_at": "2024-03-22T00:00:00+00:00",
    "delivery_address": "65 chemin de ruine",
    "status": "deleted",
    "comment": "Je veux un chiot dessiné sur la casquette",
    "created_at": "2024-03-25T22:47:42+00:00",
    "updated_at": null,
    "user": {
        "id": 1
    },
    "customer": {
        "id": 5
    },
    "products": [
        {
            "id": 11
        }
    ]
}
```  

- Contract format on update endpoint:
  
``` json

```  
- Format to send via edit routes

```
{
    "id": 1,
    "type": "quotation",
    "ordered_at": "2024-03-20T00:00:00+00:00",
    "invoiced_at": "2024-03-22T00:00:00+00:00",
    "delivery_address": "65 chemin de ruine",
    "status": "deleted",
    "comment": "Je veux un chiot dessiné sur la casquette",
    "created_at": "2024-03-25T22:47:42+00:00",
    "updated_at": null,
    "user": {
        "id": 1
    },
    "customer": 1,
    "products":[1 ,2]
}
```