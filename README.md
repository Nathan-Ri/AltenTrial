# Utilisation


## Lancement de l'application

Pour les tests lancer le server en local:
- installer les dépendences : npm install, composer install
- il faut aussi l'utilitaire symfony (dans le path)
- ng serve depuis le dossier front
- symfony server:start depuis le dossier Alten-eshop du dossier back

### Partie 1 : Shop

Pour charger la liste il faut se connecter : 
- Créer un utilisateur depuis l'écran user (accessible via le menu)
  - créer un utilisateur admin@admin.com pour obtenir les droits
- aller sur le menu product
  - créer un product
- ajouter le produit au panier
  - cela ajoute le produit au panier dans le back et le front
- accéder à la liste du panier : 
  - cliquer surle bouton panier en haut à droite de l'écran

### Partie 2 : formulaire de contact

- accéder au contact via le menu dans la barre latérale
  - remplir le formulaire 
  - soumettre



Consigne front : 

Le site de e-commerce d'Alten a besoin de s'enrichir de nouvelles fonctionnalités.
Partie 1 : Shop

    Afficher toutes les informations pertinentes d'un produit sur la liste
    Permettre d'ajouter un produit au panier depuis la liste
    Permettre de supprimer un produit du panier
    Afficher un badge indiquant la quantité de produits dans le panier
    Permettre de visualiser la liste des produits qui composent le panier.

Partie 2

    Créer un nouveau point de menu dans la barre latérale ("Contact")
    Créer une page "Contact" affichant un formulaire
    Le formulaire doit permettre de saisir son email, un message et de cliquer sur "Envoyer"
    Email et message doivent être obligatoirement remplis.
    Quand le message a été envoyé, afficher un message à l'utilisateur : "Demande de contact envoyée avec succès".
