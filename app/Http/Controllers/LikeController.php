<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    // mètode per comprovar els likes al carregar la pàgina
    public function checkLike(Request $request, $imageId)
    {
        // agafem la id de l'usuari loguejat
        $userId = Auth::user()->id;

        // cercar el like en funció de la id de l'usuari i la id de la imatge 
        $like = Like::where('user_id', $userId)->where('image_id', $imageId)->first();

        // agafem el total de likes de la imatge
        $totalLikes = Like::where('image_id', $imageId)->count();

        // si s'ha fet like a la imatge, retornem un json amb liked a true i els likes totals
        if ($like) {
            return response()->json(['liked' => true, 'totalLikes' => $totalLikes]);
        }

        // si NO s'ha fet like a la imatge, retornem un json amb liked a false i els likes totals
        return response()->json(['liked' => false, 'totalLikes' => $totalLikes]);
    }

    // mètode per fer / desfer likes al clicar el botó 
    public function toggleLike(Request $request, $imageId)
    {
        // agafem la id de l'usuari
        $userId = Auth::user()->id;

        // cercar el like en funció de la id de l'usuari i la id de la imatge 
        $like = Like::where('user_id', $userId)->where('image_id', $imageId)->first();

        // agafem el total de likes de la imatge
        $totalLikes = Like::where('image_id', $imageId)->count();

        if ($like) {
            // si existex el like, l'eliminem
            $like->delete();

            // retornem un json amb les dades necessaries i el missatge
            return response()->json(['success' => true, 'liked' => false, 'totalLikes' => $totalLikes, 'message' => 'Post disliked!']);
        }

        // si no existeix el like, crear una nova instància de like
        $like = new Like();

        // afegim la id de l'usuari al like
        $like->user_id = $userId;

        // afegim la id de la imatge al like
        $like->image_id = $imageId;

        // desem el like 
        $like->save();

        // retornem un json amb les dades necessaries i el missatge
        return response()->json(['success' => true, 'liked' => true, 'totalLikes' => $totalLikes, 'message' => 'Post liked!']);
    }
}
