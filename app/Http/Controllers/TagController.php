<?php

namespace App\Http\Controllers;

use App\Http\Resources\Tag\TagCollection;
use App\Models\Tag;

class TagController extends Controller
{
    public function index(Tag $tag): TagCollection
    {
        return $this->tagResponseCollection($tag);
    }
}
