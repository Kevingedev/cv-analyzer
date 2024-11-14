<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class AllDocumentController extends Controller
{
    //
    public function index()
    {
        
        $documents = Document::all();

        return view('all-documents', compact('documents'));
    }

    public function view($id)
    {
        
        $document = Document::find($id);

        return view('view_document', compact('document'));
    }
}
