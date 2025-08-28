<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>كشف العلامات</title>
    <style>
    

    body {
       font-family: amiri;
        direction: rtl;
         text-align: right; 
    }
       table {
        width: 100%;
        border-collapse: collapse;
        direction: rtl;
    }

    th, td {
        border: 1px solid #000;
        padding: 5px;
        text-align: center;
        font-family: 'Amiri', sans-serif;
    }
        th {
            background: #f2f2f2ff;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>كشف العلامات الجامعي</h2>

    <p><strong>الاسم:</strong> {{ $student->name }}</p>
    <p><strong>الرقم الجامعي:</strong> {{ $student->university_number }}</p>

    <table>
        <thead>
            <tr>
                <th>السنة</th>
                <th>الفصل</th>
                <th>المادة</th>
                <th>العلامة العملية</th>
                <th>العلامة النظرية</th>
                <th>العلامة النهائية</th>
                <th>النتيجة</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    
                    <td>{{ $row['year'] }}</td>
                    <td>{{ $row['semester'] }}</td>
                    <td>{{ $row['course'] }}</td>
                    <td>{{ $row['practical_mark'] }}</td>
                    <td>{{ $row['theoretical_mark'] }}</td>
                    <td>{{ $row['total_mark'] }}</td>
                    <td>{{ $row['result'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
