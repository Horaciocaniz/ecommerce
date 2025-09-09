<?php include_once('../includes/db.php'); ?>
<?php include_once('../config/config.php'); ?>
<?php include_once('partials/header.php'); ?>

<!-- Tailwind y Fuentes -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    'sans': ['Inter', 'system-ui', 'sans-serif']
                }
            }
        }
    }
</script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    .hero-gradient {
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
    }
    .btn-hover {
        transition: all 0.3s ease;
    }
    .btn-hover:hover {
        transform: scale(1.05);
    }
    .mobile-menu { display: none; }
    .mobile-menu.active { display: block; }
    @media (max-width: 768px) {
        .desktop-menu { display: none; }
    }
</style>

<body class="min-h-screen bg-white font-sans">
    <!-- Navbar Sticky -->
    
    <!-- Hero Principal -->
    <section class="hero-gradient py-20 lg:py-32">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">✨ Nueva Colección 2024</span>
                        <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 leading-tight">
                            Estilo que
                            <span class="text-blue-600"> define</span> tu personalidad
                        </h1>
                        <p class="text-xl text-gray-600 leading-relaxed">
                            Descubre nuestra colección exclusiva de productos premium diseñados para personas que buscan calidad y
                            elegancia en cada detalle.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="catalogo.php" class="btn-hover bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 text-lg rounded-lg">
                            Ver productos
                        </a>
                        <a href="contacto.php" class="btn-hover px-8 py-4 text-lg rounded-lg border border-gray-300 hover:bg-gray-50 bg-transparent">
                            Conocer más
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative z-10">
                        <img src="<?= URL_BASE ?>assets/img/guante.png" 
                             alt="Producto destacado" 
                             class="rounded-2xl shadow-2xl w-full h-auto">
                    </div>
                    <div class="absolute -top-4 -right-4 w-full h-full bg-blue-100 rounded-2xl -z-10"></div>
                </div>
            </div>
        </div>
    </section>

<?php include('partials/footer.php'); ?>
