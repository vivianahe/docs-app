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
            $this->newDocument($request->type_document, $request->process, $request->content, $code);
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
    public function show(int $id)
    {
        $documentId =  Documents::find($id);
        return response()->json($documentId);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documents $documents)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $docExist = Documents::join('type_documents', 'type_documents.id', '=', 'documents.type_document_id')
        ->join('processes', 'processes.id', '=', 'documents.process_id')
        ->select('documents.*', 'type_documents.name as type_doc_name', 'type_documents.prefix as pref_doc', 'processes.name as process_name', 'processes.prefix as pre_process')
        ->where('documents.id', $id)->first();
        if ($docExist->type_document_id !== $request->type_document || $docExist->process_id !== $request->process || $docExist->content !== $request->content) {
            $lastCode = Documents::where([
                ['type_document_id', $request->type_document],
                ['process_id', $request->process]
            ])->value('code');

            if (empty($lastCode)) {
                $code = 1;
            } else {
                $code = $lastCode + 1;
            }
            unlink(public_path('support/doc/') . $docExist->pref_doc."-".$docExist->pre_process."-".$docExist->code . '.docx');
            $this->newDocument($request->type_document, $request->process, $request->content, $code);
        } else {
            $code = $docExist->code;
        }
        Documents::where('id', $id)->update([
            'name' => $request->name,
            'code' => $code,
            'content' => $request->content,
            'type_document_id' => $request->type_document,
            'process_id' => $request->process
        ]);
        return response()->json('ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Documents::join('type_documents', 'type_documents.id', '=', 'documents.type_document_id')
        ->join('processes', 'processes.id', '=', 'documents.process_id')
        ->select('documents.*', 'type_documents.name as type_doc_name', 'type_documents.prefix as pref_doc', 'processes.name as process_name', 'processes.prefix as pre_process')
        ->where('documents.id', $id)->first();
        if ($document) {
            unlink(public_path('support/doc/') . $document->pref_doc."-".$document->pre_process."-".$document->code . '.docx');
            $document->delete();
            return response()->json('ok');
        }
    }

    public function newDocument($type_document, $process, $content, $code)
    {
        $type_doc = TypeDocument::where('id', $type_document)->select('prefix as type')->first();
        $process = Process::where('id', $process)->select('prefix as proc')->first();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addText($content);
        $filename = $type_doc->type . "-" . $process->proc . "-" . $code . ".docx";

        $filePath = public_path('support/doc/') . $filename;

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);
    }

    public function getDataDocument($id)
    {
        $document = Documents::join('type_documents', 'type_documents.id', '=', 'documents.type_document_id')
        ->join('processes', 'processes.id', '=', 'documents.process_id')
        ->select('documents.code', 'type_documents.prefix as pref_doc', 'processes.prefix as pre_process')
        ->where('documents.id', $id)->first();
        return response()->json($document);
    }
}
