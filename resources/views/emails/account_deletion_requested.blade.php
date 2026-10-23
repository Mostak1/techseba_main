<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account Deletion Request</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #d32f2f, #7b1fa2);
            padding: 35px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }
        .content {
            padding: 30px 25px;
        }
        .notice {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #856404;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .details-table th, .details-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #edf2f7;
            font-size: 14px;
        }
        .details-table th {
            background-color: #f8fafc;
            color: #4a5568;
            font-weight: 600;
            width: 35%;
        }
        .btn {
            display: inline-block;
            background: #d32f2f;
            color: #ffffff !important;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 15px;
        }
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #718096;
            border-top: 1px solid #edf2f7;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Account Deletion Request</h1>
        </div>
        <div class="content">
            <div class="notice">
                A user has submitted a request to delete their account. Please review this request in the admin dashboard.
            </div>

            <table class="details-table">
                <tr>
                    <th>User ID:</th>
                    <td>#{{ $user->id }}</td>
                </tr>
                <tr>
                    <th>User Name:</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>User Email:</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Requested At:</th>
                    <td>{{ $deleteRequest->created_at->format('d M, Y h:i A') }}</td>
                </tr>
                @if(!empty($deleteRequest->reason))
                <tr>
                    <th>Reason:</th>
                    <td>{{ $deleteRequest->reason }}</td>
                </tr>
                @endif
            </table>

            <div style="text-align: center; margin-top: 25px;">
                <a href="{{ route('admin.account-delete-requests') }}" class="btn">View Request in Admin Dashboard</a>
            </div>
        </div>
        <div class="footer">
            <p>This is an automated notification from {{ config('app.name') }}.</p>
        </div>
    </div>
</body>
</html>
