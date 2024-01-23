<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Creating an Account</title>
</head>

<body>
    <p>Dear {{ $name }},</p>

    <p>Thank you for creating an account on Vincent-TMS! We are thrilled to have you on board.</p>

    <p>Please take a moment to verify your email address by clicking on the following link:</p>

    <p><a href="{{ $verificationLink }}">{{ $verificationLink }}</a></p>

    <p>This verification step helps us ensure the security of your account and provides you with full access to our
        services.</p>

    <p>If you have any questions or need further assistance, feel free to contact our support team at
        support@vincent-tms.com.</p>

    <p>Thank you again for choosing Vincent-TMS!</p>

    <p>Best regards,<br>
        The Vincent-TMS Team</p>
</body>

</html>
