<?php

use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PreferenceController;
use App\Http\Middleware\authUser;
use Illuminate\Support\Facades\Route;


    Route::get('/',[AuthController::class,'index'])->name('auth.index');
    Route::get('/login',[AuthController::class,'login'])->name('auth.login');
    Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');
    Route::get('/forgetPassword',[AuthController::class,'forgetPassword'])->name('auth.forgetPassword');
    Route::post('/emailSearch',[AuthController::class,'emailSearch'])->name('auth.emailSearch');
    Route::get('/email/forgetPassword/{user}',[EmailController::class,'forgetPassword'])->name('email.forgetPassword');
    Route::get('/resetPassword/{user}',[AuthController::class,'restPassword'])->name('auth.resetPassword');
    Route::post('/update/password/{user}',[AuthController::class,'updatePassword'])->name('auth.updatePassword');
    Route::get('/modifier/password',[AuthController::class,'editPassword'])->name('auth.password');
    Route::post('/update/password',[AuthController::class,'updatePasswordProfile'])->name('auth.editPassword');

    Route::middleware([authUser::class])->group(function () {


    Route::get('/profile',[AuthController::class,'profile'])->name('auth.profile');
    Route::post('/profile/edit',[AuthController::class,'editProfile'])->name('auth.edit');
    Route::get('/audio/settings', [PreferenceController::class, 'index'])->name('audio.settings');
    Route::post('/audio/upload', [PreferenceController::class, 'upload'])->name('audio.upload');

    Route::get('/eleves', [EleveController::class, 'index'])->name('eleves.index');
    Route::get('/eleves/{id}', [EleveController::class, 'show'])->name('eleves.show');
    Route::get('/liste/reussis', [EleveController::class, 'elevesReussis'])->name('liste.reussis');
    Route::put('/update-statuts', [EleveController::class, 'updateStatutBatch'])->name('update.statut.batch');
    Route::put('/eleves/{id}/update-statut', [EleveController::class, 'updateStatut'])->name('eleves.update_statut');
    Route::put('/eleves/{id}/revert-statut', [EleveController::class, 'revertStatut'])->name('eleves.revert_statut');
    Route::get('/eleves/{id}/traiter-paiement', [PaiementController::class, 'traiter'])->name('paiements.traiter');
    Route::post('/paiements/store', [PaiementController::class, 'store'])->name('paiements.store');
    Route::get('paiements/liste/{id}', [PaiementController::class, 'liste'])->name('paiements.liste');
    Route::get('/paiements/{id}/edit', [PaiementController::class, 'edit'])->name('paiements.edit');
    Route::put('/paiements/{id}', [PaiementController::class, 'update'])->name('paiements.update');
    Route::delete('/paiement/{id}', [PaiementController::class, 'destroy'])->name('paiements.destroy');

    Route::get('/frais/corbeille', [ArchiveController::class, 'corbeille'])->name('frais.corbeille');
    Route::get('/frais/corbeille/eleve/{id}', [ArchiveController::class, 'corbeilleEleve'])->name('frais.corbeille.eleve');
    Route::get('/frais/restore/{id}', [ArchiveController::class, 'restore'])->name('frais.restore');
    Route::get('/frais/restore-all', [ArchiveController::class, 'restoreAll'])->name('frais.restoreAll');
    Route::get('/corbeille/{eleve_id}/restore/{id}', [ArchiveController::class, 'restoreForEleve'])->name('frais.restore.eleve');
    Route::get('/corbeille/{eleve_id}/restore-all', [ArchiveController::class, 'restoreAllForEleve'])->name('frais.restore.all.eleve');
    Route::delete('/frais/corbeille/vider', [ArchiveController::class, 'viderCorbeilleGenerale'])->name('frais.viderCorbeille');
    Route::delete('/frais/corbeille/vider/{eleve}', [ArchiveController::class, 'viderCorbeilleParEleve'])->name('frais.viderCorbeille.eleve');

    Route::get('/archive-frais', [ArchiveController::class, 'archiveFrais'])->name('archive.frais');
    Route::get('/frais-archives', [ArchiveController::class, 'archivedFrais'])->name('archived.frais');
    Route::delete('/archives/vider', [ArchiveController::class, 'viderArchives'])->name('vider.archives');

    Route::get('paiement/print/{id}', [PaiementController::class, 'print'])->name('paiement.print');


    Route::get('/eleve/ajouter',[EleveController::class,'ajouterEleve'])->name('eleve.ajoute');
    Route::get('/eleve/filterNiveaux',[EleveController::class,'filterNiveau']);
    Route::get('/eleve/filterClasses', [EleveController::class, 'filterClasses']);
    Route::post('/eleve/store',[EleveController::class,'storeEleve'])->name('eleve.store');
    Route::get('/eleve/modifier/{eleve}',[EleveController::class,'modifierEleve'])->name('eleve.modifier');
    Route::put('/eleve/update/{eleve}',[EleveController::class,'updateEleve'])->name('eleve.update');

    Route::get('/cycle',[AdministrationController::class,'listeCycle'])->name('cycle.liste');
    Route::get('/ajouter/cycle',[AdministrationController::class,'ajouterCycle'])->name('cycle.ajouter');
    Route::post('/ajouter/cycle',[AdministrationController::class,'storeCycle'])->name('cycle.store');
    Route::get('/modifier/cycle/{cycle}',[AdministrationController::class,'modifierCycle'])->name('cycle.modifier');
    Route::put('/modifier/cycle/{cycle}',[AdministrationController::class,'updateCycle'])->name('cycle.update');
    Route::delete('/supprimer/cycle/{cycle}',[AdministrationController::class,'deleteCycle'])->name('cycle.delete');

    Route::get('/niveau',[AdministrationController::class,'listeNiveau'])->name('niveau.liste');
    Route::get('/filtre/niveau',[AdministrationController::class,'filtreNiveau'])->name('niveau.filtre');
    Route::get('/ajouter/niveau',[AdministrationController::class,'ajouterNiveau'])->name('niveau.ajouter');
    Route::post('/ajouter/niveau',[AdministrationController::class,'storeNiveau'])->name('niveau.store');
    Route::get('/modifier/niveau/{niveau}',[AdministrationController::class,'modifierNiveau'])->name('niveau.modifier');
    Route::put('/modifier/niveau/{niveau}',[AdministrationController::class,'updateNiveau'])->name('niveau.update');
    Route::delete('/supprimer/niveau/{niveau}',[AdministrationController::class,'deleteNiveau'])->name('niveau.delete');

    Route::get('/classes', [AdministrationController::class, 'indexClasse'])->name('classes.index');
    Route::get('/classes/filter', [AdministrationController::class, 'filterClasse'])->name('classes.filter');
    Route::get('/classes/create', [AdministrationController::class, 'insertClasse'])->name('classes.create');
    Route::post('/classes/store', [AdministrationController::class, 'storeClasse'])->name('classes.store');
    Route::get('/classes/{classe}/edit', [AdministrationController::class, 'editClasse'])->name('classes.edit');
    Route::put('/classes/{classe}/update', [AdministrationController::class, 'updateClasse'])->name('classes.update');
    Route::delete('/classes/{classe}/delete', [AdministrationController::class, 'deleteClasse'])->name('classes.destroy');


    Route::get('/caisse', [CaisseController::class, 'index'])->name('index.frais');
    Route::get('/caisse/inscription', [CaisseController::class, 'inscription'])->name('inscription.frais');
    Route::get('/caisse/transport', [CaisseController::class, 'transport'])->name('transport.frais');
    Route::get('/caisse/scolaire', [CaisseController::class, 'scolaire'])->name('scolaire.frais');

    });