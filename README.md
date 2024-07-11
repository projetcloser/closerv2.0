
# Closer v2.0

## Name
Choose a self-explaining name for your project.

## Description
Let people know what your project can do specifically. Provide context and add a link to any reference visitors might be unfamiliar with. A list of Features or a Background subsection can also be added here. If there are alternatives to your project, this is a good place to list differentiating factors.

## Badges
On some READMEs, you may see small images that convey metadata, such as whether or not all the tests are passing for the project. You can use Shields to add some to your README. Many services also have instructions for adding a badge.

## Visuals
Depending on what you are making, it can be a good idea to include screenshots or even a video (you'll frequently see GIFs rather than actual videos). Tools like ttygif can help, but check out Asciinema for a more sophisticated method.

## Installation
Within a particular ecosystem, there may be a common way of installing things, such as using Yarn, NuGet, or Homebrew. However, consider the possibility that whoever is reading your README is a novice and would like more guidance. Listing specific steps helps remove ambiguity and gets people to using your project as quickly as possible. If it only runs in a specific context like a particular programming language version or operating system or has dependencies that have to be installed manually, also add a Requirements subsection.

## Usage
Use examples liberally, and show the expected output if you can. It's helpful to have inline the smallest example of usage that you can demonstrate, while providing links to more sophisticated examples if they are too long to reasonably include in the README.

## Support
Tell people where they can go to for help. It can be any combination of an issue tracker, a chat room, an email address, etc.

## Roadmap
If you have ideas for releases in the future, it is a good idea to list them in the README.

## Contributing
State if you are open to contributions and what your requirements are for accepting them.

For people who want to make changes to your project, it's helpful to have some documentation on how to get started. Perhaps there is a script that they should run or some environment variables that they need to set. Make these steps explicit. These instructions could also be useful to your future self.

You can also document commands to lint the code or run tests. These steps help to ensure high code quality and reduce the likelihood that the changes inadvertently break something. Having instructions for running tests is especially helpful if it requires external setup, such as starting a Selenium server for testing in a browser.

## Authors and acknowledgment
Show your appreciation to those who have contributed to the project.

## License
For open source projects, say how it is licensed.

## Project status
If you have run out of energy or time for your project, put a note at the top of the README saying that development has slowed down or stopped completely. Someone may choose to fork your project or volunteer to step in as a maintainer or owner, allowing your project to keep going. You can also make an explicit request for maintainers.


## Postman workspace

[Closer 2.0 API Collection](https://wintech-cmr.postman.co/workspace/WinTech-CMR~16c48208-229c-4a90-b775-8f2b85dc1d3e/collection/15776766-5a17d904-f506-4d61-8c38-c16df18bed01?action=share&creator=15776766)





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
```bash
git checkout -b develop
```
#### Poussez la branche develop vers le dépôt distant
```bash
git push origin develop
```
#### Vérifiez que vous êtes sur la branche develop
```bash
git checkout develop
```
#### Fusionnez la branche feat/map-api-automatic-addressing avec l'option --allow-unrelated-histories
```bash
git merge feat/map-api-automatic-addressing --allow-unrelated-histories
```
#### (Optionnel) Résolvez les conflits s'il y en a
```bash
git add .
git commit -m "Résolution des conflits de fusion"
```
#### Poussez les modifications vers le dépôt distant
```bash
git push origin develop
```


