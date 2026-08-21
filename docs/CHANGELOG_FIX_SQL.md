# Correction SQL Stylt V2

## Problème corrigé

L'ancien `database/schema.sql` utilisait une instruction DROP groupée alors que des clés étrangères reliaient encore les tables. MySQL pouvait donc retourner `#1451 - Impossible de supprimer un enregistrement père`.

## Correction

Le script utilise maintenant :

- `SET FOREIGN_KEY_CHECKS = 0` avant la suppression ;
- suppression des tables dépendantes avant les tables parentes ;
- `SET FOREIGN_KEY_CHECKS = 1` avant la recréation du schéma.

La contrainte anti-double-réservation `UNIQUE KEY uq_professional_slot(professional_id, appointment_date, appointment_time)` est conservée.
