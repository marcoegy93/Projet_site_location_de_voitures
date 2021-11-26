<div align="center">
    <h3>PROJET PWEB</h3>
    <h4>Application web de gestion de location de véhicules</h4>
</div>
</br>

## Objectif du projet

L'objectif est de développer une application web basé sur une architecture MVC.
Nous avons choisi d'utiliser le framework [Symfony](https://symfony.com/).

## Fonctionnalités disponibles

#### Fonctionnalités principales

- Connexion / Inscription (non obligatoire)
- Visualisation des véhicules disponibles
- Réserver une location si l'utilisateur est connecté
- Selection date de début et date fin de location (non obligatoire) lors d'une location
- Réduction de 10% sur la facture si le nombre de véhicules dans la flotte est > 10
- Réduction de 10% sur la facture si le nombre de jours de location est strictement spérieur à 35
- Visualisation du panier de l'utilisateur connecté
- Possibilité d'annuler la pré-réservation (l'utilisateur n'a pas validé sa commande)

### Espace utilisateur

Chaque utilisateur à un espace utilisateur dédié

- Client (Entreprise)

  - tableau de bord (visualisation des statistiques)

    - Nombre de véhicules loués
    - Nombre de véhicules non payés
    - Nombre de véhicule retournés
    - Côut total de toutes les locations effectuées

  - Visualisation des véhicules loués (payées, non payées)
  - Visualisation des facturations effectuées
    </br>

- Loueur

  - Tableau (visualisation des statistiques)

    - Nombre de véhicule loués
    - Nombre de véhicule non payés
    - Nombre de véhicule rendu
    - Côut total de toutes les locations effectuées

  - Visualisation des véhicules loués lui appartenant (payées, non payées)
  - Modifier / Supprimer un véhicule
  - Visualiser les véhicules loués par client
  - Ajouter un véhicule
  - Visualisation des facturations effectuées par nos clients
    </br>

## Installation

### Pré-requis

- PHP >= 7.4
- Composer
- Symfony CLI
- Serveur MySQL
-Symfony version : 4.4

Pour créer un projet, on fait :
    symfony new <\nom du projet\> --version=4.4 --full

Cloner le repository

```
git clone --single-branch -b master https://github.com/marcoegy93/Projet_site_location_de_voitures
```

Installer les dépendances nécessaires du projet

```
composer install
```

Configurer la connexion à la base de données dans le fichier `.env`

```
DATABASE_URL='mysql://<user><password>:@127.0.0.1:3306/<database>'
```

Remplacer :

- `<user>` par votre nom utilisateur
- `<password>` par votre mot de passe
- `<database>` par le nom de votre base de données

Créer la base de données

```
php bin/console d:d:c --if-not-exists
```

Importer le fichier `db.sql` dans votre base de données sur le serveur MySQL

Lancer l'application web

```
symfony server:start
```

Copier les différents dossier après :b4
-bin
-config
-migrations
-public
-templates
-tests
-translations
-var
-vendor

Vous pouvre profiter du site web !
Si besoin arrêtez le server :
```
symfony server:stop
```

et redémarrer le :

```
symfony server:start
```

Profils utilisateurs disponibles

| Nom               | Adresse email             | Mot de passe | Rôle       |
| ------------------| --------------------------| ------------ | ---------- |
| Balamon Marco     | marco.balamon@gmail.com   | Azerty123    | LOUEUR     |
| Saavedra Arthur   | cisco@gmail.com           | Azerty123    | CLIENT     |
| sivanand Nirussan | Niru@gmail.com            | sivanand     | CLIENT     |
| Zaher Lyamine     |   zaher93@gmail.com       | 123Viva      | CLIENT     |
| Dem Cherif        |   cherif@gmail.com        | bgDeStates   | CLIENT     |

## Crédits

**Développé par Marco Balamon, Arthur Saavedra, Abdeldjalel Chihab**

## License

MIT © [Marco Balamon](https://github.com/marcoegy93)
<div align="center">
    <h3>PROJET PWEB</h3>
    <h4>Application web de gestion de location de véhicules</h4>
</div>
</br>

