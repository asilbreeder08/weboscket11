<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Client</title>
</head>

<body>
    <h1>WebSocket Client</h1>
    <ul id="data-list"></ul>

    <script>
        const socket = new WebSocket("ws://localhost:8080");

        socket.addEventListener("open", (event) => {
            console.log("WebSocket connection opened");
        });

        socket.addEventListener("message", (event) => {
            const data = JSON.parse(event.data);
            updateDataList(data);
        });

        socket.addEventListener("close", (event) => {
            console.log("WebSocket connection closed");
        });

        function updateDataList(data) {
            const dataList = document.getElementById("data-list");
            dataList.innerHTML = ""; // Clear previous data

            data.forEach((item) => {
                const listItem = document.createElement("li");
                listItem.textContent = `${item.fname} ${item.lname}`;
                dataList.appendChild(listItem);
            });
        }
    </script>
</body>

</html>