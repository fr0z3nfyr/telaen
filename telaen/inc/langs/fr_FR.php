<?php
/*
 * French (Fran�ais) (canonical list and phrasing)
 */

$lang = array();
//
// Date Format
// %d = day, %m = month, %y = year, %H = hour, %M = minutes
// for a complete list, see http://www.php.net/strftime
//
$lang['date_format'] = '%d/%m/%y %H:%M';

// CharSet
$lang['default_char_set'] = 'UTF-8';

// User-friendly names to system folders
$lang['inbox_extended'] = 'Bo�te de r�ception';
$lang['sent_extended'] = 'El�ments envoy�s';
$lang['trash_extended'] = 'Corbeille';
$lang['spam_extended'] = 'dossier Spam';
$lang['drafts_extended'] = 'Brouillons';

// Navigation texts
$lang['pages_text'] = 'Pages';
$lang['first_text'] = 'First';
$lang['previous_text'] = 'Pr�c�dent';
$lang['next_text'] = 'Suivant';
$lang['last_text'] = 'Last';
$lang['total_text'] = 'Total';

// Mail Server Errors
$lang['err_login_msg'] = 'erreur Connexion';
$lang['err_system_msg'] = 'Erreur syst�me';
$lang['error_login'] = 'Veuillez v�rifier votre Nom d\'utilisateur ou votre mot de passe, et r�essayez';
$lang['error_connect'] = 'Connexion au serveur impossible';
$lang['error_retrieving'] = 'Impossible de recevoir le message, d� aux modifications ';
$lang['error_session_expired'] = 'Votre session a expir�. Veuillez vous reconnecter';
$lang['error_other'] = 'Des erreurs sont survenues, veuillez contacter votre administrateur';

// Invalid name of mailbox
$lang['error_invalid_name'] = 'Nom de dossier invalide - Veuillez utiliser les caract�res suivants A-Z, 0-9, . - espace';

// Validations when sending mails
$lang['error_no_recipients'] = 'Aucun destinataire sp�cifi�';
$lang['error_compose_invalid_mail1_s'] = 'L\'adresse suivante semble invalide';
$lang['error_compose_invalid_mail1_p'] = 'Les adresses suivantes semblent invalides';
$lang['error_compose_invalid_mail2_s'] = 'Veuillez la v�rifier avant l\'envoi du message';
$lang['error_compose_invalid_mail2_p'] = 'Veuillez les v�rifier avant l\'envoi du message';

// Confirmation of delete
$lang['confirm_delete'] = 'Etes-vous s�r de vouloir effacer ce message ? ';

// If the message no have a subject or sender
$lang['no_subject_text'] = '[Pas d\'objet]';
$lang['no_sender_text'] = '[Inconnu]';
$lang['no_recipient_text'] = '[Inconnu]';

// If the quota limit was exceeded
$lang['quota_exceeded'] = 'Espace insuffisant pour effectuer cette op�ration.\rVeuillez nettoyer les anciens messages et r�essayer.';
$lang['quota_usage_info'] = 'Limite de quota';
$lang['quota_usage_used'] = 'utilis�';
$lang['quota_usage_of'] = 'de';
$lang['quota_usage_avail'] = 'Total';

// Menu
$lang['messages_mnu'] = 'Messages';
$lang['read_menu'] = 'Read E-Mail(s)';
$lang['compose_mnu'] = 'Ecrire un nouveau message';
$lang['refresh_mnu'] = 'Actualiser';
$lang['folders_mnu'] = 'Dossiers';
$lang['search_mnu'] = 'Rechercher';
$lang['address_mnu'] = 'Carnet d\'adresses';
$lang['empty_trash_mnu'] = 'Vider la corbeille';
$lang['prefs_mnu'] = 'Pr�f�rences';
$lang['logoff_mnu'] = 'Quitter';

// Reply
$lang['reply_prefix'] = 'Re:';
$lang['forward_prefix'] = 'Tr:';
$lang['reply_delimiter'] = '--------- Message d\'origine --------';
$lang['reply_from_hea'] = 'De:';
$lang['reply_to_hea'] = 'A:';
$lang['reply_cc_hea'] = 'Copies:';
$lang['reply_date_hea'] = 'Date:';
$lang['reply_subject_hea'] = 'Objet:';
// done


// page-specific vars

