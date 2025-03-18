<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Borrowing Slip Notification</title>
</head>
<body>
    <h1>New Borrowing Slip Submitted</h1>
    <p>Hello,</p>
    <p>A new borrowing slip has been submitted and is awaiting your approval. Below are the details:</p>
    
    <ul>
        <li><strong>Name:</strong> {{ $borrowingSlip->name }}</li>
        <li><strong>Department:</strong> {{ $borrowingSlip->department }}</li>
        <li><strong>Item Code:</strong> {{ $borrowingSlip->item_code }}</li>
        <li><strong>Quantity:</strong> {{ $borrowingSlip->quantity }}</li>
        <li><strong>Borrow Date:</strong> {{ $borrowingSlip->borrow_date }}</li>
        <li><strong>Due Date:</strong> {{ $borrowingSlip->due_date }}</li>
    </ul>

    <p>Please review and approve the borrowing slip. Click the link below to view and accept the borrowing slip:</p>
    
    <a href="{{ route('borrowing-slip.show', $borrowingSlip->id) }}">View Borrowing Slip</a>

    <p>Best regards,</p>
    <p>Your Company</p>
</body>
</html>
