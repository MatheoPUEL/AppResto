# RestoAPP

## **Description du projet**  
RestoAPP est une application web destinée aux clients d’un restaurant. Elle leur permet de consulter le menu et de passer une commande.  
Une fois la commande prête, le client est notifié et peut venir la récupérer au comptoir.  
L’application est responsive afin d’être utilisable facilement sur smartphone.

### **Fonctionnalités principales**  
- Les clients peuvent passer une commande et choisir entre une consommation **sur place** ou **à emporter**.  
- Le paiement s’effectue en ligne.  
- Le client reçoit un email lorsque la commande est prête.  
- Une inscription préalable sur le site est obligatoire.  
- Les administrateurs peuvent valider ou refuser les commandes.

Ce projet a été réalisé dans le cadre d’un **projet de classe de 2SIO, option SLAM** (Solutions Logicielles et Applications Métiers).

---

## **Procédure d'installation**  

| **Étape**              | **Action à réaliser**                                                                 |
|------------------------|---------------------------------------------------------------------------------------|
| **Cloner le dépôt**    | `https://github.com/MatheoPUEL/RestoWeb.git`                                          |
| **Lancer les serveurs**| Démarrer les services **Apache** et **MySQL**                                         |
| **Importer la base**   | Importer le fichier `.sql` disponible dans la documentation via l’interface PHPMyAdmin |
| **Accéder au site**    | Ouvrir [https://localhost/](https://localhost/) dans un navigateur                    |

Si toutes les étapes sont correctement réalisées, vous aurez accès au site **RestoWeb**.

---

## **Structure du projet**

```plaintext
Site
├── index.php
├── deconnexion.php
├── inscription.php
├── commande.php
├── connexion.php
├── carte.php
├── validation.php
├── sectionUtil.php
├── paiement.php
├── css
│   ├── main.css
│   ├── panier.css
│   ├── collapse.css
│   ├── paiement.css
├── image
│   ├── homepage.webp
│   ├── shopping-cart.png
│   ├── logo.png
│   ├── value-proposition.png
│   ├── vegetables.png
│   ├── restaurant.png
│   ├── entrecote.jpg
│   ├── cotedeboeuf.jpg
│   ├── vivelaviande.jpg
├── inc
│   ├── nav.inc.php
│   ├── head.inc.php
├── function
│   ├── removeItemPanier.php
│   ├── addPanier.php
│   ├── db_function.php
│   ├── pushCommande.php
└── classes
    └── panier.classes.php
Documents
├── DCU et DPC
│   ├── Diagramme d'activité du processus de commande.drawio.png
│   ├── Diagramme des Cas d'Utilisations AppResto.drawio.png
├── IHM
├── MCD et MLD
│   └── AppResto.loo
├── MPD et BDD-AppResto
│   └── AppResto.sql
└── SiteMap
    ├── SiteMapRestoApp.drawio
    └── SiteMapRestoApp.png
```
---

## **Comptes de connexion par défaut**  

| **Rôle**       | **Identifiant** | **Mot de passe** | **Email**             |
|----------------|-----------------|------------------|-----------------------|
| Utilisateur 1  | user1           | user123456!            | user1@restoweb.com    |
| Utilisateur 2  | user2           | user23456!            | user2@restoweb.com    |

---

## **Technologies utilisées**  

| **Technologie / Outil** | **Utilisation**                                                 |
|------------------------|-----------------------------------------------------------------|
| HTML, CSS, JavaScript  | Structure, style et interactivité du site web                   |
| PHP                    | Back-end et gestion des interactions avec la base de données   |
| MySQL                  | Gestion des données et des utilisateurs                         |
| PHPMyAdmin             | Interface pour la gestion de la base de données                 |
| Balsamiq               | Création des maquettes d’interface utilisateur                  |
| Looping MCD            | Modélisation du modèle conceptuel de données (MCD)             |
| Visual Studio Code     | Environnement de développement                                  |

---

## **Informations supplémentaires**  

- **Projet réalisé pour l’année 2025-2026**  
- **Équipe** :  
  - Truwant Gaëtan  
  - Puel Mathéo  
  - Ramia Noa  
  - Martin Noah  
