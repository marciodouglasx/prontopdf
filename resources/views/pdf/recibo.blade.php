<h2 style="text-align:center;">Recibo</h2>
<p>Recebi de <strong>{{ $nome }}</strong> (CPF: {{ $cpf ?? '---' }}) a quantia de <strong>{{ $valor ?? '---' }}</strong>.</p>
<p>Referente a: {{ $descricao }}</p>
<p>Data: {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}</p>
<p style="text-align:right;">Assinatura: ____________________</p>
