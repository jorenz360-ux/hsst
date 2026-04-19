<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Approved</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f4f4f5; margin: 0; padding: 32px 16px; color: #18181b; }
        .wrapper { max-width: 520px; margin: 0 auto; }
        .card { background: #ffffff; border-radius: 16px; padding: 40px 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .logo { font-size: 13px; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: #d97706; margin-bottom: 28px; }
        h1 { font-size: 22px; font-weight: 700; margin: 0 0 8px; }
        p { font-size: 15px; color: #52525b; line-height: 1.6; margin: 0 0 16px; }
        .credentials { background: #f8f8f8; border: 1px solid #e4e4e7; border-radius: 12px; padding: 20px 24px; margin: 24px 0; }
        .credentials dt { font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: #71717a; margin-bottom: 3px; }
        .credentials dd { font-size: 16px; font-weight: 600; font-family: 'Courier New', monospace; color: #18181b; margin: 0 0 16px; }
        .footer { text-align: center; font-size: 12px; color: #a1a1aa; margin-top: 28px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="logo">Holy Spirit School Alumni Reunion</div>
            <h1>Your account is approved, {{ $staff->fname }}!</h1>
            <p>Your registration for the HSST Reunion 2026 has been approved. You can now log in using your username and the password you set during registration.</p>
            <div class="credentials">
                <dl>
                    <dt>Username</dt>
                    <dd>{{ $username }}</dd>
                </dl>
            </div>
            <p>Visit the site and log in to signify your attendance.</p>
        </div>
        <div class="footer">This email was sent by the HSST Alumni Reunion system. Do not reply.</div>
    </div>
</body>
</html>
