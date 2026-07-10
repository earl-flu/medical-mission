<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ordered Items | Dispensed Medicines</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #222;
            background: #fff;
            margin: 0;
            padding: 1.5rem;
        }

        h2,
        h3 {
            margin-bottom: 0.25em;
        }

        .header,
        .section {
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            border: 1px solid #bbb;
            padding: 7px 10px;
            text-align: left;
            font-size: 15px;
        }

        th {
            background: #f3f4f6;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .info-table td {
            border: none;
            padding: 2px 10px;
        }

        .signature-section {
            margin-top: 4rem;
            text-align: left;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            width: 300px;
            height: 1px;
            display: block;
        }

        .signature-label {
            margin-top: 0.5em;
            font-size: 0.97em;
            color: #474747;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Dispensed Medicines</h2>
        <p style="font-size: 0.95em; margin-top:0;">
            Encounter #: <strong>{{ $encounter->id }}</strong><br>
            Date: <strong>{{ \Carbon\Carbon::now()->format('F d, Y') }}</strong>

        </p>
    </div>
    <div class="section">
        <h3>Patient Information</h3>
        <table class="info-table">
            <tr>
                <td><strong>Name</strong></td>
                <td style="text-transform: uppercase;">{{ $encounter->patient->full_name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Sex</strong></td>
                <td>{{ $encounter->patient->sex_str ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Birthdate</strong></td>
                <td>{{ $encounter->patient->birthdate_str ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Age</strong></td>
                <td>{{ $encounter->patient->age_years ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Address</strong></td>
                <td>{{ $encounter->patient->full_address ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Event</strong></td>
                <td>{{ $encounter->event->name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Dispensed Items</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 40%;">Item Name</th>
                    <th style="width: 20%;">Quantity</th>
                    <th style="width: 30%;">Lot Number</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orderedItems as $item)
                    <tr>
                        <td>{{ $item->item->name ?? '-' }}</td>
                        <td>{{ $item->quantity ?? '0' }}</td>
                        <td>{{ $item->item->lot_no ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center;">No items ordered/dispensed.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="signature-section">
        <strong style="text-transform: uppercase;">{{ $encounter->patient->full_name ?? '-' }}</strong>
        <span class="signature-line"></span>
        <div class="signature-label">
            Patient's signature over printed Name
        </div>
    </div>
</body>

</html>
