<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">




    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
        }

        .logo {
            width: 110px;
        }

        .titulo {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .label {
            background-color: #d9d9d9;
            font-weight: bold;
        }

        .tabla-materiales th {
            background-color: #d9d9d9;
            font-weight: bold;
            text-align: center;
        }

        .tabla-materiales td {
            text-align: center;
        }

        .tabla-materiales td:nth-child(2) {
            text-align: left;
        }

        .footer-space {
            height: 7cm;
        }

        .page-break {
            page-break-before: always;
        }

        .page-number {
            font-size: 10px;
            text-align: right;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    @php
    $itemsPerPage = 25; // Ajusta según cuántos materiales caben por página
    $totalPages = ceil(count($materiales) / $itemsPerPage);
    $chunks = array_chunk($materiales->toArray(), $itemsPerPage);
    @endphp

    @foreach($chunks as $pageIndex => $materialesChunk)
    @if($pageIndex > 0)
    <div class="page-break"></div>
    @endif


    <table>
        <tr>
            <td rowspan="3" style="width: 25%; text-align: center;">
                <img src="{{ public_path('assets/images/MARCAREGISTRADA.png') }}" class="logo">
            </td>
            <td colspan="2" class="titulo">Requisición de Materiales - MR</td>



        </tr>
        <tr>
            <td class="label" style="width: 15%;">No. de MR:</td>
            <td>{{ $no_mr }}</td>
        </tr>
        <tr>
            <td class="label">Fecha de solicitud:</td>
            <td>
                <span style="display: inline-block; width: 70%;">{{ $fecha }}</span>
                <span style="display: inline-block; border-left: 1px solid black; height: 25px; margin: 0 6px;"></span>
                <span style="display: inline-block;">Página {{ $pageIndex + 1 }} de {{ $totalPages }}</span>

            </td>
        </tr>
    </table>

    <table class=" tabla-materiales">
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th>Descripción</th>
                <th style="width: 15%;">Cantidad</th>
                <th style="width: 20%;">Unidad de medida</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($materialesChunk as $index => $mat)
            <tr>
                <td>{{ ($pageIndex * $itemsPerPage) + $index + 1 }}</td>
                <td>{{ $mat['DESCRIPCION'] }}</td>
                <td>{{ $mat['CANTIDAD'] }}</td>
                <td>{{ $mat['UNIDAD_MEDIDA'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @endforeach

</body>

</html>