<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        // Nettoyer les templates existants pour éviter les doublons
        Template::query()->delete();

        // ═══════════════════════════════════════════════════════════
        // 1. Demande d'autorisation de tournage — Président
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Autorisation de tournage — Président de la République',
            'type' => 'letter',
            'category' => 'autorisation_tournage',
            'design' => 'moderne',
            'variables' => [
                ['key' => 'nom_projet', 'label' => 'Nom du projet', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: …ET SI DEMAIN…'],
                ['key' => 'type_projet', 'label' => 'Type de projet', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: long métrage de fiction'],
                ['key' => 'description_projet', 'label' => 'Description du projet', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Brève description du projet et de sa thématique'],
                ['key' => 'lieux_tournage', 'label' => 'Lieux de tournage', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: Palais de la République, Place de l\'Indépendance'],
                ['key' => 'dates_tournage', 'label' => 'Dates de tournage', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: du 15 mars au 30 avril 2025'],
                ['key' => 'equipe_nombre', 'label' => 'Taille de l\'équipe', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: 25 personnes'],
                ['key' => 'besoins_specifiques', 'label' => 'Besoins spécifiques', 'type' => 'textarea', 'required' => false, 'placeholder' => 'Ex: accès aux zones sécurisées, autorisation de survol drone'],
            ],
            'content' => "J'ai l'honneur de venir très respectueusement auprès de votre haute bienveillance solliciter une autorisation de tournage pour le projet intitulé « {nom_projet} », un {type_projet} produit par SINIING SOHOMA TILO SARL (SST).

{description_projet}

Ce projet nécessite des prises de vues dans les lieux suivants : {lieux_tournage}, durant la période {dates_tournage}. L'équipe de tournage sera composée de {equipe_nombre}.

{besoins_specifiques}

Notre société s'engage à respecter scrupuleusement les règles de sécurité, à préserver l'intégrité des lieux ainsi qu'à se conformer à toutes les dispositions réglementaires en vigueur.

Ce projet vise à promouvoir le rayonnement culturel du Sénégal à travers le cinéma et contribuera au développement de l'industrie audiovisuelle nationale.

Dans l'attente d'une suite favorable, je vous prie d'agréer l'expression de ma très haute considération.",
        ]);

        // ═══════════════════════════════════════════════════════════
        // 2. Demande d'autorisation de tournage — Ministre de la Culture
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Autorisation de tournage — Ministre de la Culture',
            'type' => 'letter',
            'category' => 'autorisation_tournage',
            'design' => 'corporate',
            'variables' => [
                ['key' => 'nom_projet', 'label' => 'Nom du projet', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: …ET SI DEMAIN…'],
                ['key' => 'type_projet', 'label' => 'Type de projet', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: long métrage de fiction'],
                ['key' => 'description_projet', 'label' => 'Description du projet', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Description du projet et sa portée culturelle'],
                ['key' => 'lieux_tournage', 'label' => 'Lieux de tournage', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: Grand Théâtre National, Île de Gorée'],
                ['key' => 'dates_tournage', 'label' => 'Dates de tournage', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: du 1er au 28 février 2025'],
                ['key' => 'objectif_culturel', 'label' => 'Objectif culturel', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Impact culturel et artistique visé par le projet'],
            ],
            'content' => "J'ai l'honneur de solliciter auprès de votre Ministère une autorisation de tournage pour le projet cinématographique « {nom_projet} », un {type_projet} produit par SINIING SOHOMA TILO SARL (SST).

{description_projet}

Les prises de vues sont prévues aux lieux suivants : {lieux_tournage}, sur la période {dates_tournage}.

Ce projet s'inscrit dans une démarche de valorisation du patrimoine culturel sénégalais. {objectif_culturel}

Notre société dispose de toutes les assurances professionnelles requises et s'engage à respecter les réglementations en vigueur concernant la protection du patrimoine et des sites culturels.

Nous restons à votre entière disposition pour tout complément d'information ou pour convenir d'une rencontre afin de présenter le projet en détail.

Dans l'attente de votre accord, veuillez agréer l'expression de ma haute considération.",
        ]);

        // ═══════════════════════════════════════════════════════════
        // 3. Demande de financement
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Demande de financement',
            'type' => 'letter',
            'category' => 'demande_financement',
            'design' => 'corporate',
            'variables' => [
                ['key' => 'nom_organisme', 'label' => 'Nom de l\'organisme', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: Fonds de Promotion de l\'Industrie Cinématographique'],
                ['key' => 'titre_responsable', 'label' => 'Titre du responsable', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: Monsieur le Directeur'],
                ['key' => 'nom_projet', 'label' => 'Nom du projet', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: …ET SI DEMAIN…'],
                ['key' => 'type_projet', 'label' => 'Type de projet', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: long métrage de fiction'],
                ['key' => 'budget_total', 'label' => 'Budget total (FCFA)', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: 150 000 000 FCFA'],
                ['key' => 'montant_sollicite', 'label' => 'Montant sollicité (FCFA)', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: 50 000 000 FCFA'],
                ['key' => 'description_projet', 'label' => 'Description du projet', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Synopsis et contexte du projet'],
                ['key' => 'plan_utilisation', 'label' => 'Plan d\'utilisation des fonds', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Détail de l\'utilisation prévue des fonds'],
            ],
            'content' => "J'ai l'honneur de solliciter auprès de {nom_organisme} un appui financier pour la réalisation du projet « {nom_projet} », un {type_projet} produit par SINIING SOHOMA TILO SARL (SST).

{description_projet}

Le budget total de cette production est estimé à {budget_total}. Nous sollicitons une contribution de {montant_sollicite} qui sera affectée comme suit :

{plan_utilisation}

Notre société, enregistrée au RCCM sous le numéro SN-DKR-2025-B-50427, dispose d'une expérience avérée dans la production audiovisuelle et s'engage à fournir tous les justificatifs de dépenses conformément aux procédures de votre organisme.

Nous tenons à votre disposition le dossier complet du projet incluant le scénario, le budget détaillé, le plan de financement et le calendrier de production.

Dans l'espoir d'une suite favorable, veuillez agréer l'expression de ma considération distinguée.",
        ]);

        // ═══════════════════════════════════════════════════════════
        // 4. Demande de partenariat
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Demande de partenariat',
            'type' => 'letter',
            'category' => 'demande_partenariat',
            'design' => 'elegant',
            'variables' => [
                ['key' => 'nom_entreprise', 'label' => 'Nom de l\'entreprise partenaire', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: Orange Sénégal'],
                ['key' => 'titre_responsable', 'label' => 'Titre du responsable', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: Monsieur le Directeur Général'],
                ['key' => 'nom_projet', 'label' => 'Nom du projet', 'type' => 'text', 'required' => true, 'placeholder' => 'Titre du projet'],
                ['key' => 'description_projet', 'label' => 'Description du projet', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Présentation du projet'],
                ['key' => 'type_partenariat', 'label' => 'Type de partenariat souhaité', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Ex: sponsoring, mise à disposition de matériel, co-production'],
                ['key' => 'contreparties', 'label' => 'Contreparties proposées', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Ex: visibilité logo, mentions dans le générique, invitations VIP'],
            ],
            'content' => "SINIING SOHOMA TILO SARL (SST), société de production audiovisuelle basée à Dakar, a le plaisir de vous présenter le projet « {nom_projet} » et de solliciter un partenariat avec {nom_entreprise}.

{description_projet}

Dans le cadre de ce projet ambitieux, nous recherchons des partenaires stratégiques partageant notre vision de promotion de la culture sénégalaise. Le partenariat que nous souhaitons établir avec votre structure se décline comme suit :

{type_partenariat}

En contrepartie de votre soutien, nous proposons :

{contreparties}

Ce partenariat représente une opportunité unique d'associer l'image de {nom_entreprise} à un projet culturel d'envergure, porteur de valeurs positives et bénéficiant d'une large diffusion nationale et internationale.

Nous serions honorés de vous rencontrer afin de vous présenter le projet en détail et d'explorer ensemble les modalités de notre collaboration.

Veuillez agréer l'expression de mes salutations distinguées.",
        ]);

        // ═══════════════════════════════════════════════════════════
        // 5. Demande de collaboration artistique
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Demande de collaboration artistique',
            'type' => 'letter',
            'category' => 'collaboration_artistique',
            'design' => 'classique',
            'variables' => [
                ['key' => 'nom_artiste', 'label' => 'Nom de l\'artiste/technicien', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: Ousmane Sembène Jr.'],
                ['key' => 'specialite', 'label' => 'Spécialité', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: directeur de la photographie'],
                ['key' => 'nom_projet', 'label' => 'Nom du projet', 'type' => 'text', 'required' => true, 'placeholder' => 'Titre du projet'],
                ['key' => 'description_projet', 'label' => 'Description du projet', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Présentation du projet'],
                ['key' => 'role_propose', 'label' => 'Rôle proposé', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Description du rôle et des responsabilités proposées'],
                ['key' => 'conditions', 'label' => 'Conditions de collaboration', 'type' => 'textarea', 'required' => false, 'placeholder' => 'Période, rémunération, déplacements prévus'],
            ],
            'content' => "SINIING SOHOMA TILO SARL (SST) prépare activement le projet « {nom_projet} » et votre talent reconnu en tant que {specialite} a retenu toute notre attention.

{description_projet}

Nous souhaiterions vivement vous proposer de participer à ce projet dans le rôle suivant :

{role_propose}

{conditions}

Votre expertise et votre sensibilité artistique apporteraient une dimension unique à cette production. Nous sommes convaincus que cette collaboration serait mutuellement enrichissante et contribuerait au rayonnement de la création audiovisuelle sénégalaise.

Nous serions ravis d'échanger avec vous à votre convenance afin de discuter des détails de cette proposition.

Dans l'attente de votre retour, veuillez recevoir l'expression de notre sincère considération.",
        ]);

        // ═══════════════════════════════════════════════════════════
        // 6. Lettre d'intention de projet culturel
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Lettre d\'intention de projet culturel',
            'type' => 'letter',
            'category' => 'intention_projet',
            'design' => 'moderne',
            'variables' => [
                ['key' => 'nom_projet', 'label' => 'Nom du projet', 'type' => 'text', 'required' => true, 'placeholder' => 'Titre du projet'],
                ['key' => 'type_projet', 'label' => 'Type de projet', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: documentaire, série TV, court métrage'],
                ['key' => 'contexte', 'label' => 'Contexte et genèse', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Origine du projet, inspiration, recherche préalable'],
                ['key' => 'synopsis', 'label' => 'Synopsis', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Résumé du projet en quelques paragraphes'],
                ['key' => 'objectifs', 'label' => 'Objectifs artistiques', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Vision artistique et objectifs du projet'],
                ['key' => 'public_cible', 'label' => 'Public cible', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: tout public, festivals internationaux'],
                ['key' => 'calendrier', 'label' => 'Calendrier prévisionnel', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: écriture jan-mars, tournage avr-juin, post-prod juil-sept'],
            ],
            'content' => "Par la présente, SINIING SOHOMA TILO SARL (SST) a l'honneur de vous présenter son intention de réaliser le projet « {nom_projet} », un {type_projet}.

CONTEXTE ET GENÈSE DU PROJET

{contexte}

SYNOPSIS

{synopsis}

VISION ARTISTIQUE ET OBJECTIFS

{objectifs}

Ce projet s'adresse à un public {public_cible} et ambitionne de contribuer au paysage audiovisuel sénégalais et africain par une approche artistique singulière et engagée.

CALENDRIER PRÉVISIONNEL

{calendrier}

SST, à travers ce projet, réaffirme son engagement pour une production audiovisuelle de qualité, ancrée dans les réalités culturelles et sociales de notre continent.

Nous vous remercions de l'intérêt que vous porterez à ce projet et restons disponibles pour toute information complémentaire.

Veuillez agréer l'expression de nos salutations distinguées.",
        ]);

        // ═══════════════════════════════════════════════════════════
        // 7. Invitation à un événement culturel
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Invitation à un événement culturel',
            'type' => 'letter',
            'category' => 'invitation_evenement',
            'design' => 'elegant',
            'variables' => [
                ['key' => 'nom_evenement', 'label' => 'Nom de l\'événement', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: Avant-première de « …ET SI DEMAIN… »'],
                ['key' => 'type_evenement', 'label' => 'Type d\'événement', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: avant-première, projection, vernissage'],
                ['key' => 'date_evenement', 'label' => 'Date et heure', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: samedi 15 mars 2025 à 19h00'],
                ['key' => 'lieu_evenement', 'label' => 'Lieu', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: Grand Théâtre National de Dakar'],
                ['key' => 'description_evenement', 'label' => 'Description de l\'événement', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Programme et détails de l\'événement'],
                ['key' => 'dress_code', 'label' => 'Code vestimentaire', 'type' => 'text', 'required' => false, 'placeholder' => 'Ex: tenue de soirée'],
                ['key' => 'rsvp', 'label' => 'Contact RSVP', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: rsvp@sst-production.com / +221 77 549 90 38'],
            ],
            'content' => "SINIING SOHOMA TILO SARL (SST) a le grand plaisir de vous convier à « {nom_evenement} », un {type_evenement} qui se tiendra le {date_evenement} au {lieu_evenement}.

{description_evenement}

Votre présence honorerait cet événement et témoignerait de votre soutien au développement de la culture audiovisuelle sénégalaise.

INFORMATIONS PRATIQUES :
• Date : {date_evenement}
• Lieu : {lieu_evenement}
• Dress code : {dress_code}

Nous vous prions de bien vouloir confirmer votre participation auprès de : {rsvp}

Dans l'attente du plaisir de vous y accueillir, veuillez recevoir nos salutations les plus cordiales.",
        ]);

        // ═══════════════════════════════════════════════════════════
        // 8. Remerciement post-événement
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Remerciement post-événement',
            'type' => 'letter',
            'category' => 'remerciement',
            'design' => 'classique',
            'variables' => [
                ['key' => 'nom_evenement', 'label' => 'Nom de l\'événement', 'type' => 'text', 'required' => true, 'placeholder' => 'Nom de l\'événement'],
                ['key' => 'date_evenement', 'label' => 'Date de l\'événement', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: 15 mars 2025'],
                ['key' => 'contribution', 'label' => 'Contribution du destinataire', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Ex: Votre présence et votre discours d\'ouverture ont grandement contribué...'],
                ['key' => 'resultats', 'label' => 'Résultats / Retombées', 'type' => 'textarea', 'required' => false, 'placeholder' => 'Ex: Plus de 500 personnes ont assisté à l\'événement...'],
                ['key' => 'prochaines_etapes', 'label' => 'Prochaines étapes', 'type' => 'textarea', 'required' => false, 'placeholder' => 'Ex: diffusion nationale prévue en septembre 2025'],
            ],
            'content' => "Au nom de SINIING SOHOMA TILO SARL (SST), je tiens à vous adresser nos sincères remerciements pour votre participation à « {nom_evenement} » qui s'est tenu le {date_evenement}.

{contribution}

{resultats}

Le succès de cet événement est le fruit d'un engagement collectif, et votre contribution y a été déterminante.

{prochaines_etapes}

Nous espérons pouvoir compter sur votre soutien pour nos futurs projets et avons hâte de renouveler cette belle collaboration.

Avec nos remerciements renouvelés, veuillez agréer l'expression de notre gratitude et de notre considération la plus distinguée.",
        ]);

        // ═══════════════════════════════════════════════════════════
        // 9. Lettre de recommandation professionnelle
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Lettre de recommandation professionnelle',
            'type' => 'letter',
            'category' => 'recommandation',
            'design' => 'corporate',
            'variables' => [
                ['key' => 'nom_personne', 'label' => 'Nom de la personne recommandée', 'type' => 'text', 'required' => true, 'placeholder' => 'Nom complet'],
                ['key' => 'poste_occupe', 'label' => 'Poste/fonction occupé(e)', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: assistant réalisateur'],
                ['key' => 'periode_collaboration', 'label' => 'Période de collaboration', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: de janvier 2023 à décembre 2024'],
                ['key' => 'projets_realises', 'label' => 'Projets réalisés ensemble', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Liste des projets et contributions'],
                ['key' => 'qualites', 'label' => 'Qualités professionnelles', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Qualités et compétences de la personne'],
                ['key' => 'recommandation', 'label' => 'Recommandation', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Contexte de la recommandation'],
            ],
            'content' => "Par la présente, je soussigné Sidi Hairou Camara, Producteur / Réalisateur et gérant de SINIING SOHOMA TILO SARL (SST), ai le plaisir de recommander {nom_personne} qui a occupé le poste de {poste_occupe} au sein de notre structure {periode_collaboration}.

Durant cette collaboration, {nom_personne} a participé activement aux projets suivants :

{projets_realises}

Au cours de ces différentes missions, {nom_personne} a fait preuve de remarquables qualités professionnelles :

{qualites}

{recommandation}

C'est donc sans réserve que je recommande {nom_personne} et reste à votre disposition pour tout renseignement complémentaire.

Veuillez agréer l'expression de mes salutations distinguées.",
        ]);

        // ═══════════════════════════════════════════════════════════
        // 10. Notification officielle
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Notification officielle',
            'type' => 'letter',
            'category' => 'notification_officielle',
            'design' => 'moderne',
            'variables' => [
                ['key' => 'objet_notification', 'label' => 'Objet de la notification', 'type' => 'text', 'required' => true, 'placeholder' => 'Ex: Sélection officielle au Festival de Cannes'],
                ['key' => 'contexte', 'label' => 'Contexte', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Contexte et raison de la notification'],
                ['key' => 'details', 'label' => 'Détails de la notification', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Informations détaillées sur l\'objet de la notification'],
                ['key' => 'actions_requises', 'label' => 'Actions requises', 'type' => 'textarea', 'required' => false, 'placeholder' => 'Actions attendues du destinataire, le cas échéant'],
                ['key' => 'date_limite', 'label' => 'Date limite (si applicable)', 'type' => 'text', 'required' => false, 'placeholder' => 'Ex: avant le 30 avril 2025'],
            ],
            'content' => "Par la présente, SINIING SOHOMA TILO SARL (SST) vous notifie officiellement ce qui suit :

OBJET : {objet_notification}

{contexte}

DÉTAILS :

{details}

{actions_requises}

{date_limite}

Nous restons à votre entière disposition pour toute clarification ou information complémentaire.

Veuillez agréer l'expression de nos salutations distinguées.",
        ]);

        // ═══════════════════════════════════════════════════════════
        // Templates Facture Proforma
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Facture proforma',
            'type' => 'invoice_proforma',
            'design' => 'classique',
            'content' => "FACTURE PROFORMA\n\nClient : {{client}}\n\nProduits :\n{{produits}}\n\nTotal : {{total}} FCFA",
        ]);

        Template::create([
            'name' => 'Proforma — Production vidéo',
            'type' => 'invoice_proforma',
            'design' => 'moderne',
            'content' => "FACTURE PROFORMA\n\nServices de production audiovisuelle",
        ]);

        Template::create([
            'name' => 'Proforma — Événementiel',
            'type' => 'invoice_proforma',
            'design' => 'corporate',
            'content' => "FACTURE PROFORMA\n\nCouverture événementielle",
        ]);

        Template::create([
            'name' => 'Proforma — Location matériel',
            'type' => 'invoice_proforma',
            'design' => 'elegant',
            'content' => "FACTURE PROFORMA\n\nLocation de matériel audiovisuel",
        ]);

        Template::create([
            'name' => 'Proforma — Post-production',
            'type' => 'invoice_proforma',
            'design' => 'simple',
            'content' => "FACTURE PROFORMA\n\nServices de post-production",
        ]);

        // ═══════════════════════════════════════════════════════════
        // Templates Facture Définitive
        // ═══════════════════════════════════════════════════════════
        Template::create([
            'name' => 'Facture définitive',
            'type' => 'invoice_final',
            'design' => 'classique',
            'content' => "FACTURE\n\nClient : {{client}}\n\nProduits :\n{{produits}}\n\nTotal : {{total}} FCFA",
        ]);

        Template::create([
            'name' => 'Facture — Production vidéo',
            'type' => 'invoice_final',
            'design' => 'moderne',
            'content' => "FACTURE\n\nServices de production audiovisuelle",
        ]);

        Template::create([
            'name' => 'Facture — Événementiel',
            'type' => 'invoice_final',
            'design' => 'corporate',
            'content' => "FACTURE\n\nCouverture événementielle",
        ]);

        Template::create([
            'name' => 'Facture — Location matériel',
            'type' => 'invoice_final',
            'design' => 'elegant',
            'content' => "FACTURE\n\nLocation de matériel audiovisuel",
        ]);

        Template::create([
            'name' => 'Facture — Post-production',
            'type' => 'invoice_final',
            'design' => 'simple',
            'content' => "FACTURE\n\nServices de post-production",
        ]);

        Template::create([
            'name' => 'Contrat de prestation',
            'type' => 'contrat',
            'content' => "CONTRAT DE PRESTATION\n\nEntre :\nSINIING SOHOMA TILO SARL (SST)\n\nEt :\n{{client}}\n\nArticle 1 – Objet\n{{objet}}\n\nArticle 2 – Durée\n{{duree}}\n\nArticle 3 – Conditions financières\n{{conditions}}\n\nFait à Dakar, le {{date}}",
        ]);

        Template::create([
            'name' => 'Note officielle',
            'type' => 'note_officielle',
            'content' => "NOTE OFFICIELLE\n\nRéférence : {{reference}}\nObjet : {{objet}}\n\n{{contenu}}\n\nSidi Hairou Camara\nProducteur / Réalisateur",
        ]);

        Template::create([
            'name' => 'Page de garde film',
            'type' => 'page_garde',
            'content' => "{{titre_film}}\n\nUn film de\nSidi Hairou Camara (SHC)\n\nProduction\nSINIING SOHOMA TILO SARL (SST)",
        ]);
    }
}

