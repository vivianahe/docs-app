<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Documents::join('type_documents', 'type_documents.id', '=', 'documents.type_document_id')
            ->join('processes', 'processes.id', '=', 'documents.process_id')->select('documents.*', 'type_documents.name as type_doc_name', 'processes.name as document_na')
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
        $lastCode = Documents::max('code');
        if (empty($lastCode)) {
            $code = 1;
        } else {
            $code = $lastCode + 1;
        }

        $doc = $request->file('doc');
        $fileDoc = $doc->getClientOriginalExtension();
        $name_doc = $request->date . $fileDoc;
        Storage::disk('docs')->put($name_doc, file_get_contents($doc->getRealPath()));

        Documents::Create([
            'name' => $request->name,
            'code' => $code,
            'content' => $request->content,
            'type_document_id' => $request->type_document_id,
            'process_id' => $request->process_id,
            'doc' => $name_doc
        ]);
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
