<!DOCTYPE html>
<html>
<head>
    <title>Issue Reported</title>
    <style>
        body {
            font-family: 'Arial, sans-serif';
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gym Issue Reported</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user->first_name }},</p>
            <p>A new issue has been reported. Below are the details:</p>
            <p><strong>Issue Title:</strong> {{ $issue->title }}</p>
            <p><strong>Issue Type:</strong> {{ ucfirst($issue->type) }}</p>
            @if ($issue->equipment_machine_id)
                <p><strong>Equipment:</strong> {{ $issue->equipmentMachine->equipment->name }} #{{ $issue->equipmentMachine->label }}</p>
            @endif
            <p><strong>Description:</strong> {{ $issue->description }}</p>
            @if ($issue->image)
                <p><strong>Attached Image:</strong></p>
                <p><img style="height: 150px; object-fit:contain;" src="{{ asset('storage/' . $issue->image) }}" alt="Preview Image"></p>
            @else
                <p><strong>Attached Image:</strong> No Image Attached</p>
            @endif
            <p>Best regards,</p>
            <p>APGym</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} APGym. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
