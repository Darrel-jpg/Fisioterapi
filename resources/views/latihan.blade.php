<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uji Coba AI Fisioterapi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/pose/pose.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 h-screen flex flex-col items-center justify-center p-4">
    
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Uji Coba Kamera & MediaPipe</h1>
    
    <div class="relative w-full max-w-3xl aspect-video bg-black rounded-xl overflow-hidden shadow-lg border-4 border-gray-800">
        <video id="video_element" class="hidden"></video>
        <canvas id="output_canvas" class="absolute inset-0 w-full h-full object-cover"></canvas>
    </div>

    <div class="mt-6 bg-white px-6 py-4 rounded-lg shadow font-mono text-xl font-bold text-gray-700 w-full max-w-3xl text-center" id="status_text">
        Meminta akses kamera...
    </div>

    <script>
        const videoElement = document.getElementById('video_element');
        const canvasElement = document.getElementById('output_canvas');
        const canvasCtx = canvasElement.getContext('2d');
        const statusText = document.getElementById('status_text');

        const synth = window.speechSynthesis;
        let isSpeaking = false;

        function speak(text) {
            if (isSpeaking || synth.speaking) return;
            isSpeaking = true;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 1.2;
            utterance.onend = () => { isSpeaking = false; };
            synth.speak(utterance);
        }

        function calculateAngle(a, b, c) {
            let radians = Math.atan2(c.y - b.y, c.x - b.x) - Math.atan2(a.y - b.y, a.x - b.x);
            let angle = Math.abs(radians * 180.0 / Math.PI);
            
            if (angle > 180.0) {
                angle = 360.0 - angle;
            }
            return angle;
        }

        function onResults(results) {
            canvasElement.width = videoElement.videoWidth;
            canvasElement.height = videoElement.videoHeight;
            
            canvasCtx.save();
            canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
            canvasCtx.drawImage(results.image, 0, 0, canvasElement.width, canvasElement.height);

            if (results.poseLandmarks) {
                drawConnectors(canvasCtx, results.poseLandmarks, POSE_CONNECTIONS, {color: '#ffffff', lineWidth: 4});
                drawLandmarks(canvasCtx, results.poseLandmarks, {color: '#FF0000', lineWidth: 2});

                let shoulder = results.poseLandmarks[11];
                let elbow = results.poseLandmarks[13];
                let wrist = results.poseLandmarks[15];

                if(shoulder.visibility > 0.5 && elbow.visibility > 0.5 && wrist.visibility > 0.5) {
                    let angle = calculateAngle(shoulder, elbow, wrist);
                    statusText.innerText = "Sudut Siku Kiri: " + Math.round(angle) + "°";

                    if (angle < 45) {
                        speak("Bagus");
                        canvasCtx.fillStyle = "rgba(0, 255, 0, 0.2)";
                        canvasCtx.fillRect(0, 0, canvasElement.width, canvasElement.height);
                    } else if (angle > 150) {
                        speak("Ayo tekuk tangan kiri");
                    }
                } else {
                    statusText.innerText = "Pastikan lengan kiri terlihat jelas di kamera";
                }
            } else {
                statusText.innerText = "Mendeteksi kerangka...";
            }
            canvasCtx.restore();
        }

        const pose = new Pose({locateFile: (file) => {
            return `https://cdn.jsdelivr.net/npm/@mediapipe/pose/${file}`;
        }});

        pose.setOptions({
            modelComplexity: 1,
            smoothLandmarks: true,
            enableSegmentation: false,
            smoothSegmentation: false,
            minDetectionConfidence: 0.5,
            minTrackingConfidence: 0.5
        });

        pose.onResults(onResults);

        const camera = new Camera(videoElement, {
            onFrame: async () => {
                await pose.send({image: videoElement});
            },
            width: 1280,
            height: 720
        });

        camera.start();
    </script>
</body>
</html>