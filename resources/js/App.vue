<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const isLoading = ref(true);
const messages = ref([]);
const dataForm = ref({
  prompt: '',
  negative_prompt: ''
});

const user = window.Laravel.user;
const isLoggedIn = window.Laravel.isLoggedIn;

const logout = async () => {
  isLoading.value = true;
  try {
    await axios.post('/logout');
    window.location.reload();
  } catch (e) {
    console.error('Logout gagal:', e);
    isLoading.value = false;
  }
};

const sendMessage = async () => {
  const userPrompt = dataForm.value.prompt;
  if (!userPrompt.trim()) return;

  messages.value.push({
    prompt: userPrompt,
    side: 'user'
  });

  dataForm.value.prompt = '';

  isLoading.value = true;
  try {
    const res = await axios.post('/api/generate-image', {
      prompt: userPrompt,
      negative_prompt: dataForm.value.negative_prompt
    });

    const output = res.data.output || [];
    if (output.length > 0) {
      messages.value.push({
        prompt: `<img src="${output[0]}" alt="Generated Image" class="rounded border mt-2" />`,
        side: 'assistance'
      });
    } else {
      messages.value.push({
        prompt: 'Gagal menghasilkan gambar.',
        side: 'assistance'
      });
    }
  } catch (err) {
    messages.value.push({
      prompt: 'Terjadi error saat generate gambar.',
      side: 'assistance'
    });
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  setTimeout(() => {
    isLoading.value = false;
  }, 1500); // Simulasi loading saat pertama buka halaman
});
</script>


<template>
<!-- loading -->
<div v-if="isLoading" class="fixed inset-0 bg-purple-900 flex items-center justify-center z-50">
  <div class="flex flex-col items-center text-white">
    <img src="{{ asset('logo.png') }}" class="w-20 h-20 animate-bounce mb-4" alt="Loading Logo" />
    <div class="text-xl font-semibold">Loading, please wait...</div>
  </div>
</div>

<!-- login  -->

<div class="w-full px-4 py-2 flex justify-end">
  <div v-if="isLoggedIn" class="text-slate-600 flex items-center space-x-3">
    <!-- Newer looking user icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M4 21v-1a6 6 0 016-6h4a6 6 0 016 6v1" />
    </svg>

    <p><span class="font-semibold">Welcome</span> {{ user.name }}</p>

    <button @click="logout" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600">
      Logout
    </button>
  </div>

  <div v-else>
    <button id="login" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
      Login with Google
    </button>
  </div>
</div>

  <div>
    <div class="mx-auto flex justify-center">
      <img src="/public/logo.png" alt="Logo" class="w-32 h-32" />
    </div>
    <div class="text-center mb-10">
      <div class="text-3xl font-bold text-gray-800">Hi there, Sam</div>
      <div class="text-2xl text-purple-600">How can I help you today?</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 w-full max-w-3xl px-4">
      <div class="bg-white shadow-lg p-4 rounded-lg flex flex-col items-center">
        <img src="/public/logo.png" alt="Icon 1" class="w-8 h-8 mt-2" />
        <div class="text-md font-semibold text-gray-600 text-center">Transform Words Into Beautiful Images</div>
      </div>
      <div class="bg-white shadow-lg p-4 rounded-lg flex flex-col items-center">
        <img src="/public/logo.png" alt="Icon 2" class="w-8 h-8 mt-2" />
        <div class="text-md font-semibold text-gray-600 text-center">Generate Instant Art. Infinite Imagination</div>
      </div>
      <div class="bg-white shadow-lg p-4 rounded-lg flex flex-col items-center">
        <img src="/public/logo.png" alt="Icon 3" class="w-8 h-8 mt-2" />
        <div class="text-md font-semibold text-gray-600 text-center">Interact with the Smartest Data Bot Ever</div>
      </div>
    </div>

    <div class="flex flex-col gap-4 w-full max-w-4xl p-4 bg-white border border-gray-300 rounded-lg">
      <div v-for="(msg, index) in messages" :key="index">
        <div v-if="msg.side === 'user'" class="flex justify-end">
          <div class="bg-gray-100 border border-gray-400 px-3 py-2 rounded-xl text-right max-w-xs">
            <strong>User</strong><br />{{ msg.prompt }}
          </div>
        </div>
        <div v-else class="flex justify-start">
          <div class="bg-purple-50 border border-purple-200 px-3 py-2 rounded-xl max-w-xs">
            <strong>Assistant</strong><span class="text-gray-400"> - Image Generated</span>
            <div class="mt-1" v-html="msg.prompt"></div>
          </div>
        </div>
      </div>

      <div class="flex items-center gap-2">
        <input
          v-model="dataForm.prompt"
          type="text"
          placeholder="Ask me anything..."
          class="flex-grow outline-none px-4 py-2 border border-gray-300 rounded-lg"
        />
        <button
          @click="sendMessage"
          class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition"
        >Search</button>
      </div>
    </div>

    <div class="flex justify-center mt-4">
      <button class="text-purple-600 px-4">General</button>
      <button class="text-gray-600 px-4">Text</button>
      <button class="text-gray-600 px-4">Media</button>
      <button class="text-gray-600 px-4">Music</button>
      <button class="text-gray-600 px-4">Analytics</button>
    </div>
  </div>
</template>

<script type="module">
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js';
import { getAnalytics } from 'https://www.gstatic.com/firebasejs/10.0.0/firebase-analytics.js';
import {
  GoogleAuthProvider,
  getAuth,
  signInWithPopup
} from 'https://www.gstatic.com/firebasejs/10.0.0/firebase-auth.js';

const firebaseConfig = {
  apiKey: "AIzaSyCL5v7FvizAxmgDAf7DQ9X6nWZ4Wt2zKSY",
  authDomain: "chatbot-ai-e4ecd.firebaseapp.com",
  projectId: "chatbot-ai-e4ecd",
  storageBucket: "chatbot-ai-e4ecd.appspot.com",
  messagingSenderId: "582666917547",
  appId: "1:582666917547:web:9807d0afc244589d8dc9ee",
  measurementId: "G-E8SZYZRRR0"
};

const app = initializeApp(firebaseConfig);
getAnalytics(app);
const provider = new GoogleAuthProvider();
const auth = getAuth();

window.addEventListener('load', () => {
  const loginBtn = document.querySelector('#login');
  if (loginBtn) {
    loginBtn.addEventListener('click', async () => {
      try {
        const result = await signInWithPopup(auth, provider);
        const user = result.user;

        const tokenCSRF = document.querySelector('meta[name="csrf-token"]').content;

        const response = await fetch('/login/google', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': tokenCSRF
          },
          body: JSON.stringify({
            uid: user.uid,
            name: user.displayName,
            email: user.email
          })
        });

        if (!response.ok) throw new Error('Login failed');
        const data = await response.json();
        // console.log('Login success:', data);
      } catch (err) {
        // console.error('Login error:', err);
        alert('Gagal login.');
      }
    });
  }
});
</script>
