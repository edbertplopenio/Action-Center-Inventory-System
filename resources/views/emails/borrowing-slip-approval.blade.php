<!DOCTYPE html>
<html>
<head>
    <title>Borrowing Slip Approval Request</title>
</head>
<body>
    <h3>Hello, Approver</h3>
    <p>A new borrowing slip has been submitted and requires your approval.</p>
    <p><strong>Item:</strong> {{ $borrowingSlip->item }}</p>
    <p><strong>Quantity:</strong> {{ $borrowingSlip->quantity }}</p>
    <p>
        <a href="{{ url('/borrowing-slips/approve/' . $borrowingSlip->id) }}">Approve Borrowing Slip</a>
    </p>
</body>
</html>
