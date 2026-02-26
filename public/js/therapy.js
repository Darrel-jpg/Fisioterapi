import { Pose } from "https://cdn.jsdelivr.net/npm/@mediapipe/pose/pose.js";
import { Camera } from "https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js";

const videoElement = document.getElementById("input_video");
const canvasElement = document.getElementById("output_canvas");
const canvasCtx = canvasElement.getContext("2d");

let repetition = 0;
let stage = null;

function calculateAngle(a, b, c) {
    const radians =
        Math.atan2(c.y - b.y, c.x - b.x) -
        Math.atan2(a.y - b.y, a.x - b.x);
    let angle = Math.abs((radians * 180.0) / Math.PI);
    if (angle > 180.0) angle = 360 - angle;
    return angle;
}

function onResults(results) {
    canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
    canvasCtx.drawImage(results.image, 0, 0);

    if (results.poseLandmarks) {
        const shoulder = results.poseLandmarks[11];
        const elbow = results.poseLandmarks[13];
        const wrist = results.poseLandmarks[15];

        const angle = calculateAngle(shoulder, elbow, wrist);

        if (angle > 160) stage = "down";
        if (angle < 40 && stage === "down") {
            stage = "up";
            repetition++;
            document.getElementById("counter").innerText = repetition;
        }

        const feedback = document.getElementById("feedback");
        if (angle < 40 || angle > 160) {
            feedback.style.color = "green";
            feedback.innerText = "Gerakan Benar";
        } else {
            feedback.style.color = "red";
            feedback.innerText = "Perbaiki Posisi";
        }
    }
}

const pose = new Pose({
    locateFile: (file) =>
        `https://cdn.jsdelivr.net/npm/@mediapipe/pose/${file}`,
});

pose.onResults(onResults);

const camera = new Camera(videoElement, {
    onFrame: async () => {
        await pose.send({ image: videoElement });
    },
    width: 640,
    height: 480,
});

camera.start();