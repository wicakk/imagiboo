<script setup>
import { ref } from 'vue';
import axios from 'axios'

const counter = ref(0);
const messages = ref([
    { prompt: "", side: "user" },
    { prompt: "", side: "assistance" }
]);

const dataForm = ref({
    prompt: "",
    negative_prompt: ""
})

const images = ref([])

const sendMessage = async () => {
    // Simpan pesan user langsung ke UI dulu
    const userPrompt = dataForm.value.prompt

    messages.value.push({
        prompt: userPrompt,
        side: "user"
    })

    dataForm.value.prompt = "" // Reset inputan agar kosong setelah klik

    try {
        const res = await axios.post('/api/generate-image', {
            prompt: userPrompt,
            negative_prompt: dataForm.value.negative_prompt,
        })

        const output = res.data.output || []

        if (output.length > 0) {
            // Kirim gambar sebagai balasan dari AI
            messages.value.push({
                prompt: `<img src="${output[0]}" alt="Generated Image" class="rounded border mt-2" />`,
                side: "assistance"
            })
        } else {
            messages.value.push({
                prompt: "Gagal menghasilkan gambar.",
                side: "assistance"
            })
        }

    } catch (err) {
        console.error(err)
        messages.value.push({
            prompt: "Terjadi error saat generate gambar.",
            side: "assistance"
        })
    }
}

const increase = () => {
    counter.value += 1
}

</script>

<template>
    <!-- <div class="h-12"></div> -->
    <!-- <div class="max-w-md mx-auto border border-gray-400 px-2 py-2 rounded-xl">
        <div class="text-2xl">
            Ai Assistance
        </div>
        <div class="grid grid-cols-1 gap-4 mb-4">
            <p class="text-gray-400">Welcome Image Generated</p> 
            <template v-for="msg in messages">
                <div class="flex justify-end" v-if="msg.side === 'user'">
                    <div class="bg-gray-50 border border-gray-400 px-2 py-0.5 rounded-xl">
                        <strong> User</strong><br>
                        {{ msg.prompt }}
                    </div>
                </div>
                <div class="px-2 py-0.5 rounded-xl" v-else>
                    <strong>Assistance</strong> - <span class="text-gray-400">Image Generated</span><br>
                    {{ msg.output }}
                    <div v-html="msg.prompt"></div>
                </div>
            </template>
</div>

<div class="flex items-center">
    <input v-model="dataForm.prompt" type="text"
        class="w-full bg-gray-100 border border-gray-400 rounded-xl px-2 py-1.5" placeholder="Create Your Journely" />
    <button @click="sendMessage"
        class=" bg-gray-700 border border-gray-400 rounded-xl px-4 py-1.5 text-white">Send</button>
</div>
</div> -->

    <!-- BARU CODE  -->

    <div class="mx-auto"><img src="/public/logo.png" alt="Icon 1" class="w-32 h-32" /></div>
    <div class="text-center mb-10">
        <div class="text-3xl font-bold text-gray-800">Hi there, Sam</div>
        <div class="text-2xl text-purple-600">How can I help you today?</div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 w-full max-w-3xl px-4">
        <div class="bg-white bg-transparant shadow-lg p-4 rounded-lg flex flex-col items-center">
            <div class="mt-2"><img src="/public/logo.png" alt="Icon 1" class="w-8 h-8"/></div>
            <div class="text-md font-semibold text-gray-600 text-center">Transform Words Into Beautiful Images</div>
        </div>
        <div class="bg-white bg-transparant shadow-lg p-4 rounded-lg flex flex-col items-center">
            <div class="mt-2"><img src="/public/logo.png" alt="Icon 2" class="w-8 h-8"/></div>
            <div class="text-md font-semibold text-gray-600 text-center">Generate Instant Art. Infinite Imagination</div>
        </div>
        <div class="bg-white bg-transparant shadow-lg p-4 rounded-lg flex flex-col items-center">
            <div class="mt-2"><img src="/public/logo.png" alt="Icon 3" class="w-8 h-8"/></div>
            <div class="text-md font-semibold text-gray-600 text-center">Interact with the Smartest Data Bot Ever</div>
        </div>
    </div>
    <div class="flex flex-col gap-4 w-full max-w-4xl p-4 bg-white border border-gray-300 rounded-lg">
        <div v-for="msg in messages" :key="msg.id">
            <!-- User message -->
            <div v-if="msg.side === 'user'" class="flex justify-end">
                <div class="bg-gray-50 border border-gray-400 px-3 py-2 rounded-xl text-right max-w-xs">
                    <strong>User</strong><br />
                    {{ msg.prompt }}
                </div>
            </div>

            <!-- Assistant message -->
            <div v-else class="flex justify-start">
                <div class="bg-purple-50 border border-purple-200 px-3 py-2 rounded-xl max-w-xs">
                    <strong>Assistant</strong>
                    <span class="text-gray-400"> - Image Generated</span><br />
                    {{ msg.output }}
                    <div v-html="msg.prompt" class="mt-1"></div>
                </div>
            </div>
        </div>

        <!-- Input form -->
        <div class="flex items-center gap-2">
            <input v-model="dataForm.prompt" type="text" placeholder="Ask me anything..."
                class="flex-grow outline-none px-4 py-2 border border-gray-300 rounded-lg" />
            <button @click="sendMessage"
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                Search
            </button>
        </div>
    </div>

    <div class="flex justify-center mt-4">
        <button class="text-purple-600 px-4">General</button>
        <button class="text-gray-600 px-4">Text</button>
        <button class="text-gray-600 px-4">Media</button>
        <button class="text-gray-600 px-4">Music</button>
        <button class="text-gray-600 px-4">Analytics</button>
    </div>
</template>
