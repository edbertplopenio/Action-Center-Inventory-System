<!DOCTYPE html>
<html>
<head>
    <title>Borrowing Slip Confirmation</title>
</head>
<body>
    <h3>Hello, {{ $borrower }}</h3>
    <p>Your borrowing slip has been submitted successfully.</p>
    <p><strong>Item:</strong> {{ $borrowingSlip->item }}</p>
    <p><strong>Quantity:</strong> {{ $borrowingSlip->quantity }}</p>
    <p>Status: Pending Approval</p>
</body>
</html>
