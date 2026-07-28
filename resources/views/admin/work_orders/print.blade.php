<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TechSeba Work Order - {{ $workOrder->order_number }}</title>
<style>
  :root {
    --navy:#0b2c72;
    --blue:#0e6fe8;
    --purple:#7628d8;
    --light:#f5f8ff;
    --line:#cfd8ea;
    --text:#1b2430;
  }
  * { box-sizing: border-box; }
  body {
    margin:0;
    font-family: Arial, Helvetica, sans-serif;
    background:#e9edf5;
    color:var(--text);
  }
  .toolbar {
    position:sticky;
    top:0;
    z-index:10;
    display:flex;
    gap:10px;
    justify-content:center;
    padding:12px;
    background:#111827;
    box-shadow:0 2px 8px rgba(0,0,0,.2);
  }
  .toolbar button {
    border:0;
    border-radius:8px;
    padding:10px 18px;
    font-size:15px;
    font-weight:700;
    cursor:pointer;
  }
  .print-btn { background:#2563eb; color:#fff; }
  .back-btn { background:#fff; color:#111827; }
  .page {
    width:210mm;
    min-height:297mm;
    margin:14px auto;
    background:#fff;
    padding:14mm 14mm 12mm;
    position:relative;
    box-shadow:0 0 18px rgba(0,0,0,.14);
    overflow:hidden;
    page-break-after:always;
  }
  .page:last-child { page-break-after:auto; }
  .top-line {
    position:absolute;
    top:0; left:0; right:0;
    height:7px;
    background:linear-gradient(90deg,var(--blue),var(--purple));
  }
  .header {
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    border-bottom:2px solid var(--navy);
    padding-bottom:10px;
    margin-bottom:12px;
  }
  .logo {
    width:200px;
    max-height:80px;
    object-fit:contain;
    object-position:left center;
  }
  .doc-title {
    text-align:right;
  }
  .doc-title h1 {
    margin:0;
    color:var(--navy);
    font-size:28px;
    letter-spacing:.5px;
  }
  .doc-title .meta {
    margin-top:8px;
    font-size:13px;
    line-height:1.8;
  }
  .section-title {
    display:inline-block;
    margin:8px 0 7px;
    padding:6px 14px;
    color:#fff;
    background:linear-gradient(90deg,var(--navy),var(--purple));
    font-size:14px;
    font-weight:700;
    clip-path:polygon(0 0,92% 0,100% 50%,92% 100%,0 100%);
  }
  .two-col {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
  }
  .info-box {
    border:1px solid var(--line);
    border-radius:8px;
    padding:10px 12px;
    background:var(--light);
    min-height:120px;
  }
  .info-box h3 {
    margin:0 0 7px;
    color:var(--navy);
    font-size:17px;
  }
  .info-line { margin:5px 0; font-size:13px; line-height:1.5; }
  .project-title {
    border-left:5px solid var(--purple);
    padding:9px 12px;
    background:#f8f6ff;
    font-weight:700;
    margin:3px 0 10px;
  }
  p, li { font-size:12.5px; line-height:1.5; }
  table {
    width:100%;
    border-collapse:collapse;
    margin:7px 0 12px;
    font-size:12.5px;
  }
  th {
    background:var(--navy);
    color:#fff;
    padding:8px;
    border:1px solid #27488b;
  }
  td {
    border:1px solid #b9c5d8;
    padding:8px;
    vertical-align:top;
  }
  .amount { text-align:right; font-weight:700; }
  .note {
    background:#fff8e8;
    border-left:4px solid #f59e0b;
    padding:8px 10px;
    font-size:12px;
  }
  .legal {
    display:grid;
    grid-template-columns:1.1fr 1fr;
    gap:12px;
    border:1px solid #b7c4de;
    padding:10px;
    background:#fafbff;
  }
  .legal strong { color:var(--navy); }
  .terms {
    margin:0;
    padding-left:20px;
  }
  .terms li { margin:4px 0; }
  .signatures {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:28px;
    margin-top:24px;
  }
  .sig-box {
    border:1px solid #aebbd0;
    min-height:145px;
    padding:12px;
  }
  .sig-title {
    color:var(--navy);
    font-weight:700;
    margin-bottom:18px;
  }
  .sig-line {
    margin:12px 0;
    border-bottom:1px solid #555;
    height:20px;
  }
  .footer {
    position:absolute;
    left:0; right:0; bottom:0;
    height:18mm;
    background:linear-gradient(90deg,var(--navy),#101b45);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 14mm;
    font-size:11px;
  }
  .footer span { opacity:.95; }
  .page-no {
    font-weight:700;
    color:#e7dcff;
  }
  @media print {
    body { background:#fff; }
    .toolbar { display:none !important; }
    .page {
      margin:0;
      box-shadow:none;
      width:210mm;
      min-height:297mm;
    }
  }
</style>
</head>
<body>

<div class="toolbar">
  <button class="print-btn" onclick="window.print()">Print / Save as PDF</button>
  <button class="back-btn" onclick="window.history.back()">Go Back</button>
</div>

<section class="page">
  <div class="top-line"></div>
  <div class="header">
    <div style="font-size: 26px; font-weight: bold; color: var(--navy); display: flex; align-items: center; gap: 10px;">
      <span style="background: linear-gradient(135deg, var(--blue), var(--purple)); color: white; padding: 5px 12px; border-radius: 6px;">TS</span>
      TechSeba
    </div>
    <div class="doc-title">
      <h1>WORK ORDER</h1>
      <div class="meta">
        <strong>Work Order No:</strong> {{ $workOrder->order_number }}<br>
        <strong>Date:</strong> {{ $workOrder->created_at->format('M d, Y') }}
      </div>
    </div>
  </div>

  <div class="two-col">
    <div class="info-box">
      <h3>CLIENT INFORMATION</h3>
      <div class="info-line"><strong>Name:</strong> {{ $workOrder->user->name }}</div>
      <div class="info-line"><strong>Email:</strong> {{ $workOrder->user->email }}</div>
      <div class="info-line"><strong>Phone:</strong> {{ $workOrder->user->phone ?? 'N/A' }}</div>
      <div class="info-line"><strong>Address:</strong> {{ $workOrder->user->address ?? 'N/A' }}</div>
    </div>
    <div class="info-box">
      <h3>PROVIDER INFORMATION</h3>
      <div class="info-line"><strong>Company:</strong> TechSeba Inc.</div>
      <div class="info-line"><strong>Email:</strong> info@techseba.com</div>
      <div class="info-line"><strong>Website:</strong> www.techseba.com</div>
      <div class="info-line"><strong>Support:</strong> +8801898828248</div>
    </div>
  </div>

  <div class="section-title">1. SCOPE OF WORK & DETAILS</div>
  <div class="project-title">
    Project Name: {{ $workOrder->title }}
  </div>

  @if($workOrder->description)
    <div style="font-size: 13px; line-height: 1.6; color: #334155; background: #faf5ff; border-left: 4px solid var(--purple); padding: 15px; border-radius: 6px; margin: 15px 0;">
      <strong>Details & Scope:</strong><br>
      {!! nl2br(e($workOrder->description)) !!}
    </div>
  @endif

  <div class="section-title">2. INVESTMENT & PAYMENT TERMS</div>
  <table>
    <thead>
      <tr>
        <th>Description</th>
        <th style="width:28%">Amount (BDT)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Total Setup / Implementation Budget</td>
        <td class="amount">{{ currency($workOrder->total_budget, 2) }}</td>
      </tr>
      @if($workOrder->discount > 0)
      <tr>
        <td style="color: #7628d8;">Discount Applied</td>
        <td class="amount" style="color: #7628d8;">-{{ currency($workOrder->discount, 2) }}</td>
      </tr>
      @endif
      <tr>
        <td style="color: #16a34a;">Total Confirmed Payments Received</td>
        <td class="amount" style="color: #16a34a;">{{ currency($workOrder->paid_amount, 2) }}</td>
      </tr>
      <tr style="background-color: #fef2f2; font-weight: bold; border-top: 2px solid #ef4444;">
        <td style="color: #dc2626;">Remaining Balance Due</td>
        <td class="amount" style="color: #dc2626;">{{ currency($workOrder->due_amount, 2) }}</td>
      </tr>
    </tbody>
  </table>

  <div class="note">
    Note: Dynamic billing details reflect payments verified by administrative accounts. Future service renewals, hosting, and extra modules are subject to separate mutual agreements.
  </div>

  <div class="footer">
    <span>TechSeba • One Click Solution • techseba.com</span>
    <span class="page-no">Page 1 of 1</span>
  </div>
</section>

<section class="page" style="page-break-before: always;">
  <div class="top-line"></div>
  <div class="header">
    <div style="font-size: 26px; font-weight: bold; color: var(--navy); display: flex; align-items: center; gap: 10px;">
      <span style="background: linear-gradient(135deg, var(--blue), var(--purple)); color: white; padding: 5px 12px; border-radius: 6px;">TS</span>
      TechSeba
    </div>
    <div class="doc-title">
      <h1>WORK ORDER</h1>
      <div class="meta">
        <strong>Work Order No:</strong> {{ $workOrder->order_number }}
      </div>
    </div>
  </div>

  <div class="legal" style="margin-top: 15px;">
    <div>
      <strong>Terms & Conditions:</strong>
      <ol class="terms">
        <li>The client shall pay the setup and monthly costs as mutually agreed.</li>
        <li>TechSeba holds exclusive copyrights of standard system codebase unless specified.</li>
        <li>System deployment requires typical server host specifications provided by TechSeba.</li>
        <li>Standard support hours are 10:00 AM - 8:00 PM, except public holidays.</li>
        <li>Data backups are automated daily, but local downloads are encouraged.</li>
      </ol>
    </div>
    <div>
      <strong>Acceptance Note:</strong>
      <p style="margin: 0; line-height: 1.5;">
        By signing below, both parties confirm their agreement to the scope, budgets, and terms mentioned in this work order. System provisioning will start immediately upon approval.
      </p>
    </div>
  </div>

  <div class="signatures">
    <div class="sig-box">
      <div class="sig-title">For TechSeba</div>
      <div class="sig-line"></div>
      <p style="margin:0;"><small>Authorized Signature & Date</small></p>
    </div>
    <div class="sig-box">
      <div class="sig-title">For Client ({{ $workOrder->user->name }})</div>
      <div class="sig-line"></div>
      <p style="margin:0;"><small>Authorized Signature & Date</small></p>
    </div>
  </div>

  <div class="footer">
    <span>TechSeba • One Click Solution • techseba.com</span>
    <span class="page-no">Page 2 of 2</span>
  </div>
</section>

</body>
</html>
