# Letflix
### Projet de Terminale au Lycée Louis-Vincent

Lien vers le site : [https://letflix-six.vercel.app/](https://letflix-six.vercel.app/)

Notions : Base de données, SQL, Web

Technologies utilisées : Svelte, Typescript, PHP

L'API PHP se trouve dans le dossier /api. Ajoutez un fichier `api_key.php` dans le dossier `/api` contenant le code suivant :
```php
<?php
  $apiKey = 'VOTRE CLE API THEMOVIEDB';
?>
```

Pour lancer l'API PHP, exécutez :
```
cd /api
php -S localhost:8000 -c php.ini
```

Changez, si vous servez le site vous-même, les liens vers l'API PHP dans `/src/AppVariables.ts`

Pour le reste du projet Svelte, lancez-le avec :
```
npm install
npm run dev
```

Enjoy!
