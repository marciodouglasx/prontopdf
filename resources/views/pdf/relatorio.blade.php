<h2 style="text-align:center;">Relatório</h2>
<p><strong>Título:</strong> {{ $descricao }}</p>
<p>Autor: {{ $nome }}</p>
<p>Data: {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}</p>
