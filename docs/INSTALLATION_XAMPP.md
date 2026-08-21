# Stylt V2 — installation locale XAMPP

## 1. Pré-requis
- XAMPP avec Apache + MySQL/MariaDB + PHP 8+
- VS Code (facultatif)
- navigateur moderne

## 2. Copier le projet
Décompresser le dossier dans :
`C:\xampp\htdocs\stylt_v2`

Sur Linux/XAMPP : `/opt/lampp/htdocs/stylt_v2`

## 3. Démarrer les services
Dans XAMPP : Start Apache et MySQL.

## 4. Créer la base
Ouvrir `http://localhost/phpmyadmin`, cliquer sur **Importer**, choisir `database/schema.sql`, puis exécuter.
Le script crée la base `stylt`, les tables et un professionnel de démonstration.

## 5. Vérifier la connexion
`config/config.php` contient par défaut :
- host `127.0.0.1`
- base `stylt`
- utilisateur `root`
- mot de passe vide

Si ton MySQL a un autre mot de passe, modifie `DB_PASS`.

## 6. Ouvrir Stylt
`http://localhost/stylt_v2/public/`

Profil démo :
`http://localhost/stylt_v2/public/index.php?page=professional&id=1`

Création de compte coiffeur :
`http://localhost/stylt_v2/public/index.php?page=register-professional`

## 7. Test complet du rendez-vous
1. Accueil → Explorer.
2. Ouvrir Junior Barber.
3. Choisir ce service.
4. Sélectionner une prestation, une date et une heure.
5. Choisir le mode et la zone.
6. Cliquer sur Confirmer le rendez-vous.
7. Stylt affiche automatiquement une page récapitulative avec date, heure, coiffeur, prestation, mode, zone et prix.

## 8. Créer un coiffeur
Ouvrir la page « Devenir coiffeur ».
Remplir le formulaire et sélectionner une photo JPG/PNG/WebP de 3 Mo maximum.
Le serveur valide le MIME, renomme le fichier et l'enregistre dans `public/assets/uploads/professionals/`.
Le chemin est stocké en base et la photo apparaît immédiatement sur le profil créé. Le profil est marqué `pending` jusqu'à validation administrative.

## 9. Si Apache refuse l'URL
Utilise toujours le chemin `/public/` dans cette V2. Aucun framework ni dépendance externe n'est requis.

## 10. Linux/Kali
Si XAMPP est installé sous `/opt/lampp`, place le projet dans `/opt/lampp/htdocs/stylt_v2` et donne au serveur les droits d'écriture sur `public/assets/uploads/professionals`.
Exemple :
`sudo chown -R $USER:www-data /opt/lampp/htdocs/stylt_v2`
Puis vérifie que le dossier d'upload est inscriptible.


## Correction importante — import SQL

La version corrigée de `database/schema.sql` désactive temporairement les contrôles de clés étrangères pendant la suppression des anciennes tables. Cela évite l'erreur MySQL `#1451` lors d'une réinstallation de la base.

Pour une installation propre :
1. Ouvrir `http://localhost/phpmyadmin`.
2. Sélectionner la base `stylt` (si elle existe).
3. Ouvrir **Importer**.
4. Sélectionner `database/schema.sql`.
5. Exécuter l'import.

Le script supprime les anciennes tables dans un ordre sûr, recrée le schéma et réinsère le professionnel de démonstration.
