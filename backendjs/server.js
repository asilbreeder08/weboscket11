const WebSocket = require("ws");
const http = require("http");
const fetch = require("node-fetch"); // Make sure to install the "node-fetch" package

const server = http.createServer();
const wss = new WebSocket.Server({ noServer: true });
let clients = [];

server.on("upgrade", (request, socket, head) => {
    wss.handleUpgrade(request, socket, head, (ws) => {
        wss.emit("connection", ws, request);
    });
});

wss.on("connection", (ws) => {
    console.log("New Client Connected");
    clients.push(ws);

    ws.on("close", () => {
        console.log("Client Disconnected");
        clients = clients.filter((client) => client !== ws);
    });

    ws.on("message", (message) => {
        console.log(`Received message: ${message}`);
        // You can handle client messages if needed
    });
});

// Function to send data to all connected clients
function sendDataToClients(data) {
    const jsonData = JSON.stringify(data);
    clients.forEach((client) => {
        if (client.readyState === WebSocket.OPEN) {
            client.send(jsonData);
        }
    });
}

// Interval to fetch data from PHP script and send it to clients
setInterval(() => {
    const phpScriptUrl = 'http://localhost/weboscket11/fetch.php';

    fetch(phpScriptUrl)
        .then(response => response.json())
        .then(data => {
            // Send the retrieved data to all connected WebSocket clients
            sendDataToClients(data);
        })
        .catch(error => {
            console.error("Error fetching data from PHP:", error);
        });
}, 1000); // Update every 5 seconds (adjust as needed)

server.listen(8080);
