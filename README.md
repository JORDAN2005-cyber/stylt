# STYLT — V2 UI/UX inspirée du wireframe C03

**Visualiser. Choisir. Réserver.**

Cette version met l'accent sur le design du visuel fourni : bannière pastel, avatar circulaire superposé, badge vérifié, carte de service, réalisations horizontales, ligne d'annulation, CTA orange et navigation mobile inférieure. Les animations restent courtes et utiles : apparition progressive, hover léger, sélection de créneaux et confirmation.

## Fonctionnalités incluses
- Accueil mobile-first / desktop responsive
- Recherche et filtres
- Profil professionnel fidèle à C03
- Photo professionnelle dynamique issue de l'inscription
- Création de compte coiffeur avec upload sécurisé de photo
- Page de prise de rendez-vous
- Sélection de date et de créneau
- Création serveur du rendez-vous
- Contrôle transactionnel du créneau pour éviter deux réservations simultanées
- Page de rendez-vous confirmée avec date, heure, coiffeur, prestation, mode, zone et prix
- Impression / export PDF via le dialogue d'impression du navigateur
- MySQL + PDO + requêtes préparées
- CSRF et validation upload
- Aucun framework frontend, aucune librairie CSS/JS externe

## Stack
HTML5, CSS3, JavaScript vanilla, PHP 8+, MySQL/MariaDB, PDO.

## Limites MVP
L'envoi réel d'OTP/SMS, les notifications push, le paiement en ligne, le chat temps réel et l'administration complète doivent être raccordés dans une phase ultérieure.
