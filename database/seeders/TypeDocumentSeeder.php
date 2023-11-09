<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeDocument;

class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeDocuments = [
            ['name' => 'Instructivo', 'prefix' => 'INS'],
            ['name' => 'Certificado', 'prefix' => 'CERT'],
            ['name' => 'Formulario', 'prefix' => 'FORM'],
            ['name' => 'Recibo', 'prefix' => 'REC'],
            ['name' => 'Informe', 'prefix' => 'INF'],
        ];
        foreach ($typeDocuments as $typeDocument) {
            TypeDocument::create([
                'name' => $typeDocument['name'],
                'prefix' => $typeDocument['prefix'],
            ]);
        }
    }
}
