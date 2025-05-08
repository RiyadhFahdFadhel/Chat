<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ auth()->user()->createToken('chat')->plainTextToken }}">
</head>
<body>
    <h1>Real-Time Chat</h1>
    <input type="hidden" id="current_user_id" value="{{ auth()->id() }}">
    
    <div id="messages" style="border: 1px solid #ccc; padding: 10px; height: 300px; overflow-y: auto;"></div>
    
    <input type="text" id="receiver_id" placeholder="Receiver ID">
    <input type="text" id="message_input" placeholder="Write a message...">
    <button id="send">Send</button>
    @vite('resources/js/echo.js')
</body>
</html>
