<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $mail_subject }}</title>
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
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: bold;
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
        }
        .details-table th {
            background-color: #f8fafc;
            color: #4a5568;
            font-weight: 600;
        }
        .total-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .total-box p {
            margin: 5px 0;
            color: #166534;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #edf2f7;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Payment Receipt & Confirmation</h1>
        </div>
        <div class="content">
            <p class="greeting">Dear {{ $payment->workOrder->user->name }},</p>
            <p>We are pleased to inform you that your payment has been received and confirmed for your work order.</p>

            <table class="details-table">
                <tr>
                    <th>Work Order</th>
                    <td>{{ $payment->workOrder->title }} ({{ $payment->workOrder->order_number }})</td>
                </tr>
                <tr>
                    <th>Payment Method</th>
                    <td>{{ $payment->payment_method }}</td>
                </tr>
                <tr>
                    <th>Transaction ID</th>
                    <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Payment Date</th>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <th>Amount Paid</th>
                    <td><strong>{{ currency($payment->amount, 2) }}</strong></td>
                </tr>
            </table>

            <div class="total-box">
                <p><strong>Total Budget:</strong> {{ currency($payment->workOrder->total_budget, 2) }}</p>
                <p><strong>Remaining Due Balance:</strong> {{ currency($payment->workOrder->due_amount, 2) }}</p>
            </div>

            <p style="text-align: center;">
                <a href="{{ route('user.dashboard') }}" class="btn">View Customer Panel</a>
            </p>

            <p>If you have any questions or require further assistance, please feel free to reach out to us.</p>
            <p>Thank you for choosing TechSeba!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} TechSeba. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
