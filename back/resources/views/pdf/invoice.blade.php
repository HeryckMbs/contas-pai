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
    <h1 style="margin: 0 0 40px 0;text-align: center">Relatório de Cartões de Crédito</h1>
    <h3 style="text-align: center">Intervalo: {{$report->mes}}/{{$report->ano}} </h3>

    @foreach ($foo as $cartao => $compras)
        @php
            $totalCartao = 0;
        @endphp
        
        <table  style="page-break-after: always; ">
            <caption>
                Fatura Cartão : {{ $cartao }}
            </caption>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Valor</th>
                    <th>Pago</th>
                    <th>Data de compra</th>
                    <th>N° Parcela</th>
                    <th>Descrição</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($compras as $purchase)
                    @php
                        $totalCartao += $purchase['amount'];
                    @endphp
                    <tr>
                        <td>{{ $purchase['purchase_date'] }}</td>
                        <td>{{ $purchase['description'] }}</td>
                        <td>{{ $purchase['amount_formatted'] }}</td>
                        <td>{{ $purchase['name'] }}</td>
                        <td>{{ $purchase['payed'] }}</td>
                        <td>{{ $purchase['installment'] }}</td>
                        <td>{{ $purchase['category'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="7">
                       Total {{ App\Helpers\Formatter::formatarParaReal($totalCartao) }}
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach






</body>

</html>
