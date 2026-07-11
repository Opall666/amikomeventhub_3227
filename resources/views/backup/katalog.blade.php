<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Event - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-cyan-50 min-h-screen p-8">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-slate-800 mb-2">Katalog Event</h1>
            <p class="text-slate-600">Temukan event menarik di AmikomEventHub</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Event Card 1 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Seminar Web Development</h3>
                    <p class="text-slate-600 text-sm mb-4">Pelajari framework modern Laravel, React, dan Vue.js dari para expert.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500">📅 15 Juni 2026</span>
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Gratis</span>
                    </div>
                </div>
            </div>
            
            <!-- Event Card 2 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                <div class="h-48 bg-gradient-to-br from-pink-500 to-orange-500 flex items-center justify-center">
                    <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Workshop UI/UX Design</h3>
                    <p class="text-slate-600 text-sm mb-4">Mastering Figma dan prinsip desain untuk aplikasi modern.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500">📅 20 Juni 2026</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">Rp 50K</span>
                    </div>
                </div>
            </div>
            
            <!-- Event Card 3 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                <div class="h-48 bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center">
                    <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Hackathon 2026</h3>
                    <p class="text-slate-600 text-sm mb-4">Kompetisi coding 48 jam dengan hadiah total 10 juta rupiah!</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500">📅 25 Juni 2026</span>
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-medium">Rp 100K</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigasi -->
        <div class="flex flex-wrap gap-2 justify-center">
            <a href="/" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition">Home</a>
            <a href="/profil" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition">Profil</a>
            <a href="/kontak" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition">Kontak</a>
            <a href="/bantuan" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition">Bantuan</a>
        </div>
    </div>
</body>
</html>