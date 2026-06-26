<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de contraseña</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:40px 0;">
                <table width="480" cellpadding="0" cellspacing="0" style="background:#fff; border-radius:8px; padding:40px; box-shadow:0 2px 8px rgba(0,0,0,.08);">
                    <tr>
                        <td>
                            <h2 style="color:#1a1a2e; margin-top:0;">Recupera tu contraseña</h2>
                            <p style="color:#444;">Usa el siguiente código para restablecer tu contraseña. Expira en <strong>{{ $expiresInMinutes }} minutos</strong>.</p>
                            <div style="text-align:center; margin:32px 0;">
                                <span style="font-size:36px; font-weight:bold; letter-spacing:12px; color:#1a1a2e;">{{ $code }}</span>
                            </div>
                            <p style="color:#888; font-size:13px;">Si no solicitaste este código, ignora este correo. Tu contraseña no será modificada.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
