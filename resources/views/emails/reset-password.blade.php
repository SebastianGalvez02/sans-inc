<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:40px 0;">
                <table width="480" cellpadding="0" cellspacing="0" style="background:#fff; border-radius:8px; padding:40px; box-shadow:0 2px 8px rgba(0,0,0,.08);">
                    <tr>
                        <td>
                            <h2 style="color:#1a1a2e; margin-top:0;">Reset your password</h2>
                            <p style="color:#444;">Use the following code to reset your password. It expires in <strong>{{ $expiresInMinutes }} minutes</strong>.</p>
                            <div style="text-align:center; margin:32px 0;">
                                <span style="font-size:36px; font-weight:bold; letter-spacing:12px; color:#1a1a2e;">{{ $code }}</span>
                            </div>
                            <p style="color:#888; font-size:13px;">If you did not request this code, ignore this email. Your password will not be changed.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
