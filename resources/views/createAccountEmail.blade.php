<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Creating an Account</title>
</head>

<body style="background: #262626; color: #e5e5e5; margin: 0; padding: 0;">

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
        <tr>
            <td style="padding: 20px;">
                <section
                    style="background: #333; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);">
                    <p style="color: #fe6902; font-size: 1.2rem; margin-bottom: 15px;">Dear {{ $name }},</p>

                    <p style="margin-bottom: 15px;">Thank you for creating an account on Vincent-TMS! We are thrilled to
                        have you on board.</p>

                    <p style="margin-bottom: 15px;">Please take a moment to verify your email address by clicking on the
                        following link:</p>

                    <p style="margin-bottom: 15px;"><a href="{{ $verificationLink }}"
                            style="color: #fe6902;">{{ $verificationLink }}</a></p>

                    <p style="margin-bottom: 15px;">This verification step helps us ensure the security of your account
                        and provides you with full access to our services.</p>

                    <p style="margin-bottom: 15px;">If you have any questions or need further assistance, feel free to
                        contact our support team at <a href="mailto:support@vincent-tms.com"
                            style="color: #fe6902;">support@vincent-tms.com</a>.</p>

                    <p style="margin-bottom: 15px;">Thank you again for choosing Vincent-TMS!</p>

                    <p style="margin-bottom: 0;">Best regards,<br>The Vincent-TMS Team</p>
                </section>
            </td>
        </tr>
    </table>

</body>

</html>
