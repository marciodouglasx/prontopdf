<h2 style="text-align:center;">Declaração</h2>
<p>Declaro para os devidos fins que <strong>{{ $nome }}</strong> (CPF: {{ $cpf ?? '---' }}) {{ $descricao }}</p>
<p>Feito em {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}</p>
<p style="text-align:right;">Assinatura: ____________________</p>
