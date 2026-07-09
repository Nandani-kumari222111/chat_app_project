<!DOCTYPE html>
<html>
<head>
    <title>Simple Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <h2>Simple HTML Form</h2>

    <form id="userForm">

        <label>Name:</label><br>
        <input id="name" type="text" name="name" placeholder="Enter your name"><br><br>

        <label>Email:</label><br>
        <input id="email" type="email" name="email" placeholder="Enter your email"><br><br>

        <label>Message:</label><br>
        <textarea id="message" name="message" rows="4" cols="40" placeholder="Enter your message"></textarea><br><br>

        <button type="submit" onclick="submitForm()">Submit</button>

    </form>


    <script>
        document.getElementById('userForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            console.log("Form Submitted");

            // Get form values
            let name = document.getElementById("name").value;

            let email = document.getElementById("email").value;

            let message = document.getElementById("message").value;

            console.log(name);
            console.log(email);
            console.log(message);
        
    
        

            fetch("/submit", {

    method: "POST",

    headers: {

        "Content-Type": "application/json",

        "X-CSRF-TOKEN":
        document.querySelector('meta[name="csrf-token"]').content

    },
    
    body: JSON.stringify({

        name: name,

        email: email,

        message: message

    })
       })    

.then(response => response.json())

.then(data=>{

console.log(data);
alert('Form submitted successfully!');

 });

});
        </script>

</body>
</html>