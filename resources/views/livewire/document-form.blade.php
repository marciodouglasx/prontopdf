@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3 text-capitalize">Gerar {{ $tipo }}</h2>

    <form method="POST" action="{{ route('document.generate', $tipo) }}">
        @csrf

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>CPF (opcional)</label>
            <input type="text" name="cpf" class="form-control">
        </div>

        <div class="mb-3">
            <label>Descrição</label>
            <textarea name="descricao" class="form-control" required></textarea>
        </div>

        @if($tipo === 'recibo')
        <div class="mb-3">
            <label>Valor</label>
            <input type="text" name="valor" class="form-control">
        </div>
        @endif

        <div class="mb-3">
            <label>Data</label>
            <input type="date" name="data" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Gerar PDF</button>
    </form>
</div>
@endsection
