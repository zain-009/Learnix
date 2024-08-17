<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function uploadMaterial(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:50000',
            'title' => 'required',
            'classId' => 'required|exists:class,id',
        ]);
        
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/materials');

            $material = new Material();
            $material->title = $request->input('title');
            $material->file = $path;
            $material->class_id = $request->input('classId');
            if ($request->input('instructions') != '') {
                $material->instructions = $request->input('instructions');
            }
            $material->save();
            return redirect()->back();
        }
    }

    public function deleteMaterial(Request $request)
    {
        $material = Material::find($request->input('materialId'));

        if ($material) {
            if (Storage::exists($material->file)) {
                Storage::delete($material->file);
            }

            $material->delete();

            return redirect()->back();
        }
    }
}
