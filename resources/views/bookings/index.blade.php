<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table border="1">
    <thead>
        <tr>
            <th>Hora</th>
            <th>Lunes</th>
            <th>Yape</th>
            <th>Total</th>
            <th>Martes</th>
            <th>yape</th>
            <th>Total</th>
            <th>Miércoles</th>
            <th>Yape</th>
            <th>Total</th>
            <th>Jueves</th>
            <th>Yape</th>
            <th>Total</th>
            <th>Viernes</th>
            <th>Yape</th>
            <th>Total</th>
            <th>Sábado</th>
            <th>Yape</th>
            <th>Total</th>
            <th>Domingo</th>
            <th>Yape</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->hour }}</td>
                <td>{{ $booking->monday }}</td>
                <td>{{ $booking->monday_yape }}</td>
                <td>{{ $booking->monday_total }}</td>
                <td>{{ $booking->tuesday }}</td>
                <td>{{ $booking->tuesday_yape }}</td>
                <td>{{ $booking->tuesday_total }}</td>
                <td>{{ $booking->wednesday }}</td>
                <td>{{ $booking->wednesday_yape }}</td>
                <td>{{ $booking->wednesday_total }}</td>
                <td>{{ $booking->thursday }}</td>
                <td>{{ $booking->thursday_yape }}</td>
                <td>{{ $booking->thursday_total }}</td>
                <td>{{ $booking->friday }}</td>
                <td>{{ $booking->friday_yape }}</td>
                <td>{{ $booking->friday_total }}</td>
                <td>{{ $booking->saturday }}</td>
                <td>{{ $booking->saturday_yape }}</td>
                <td>{{ $booking->saturday_total }}</td>
                <td>{{ $booking->sunday }}</td>
                <td>{{ $booking->sunday_yape }}</td>
                <td>{{ $booking->sunday_total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
