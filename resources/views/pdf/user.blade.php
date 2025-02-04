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
        .header {
            display: flex;
            align-items: center;
            width: 100%;
            margin-bottom: 32px;
            padding: 0 32px;
        }
        .header img {
            width: 160px;
        }
        .header-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
        .report-info {
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            padding: 0 4px;
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
        .footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .signature {
            width: 240px;
            text-align: center;
        }
        .signature hr {
            border: none;
            height: 1px;
            background-color: black;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="{{ asset('logo.jpg') }}" alt="">
            <div class="header-content">
                <div class="title">Las Phaqchas</div>
                <div class="subtitle">
                    <span>RUC: 124545454545</span><br>
                    <span>Javier Cardenas</span>
                </div>
            </div>
        </div>

        <div class="report-info">
            <p>Reporte de usuarios</p>
            <p>Fecha: 02/02/2025</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Dni</th>
                    <th>Telefono</th>
                    <th>Faltas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->dni }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->faults }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
           <div class="signature">
                <hr>
                <h2>Javier Cardenas</h2>
           </div>
        </div>
    </div>

</body>
</html>
