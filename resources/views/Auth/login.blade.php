<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Barbershop Admin Login</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700;900&amp;family=Noto+Sans:wght@400;700&amp;family=Playfair+Display:wght@700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              colors: {
                "primary": "#1152d4",
                "accent-gold": "#C5A059",
                "background-light": "#f6f6f8",
                "background-dark": "#101622",
                "form-bg": "#1c1f27"
              },
              fontFamily: {
                "display": ["Work Sans", "sans-serif"],
                "serif": ["Playfair Display", "serif"]
              },
              borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
            },
          },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background-light dark:bg-background-dark font-display min-h-screen flex items-center justify-center overflow-x-hidden">
<div class="layout-container flex w-full h-screen overflow-hidden">
<!-- Left Side: Atmospheric Image (Visible on desktop) -->
<div class="hidden lg:flex lg:w-1/2 relative">
<div class="absolute inset-0 bg-cover bg-center" data-alt="Modern barbershop interior with leather chairs and wooden mirrors" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuByWhSXiVElmXYhDGno9D_rxKshPZGD1bCgAhPDOTwnhoVZAV7UCzfE68uSj4t70-KGJvP3dPq26Wh3E-XfzUI5ZGnUoUq1UKHfbK0_-nq4ZpNojVxDbwt7pwcT8YLO7Lo-kcB1GENgQaHYZQzjLHvjfVheoYa155-WIWDTfuAfU4y3NvZrglfkFmDBxD-GOosjByQQF97hyoQorA0QebHA4-YFP51iKeokxLPbSVTDbGuLj31jd1QBGthlX9ouXLm-CAfIWKU7kwE");'>
</div>
<div class="absolute inset-0 bg-black/40 flex flex-col justify-end p-20 text-white">
<h1 class="font-serif text-5xl mb-4">Barberia</h1>
<p class="text-lg text-white/80 max-w-md">     </p>
</div>
</div>
<!-- Right Side: Login Form -->
<div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-background-light dark:bg-background-dark p-8 @container">
<div class="max-w-[480px] w-full flex flex-col gap-8">
<!-- Logo & Heading -->
<div class="flex flex-col items-center gap-4">
<div class="w-20 h-20 bg-accent-gold rounded-full flex items-center justify-center text-background-dark">
<span class="material-symbols-outlined !text-4xl">content_cut</span>
</div>
<div class="text-center">
<h2 class="text-white font-serif text-3xl font-bold tracking-tight">Sistema Facturación</h2>
<p class="text-[#9da6b9] text-base mt-2">Welcome back to Barber Manager Admin</p>
</div>
</div>
<!-- Form Fields -->
 <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-1">
   @csrf
<!-- Email Field -->
<div class="flex flex-wrap items-end gap-4 px-4 py-3">
<label class="flex flex-col min-w-40 flex-1">
<p class="text-white text-base font-medium leading-normal pb-2" >Email Address</p>
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-white focus:outline-0 focus:ring-2 focus:ring-accent-gold/50 border border-[#3b4354] bg-[#1c1f27] focus:border-accent-gold h-14 placeholder:text-[#9da6b9] p-[15px] text-base font-normal leading-normal" placeholder="admin@barbershop.com" required="" type="email" name="email"/>
</label>
</div>
<!-- Password Field -->
<div class="flex flex-wrap items-end gap-4 px-4 py-3">
<label class="flex flex-col min-w-40 flex-1">
<p class="text-white text-base font-medium leading-normal pb-2">Password</p>
<div class="flex w-full flex-1 items-stretch rounded-lg group">
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-white focus:outline-0 focus:ring-2 focus:ring-accent-gold/50 border border-[#3b4354] bg-[#1c1f27] focus:border-accent-gold h-14 placeholder:text-[#9da6b9] p-[15px] rounded-r-none border-r-0 pr-2 text-base font-normal leading-normal" placeholder="••••••••" required="" type="password" name="password"/>
<div class="text-[#9da6b9] flex border border-[#3b4354] bg-[#1c1f27] items-center justify-center pr-[15px] rounded-r-lg border-l-0 cursor-pointer hover:text-white">
<span class="material-symbols-outlined" style="font-size: 24px;">visibility</span>
</div>
</div>
</label>
</div>
<!-- Additional Options -->
<div class="flex items-center justify-between px-4 py-2">
<label class="flex items-center gap-2 cursor-pointer">
<input class="rounded border-[#3b4354] bg-[#1c1f27] text-accent-gold focus:ring-accent-gold focus:ring-offset-background-dark" type="checkbox"/>
<span class="text-sm text-[#9da6b9]">Remember Me</span>
</label>
<a class="text-sm text-accent-gold hover:underline font-medium" href="#">Forgot Password?</a>
</div>
<!-- Action Button -->
<div class="px-4 py-6">
<button class="w-full flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-14 px-5 bg-[#1a1a1a] border border-[#3b4354] text-white text-base font-bold leading-normal tracking-[0.015em] hover:bg-black transition-colors shadow-xl" type="submit">
<span class="truncate">Sign In to Dashboard</span>
</button>
</div>
</form>
<!-- Footer Text -->
<div class="text-center">
<p class="text-sm text-[#9da6b9]">
                        Powered by BarberManager © 2024
                    </p>
</div>
</div>
</div>
</div>
</body></html>