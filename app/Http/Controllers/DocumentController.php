<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
      public function index()
    {
        return view('home');
    }

    public function create($tipo)
    {
        $tipos = ['recibo', 'declaracao', 'relatorio'];
        abort_unless(in_array($tipo, $tipos), 404);

        if (!session('paid')) {
            return redirect()->route('home')->with('error', 'Efetue o pagamento para gerar o documento.');
        }

        return view('livewire.document-form', compact('tipo'));
    }

    public function generate(Request $request, $tipo)
    {
        $data = $request->validate([
            'nome' => 'required|string',
            'cpf' => 'nullable|string',
            'descricao' => 'required|string',
            'valor' => 'nullable|string',
            'data' => 'required|date',
        ]);

        $pdf = Pdf::loadView('pdf.' . $tipo, $data);
        return $pdf->download($tipo . '.pdf');
    }
}
