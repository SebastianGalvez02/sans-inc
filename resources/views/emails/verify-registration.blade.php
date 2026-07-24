<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Your Registration</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:40px 0;">
                <table width="480" cellpadding="0" cellspacing="0" style="background:#fff; border-radius:8px; padding:40px; box-shadow:0 2px 8px rgba(0,0,0,.08);">
                    <tr>
                        <td>
                            <h2 style="color:#1a2332; margin-top:0;">Confirm your registration</h2>
                            <p style="color:#444;">Hi {{ $name }}, thank you for creating an account at Sans Inc.</p>
                            <p style="color:#444;">Click the button below to confirm your email address.</p>
                            <div style="text-align:center; margin:32px 0;">
                                <a href="{{ $verificationUrl }}" style="display:inline-block; background:#1a2332; color:#ffffff; padding:14px 22px; border-radius:8px; text-decoration:none; font-weight:bold;">Confirm registration</a>
                            </div>
                            <p style="color:#888; font-size:13px;">If you did not create this account, you can ignore this email.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
