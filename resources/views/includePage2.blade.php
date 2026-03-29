<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hospitex</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#2563eb',
                    secondary: '#1e3a8a',
                    darknav: '#0f172a'
                }
            }
        }
    }
</script>
<style>
    /* Smooth collapse/expand animation */
    details > *:not(summary) {
        overflow: hidden;
        transition: all 0.5s ease-out;
        max-height: 1000px;
        opacity: 1;
    }

    details:not([open]) > *:not(summary) {
        max-height: 0;
        opacity: 0;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    /* Smooth rotation for arrow icon */
    details summary span {
        transition: transform 0.5s ease-out;
        display: inline-block;
    }

    details[open] summary span {
        transform: rotate(90deg);
    }

    
</style>
</head>
<body class="bg-slate-100 font-sans">
<!-- Sidebar -->
<!-- Main Content -->
<main class="ml-6 flex-1 p-24">
    <div class="mt-8">
        @yield('content')
    </div>
</main>
</div>
</body>
</html>