// [Headers]
$lang['key_hea'] = 'Clef';
$lang['value_hea'] = 'Valeur';

// [Folders]
$lang['fld_name_hea'] = 'Dossiers';
$lang['fld_messages_hea'] = 'Messages';
$lang['fld_size_hea'] = 'Taille';
$lang['fld_empty_hea'] = 'Vider';
$lang['fld_delete_hea'] = 'Supprimer';
$lang['fld_total'] = 'Total:';
$lang['fld_make_new'] = 'Cr�er un nouveau dossier';
$lang['folders_to'] = 'Dossier de';

// [MessageList]
$lang['messages_to'] = 'Messages de ';
$lang['no_messages'] = 'Aucun message dans le dossier ';
$lang['delete_selected_mnu'] = 'Supprimer la s�lection';
$lang['move_selected_mnu'] = 'D�placer la s�lection dans';
$lang['mark_selected_mnu'] = 'Marquer comme lu';
$lang['unmark_selected_mnu'] = 'Marquer comme non lu';
$lang['move_selected_to_trash_mnu'] = '�placer vers la corbeille';


$lang['delete_mnu'] = 'Supprimer';
$lang['move_mnu'] = 'D�placer dans';
$lang['subject_hea'] = 'Objet:';
$lang['from_hea'] = 'De:';
$lang['to_hea'] = 'A:';
$lang['date_hea'] = 'Date:';
$lang['size_hea'] = 'Taille';
$lang['have_spam'] = 'Vous avez le Spam (v�rifier dossier Spam)';

$lang['msg_you_have'] = 'Vous avez';
$lang['msg_message'] = 'message';
$lang['msg_messages'] = 'messages';

$lang['msg_more_unread'] = 'non lus';
$lang['msg_one_unread'] = 'non lu';
$lang['msg_none_unread'] = 'aucun non lu';
$lang['msg_in_the_folder'] = 'dans le dossier';


// [Login]
$lang['lgn_title'] = 'Authentification';
$lang['lgn_welcome_msg'] = 'Bienvenue. Veuillez entrer vos informations de connexion.';
$lang['lng_user_email'] = 'e-Mail';
$lang['lng_user_name'] = 'Nom d\'utilisateur';
$lang['lng_user_pwd'] = 'Mot de passe';
$lang['lng_server'] = 'Server';
$lang['lng_theme'] = 'Th�me';
$lang['lng_language'] = 'Langue';
$lang['lng_login_btn'] = 'Connexion &gt;&gt;';
$lang['lng_cookie_not_enabled'] = 'Les cookies doivent �tre activ�s';
$lang['lng_cookie_not_valid'] = 'Cookie �chec de la v�rification de la s�curit�';

// [Newmessage]

$lang['newmsg_title'] = 'Nouveau Email';

$lang['to_hea'] = 'A:';
$lang['cc_hea'] = 'Copies:';
$lang['bcc_hea'] = 'Copies cach�es:';
$lang['subject_hea'] = 'Objet:';
$lang['address_tip'] = 'Carnet d adresses';

$lang['attach_hea'] = 'Pi�ces jointes:';
$lang['attch_add_new'] = 'Ajouter une pi�ce jointe';
$lang['attch_name_hea'] = 'Nom';
$lang['attch_size'] = 'Taille';
$lang['attch_type_hea'] = 'Type';
$lang['attch_dele_hea'] = 'Supprimer';
$lang['attch_no_hea'] = 'Aucune pi�ce jointe';

$lang['add_signature'] = 'Ajouter une signature';
$lang['send_text'] = 'Envoyer';

$lang['result_error'] = 'Impossible d\'envoyer l\'e-Mail';
$lang['result_success'] = 'Votre e-Mail a bien �t� envoy�.';
$lang['nav_continue'] = 'Continuer';
$lang['nav_back'] = 'Retour';

$lang['up_title'] = 'Ajouter une pi�ce jointe';
$lang['up_information_text'] = 'S�lectionnez un fichier';
$lang['up_button_text'] = 'Envoyer';

$lang['require_receipt'] = 'Retour r�ception';

$lang['priority_text'] = 'Priorit�';
$lang['priority_low'] = 'Basse';
$lang['priority_normal'] = 'Normale';
$lang['priority_high'] = 'Haute';

