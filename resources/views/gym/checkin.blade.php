<!DOCTYPE html>
<html>
<head>
    <title>Gym Check-In</title>
</head>
<body>
    <h1>Gym Check-In</h1>
    <form action="{{ route('gym-checkin-post') }}" method="POST">
        @csrf
        <label for="check_in_code">Enter Gym User Check-In Code:</label>
        <input type="text" id="check_in_code" name="check_in_code" required>
        <button type="submit">Check In</button>
    </form>
</body>
</html>
