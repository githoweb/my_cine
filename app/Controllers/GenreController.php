<?php

namespace App\Controllers;

use App\Models\Genre;

class GenreController extends CoreController
{
  public function delete($id)
    {
        $genre = Genre::find($id);

        $tokenCsrf = filter_input(INPUT_GET, 'tokenCsrf');

        if ($genre === null || $genre === false || !self::checkCsrf($tokenCsrf)) {
            header('HTTP/1.0 404 Not Found');
        } else {
            $genre->delete();
            header("Location: /user/genres-list");
        }
    }
}
