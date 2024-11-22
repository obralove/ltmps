<?php

namespace App\Http\Controllers;

use App\Http\Requests\LiveStockCreateRequest;
use App\Models\Livestock;
use Illuminate\Http\Request;
use App\Models\Medical;
use App\Models\Vaccination;
use Illuminate\Support\Facades\Storage;


use Illuminate\Support\Str;

class LivestockController extends Controller
{
    public function index(Request $request)
    {
       
        $query = Livestock::query();

        
        if ($request->has('owner') && $request->owner !== null) {
            $query->where('owner', 'like', '%' . $request->input('owner') . '%');
        }

        
        if ($request->has('species') && $request->species !== null) {
            $query->where('species', 'like', '%' . $request->input('species') . '%');
        }

       
        if ($request->has('veterinarian') && $request->veterinarian !== null) {
            $query->where('veterinarian', 'like', '%' . $request->input('veterinarian') . '%');
        }
        
       
        $livestocks = $query->paginate(10);

        
        return view('livestocks.index', compact('livestocks'));
    }

    public function create()
    {
        
        return view('livestocks.create');
    }
    
    public function show($id)
    {
   
    $livestock = Livestock::findOrFail($id);

    
    $medicals = Medical::where('livestock_id', $id)->get();
    $vaccinations = Vaccination::where('livestock_id', $id)->get();

    
    return view('livestocks.show', compact('livestock', 'medicals', 'vaccinations'));
    }

    public function getLivestockByQrCode(Request $request)
    {
        $qrCodeHash = $request->input('qr-code');

        
        $livestock = Livestock::where('tag', $qrCodeHash)->get(["id", "owner", "name", "veterinarian", "date_of_birth", "species", "picture", "tag"]);

        if ($livestock->isNotEmpty()) {
            
            return response()->json([
                "data" => $livestock->first()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Livestock not found'
            ], 404);
        }
    }




    public function store(LiveStockCreateRequest $request)
    {
       
        do {
            $tagNumber = 'TAG-' . strtoupper(Str::random(8));
        } while (Livestock::where('tag', $tagNumber)->exists());

        
        $picturePath = $request->file('picture')->store('livestock_pictures', 'public');

        
        $livestock = Livestock::create([
            'owner' => $request['owner'],
            'veterinarian' => $request['veterinarian'],
            'name' => $request['name'],
            'date_of_birth' => $request['date_of_birth'],
            'species' => $request['species'],
            'tag' => $tagNumber,
            'picture' => $picturePath,
        ]);

       
        \DB::connection('mysql_backup')->table('livestocks')->insert([
            'owner' => $request['owner'],
            'veterinarian' => $request['veterinarian'],
            'name' => $request['name'],
            'date_of_birth' => $request['date_of_birth'],
            'species' => $request['species'],
            'tag' => $tagNumber,
            'picture' => $picturePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('livestocks.index')
                         ->with('success', 'Livestock record created successfully.');
    }

    public function edit($id)
    {
       
        $livestock = Livestock::findOrFail($id);
       
        return view('livestocks.edit', compact('livestock'));
        
        $medicals = Medical::all();
        $vaccinations = Vaccination::all();
        $livestocks = Livestock::all();


       
        return view('livestock', compact('vaccinations', 'medicals','livestocks'));
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'owner' => 'required|string',
            'veterinarian' => 'required|string',
            'name' => 'required|string',
            'date_of_birth' => 'required|date',
            'species' => 'required|string',
            'picture' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

      
        $livestock = Livestock::findOrFail($id);

        $livestock->update($request->except('picture'));

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('livestock_pictures', 'public');
            $livestock->update(['picture' => $path]);
        }

        return redirect()->route('livestocks.index')->with('success', 'Livestock updated successfully!');
    }
    public function showdeleted()
    {
        $livestocks = Livestock::onlyTrashed()->get();
    
        return view('livestocks.showdeleted', compact('livestocks'));
    }

    public function destroy($id)
    {
        
        $livestock = Livestock::findOrFail($id);
        $livestock->delete();

        
        return redirect()->route('livestocks.index')->with('success', 'Livestock deleted successfully!');
    }
    

    
}
