<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProjectsImport;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $projects = Project::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('projects')->where(fn($q) => $q->where('tenant_id', auth()->user()->tenant_id)),
            ],
            'name' => 'required',
        ]);

        $data = $request->all();
        
        $data['tenant_id'] = auth()->user()->tenant_id;

        Project::create($data);

        return redirect()->route('projects.index')
            ->with('success', 'Project created');
    }


    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'code' => [
                'required',
                Rule::unique('projects')
                    ->where(fn($q) => $q->where('tenant_id', auth()->user()->tenant_id))
                    ->ignore($project->id),
            ],
            'name' => 'required',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')
            ->with('success', 'Project updated');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return back()->with('success', 'Project deleted');
    }

    // IMPORT
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new ProjectsImport, $request->file('file'));

        return back()->with('success', 'Import success');
    }
}
