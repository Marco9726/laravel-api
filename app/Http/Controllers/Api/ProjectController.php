<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;


class ProjectController extends Controller
{
	public function index()
	{
		// per utilizzare le foreign key associate, passo come parametri del metodo with() i nomi dei metodi delle relazioni presenti nel model Project
		$projects = Project::with('type', 'technologies')->paginate(9);
		return response()->json([
			'success' => true,
			'results' => $projects
		]);
	}

	public function show($slug)
	{
		$project = Project::with('type', 'technologies')->where('slug', $slug)->first();

		if ($project) {
			return response()->json([
				'success'  => true,
				'result'  => $project
			]);
		} else {
			return response()->json([
				'success' => false,
				'error' => 'Nessun progetto trovato'
			]);
		}
	}
}
