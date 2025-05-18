<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Resultados</title>
    <style>
        @page {
            size: A4 landscape;
        }

        body,
        html {
            margin: 0.5%;
            padding: 0;

        }

        td,
        th {
            border: 1px solid black;
            text-align: center
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px
        }
    </style>
</head>

<body>
    <h1 style="margin: 0 0 40px 0;text-align: center">Relatório de Entradas e Saídas</h1>
    <h3 style="text-align: center">Intervalo: {{ $report->mes }}/{{ $report->ano }} </h3>


    <table style="page-break-after: always; ">
        <caption>
            Receitas
        </caption>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Data de Pagamento</th>
                <th>Recorrência</th>

            </tr>
        </thead>
        <tbody>
            @php
                $totalCartao = 0;
            @endphp
            @foreach ($foo['bills_to_pay'] as $recebidos)
                @php
                    $totalCartao += $recebidos['amount'];
                @endphp
                <tr>
                    <td>{{ $recebidos['nome'] }}</td>
                    <td>{{ $recebidos['description'] }}</td>
                    <td>{{ $recebidos['category'] }}</td>
                    <td>{{ $recebidos['amount_formatted'] }}</td>
                    <td>{{ $recebidos['status'] }}</td>
                    <td>{{ $recebidos['due_date'] }}</td>
                    <td>{{ $recebidos['recurrence'] }}</td>

                </tr>
            @endforeach
            <tr>
                <td colspan="7">
                    Total {{ App\Helpers\Formatter::formatarParaReal($totalCartao) }}
                </td>
            </tr>
        </tbody>
    </table>

    <table style="page-break-after: always; ">
        <caption>
            Receitas
        </caption>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Data de Recebimento</th>
                <th>Recorrência</th>

            </tr>
        </thead>
        <tbody>
            @php
                $totalCartao = 0;
            @endphp
            @foreach ($foo['bills_to_receive'] as $recebidos)
                @php
                    $totalCartao += $recebidos['amount'];
                @endphp
                <tr>
                    <td>{{ $recebidos['nome'] }}</td>
                    <td>{{ $recebidos['description'] }}</td>
                    <td>{{ $recebidos['category'] }}</td>
                    <td>{{ $recebidos['amount_formatted'] }}</td>
                    <td>{{ $recebidos['status'] }}</td>
                    <td>{{ $recebidos['received_date'] }}</td>
                    <td>{{ $recebidos['recurrence'] }}</td>

                </tr>
            @endforeach
            <tr>
                <td colspan="7">
                    Total {{ App\Helpers\Formatter::formatarParaReal($totalCartao) }}
                </td>
            </tr>
        </tbody>
    </table>





</body>

</html>
