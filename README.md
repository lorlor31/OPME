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


On a les mêmes routes pour chaque entité : Textiles, Embroideries, Customers,Users, Products,Contracts

Exemple avec Contracts

| URL | HTTP Method | Controller  | Content | Comments |
|--|--|--|--|--|--|
| `/api/contracts/` | `GET` | `ContractController` | `index` | liste des contracts|
| `/api/contracts/{id}` | `GET` | `ContractController` |`show`| voir un contract depuis son id | id=integer |
| `/api/contracts/delete/{id}` | `GET` | `ContractController` |`delete`| effacer un contract depuis son id |id=integer |
| `/api/contracts/create` | `POST` | `ContractController` |`create`| créer un nouveau contract|
| `/api/contracts/edit/{id}` | `GET` | `ContractController` |`edit`| voir les infos du contract à modifier|id=integer |
| `/api/contracts/update/{id}` | `PUT` | `ContractController` |`update`| envoyer les infos du contract à modifier|id=integer |
| `/api/contracts/type/{type}` | `GET` | `ContractController` || afficher que les contracts de type quotation/invoice ou order|type=quotation/invoice/ order|
| `/api/contracts/customer/{name}` | `GET` | `ContractController` || afficher que les contracts du client {name}|name=string|
| `api/contracts/{id}/viewpdf` | `GET` | `ContractController` || afficher la prévisualisation du pdf du contrat n°=id|id=integer|
| `api/contracts/{id}/renderpdf?path={path_to_the_local_folder}` | `GET` | `ContractController` || enregistrer le pdf dans le dossier {path} |path=/home/user par exemple|

### Exemple de JSON  

- Contract :  

``` json

{
    "id": 1,
    "type": "quotation",
    "ordered_at": "2024-03-20T00:00:00+00:00",
    "invoiced_at": "2024-03-22T00:00:00+00:00",
    "delivery_address": "65 chemin de ruine",
    "status": "deleted",
    "comment": "Je veux un chiot dessiné sur la casquette",
    "user": 1,
    "customer": 1
    "products": [
        1,2,3
    ]
}

```
