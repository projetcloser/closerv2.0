<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).




## Bonnes Pratiques de Travail en Équipe et Utilisation de Git

### Utilisation de Git et GitHub

#### A. Gestion de Référentiels
- **Création d'un Référentiel :** Créez un répertoire GitHub pour chaque projet. Utilisez des noms de répertoires clairs et descriptifs.


#### B. Branching
- **Branches Principales :** `main`  pour le code stable de production. 
- **Branches de Fonctionnalités :** Créez des branches spécifiques pour chaque fonctionnalité (`feature/nom-fonctionnalité`) ou correctif (`fix/nom-bug`).
- **Branches de Développement :**  `develop` pour intégrer les nouvelles fonctionnalités avant de les fusionner dans la branche principale. (Nb : Rôle du manageur)

#### B. Projets GitHub
- **Tableaux de Bord :** Utilisez les projets (GitHub Projects) pour organiser les tâches en tableaux Kanban. Créez des colonnes telles que `To Do`, `In Progress`, `Review`, et `Done`.
- **Milestones :** Définissez des milestones pour regrouper les issues et les pull requests en fonction des objectifs ou des sprints.

### Pull Requests et Code Reviews

#### A. Création de Pull Requests
- **Descriptif :** Incluez une description détaillée de ce qui a été fait, pourquoi c'est nécessaire, et les éventuels impacts sur d'autres parties du projet.
- **Templates de PR :** Utilisez des templates de pull request pour standardiser les informations incluses.

#### B. Revue de Code
- **Processus de Revue :** Mettez en place un processus de revue de code où chaque pull request doit être approuvée par au moins un autre développeur avant d'être fusionnée.
- **Commentaires Constructifs :** Fournissez des commentaires constructifs et des suggestions d'amélioration.
- **Tests :** Assurez-vous que les nouvelles fonctionnalités ou correctifs passent tous les tests avant de fusionner.

### Commandes Git Essentielles

#### Collaboration et Gestion à Distance
```bash
git clone https://github.com/utilisateur/repo.git
git remote add origin https://github.com/utilisateur/repo.git
git push origin main
git fetch origin
git pull origin main
```


#### Travail sur le Code
```bash
git add fichier1 fichier2
git add .
git commit -m "Message de validation"
git status
```

#### Merge les features sur la branche develop
```bash
git checkout -b feature/nom-fonctionnalité
git checkout develop
git merge develop
```

#### Rebase et Résolution de Conflits
```bash
git checkout feature/nom-fonctionnalité
git rebase main
git add fichier-conflit
git rebase --continue
```
#### Suivre et Créer Localement les Branches Distantes (option2 ) :

# Cloner le dépôt distant
```bash
git clone https://github.com/votre-utilisateur/votre-repo.git
cd votre-repo
```
# Récupérer toutes les branches distantes
```bash
git fetch --all
```

# Lister toutes les branches locales et distantes
```bash
git branch -a
```

# Suivre et créer localement les branches distantes spécifiques
#### synthaxe :  git checkout -b nom_branch_local origin/nom_branch_distant
#### il crée votre branche locale qui correspond à la branche distante
```bash
git checkout -b feat/map-api-automatic-addressing origin/feat/map-api-automatic-addressing
git checkout -b feat/member-crud-api-endpoint origin/feat/member-crud-api-endpoint
git checkout -b main origin/main
```

# Notes Supplémentaires
#### Mise à Jour des Branches Locales : Pour mettre à jour vos branches locales avec les dernières 
#### modifications du dépôt distant, utilisez :
```bash
git pull origin nom-de-la-branche
```
#### Suppression d'une Branche Locale : Si vous avez besoin de supprimer une branche locale :
```bash
git branch -d nom-de-la-branche
```
#### Suppression d'une Branche Distante : Pour supprimer une branche distante :
```bash
git push origin --delete nom-de-la-branche
```

# Comment faire des merges dans notre projet 
#### Assurez-vous d'être sur la branche develop
```bash
git checkout develop
```
#### Récupérez les dernières modifications de develop
```bash
git pull origin develop
```
#### Fusionnez la branche feat/map-api-automatic-addressing dans develop
```bash
git merge feat/map-api-automatic-addressing
```
#### (Optionnel) Résolvez les conflits s'il y en a
#### Ouvrez les fichiers conflictuels, résolvez les conflits, puis
```bash
git add fichier-conflit
git commit -m "Résolution des conflits de fusion"
```
#### Poussez les modifications vers le dépôt distant
```bash
git push origin develop
```

# ajouter un branche sur le depôt distant (exemple avec la branche develop)
#### Assurez-vous d'être sur la branche principale
```bash
git checkout main
```
#### Créez la branche develop localement
```bash
git checkout -b develop
```
#### Poussez la branche develop vers le dépôt distant
```bash
git push origin develop
```
#### Configurez la branche develop pour suivre la branche distante
```bash
git branch --set-upstream-to=origin/develop develop
```
# Voici un exemple complet pour créer la branche develop et fusionner une autre branche en traitant les histoires non liées :
#### Créez la branche develop localement
git checkout -b develop

#### Poussez la branche develop vers le dépôt distant
git push origin develop

#### Vérifiez que vous êtes sur la branche develop
git checkout develop

#### Fusionnez la branche feat/map-api-automatic-addressing avec l'option --allow-unrelated-histories
git merge feat/map-api-automatic-addressing --allow-unrelated-histories

#### (Optionnel) Résolvez les conflits s'il y en a
git add .
git commit -m "Résolution des conflits de fusion"

#### Poussez les modifications vers le dépôt distant
git push origin develop



