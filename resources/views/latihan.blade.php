<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terapi Online - Physio Web</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/pose/pose.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-blue-50 h-screen flex flex-col items-center justify-center p-4 font-sans">
    
    <div class="w-full max-w-5xl flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-blue-900">Sesi Terapi Lengan Kiri</h1>
            <p class="text-blue-600">Pastikan tubuh bagian atas terlihat di kamera</p>
        </div>
        <button id="finish_btn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-colors hidden">
            Selesai Latihan
        </button>
    </div>
    
    <div class="relative w-full max-w-5xl aspect-video bg-white rounded-2xl overflow-hidden shadow-xl border-t-4 border-blue-500">
        
        <div id="loading_indicator" class="absolute inset-0 flex flex-col items-center justify-center bg-white z-10">
            <svg class="animate-spin h-12 w-12 text-blue-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V4a10 10 0 00-10 10h2z"></path>
            </svg>
            <span class="text-blue-800 font-semibold text-xl animate-pulse">Menyiapkan AI Tracking...</span>
        </div>

        <video id="video_element" class="hidden" autoplay playsinline></video>
        <canvas id="output_canvas" class="absolute inset-0 w-full h-full object-cover bg-gray-900"></canvas>

        <div class="absolute bottom-6 left-6 right-6 flex justify-between gap-4">
            <div class="bg-white/90 backdrop-blur border border-blue-100 p-4 rounded-xl shadow-lg text-center w-1/3">
                <p class="text-xs font-bold text-blue-800 uppercase">Repetisi</p>
                <p id="reps_text" class="text-4xl font-extrabold text-blue-600">0</p>
            </div>
            <div class="bg-white/90 backdrop-blur border border-blue-100 p-4 rounded-xl shadow-lg text-center w-1/3">
                <p class="text-xs font-bold text-blue-800 uppercase">Durasi</p>
                <p id="timer_text" class="text-4xl font-extrabold text-blue-600">00:00</p>
            </div>
            <div class="bg-white/90 backdrop-blur border border-blue-100 p-4 rounded-xl shadow-lg text-center w-1/3">
                <p class="text-xs font-bold text-blue-800 uppercase">Feedback</p>
                <p id="status_text" class="text-xl font-bold text-gray-400 mt-2">Menunggu...</p>
            </div>
        </div>
    </div>

    <script>
        const videoElement = document.getElementById('video_element');
        const canvasElement = document.getElementById('output_canvas');
        const canvasCtx = canvasElement.getContext('2d');
        const statusText = document.getElementById('status_text');
        const loadingIndicator = document.getElementById('loading_indicator');
        const repsText = document.getElementById('reps_text');
        const timerText = document.getElementById('timer_text');
        const finishBtn = document.getElementById('finish_btn');

        let reps = 0;
        let isFlexed = false;
        let maxAngleReached = 0;
        let secondsElapsed = 0;
        let timerInterval = null;
        let isReady = false;

        const synth = window.speechSynthesis;
        let isSpeaking = false;

        function speak(text) {
            if (isSpeaking || synth.speaking) return;
            isSpeaking = true;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.onend = () => { isSpeaking = false; };
            synth.speak(utterance);
        }

        function startTimer() {
            if (timerInterval) return;
            timerInterval = setInterval(() => {
                secondsElapsed++;
                const m = String(Math.floor(secondsElapsed / 60)).padStart(2, '0');
                const s = String(secondsElapsed % 60).padStart(2, '0');
                timerText.innerText = `${m}:${s}`;
            }, 1000);
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
            if (!isReady) {
                loadingIndicator.classList.add('hidden');
                finishBtn.classList.remove('hidden');
                isReady = true;
                startTimer();
            }

            canvasElement.width = videoElement.videoWidth;
            canvasElement.height = videoElement.videoHeight;
            
            canvasCtx.save();
            canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
            canvasCtx.drawImage(results.image, 0, 0, canvasElement.width, canvasElement.height);

            let skeletonColor = '#EF4444'; 

            if (results.poseLandmarks) {
                let shoulder = results.poseLandmarks[11];
                let elbow = results.poseLandmarks[13];
                let wrist = results.poseLandmarks[15];

                if(shoulder.visibility > 0.5 && elbow.visibility > 0.5 && wrist.visibility > 0.5) {
                    let angle = calculateAngle(shoulder, elbow, wrist);
                    
                    if (angle > maxAngleReached) maxAngleReached = angle;

                    if (angle < 45) {
                        skeletonColor = '#22C55E';
                        statusText.innerText = "Bagus!";
                        statusText.className = "text-xl font-bold text-green-500 mt-2";
                        
                        if (!isFlexed) {
                            speak("Bagus");
                            reps++;
                            repsText.innerText = reps;
                            isFlexed = true;
                        }
                    } else if (angle > 150) {
                        skeletonColor = '#EF4444';
                        statusText.innerText = "Tekuk lengan Anda";
                        statusText.className = "text-xl font-bold text-red-500 mt-2";
                        isFlexed = false;
                    } else {
                        skeletonColor = '#EAB308';
                        statusText.innerText = "Tahan...";
                        statusText.className = "text-xl font-bold text-yellow-500 mt-2";
                    }
                } else {
                    statusText.innerText = "Lengan tidak terlihat";
                    statusText.className = "text-xl font-bold text-gray-500 mt-2";
                }

                drawConnectors(canvasCtx, results.poseLandmarks, POSE_CONNECTIONS, {color: skeletonColor, lineWidth: 6});
                drawLandmarks(canvasCtx, results.poseLandmarks, {color: '#FFFFFF', lineWidth: 3, radius: 4});
            }
            canvasCtx.restore();
        }

        const pose = new Pose({locateFile: (file) => {
            return `https://cdn.jsdelivr.net/npm/@mediapipe/pose/${file}`;
        }});

        pose.setOptions({
            modelComplexity: 1,
            smoothLandmarks: true,
            minDetectionConfidence: 0.6,
            minTrackingConfidence: 0.6
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

        finishBtn.addEventListener('click', () => {
            clearInterval(timerInterval);
            camera.stop();

            let accuracy = reps > 0 ? (maxAngleReached / 180) * 100 : 0;
            if(accuracy > 100) accuracy = 100;

            fetch('{{ route('latihan.save') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    assignment_id: 1, 
                    achieved_reps: reps,
                    max_angle_reached: maxAngleReached,
                    accuracy_score: accuracy,
                    duration_seconds: secondsElapsed
                })
            })
            .then(response => response.json())
            .then(data => {
                window.location.href = '{{ route('patient.dashboard') }}';
            });
        });
    </script>
</body>
</html>