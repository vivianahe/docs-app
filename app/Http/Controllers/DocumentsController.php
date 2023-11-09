<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\Process;
use App\Models\TypeDocument;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Documents::join('type_documents', 'type_documents.id', '=', 'documents.type_document_id')
            ->join('processes', 'processes.id', '=', 'documents.process_id')
            ->select('documents.*', 'type_documents.name as type_doc_name', 'type_documents.prefix as pref_doc', 'processes.name as process_name', 'processes.prefix as pre_process')
            ->get();
        return response()->json($documents);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lastCode = Documents::where([
            ['type_document_id', $request->type_document],
            ['process_id', $request->process]
        ])->value('code');

        if (empty($lastCode)) {
            $code = 1;
        } else {
            $code = $lastCode + 1;
        }
        try {
            $type_doc = TypeDocument::where('id', $request->type_document)->select('prefix as type')->first();
            $process = Process::where('id', $request->process)->select('prefix as proc')->first();

            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $section = $phpWord->addSection();
            $text = $section->addText($request->content);
            $filename = $type_doc->type . "-" . $process->proc . "-" . $code . ".docx";

            $filePath = public_path('support/doc/') . $filename;

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($filePath);

            Documents::create([
                'name' => $request->name,
                'code' => $code,
                'content' => $request->content,
                'type_document_id' => $request->type_document,
                'process_id' => $request->process
            ]);
            return response()->json('ok');
        } catch (\Exception $e) {
            // Manejar la excepción
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $documentId =  Documents::join('type_documents', 'type_documents.id', '=', 'documents.type_document_id')
            ->join('processes', 'processes.id', '=', 'documents.process_id')->select('documents.*', 'type_documents.name as type_doc_name', 'documents.name as document_name')
            ->find($id);
        return response()->json($documentId);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documents $documents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Documents $documents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Documents::find($id);
        if ($document) {
            unlink(public_path('support/docs/') . $document->doc);
            $document->delete();
        }
    }
}
