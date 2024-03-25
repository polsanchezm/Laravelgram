<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // mètode per mostrar la vista on editem el perfil 
    public function edit()
    {
        return view('profile.edit');
    }

    public function updateProfileInfo(Request $request)
    {
        // obtenir el perfil autenticat i la seva id
        $user = Auth::user();
        $id = $user->id;

        // validem les dades de l'usuari
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => 'required|string|max:255|unique:users,nick,' . $id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // agafem les dades del formulari 
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');

        // verificar si hi ha imatge
        if ($request->hasFile('avatar')) {
            // esborrem la imatge antiga
            if ($user->avatar) {
                Storage::disk('users')->delete($user->avatar);
            }

            // agafem la ruta on desar la imatge 
            $path = $request->file('avatar')->store('/', 'users');

            // desem nomes el nom i extensió de la imatge
            $filename = basename($path);

            // afegim la imatge a l'usuari
            $user->avatar = $filename;
        }

        // actualitzem les dades de l'usuari
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;

        // desar els canvis a la bbdd
        $user->update();

        // redireccionar amb missatge d'èxit
        return redirect()->route('profile.editProfile')->with(['message' => 'Profile updated successfully!']);
    }

    public function updateCredentials(Request $request)
    {
        // obtenir el perfil autenticat i la seva id
        $user = Auth::user();
        $id = $user->id;

        // validem les dades del formulari
        $validate = $this->validate($request, [
            'password' => 'required|string|min:8|confirmed',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        // agafem les dades del formulari 
        $password = $request->input('password');
        $email = $request->input('email');

        // actualitzem les dades de l'usuari
        $user->password = $password;
        $user->email = $email;

        // desar els canvis a la bbdd
        $user->update();

        // redireccionar amb missatge d'èxit
        return redirect()->route('profile.editProfile')->with(['message' => 'Password updated successfully!']);
    }

    public function getImage($filename)
    {
        // comprovem si existeix una imatge de perfil
        if (Storage::disk('users')->exists($filename)) {
            // si és el cas, agafem l'arxiu i el seu tipus
            $file = Storage::disk('users')->get($filename);
            $type = Storage::disk('users')->mimeType($filename);
        } else {
            // si no existeix la imatge, agafem la default
            $defaultFilename = 'defaultAvatar.png';
            $file = Storage::disk('public')->get($defaultFilename);
            $type = Storage::disk('public')->mimeType($defaultFilename);
        }

        // retornem codi 200, imatge i tipus d'arxiu 
        return new Response($file, 200, ['Content-Type' => $type]);
    }

    public function search(Request $request)
    {
        // agafem les dades de la cerca
        $searchTerm = $request->input('search');

        // cerquem si es semblant al nom, cognoms o nickname
        $users = User::where('name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('surname', 'LIKE', "%{$searchTerm}%")
            ->orWhere('nick', 'LIKE', "%{$searchTerm}%")
            ->get();

        // renderitzem la vista de la cerca amb els perfils trobats 
        return view('profile.search', compact('users'));
    }
}
