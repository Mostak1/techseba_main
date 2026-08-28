<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Bill Generated - {{ $bill->bill_number }}</title>
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
            background: linear-gradient(135deg, #0b2c72, #7628d8);
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
            background: #faf5ff;
            border: 1px solid #e9d5ff;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .total-box p {
            margin: 5px 0;
            color: #1e293b;
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
            background-color: #0b2c72;
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
            <h1>New Invoice / Bill Generated</h1>
        </div>
        <div class="content">
            <p class="greeting">Dear {{ $bill->workOrder->user->name }},</p>
            <p>A new bill has been generated for your work order. Please review the details below:</p>

            <table class="details-table">
                <tr>
                    <th>Work Order</th>
                    <td>{{ $bill->workOrder->title }} ({{ $bill->workOrder->order_number }})</td>
                </tr>
                <tr>
                    <th>Invoice / Bill No</th>
                    <td><strong>{{ $bill->bill_number }}</strong></td>
                </tr>
                <tr>
                    <th>Bill Type</th>
                    <td>{{ ucfirst(str_replace('_', ' ', $bill->bill_type)) }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $bill->title }}</td>
                </tr>
                <tr>
                    <th>Due Date</th>
                    <td>{{ $bill->due_date->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <th>Amount Due</th>
                    <td><strong style="color: #dc2626;">{{ currency($bill->amount, 2) }}</strong></td>
                </tr>
            </table>

            <div style="background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; padding: 15px; margin: 20px 0; text-align: left;">
                <p style="margin: 0 0 8px 0; font-weight: bold; color: #0b2c72; font-size: 15px;">Your Customer Panel Login Credentials:</p>
                <p style="margin: 4px 0; font-size: 14px; color: #334155;"><strong>Login URL:</strong> <a href="https://techseba.com/user/login" style="color: #0b2c72; text-decoration: underline;">techseba.com/user/login</a></p>
                <p style="margin: 4px 0; font-size: 14px; color: #334155;"><strong>Email:</strong> {{ $bill->workOrder->user->email }}</p>
                <p style="margin: 4px 0; font-size: 14px; color: #334155;"><strong>Password:</strong> your chosen password (default: <em>techseba123</em> for newly created accounts)</p>
            </div>

            <p style="text-align: center;">
                <a href="https://techseba.com/user/login" class="btn">View & Pay Bill</a>
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
