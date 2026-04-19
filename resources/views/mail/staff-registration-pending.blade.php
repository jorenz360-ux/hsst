<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Approval</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f4f4f5; margin: 0; padding: 32px 16px; color: #18181b; }
        .wrapper { max-width: 520px; margin: 0 auto; }
        .card { background: #ffffff; border-radius: 16px; padding: 40px 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .logo { font-size: 13px; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: #d97706; margin-bottom: 28px; }
        h1 { font-size: 22px; font-weight: 700; margin: 0 0 8px; }
        p { font-size: 15px; color: #52525b; line-height: 1.6; margin: 0 0 16px; }
        .info { background: #f8f8f8; border: 1px solid #e4e4e7; border-radius: 12px; padding: 20px 24px; margin: 24px 0; }
        .info dt { font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: #71717a; margin-bottom: 3px; }
        .info dd { font-size: 15px; font-weight: 600; color: #18181b; margin: 0 0 12px; }
        .footer { text-align: center; font-size: 12px; color: #a1a1aa; margin-top: 28px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="logo">Holy Spirit School Alumni Reunion</div>
            <h1>New Registration Pending</h1>
            <p>A non-alumni user has registered and is awaiting your approval.</p>
            <div class="info">
                <dl>
                    <dt>Name</dt>
                    <dd>{{ $staff->fname }} {{ $staff->lname }}</dd>
                    <dt>Position</dt>
                    <dd>{{ $staff->position }}</dd>
                    <dt>Account Type</dt>
                    <dd>{{ ['staff' => 'Staff', 'employee' => 'Employee', 'ssps-member' => 'SSPS Member'][$accountType] ?? ucfirst($accountType) }}</dd>
                    <dt>Years at HSST</dt>
                    <dd>{{ $staff->years_working }}</dd>
                </dl>
            </div>
            <p>Please log in to the admin panel and visit <strong>Pending Staff</strong> to approve or reject this registration.</p>
        </div>
        <div class="footer">This email was sent by the HSST Alumni Reunion system. Do not reply.</div>
    </div>
</body>
</html>
