<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        return Blog::all();
    }

    public function show($slug)
    {
        return Blog::where('slug', $slug)->firstOrFail();
    }
}