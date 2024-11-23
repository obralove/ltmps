<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaccination;
use App\Models\Medical;
use App\Models\Livestock;
use Illuminate\Support\Facades\Crypt;


class VaccinationController extends Controller
{
    public function create($livestockId)
    {
        
        return view('vaccinations.create', ['livestock_id' => $livestockId]);
    }
    public function index()
    {
        
        $medicals = Medical::all();
        
        
        $vaccinations = Vaccination::all();
        
        
        $livestocks = Livestock::all(); 
        
        
        return view('livestock', compact('vaccinations', 'livestocks'));
    }
    public function show($id)
{
    
    $livestock = Livestock::findOrFail($id);

    
    $medicals = Medical::where('livestock_id', $id)->get();
    $vaccinations = Vaccination::where('livestock_id', $id)->get();

    
    return view('livestocks.show', compact('livestock', 'medicals', 'vaccinations'));
}

public function store(Request $request, Vaccination $vaccinations)
{
    $validatedData = $request->validate([
        'date' => ['required', 'string', function ($attribute, $value, $fail) {
            if (Vaccination::where('date', $value)->exists() || Medical::where('date', $value)->exists()) {
                $fail('The date is not available.');
            }
        },],
        'vaccination' => ['required', 'array'],
        'booster' => 'required|string',
        'livestock_id' => 'required|exists:livestocks,id',
        'veterinarian' => 'required|string',
    ]);

    $validatedData['vaccination'] = implode(', ', $request['vaccination']);

 
    $vaccinations->date = $validatedData['date'];
    $vaccinations->vaccination = $validatedData['vaccination'];
    $vaccinations->booster = $validatedData['booster'];
    $vaccinations->livestock_id = $validatedData['livestock_id'];
    $vaccinations->veterinarian = $validatedData['veterinarian'];
    $vaccinations->user_id = auth()->user()->id;
    $vaccinations->save();

    
    $livestock = Livestock::findOrFail($validatedData['livestock_id']);
    $backupLivestock = \DB::connection('mysql_backup')->table('livestocks')
                        ->where('id', $livestock->id)
                        ->first();

    if (!$backupLivestock) {
        
        \DB::connection('mysql_backup')->table('livestocks')->insert([
            'id' => $livestock->id,
            'owner' => $livestock->owner,
            'veterinarian' => $livestock->veterinarian,
            'name' => $livestock->name,
            'date_of_birth' => $livestock->date_of_birth,
            'species' => $livestock->species,
            'tag' => $livestock->tag,
            'picture' => $livestock->picture,
            'created_at' => $livestock->created_at,
            'updated_at' => $livestock->updated_at,
        ]);
    }

   
    \DB::connection('mysql_backup')->table('vaccinations')->insert([
        'date' => $validatedData['date'],
        'vaccination' => $validatedData['vaccination'],
        'booster' => $validatedData['booster'],
        'livestock_id' => $validatedData['livestock_id'],
        'veterinarian' => $validatedData['veterinarian'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('livestocks.show', ['livestock' => $request->livestock_id])
                     ->with('success', 'Vaccination record added successfully.');
}



    public function edit($id)
    {
        $vaccination = Vaccination::findOrFail($id);
        $livestock = Livestock::findOrFail($vaccination->livestock_id);
        return view('vaccinations.edit', compact('vaccination', 'livestock'));
    }
    
public function update(Request $request, Vaccination $vaccination)
{    
    $validatedData = $request->validate([
        'id' => 'required|string',
        'date' => 'required|date',
        'vaccination' => 'required|string',
        'booster' => 'nullable|string',
    ]);

    $id = Crypt::decrypt($request->id);
    $vaccination = Vaccination::findOrFail($id);

   
    $vaccination->date = $validatedData['date'];
    $vaccination->vaccination = $validatedData['vaccination'];
    $vaccination->booster = $validatedData['booster'];
    $vaccination->updated_at = now()->format('Y-m-d H:i:s');

    $vaccination->save();

   
    return redirect()->route('livestocks.show', ['livestock' => $vaccination->livestock_id])
                     ->with('success', 'vaccination record updated successfully.');
}

public function destroy(Request $request)
{
    $vaccination_row = Vaccination::findOrFail($request->id);
    $livestockId = $vaccination_row->livestock_id; 
    $vaccination_row->delete();

    return redirect()->route('livestocks.show', ['livestock' => $livestockId])
                     ->with('success', 'Vaccination record deleted successfully.');
}
public function apiStore(Request $request)
{
    $validatedData = $request->validate([
        'date' => 'required|string',
        'vaccination' => 'required|string',
        'booster' => 'required|string',
        'livestock_id' => 'required|exists:livestocks,id'
    ]);


    $validatedData['user_id'] = auth()->user()->id;
    
    $vaccination = Vaccination::create($validatedData);


    
    $livestock = Livestock::findOrFail($validatedData['livestock_id']);
    $backupLivestock = \DB::connection('mysql_backup')->table('livestocks')
                        ->where('id', $livestock->id)
                        ->first();

    if (!$backupLivestock) {
        
        \DB::connection('mysql_backup')->table('livestocks')->insert([
            'id' => $livestock->id,
            'owner' => $livestock->owner,
            'veterinarian' => $livestock->veterinarian,
            'name' => $livestock->name,
            'date_of_birth' => $livestock->date_of_birth,
            'species' => $livestock->species,
            'tag' => $livestock->tag,
            'picture' => $livestock->picture,
            'created_at' => $livestock->created_at,
            'updated_at' => $livestock->updated_at,
        ]);
    }

    
    \DB::connection('mysql_backup')->table('vaccinations')->insert([
        'date' => $validatedData['date'],
        'vaccination' => $validatedData['vaccination'],
        'booster' => $validatedData['booster'],
        'livestock_id' => $validatedData['livestock_id'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Vaccination record added successfully.',
        'data' => $vaccination
    ], 201);
}
public function apiUpdate(Request $request, $id)
{
    $validatedData = $request->validate([
        'date' => 'required|date',
        'vaccination' => 'required|string',
        'booster' => 'nullable|string'
    ]);

    $vaccination = Vaccination::findOrFail($id);
    $vaccination->update($validatedData);

    return response()->json([
        'success' => true,
        'message' => 'Vaccination record updated successfully.',
        'data' => $vaccination
    ], 200);
}
public function records($id) {
    return response()->json(
        Vaccination::where("livestock_id", $id)->latest()->get()
        ->transform(function($record) {
            return [
                "id" => $record->id,
                "vaccination" => $record->vaccination,
                "booster" => $record->booster,
                "date" => $record->date,
            ];
        })
    );
}



}

