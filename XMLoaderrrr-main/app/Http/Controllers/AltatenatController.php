<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AltatenatController extends Controller
{
    public function altaTenant(Request $request){
        $tenantid = $request->tenantid;
    
        // Verifica si el tenant ya existe
        $tenantExists = \App\Models\Tenant::find($tenantid);
        if ($tenantExists) {
            return response()->json(
                ['message' => 'Este tenant ya existe.',
                'tipo' => 0,
                ]);
        }
    
        
        $tenant = \App\Models\Tenant::create([
            'id' => $tenantid           
        ]);
    
        $tenant->domains()->create([
            'domain' => $tenantid.'.localhost',
            'company' => $request->company,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
        // Crea la dirección del tenant
            'street' => $request->street,
            'interiorNo' => $request->interiorNo,
            'exteriorNo' => $request->exteriorNo,
            'colony' => $request->colony,
            'zip' => $request->zip,
        ]);
    
        return response()->json(['message' => 'El inquilino ha sido creado.', 'tipo' => 1,]);
    }
    
    
    
    

}
