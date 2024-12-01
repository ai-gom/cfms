<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            text-align: center;
            margin-top: 50px;
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #007bff;
            font-size: 3rem;
        }
        p {
            color: #444;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <h1>Thank You! 🎉</h1>
    <p>Your feedback has been successfully submitted.</p>
    <p id="countdown">You will be redirected back to the form in <span id="seconds">5</span> seconds...</p>

    <script>
        // Trigger confetti
        confetti({
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 }
        });

        // Countdown logic
        let countdown = 5; // Initial countdown value in seconds
        const countdownElement = document.getElementById('seconds');

        const interval = setInterval(function () {
            countdown--; // Decrease the countdown value by 1
            countdownElement.textContent = countdown; // Update the countdown display

            if (countdown === 0) {
                clearInterval(interval); // Stop the interval when countdown reaches 0
                window.location.href = "{{ route('home.form') }}"; // Redirect to the form
            }
        }, 1000); // Run every second
    </script>
</body>
</html>