// [Preferences]
$lang['prf_title'] = 'Pr�f�rences';
$lang['prf_general_title'] = 'Informations G�n�rales';
$lang['prf_name'] = 'Nom';
$lang['prf_reply_to'] = 'R�pondre � ';
$lang['prf_time_zone'] = 'Fuseau horaire';
$lang['prf_trash_title'] = 'Corbeille';
$lang['prf_save_to_trash'] = 'Garder une copie des messages <b>supprim�s</b> dans le dossier';
$lang['prf_save_only_read'] = 'Garder une copie des messages <b>lus</b> dans les dossier';
$lang['prf_empty_on_exit'] = '<b>Vider</b> la corbeille en quittant';
$lang['prf_empty_spam_on_exit'] = '<b>Empty</b> Spam folder when you logout';
$lang['prf_unmark_read_on_exit'] = 'Reset READ messages as UNREAD when you logout';
$lang['prf_sent_title'] = 'El�ments envoy�s';
$lang['prf_save_sent'] = 'Garder une copie des messages <b>envoy�s</b> dans le dossier';
$lang['prf_messages_title'] = 'Messages';
$lang['prf_page_limit'] = 'Nombre de messages maximum affich�s par page';
$lang['prf_signature_title'] = 'Signature';
$lang['prf_signature'] = 'Tapez ou collez votre signature';
$lang['prf_auto_add_sign'] = 'Ajouter la signature automatiquement aux nouveaux messages';
$lang['prf_save_button'] = 'Enregistrer';
$lang['prf_display_images'] = 'Afficher les images attach�es';
$lang['prf_default_editor_mode'] = 'Mode d\'�dition par d�faut';
$lang['prf_default_editor_mode_text'] = '"Mode texte"';
$lang['prf_default_editor_mode_html'] = '"Editeur HTML avanc�"';
$lang['prf_time_to_refesh'] = 'Temps de rafra�chissement pour les messages (en minutes)';
$lang['prf_spam_level'] = 'SPAM sensibilit� (0 = d�sactiv�, 1 = tr�s �lev�, 9 = tr�s faible)';
$lang['prf_auto_require_receipt'] = 'Require read receipt by default';
$lang['prf_keep_on_server'] = 'Gardez email sur le serveur - aucun des dossiers locaux';

$lang['prf_msg_saved'] = 'Pr�f�rences enregistr�es';

// filters
$lang['filter_title'] = 'Filtres';

$lang['filter_new'] = 'Cr�er un filtre';
$lang['filter_desc'] = 'Choisissez les crit�res de recherche et les Action pour les messages entrants';
$lang['filter_list'] = 'Filtres actuels';

$lang['filter_field_from'] = 'De:';
$lang['filter_field_to'] = 'A:';
$lang['filter_field_subject'] = 'Sujet';
$lang['filter_field_header'] = 'Header';
$lang['filter_field_body'] = 'Body';

$lang['filter_type_move'] = 'D�placer';
$lang['filter_type_delete'] = 'Supprimer';
$lang['filter_type_mark'] = 'Marquer comme lu';

$lang['filter_add'] = 'Ajouter un filtre';
$lang['filter_delete'] = 'Supprimer un filtre';
$lang['filter_delete_selected'] = 'Supprimer les filtres s�lectionn�s';

$lang['filter_field'] = 'Filtre sur le champ';
$lang['filter_match'] = 'Rechercher';
$lang['filter_type'] = 'Action'; // FIXME: need translation
$lang['filter_folder'] = 'Dossier de destination';

$lang['filter_msg_nofilters'] = 'Aucun filtres disponibles.';
$lang['filter_msg_added'] = 'Filtre ajout�';
$lang['filter_msg_deleted'] = 'Filtre supprim�';


// [Catch]
$lang['ctc_title'] = 'Capturer une adresse';
$lang['ctc_information'] = 'Seuls les e-mails valides qui ne sont pas encore dans ce carnet seront ajout�s';
$lang['ctc_name'] = 'Nom';
$lang['ctc_email'] = 'e-Mail';
$lang['ctc_no_address'] = 'Pas d\'adresse disponible ';
$lang['ctc_close'] = 'Fermer';
$lang['ctc_save'] = 'Enregistrer';

