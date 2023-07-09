/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import Camera from './src/Camera.js';
import Config from './src/Config.js';

// start the Stimulus application
import './bootstrap';

function main() {

    const camera = new Camera;
    const config = new Config;

    if(camera.checkDeviceSuport()){
        camera.startStream(config.constraints);

    }

}

main();

        const socket = new WebSocket("ws://localhost:3001");

        socket.addEventListener("open", function() {
            console.log("CONNECTED");
        });

            function addMessage(name, message) {
        const messageHTML = "<div class='message'><strong>" + name + ":</strong> " + message + "</div>";
        document.getElementById("chat").innerHTML += messageHTML
    }

            document.getElementById("sendBtn").addEventListener("click", function() {
        const message = {
            name: document.getElementById("name").value,
            message: document.getElementById("message").value
        };
        socket.send(JSON.stringify(message));
        addMessage(message.name, message.message);
    });
                socket.addEventListener("message", function(e) {
            console.log(e.data);
        try
        {
            const message = JSON.parse(e.data);
            addMessage(message.name, message.message);
        }
        catch(e)
        {
            // Catch any errors
        };
    })

    const videoElement = document.getElementById('video');

    // When video metadata is loaded
    videoElement.addEventListener('loadedmetadata', function() {
    // Set interval to capture frames every 100 milliseconds
    setInterval(captureFrame, 100);
    });

    // Capture and send frame to the WebSocket server
    function captureFrame() {
    // Create canvas element
    const canvas = document.createElement('canvas');
    canvas.width = videoElement.videoWidth;
    canvas.height = videoElement.videoHeight;

    // Draw current frame on the canvas
    const ctx = canvas.getContext('2d');
    ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

    // Get the image data from the canvas
    const imageData = canvas.toDataURL('image/jpeg');

    // Send the image data to the WebSocket server
    socket.send(imageData);
}

// Get video element
const videoElementStream = document.getElementById('videoElement');

// Create a MediaSource object
const mediaSource = new MediaSource();

mediaSource.addEventListener('sourceopen', function() {
  // Create a new SourceBuffer
  const sourceBuffer = mediaSource.addSourceBuffer('video/webm; codecs="vp8"');

  // When the WebSocket receives a message (frame)
  socket.addEventListener('message', function(event) {
    // Append the received frame to the SourceBuffer
    const arrayBuffer = event.data;

    // Wrap the ArrayBuffer in a Uint8Array
    const uint8Array = new Uint8Array(arrayBuffer);

    // Append the Uint8Array to the SourceBuffer
    sourceBuffer.appendBuffer(uint8Array);
  });
});

// Set the video element's source to the MediaSource URL
videoElementStream.src = URL.createObjectURL(mediaSource);
