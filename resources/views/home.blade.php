@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1 class="mb-4">Gerador de Documentos Online</h1>
    <p>Escolha o tipo de documento que deseja gerar:</p>

    <div class="d-flex justify-content-center gap-3 mt-4">
         <form method="POST" action="{{ route('payment.create') }}">
            @csrf
            <input type="hidden" name="tipo" value="recibo">
            <button type="submit" class="btn btn-primary">Gerar Recibo (R$10)</button>
        </form>

        <form method="POST" action="{{ route('payment.create') }}">
            @csrf
            <input type="hidden" name="tipo" value="declaracao">
            <button type="submit" class="btn btn-secondary">Gerar Declaração (R$10)</button>
        </form>

        <form method="POST" action="{{ route('payment.create') }}">
            @csrf
            <input type="hidden" name="tipo" value="relatorio">
            <button type="submit" class="btn btn-info">Gerar Relatório (R$10)</button>
        </form>
    </div>
</div>
@endsection