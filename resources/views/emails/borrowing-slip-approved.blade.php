<!DOCTYPE html>
<html>
<head>
    <title>Borrowing Slip Approved</title>
</head>
<body>
    <h3>Hello, {{ $borrower }}</h3>
    <p>Your borrowing slip request has been approved!</p>
    <p><strong>Item:</strong> {{ $borrowingSlip->item }}</p>
    <p><strong>Quantity:</strong> {{ $borrowingSlip->quantity }}</p>
    <p>Status: Approved</p>
</body>
</html>
