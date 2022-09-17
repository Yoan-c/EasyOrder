# EasyOrder

Ce projet est totalement factice et à été créer uniquement dans le but d'un exercice.

Pour Utiliser ce projet et le faire fonctionner il faut : 
- avoir PHP 8
- avoir SYMFONY 6
- XAMMP.

Les étapes pour installer le projet : 
1) Télécharger le projet
2) Créer votre base de données (ici c'est easyorder)
3) Aller dans le dossier contenant les fichiers du projet 
4) Exectuer la commande "symfony console make:migration" pour creer la migration
5) Executer la commande "symfony console doctrine:migrations:migrate"
6) Lancer les fixtures "symfony console doctrine:fixtures:load"
7) Aller dans votre navigateur 127.0.0.1:8000 et le site devra être mis en local
8) il existe 2 comptes (email : admin@gmail.com, password : test) qui a le role administrateur et user (email : test@gmail.com, password : test).
