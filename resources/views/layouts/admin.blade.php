<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - BookField</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-slate-800 text-white flex-shrink-0">
            <div class="p-4 text-xl font-bold border-b border-slate-700">BookField Admin</div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-700' : '' }}">Dashboard</a>
                <a href="{{ route('admin.fields.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.fields.*') ? 'bg-slate-700' : '' }}">Kelola Lapangan</a>
                <a href="{{ route('admin.bookings.index') }}" class="block px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.bookings.*') ? 'bg-slate-700' : '' }}">Kelola Booking</a>
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Lihat Situs</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-slate-700">Logout</button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-6">
            <div class="mb-4 text-sm text-gray-500">Masuk sebagai {{ auth()->user()->name }} (Admin)</div>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
