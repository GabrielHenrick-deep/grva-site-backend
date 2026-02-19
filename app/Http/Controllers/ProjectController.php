<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        // return Project::all();
        return Project::with('members')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $imageUrl = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $imageUrl = url('storage/' . $path);
        }

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'image_url' => $imageUrl,
        ]);

        return response()->json($project, 201);
    }

    public function show($id)
    {
        // return Project::findOrFail($id);
        return Project::with('members')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $data = $request->only(['title', 'description', 'status']);

        if ($request->hasFile('image')) {
            if ($project->image_url) {
                $relativePath = str_replace(url('storage') . '/', '', $project->image_url);
                Storage::disk('public')->delete($relativePath);
            }

            $path = $request->file('image')->store('projects', 'public');
            $data['image_url'] = url('storage/' . $path);
        }

        $project->update($data);

        return response()->json($project, 200);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        if ($project->image_url) {
            $relativePath = str_replace(url('storage') . '/', '', $project->image_url);
            Storage::disk('public')->delete($relativePath);
        }

        $project->delete();

        return response()->json(['message' => 'Projeto deletado com sucesso']);
    }
}