// [Readmsg]
$lang['next_mnu'] = 'Suivant';
$lang['previous_mnu'] = 'Pr�c�dent';
$lang['back_mnu'] = 'Retour';
$lang['reply_mnu'] = 'R�pondre';
$lang['reply_all_mnu'] = 'R�pondre � tous';
$lang['forward_mnu'] = 'Transf�rer';
$lang['headers_mnu'] = 'En-t�te';
$lang['move_mnu'] = 'D�placer dans';
$lang['move_to_trash_mnu'] = 'D�placer vers la corbeille';
$lang['delete_mnu'] = 'Supprimer';
$lang['print_mnu'] = 'Imprimer';
$lang['download_mnu'] = 'Download';

$lang['from_hea'] = 'De:';
$lang['to_hea'] = 'A:';
$lang['cc_hea'] = 'Copies:';
$lang['date_hea'] = 'Date:';
$lang['subject_hea'] = 'Objet:';
$lang['attach_hea'] = 'Pi�ces jointes:';

$lang['attch_name_hea'] = 'Nom';
$lang['attch_force_hea'] = 'T�l�charger';
$lang['attch_type_hea'] = 'Type';
$lang['attch_size_hea'] = 'Taille';
$lang['catch_address'] = 'Ajouter l\'adresse au carnet';
$lang['block_address'] = 'adresse de bloc';

// [Search]
$lang['sch_title'] = 'Search';
$lang['sch_information_text'] = 'Entrez le mot ou la phrase que vous d�sirez trouver.<br> La recherche sera uniquement effectu�e sur les messages des <b>dossiers locaux</b> ou sur les <b>messages lus<b>.';
$lang['sch_button_text'] = 'Rechercher &gt;&gt;';
$lang['sch_subject_hea'] = 'Objet';
$lang['sch_from_hea'] = 'De';
$lang['sch_date_hea'] = 'Date';
$lang['sch_body_hea'] = 'Message';
$lang['sch_folder_hea'] = 'Dossier';
$lang['sch_no_results'] = 'Aucun message trouv�';

// [QuickAddress]
$lang['qad_title'] = 'Carnet d\'adresses';
$lang['qad_select_address'] = 'S�lectionnez un contact ';
$lang['qad_to'] = 'A';
$lang['qad_cc'] = 'Copies';
$lang['qad_bcc'] = 'Copies cach�es';

// [AddressBook]
// edit/display
$lang['adr_title'] = 'Carnet d\'adresses';
$lang['adr_name'] = 'Nom';
$lang['adr_email'] = 'e-Mail';
$lang['adr_street'] = 'Adresse';
$lang['adr_city'] = 'Ville';
$lang['adr_state'] = 'Etat';
$lang['adr_work'] = 'Travail';
$lang['adr_back'] = 'Retour';
$lang['adr_save'] = 'Enregistrer';
$lang['adr_phone'] = 'T�l�phone';
$lang['adr_cell'] = 'Cellule';
$lang['adr_note'] = 'Notes'; // FIXME: need translation

// list
$lang['adr_name_hea'] = 'Nom';
$lang['adr_email_hea'] = 'e-Mail';
$lang['adr_edit_hea'] = 'Modifier';
$lang['adr_expo_hea'] = 'Exportation';
$lang['adr_dele_hea'] = 'Supprimer';
$lang['adr_new_entry'] = 'Nouvelle entr�e';

$lang['addr_saved'] = 'Votre contact a �t� sauv�';
$lang['addr_added'] = 'Votre contact a �t� ajout�';
$lang['addr_deleted'] = 'Votre contact a �t� supprim�';


// [BlockSender]
$lang['blk_title'] = 'Block sender'; // FIXME: need translation
$lang['blk_information'] = 'Only shows e-mails that are not in the filter yet'; // FIXME: need translation
$lang['blk_email'] = 'E-mail'; // FIXME: need translation
$lang['blk_no_address'] = 'No address available';
$lang['blk_close'] = 'Fermer'; // FIXME: need translation
$lang['blk_save'] = 'Enregistrer';

// [Event]
$lang['evt_title'] = '�v�nement de calendrier';
$lang['evt_save'] = 'Enregistrer';
$lang['evt_delete'] = 'Supprimer';
$lang['evt_stop'] = 'Stop time'; // FIXME: need translation
$lang['evt_start'] = 'Start time'; // FIXME: need translation

