<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Image;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show($id)
    {
        // cercar la imatge o post amb la id
        $post = Image::find($id);

        // afegim una paginació de 6 comentaris, per no sobrecarregar el post de comentaris
        $comments = $post->comments()->paginate(6);

        // retornem els posts i els comentaris paginats
        return view('comments.create', compact('post', 'comments'));
    }

    public function upload(Request $request, $id)
    {
        $post = Image::find($id);
        $request->validate([
            'comment' => 'string|nullable|max:255',
        ]);

        // crear una nova instància de Comment
        $comment = new Comment();

        // assignem el contingut de l'input al content del comentari
        $comment->content = $request->input('comment');

        // assigem l'id de la imatge i de l'usuari al comentari
        $comment->image_id = $post->id;
        $comment->user_id = auth()->id();

        // desem el comentari a la base de dades
        $comment->save();

        // redirigim a la pàgina anterrior amb un missatge
        return redirect()->back()->with(['message' => 'Comment created successfully!']);
    }

    public function delete(Request $request, $id)
    {
        // cercar el comentari amb la id
        $comment = Comment::find($id);

        // eliminem el comentari
        $comment->delete();

        // redirigim a la pàgina anterior amb el missatge
        return redirect()->back()->with(['message' => 'Comment deleted successfully']);
    }
}