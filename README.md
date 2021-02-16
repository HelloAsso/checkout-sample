L'URL transactionnelle aussi appelée prefill ou api de paiement permet aux partenaires d'utiliser HelloAsso comme solution de paiement simple.
Cela nécessite que le partenaire gère de son côté la partie "panier".

Cette utilisation est réservée aux partenaires ayant pris contact avec notre équipe commerciale, qui se chargera d'initier le setup en interne et de communiquer la documentation.

# Fonctionnement
Ce repo contient un site d'exemple PHP permettant de réaliser un paiement via le formulaire prefill puis de revenir sur le site initial.

La page principale représente un panier prérempli et personnalisable, un formulaire de saisie de coordonnées et un récapitulatif. Il peut être intégré très facilement avec un minimum de personnalisation.

Très concrètement cela donne ce fonctionnement:

![alt text](https://github.com/HelloAsso/prefill-sample/blob/main/doc/demo.gif?raw=true)

Il est organisé selon le pattern MVC et utilise [AltoRouter](https://altorouter.com/) pour le routage des requêtes. Les échanges avec HelloAsso se font au travers d'un service qui prend la forme d'un wrapper d'API.

L'arborescence du projet est la suivante:
```c
📦prefill-sample
 ┣ 📂Controllers
 ┃ ┗ 📜FormController.php      // Récupère les données du formulaire pour les passer au wrapper de l'api
 ┣ 📂Models
 ┃ ┗ 📜FormViewModel.php       // Transporte les données entre la vue et le contrôleur
 ┣ 📂Services
 ┃ ┗ 📜HelloAssoApiWrapper.php // Récupère le lien vers le formulaire de paiement via l'API HelloAsso
 ┣ 📂Views
 ┃ ┣ 📜error.phtml             // Page statique s'affichant en cas d'erreur
 ┃ ┣ 📜form.phtml              // Page principale affichant le panier et le formulaire de coordonnées
 ┃ ┗ 📜success.phtml           // Page statique s'affichant après la validation du paiement
 ┣ 📂css
 ┃ ┗ 📜main.css
 ┣ 📂images
 ┃ ┣ 📜beer.jpg
 ┃ ┣ 📜chocolate.jpg
 ┃ ┗ 📜tree.jpg
 ┣ 📂js
 ┃ ┣ 📜address.js
 ┃ ┗ 📜form.js
 ┣ 📜Config.php                // À modifier selon votre environnement
 ┣ 📜composer.json
 ┗ 📜index.php
```

# Configuration
L'ensemble de la configuration se fait dans le fichier `Config.php`.
```c 
public $partnerId = "";                               // Votre id partenaire (fournit par HelloAsso)
public $formUrl = "";                                 // Url de votre formulaire de paiement
public $successUrl = "http://localhost:3000/success"; // A modifier en production
public $errorUrl = "http://localhost:3000/error";     // A modifier en production
```

# Déploiement
Ce site nécessite d'avoir un environnement PHP ainsi que [composer](https://getcomposer.org/) pour gérer les dépendances.

Avant de tester ou déployer ce site, il faut donc récupérer les dépendances:

`composer install`

Pour tester en local il est possible d'utiliser [Visual Studio Code](https://code.visualstudio.com/) et l'extension [PHP Server](https://marketplace.visualstudio.com/items?itemName=brapifra.phpserver)

Pour une utilisation en production, il suffit de copier l'intégralité du dossier sur votre serveur