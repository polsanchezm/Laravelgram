<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Image;

class ImageController extends Controller
{
    // mètode que mostra el formulari per crear un post nou
    public function create()
    {
        return view('posts.create');
    }

    public function index()
    {
        // cercar els posts en funció de la data de creació descendentment afegint paginació de 3 posts
        $posts = Image::orderBy('created_at', 'desc')->paginate(3);

        // retornem els posts a la vista index
        return view('posts.index', compact('posts'));
    }

    public function userPosts($userId)
    {
        // cercar els posts de l'usuari, en funció de la data de creació descendentment
        // també retornem un comptador de posts
        $user = User::with([
            'images' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->withCount('images')->findOrFail($userId);

        // retornem les dades anteriors de l'usuari al detall, per mostrar el perfil de l'usuari
        return view('profile.detail', compact('user'));
    }
    public function getImage($filename)
    {
        // obtenim les imatges i el tipus d'imatge des de l'storage
        $file = Storage::disk('images')->get($filename);
        $type = Storage::disk('images')->mimeType($filename);

        // retornem codi 200 amb l'arxiu i el tipus d'arxiu
        return new Response($file, 200, ['Content-Type' => $type]);
    }

    public function upload(Request $request)
    {
        // validem les dades del post
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        // agafem la ruta de la imatge
        $imagePath = $request->file('image')->store('/', 'images');

        // desem només el nom de la imatge
        $imageName = basename($imagePath);

        // crear una nova instància d'imatge
        $image = new Image();

        // afegim el nom de la imatge a la bbdd
        $image->image_path = $imageName;

        // afegim la descripció del formulari a la bbdd
        $image->description = $request->description;

        // vincular la id de l'usuari amb la id de l'usuari loguejat
        $image->user_id = auth()->id();

        // desem el post
        $image->save();

        // redirigim a la ruta on mostrem tots els posts amb el missatge
        return redirect()->route('posts.showAll')->with(['message' => 'Post created successfully!']);
    }

    public function delete(Request $request, $id)
    {
        // cercar el post en funció de la seva id
        $image = Image::find($id);

        // eliminem el post
        $image->delete();

        // redirigim a la ruta on mostrem tots els posts amb el seu missatge corresponent
        return redirect()->route('posts.showAll')->with(['message' => 'Post deleted successfully']);
    }
}
