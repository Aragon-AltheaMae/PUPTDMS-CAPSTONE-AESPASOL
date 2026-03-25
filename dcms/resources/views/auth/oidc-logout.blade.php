<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signing out...</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet"/>

    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: radial-gradient(ellipse at center, #7a1a00 0%, #3d0000 40%, #1A0505 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        .card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 2.5rem;
            backdrop-filter: blur(15px);
            max-width: 400px;
            width: 90%;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255,255,255,0.2);
            border-top: 4px solid #F0C040;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        h2 {
            font-weight: 800;
            margin-bottom: 0.8rem;
            letter-spacing: 0.05em;
        }

        p {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.85);
        }
    </style>
</head>
<body>

<div class="card">
    <div class="spinner"></div>
    <h2>Signing you out...</h2>
    <p>Please wait while we securely log you out.</p>
</div>

<!-- hidden iframe for POST logout -->
<iframe name="idpLogoutFrame" style="display:none;"></iframe>

<form id="idpLogoutForm" method="POST" action="{{ $logoutUrl }}" target="idpLogoutFrame">
</form>

<script>
    // Step 1: trigger IdP logout
    document.getElementById('idpLogoutForm').submit();

    // Step 2: redirect to IdP login page after delay
    setTimeout(function () {
        window.location.href = @json($loginUrl);
    }, 1200);
</script>

</body>
</html>