<script setup>
import {ref} from 'vue';
import axios from 'axios'

const counter = ref(0);
const messages = ref([
    {prompt: "", side: "user"},
    {prompt: "", side: "assistance"}
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

const increase = () =>{
    counter.value += 1
}

</script>

<template>
    <div class="h-12"></div>
    <div class="max-w-md mx-auto border border-gray-400 px-2 py-2 rounded-xl">
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
            <input v-model="dataForm.prompt" type="text" class="w-full bg-gray-100 border border-gray-400 rounded-xl px-2 py-1.5" placeholder="Create Your Journely"/>
            <button @click="sendMessage" class=" bg-gray-700 border border-gray-400 rounded-xl px-4 py-1.5 text-white">Send</button>
        </div>
    </div>

    
</template>



