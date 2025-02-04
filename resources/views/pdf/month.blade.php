<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            padding: 8px;
            font-family: Arial, sans-serif;
        }
        .container {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 16px;
        }
        .header-table {
            width: 100%;
            margin-bottom: 32px;
        }
        .header-table td {
            vertical-align: middle;
            padding: 8px 16px;
        }
        .header-logo {
            width: 160px;
        }
        .title {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            font-weight: bold;
            font-size: 20px;
            padding: 16px 0;
            text-align: center;
        }
        .subtitle {
            padding: 16px 0;
            text-align: center;
            color: #4b5563;
            font-size: 14px;
        }
        .table-report {
            width: 100%;
            margin-bottom: 8px;
        }
        .table-report td {
            text-align: right;
        }
        .table {
            width: 100%;
            font-size: 14px;
            text-align: left;
            color: #6b7280;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .table thead {
            font-size: 12px;
            text-transform: uppercase;
            background-color: #f9fafb;
            color: #374151;
        }
        .table th, .table td {
            padding: 12px 24px;
            border: 1px solid #e5e7eb;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f3f4f6;
        }
        .footer-table {
            width: 100%;
            margin-top: 20px;
        }
        .signature {
            width: 240px;
            text-align: center;
            margin: auto;
        }
        .signature h2 {
            font-size: 20px;
        }
        .signature hr {
            border: none;
            height: 1px;
            background-color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <table class="header-table">
            <tr>
                <td><img src="{{ public_path('logo.jpg') }}" alt="" class="header-logo"></td>
                <td>
                    <div class="title">Las Phaqchas</div>
                    <div class="subtitle">
                        <span>RUC: 124545454545</span><br>
                        <span>Javier Victor Cardenas Ochoa</span>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table-report">
            <tr>
                <td style="text-align: left; color: #374151; ">Reporte mensual de canchas</td>
                <td class="table-report-td" style="color: #374151;">{{ $date }}</td>
            </tr>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Campo 1</th>
                    <th>Campo 2</th>
                    <th>Campo 3</th>
                    <th>Campo 4</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalMonthSum = 0; 
            @endphp
                @foreach ($bookingsData as $item)
                <tr>
                    <td>{{ $item['date'] }}</td>
                    @foreach ( $item['fields'] as $fields )
                            <td>
                                S/{{ $fields['total'] }}
                            </td>
                    
                   
                    @endforeach
                    <td>
                        S/{{ $item['totalMonth'] }}
                    </td>
                </tr>
                @php
                $totalMonthSum += $item['totalMonth']; // Acumular el totalMonth
            @endphp
                @endforeach
                <tr>
                    <td colspan="{{ count($item['fields']) + 1 }}" class="text-right"><strong>Total:</strong></td>
                    <td><strong>S/{{ $totalMonthSum }}</strong></td>
                </tr>
            </tbody>
        </table>
        <table class="footer-table">
            <tr>
                <td></td>
                <td class="signature">
                    <hr>
                    <p style="color: #374151; font-size: 20px;">Javier Victor Cardenas Ochoa</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
