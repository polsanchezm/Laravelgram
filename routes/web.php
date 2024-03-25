<?php

use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;

// rutes per al login i registre
Auth::routes();

// ruta home que ens redirigeix als posts
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// grup de rutes dels perfils
Route::prefix('/profile')->name('profile.')->middleware('auth')->group(function () {

    // posts de l'usuari
    Route::get('/posts/{userId}', [ImageController::class, 'userPosts'])->name('userPosts');

    // editar el perfil
    Route::get('/edit', [ProfileController::class, 'edit'])->name('editProfile');

    // resultat de la cerca
    Route::get('/search-result', [ProfileController::class, 'search'])->name('searchProfile');

    // obtenir l'avatar
    Route::get('/avatar/{filename}', [ProfileController::class, 'getImage'])->name('avatar');

    // grup de rutes per editar el perfil
    Route::prefix('/update')->name('update.')->middleware('auth')->group(function () {
        // editar les dades del perfil (nom, cognom, nick i avatar)
        Route::post('/profileInfo', [ProfileController::class, 'updateProfileInfo'])->name('profileInfo');

        // editar credencials del perfil (email i password)
        Route::post('/credentials', [ProfileController::class, 'updateCredentials'])->name('credentials');

    });
});

// grup de rutes dels posts
Route::prefix('/posts')->name('posts.')->middleware('auth')->group(function () {

    // mostrar tots els posts
    Route::get('/', [ImageController::class, 'index'])->name('showAll');

    // mostrar el formulari per crear un post nou
    Route::get('/create', [ImageController::class, 'create'])->name('createPost');

    // crear el post
    Route::post('/upload', [ImageController::class, 'upload'])->name('uploadPost');

    // eliminar el post
    Route::post('/delete/{id}', [ImageController::class, 'delete'])->name('deletePost');

    // obtenir la imatge del post
    Route::get('/image/{filename}', [ImageController::class, 'getImage'])->name('getImage');

    // fer / desfer like al post
    Route::post('/like/{image_id}', [LikeController::class, 'toggleLike'])->name('like');

    // comprovar els likes del post
    Route::get('/like/check/{image_id}', [LikeController::class, 'checkLike'])->name('like');

    // grup de rutes per als comentaris
    Route::prefix('/comments')->name('comments.')->middleware('auth')->group(function () {
        // mostrar tots els comentaris del post
        Route::get('/{id}', [CommentController::class, 'show'])->name('showComments');

        // crear un comentari nou
        Route::post('/create/{id}', [CommentController::class, 'upload'])->name('uploadComment');

        // eliminar el comentari
        Route::post('/delete/{id}', [CommentController::class, 'delete'])->name('deleteComment');
    });
});
