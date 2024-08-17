<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            font-family: 'Poppins', Arial, sans-serif;
            color: white;
        }
    </style>
</head>

<body
    style="height: 100vh; width: 100vw; background-color: #2d3748; display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 8px; margin: 0; padding: 0;">

    <h1>Hi {{ $user->name }}</h1>
    @if ($purpose == 'signup')
        <p>Thanks for signing up at Learnix.</p>
    @elseif ($purpose == 'passwordReset')
        <p>Forgot your password?</p>
    @endif
    <p>Here is your verification code:</p>
    <div style="background-color: #1a202c; padding: 20px; color: #3F51B5;">{{ $user->remember_token }}</div>

</body>

</html>
