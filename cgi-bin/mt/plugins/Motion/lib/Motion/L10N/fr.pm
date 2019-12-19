# Movable Type (r) (C) 2001-2010 Six Apart, Ltd. All Rights Reserved.
# This code cannot be redistributed without permission from www.sixapart.com.
# For more information, consult your Movable Type license.
#
# $Id: fr.pm 116788 2009-12-16 06:05:21Z auno $

package Motion::L10N::fr;

use strict;
use base 'Motion::L10N::en_us';
use vars qw( %Lexicon );
%Lexicon = (

## plugins/Motion/config.yaml
	'A Movable Type theme with structured entries and action streams.' => 'Un thème Movable Type avec des notes structurées et des flux d\'actions.',
	'Adjusting field types for embed custom fields...' => 'Ajustement des types de champs pour les champs personnalisés d\'éléments embarqués...',
	'Updating favoriting namespace for Motion...' => 'Mise à jour des espaces de nom favoris pour Motion...',
	'Reinstall Motion Templates' => 'Réinstaller les gabarits Motion',
	'Motion Themes' => 'Thèmes Motion',
	'Themes for Motion template set' => 'Thèmes pour le jeu de gabarits Motion',
	'Motion' => 'Motion',
	'Post Type' => 'Type de note',
	'Photo' => 'Photo',
	'Embed Object' => 'Élément externe',
	'MT JavaScript' => 'Javascript MT',
	'Motion MT JavaScript' => 'JavaScript Motion MT',
	'Motion JavaScript' => 'JavaScript Motion',
	'Entry Listing: Monthly' => 'Liste des notes par mois',
	'Entry Listing: Category' => 'Liste des notes par catégorie',
	'Entry Listing: Author' => 'Liste des notes par auteur',
	'Entry Response' => 'Réponse à la note',
	'Profile View' => 'Vue du profil',
	'Profile Edit Form' => 'Formulaire de modification du profil',
	'Profile Error' => 'Erreur de profil',
	'Profile Feed' => 'Flux du profil',
	'Login Form' => 'Formulaire d\'identification',
	'Register Confirmation' => 'Confirmation d\'inscription',
	'Password Reset' => 'Réinitialisation du mot de passe',
	'New Password Form' => 'Nouveau formulaire de mot de passe', # Translate - New
	'User Profile' => 'Profil de l\'utilisateur',
	'Actions (Local)' => 'Actions (locales)',
	'Comment Detail' => 'Détail du Commentaire',
	'Single Entry' => 'Note simple',
	'Messaging' => 'Messagerie',
	'Form Field' => 'Champ de formulaire',
	'About Pages' => 'À propos des pages',
	'About Site' => 'À propos du site',
	'Gallery' => 'Galerie',
	'Main Column Actions' => 'Actions de la colonne principale',
	'Main Column Posting Form (All Media)' => 'Formulaire de publication (Tous médias) de la colonne principale',
	'Main Column Posting Form (Text Only, Like Twitter)' => 'Formulaire de publication (Texte uniquement, comme Twitter) de la colonne principale',
	'Main Column Registration' => 'Inscription depuis la colonne principale',
	'Fans' => 'Fans',
	'Popular Entries' => 'Notes populaires',
	'Elsewhere' => 'Ailleurs',
	'Following' => 'Suit',
	'Followers' => 'Suiveurs',
	'User Archives' => 'Archives de l\'utilisateur',
	'Blogroll' => 'Blogs préférés',
	'Feeds' => 'Flux',
	'Main Column Content' => 'Contenu de la colonne principale',
	'Main Index Widgets' => 'Widgets de l\'index principal',
	'Archive Widgets' => 'Widgets d\'archive',
	'Entry Widgets' => 'Widgets de notes',
	'Footer Widgets' => 'Widgets de pieds',
	'Default Widgets' => 'Widgets par défaut',
	'Profile Widgets' => 'Widgets de profils',

## plugins/Motion/lib/Motion/Search.pm
	'This module works with MT::App::Search.' => 'Ce module fonctionne avec MT::App::Search.',
	'Specify the blog_id of a blog that has Motion template set.' => 'Indique le blog_id d\'un blog ayant un jeu de gabarits Motion.',
	'Error loading template: [_1]' => 'Erreur lors du chargement d\'un gabarit : [_1]',

## plugins/Motion/tmpl/edit_linkpost.tmpl

## plugins/Motion/tmpl/edit_videopost.tmpl
	'Embed code' => 'Code externe',

## plugins/Motion/templates/Motion/widget_search.mtml

## plugins/Motion/templates/Motion/banner_header.mtml
	'Home' => 'Accueil',

## plugins/Motion/templates/Motion/widget_recent_comments.mtml
	'<p>[_3]...</p><div class="comment-attribution">[_4]<br /><a href="[_1]">[_2]</a></div>' => '<p>[_3]...</p><div class="comment-attribution">[_4]<br /><a href="[_1]">[_2]</a></div>',

## plugins/Motion/templates/Motion/widget_popular_entries.mtml
	'posted by <a href="[_1]">[_2]</a> on [_3]' => 'rédigé par <a href="[_1]">[_2]</a> le [_3]',

## plugins/Motion/templates/Motion/widget_followers.mtml
	'Not being followed' => 'N\'est pas suivi',

## plugins/Motion/templates/Motion/entry_response.mtml

## plugins/Motion/templates/Motion/comment_response.mtml
	'<strong>Bummer....</strong> [_1]' => '<strong>Zut...</strong> [_1]',

## plugins/Motion/templates/Motion/widget_about_ssite.mtml
	'About' => 'A propos de',
	'The Motion Template Set is a great example of the type of site you can build with Movable Type.' => 'Le jeu de gabarits Motion est un bel exemple du type de site que vous pouvez concevoir avec Movable Type.',

## plugins/Motion/templates/Motion/comment_detail.mtml

## plugins/Motion/templates/Motion/register.mtml
	'Enter a password for yourself.' => 'Choisissez un mot de passe.',
	'The URL of your website.' => 'L\'URL de votre site.',

## plugins/Motion/templates/Motion/member_index.mtml

## plugins/Motion/templates/Motion/single_entry.mtml
	'By [_1] <span class="date">on [_2]</span>' => 'Par [_1] <span class="date">sur [_2]</span>',
	'Unpublish this post' => 'Mettre cette note hors-ligne',
	'1 <span>Comment</span>' => '1 <span>commentaire</span>',
	'# <span>Comments</span>' => '# <span>commentaires</span>',
	'0 <span>Comments</span>' => '0 <span>commentaires</span>',
	'1 <span>TrackBack</span>' => '1 <span>trackback</span>',
	'# <span>TrackBacks</span>' => '# <span>trackbacks</span>',
	'0 <span>TrackBacks</span>' => '0 <span>trackbacks</span>',
	'Note: This post is being held for approval by the site owner.' => 'Note : cette note est en attente d\'acceptation par le propriétaire du site.',
	'<a href="[_1]">Most recent comment by <strong>[_2]</strong> on [_3]</a>' => '<a href="[_1]">Commentaires les plus récents par <strong>[_2]</strong> sur [_3]</a>',
	'Posted to [_1]' => 'Publié sur [_1]',
	'[_1] posted [_2] on [_3]' => '[_1] a publié [_2] sur [_3]',

## plugins/Motion/templates/Motion/widget_tag_cloud.mtml

## plugins/Motion/templates/Motion/password_reset.mtml
	'Reset Password' => 'Initialiser le mot de passe',

## plugins/Motion/templates/Motion/form_field.mtml
	'(Optional)' => '(Optionnel)',

## plugins/Motion/templates/Motion/javascript.mtml
	'Please select a file to post.' => 'Veuillez sélectionner un fichier à publier.',
	'You selected an unsupported file type.' => 'Vous avez sélectionné un fichier de type non supporté.',

## plugins/Motion/templates/Motion/trackbacks.mtml

## plugins/Motion/templates/Motion/archive_index.mtml

## plugins/Motion/templates/Motion/new_password.mtml

## plugins/Motion/templates/Motion/entry_listing_author.mtml
	'Archived Entries from [_1]' => 'Notes archivés de [_1]',
	'Recent Entries from [_1]' => 'Notes récentes de [_1]',

## plugins/Motion/templates/Motion/widget_categories.mtml

## plugins/Motion/templates/Motion/dynamic_error.mtml

## plugins/Motion/templates/Motion/widget_elsewhere.mtml
	'Are you sure you want to remove the [_1] from your profile?' => 'Êtes-vous sûr de vouloir retirer [_1] de votre profil ?',
	'Your user name or ID is required.' => 'Votre nom d\'utilisateur ou ID est requis.',
	'Add a Service' => 'Ajouter un service',
	'Service' => 'Service',
	'Select a service...' => 'Sélectionnez un service...',
	'Your Other Profiles' => 'Vos autres profils',
	'Find [_1] Elsewhere' => 'Trouver [_1] ailleurs',
	'Remove service' => 'Retirer le service',

## plugins/Motion/templates/Motion/widget_main_column_registration.mtml
	'<a href="javascript:void(0)" onclick="[_1]">Sign In</a>' => '<a href="javascript:void(0)" onclick="[_1]">Identifiez-vous</a>', # Translate - New
	'Not a member? <a href="[_1]">Register</a>' => 'Pas encore membre? <a href="[_1]">Enregistrez-vous</a>',
	'(or <a href="javascript:void(0)" onclick="[_1]">Sign In</a>)' => '(ou <a href="javascript:void(0)" onclick="[_1]">Identifiez-vous</a>)',
	'No posting privileges.' => 'Pas les droits nécessaires pour publier.',

## plugins/Motion/templates/Motion/widget_following.mtml
	'Not following anyone' => 'Ne suit personne',

## plugins/Motion/templates/Motion/widget_main_column_posting_form_text.mtml
	'QuickPost' => 'QuickPost',
	'Content' => 'Contenu',
	'more options' => 'Plus d\'options',
	'Post' => 'Publier',

## plugins/Motion/templates/Motion/comment_preview.mtml

## plugins/Motion/templates/Motion/actions_local.mtml
	'[_1] commented on [_2]' => '[_1] a commenté sur [_2]',
	'[_1] favorited [_2]' => '[_1] apprécie [_2]', # Translate - New
	'No recent actions.' => 'Plus d\'actions récentes.',

## plugins/Motion/templates/Motion/main_index.mtml

## plugins/Motion/templates/Motion/page.mtml

## plugins/Motion/templates/Motion/entry_summary.mtml

## plugins/Motion/templates/Motion/widget_main_column_posting_form.mtml
	'Text post' => 'Texte',
	'Photo post' => 'Photo',
	'Link post' => 'Lien',
	'Embed post' => 'Élément embarqué',
	'Audio post' => 'Son',
	'URL of web page' => 'URL d\'une page Web',
	'Select photo file' => 'Sélectionner une image ou photo',
	'Only GIF, JPEG and PNG image files are supported.' => 'Les types de fichiers supportés sont GIF, JPEG, et PNG.',
	'Select audio file' => 'Sélectionner un fichier sonore',
	'Only MP3 audio files are supported.' => 'Le fichier doit être au format MP3.',
	'Paste embed code' => 'Copiez le code de l\'élément embarqué',

## plugins/Motion/templates/Motion/widget_monthly_archives.mtml

## plugins/Motion/templates/Motion/profile_feed.mtml
	'Posted [_1] to [_2]' => 'A posté [_1] sur [_2]',
	'Commented on [_1] in [_2]' => 'A commenté sur [_1] dans [_2]',
	'followed [_1]' => 'a suivi [_1]',

## plugins/Motion/templates/Motion/widget_user_archives.mtml
	'Recenty entries from [_1]' => 'Notes récentes de [_1]',

## plugins/Motion/templates/Motion/entry_listing_category.mtml

## plugins/Motion/templates/Motion/widget_signin.mtml
	'You are signed in as <a href="[_1]">[_2]</a>' => 'Vous êtes identifié(e) comme étant <a href="[_1]">[_2]</a>',
	'You are signed in as [_1]' => 'Vous êtes identifié(e) comme étant [_1]',
	'Edit profile' => 'Editer le profil',
	'Sign out' => 'déconnexion',

## plugins/Motion/templates/Motion/widget_fans.mtml

## plugins/Motion/templates/Motion/entry_listing_monthly.mtml

## plugins/Motion/templates/Motion/register_confirmation.mtml
	'Authentication Email Sent' => 'Email d\'authentification envoyé',
	'Profile Created' => 'Profil créé',
	'<a href="[_1]">Return to the original page.</a>' => '<a href="[_1]">Retourner à la page initiale</a>',

## plugins/Motion/templates/Motion/entry.mtml

## plugins/Motion/templates/Motion/widget_gallery.mtml
	'Recent Photos' => 'Photos récentes',

## plugins/Motion/templates/Motion/sidebar.mtml

## plugins/Motion/templates/Motion/widget_recent_entries.mtml
	'posted by [_1] on [_2]' => 'publié par [_1] sur [_2]',

## plugins/Motion/templates/Motion/banner_footer.mtml

## plugins/Motion/templates/Motion/widget_main_column_actions.mtml

## plugins/Motion/templates/Motion/comments.mtml
	'what will you say?' => 'que direz-vous ?',
	'[_1] [_2]in reply to comment from [_3][_4]' => '[_1] [_2] en réponse au commentaire de [_3][_4]',
	'Write a comment...' => 'Rédigez un commentaire ...',

## plugins/Motion/templates/Motion/search_results.mtml

## plugins/Motion/templates/Motion/login_form.mtml
	'Forgot?' => 'Oublié ?',

## plugins/Motion/templates/Motion/widget_members.mtml

## plugins/Motion/templates/Motion/user_profile.mtml
	'Recent Actions from [_1]' => 'Actions récentes de [_1]',
	'Responses to Comments from [_1]' => 'Réponses aux commentaires de [_1]',
	'You are following [_1].' => 'Vous suivez [_1]',
	'Unfollow' => 'Ne plus suivre',
	'Follow' => 'Suivre',
	'Profile Data' => 'Données du profil',
	'More Entries by [_1]' => 'Plus de notes par [_1]',
	'Recent Actions' => 'Actions récentes',
	'_PROFILE_COMMENT_LENGTH' => '10',
	'Comment Threads' => 'Fils de discussion',
	'[_1] commented on ' => '[_1] a commenté sur',
	'No responses to comments.' => 'Pas de réponse aux commentaires.',

## plugins/Motion/templates/Motion/actions.mtml
	'[_1] is now following [_2]' => '[_1] suit désormais [_2]',
	'[_1] favorited [_2] on [_3]' => '[_1] a ajouté [_2] de [_3] dans ses favoris',

## plugins/Motion/templates/Motion/motion_js.mtml
	'Add userpic' => 'Ajouter un avatar',

## plugins/Motion/templates/Motion/widget_powered_by.mtml

## plugins/Motion/templates/Motion/user_profile_edit.mtml
	'Go <a href="[_1]">back to the previous page</a> or <a href="[_2]">view your profile</a>.' => 'Retourner à  <a href="[_1]">la page précédente</a> ou <a href="[_2]">voir votre profil</a>.',
	'Change' => 'Modifier',


);

1;
