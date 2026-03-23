<template>
    <BaseButton @click="startWebcam" v-if="!state.showWebcam">{{
        $trans("general.start_camera")
    }}</BaseButton>
    <div
        class="flex flex-col items-center justify-center gap-4"
        v-show="state.showWebcam"
    >
        <video
            id="webcam"
            autoplay
            muted
            playsinline
            width="640"
            height="480"
        ></video>
        <BaseButton design="success" @click="captureImage">{{
            $trans("general.capture_image")
        }}</BaseButton>
        <canvas id="canvas" class="hidden"></canvas>
        <template v-if="state.capturedImages.length">
            <div class="flex space-x-4">
                <div
                    class="relative"
                    v-for="image in state.capturedImages"
                    :key="image.id"
                >
                    <div class="absolute bottom-0 right-0 z-10">
                        <i
                            class="fas fa-times-circle text-red-500 cursor-pointer"
                            @click="
                                state.capturedImages.splice(image.id - 1, 1)
                            "
                        ></i>
                    </div>
                    <img :src="image.image" />
                </div>
            </div>
            <BaseButton design="success" @click="completed">Done</BaseButton>
        </template>
    </div>
</template>

<script>
export default {
    name: "WebcamCapture",
}
</script>

<script setup>
import { reactive, onUnmounted } from "vue"
import Webcam from "webcam-easy"

const emit = defineEmits(["completed"])

const state = reactive({
    showWebcam: false,
    webcam: null,
    capturedImages: [],
})

const startWebcam = () => {
    state.showWebcam = true
    const webcamElement = document.getElementById("webcam")
    const canvasElement = document.getElementById("canvas")
    state.webcam = new Webcam(webcamElement, "user", canvasElement)
    state.webcam.start()
}

const captureImage = () => {
    if (state.webcam) {
        const image = state.webcam.snap()
        state.capturedImages.push({
            id: state.capturedImages.length + 1,
            image,
        })
    }
}

const completed = () => {
    emit("completed", state.capturedImages)
    state.showWebcam = false
    state.capturedImages = []
    if (state.webcam) {
        state.webcam.stop()
    }
}

onUnmounted(() => {
    if (state.webcam) {
        state.webcam.stop()
    }
})
</script>
