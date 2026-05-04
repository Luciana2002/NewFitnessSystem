<main class="dashboard-page">

    <button type="button" id="sidebarOpen" class="sidebar-handle">
        <span>›</span>
    </button>

    <button type="button" id="sidebarClose" class="sidebar-close">
        ✕
    </button>

    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    <aside class="dashboard-sidebar" id="dashboardSidebar">

        <div style="text-align:center; padding:10px 0 40px;">
            <img src="<?= base_url('assets/img/logob.png') ?>" style="width:90px;">
        </div>

        <?php if (session()->get('id_rol') == 1): ?>
            <h3>Panel Admin</h3>
            <a href="<?= base_url('usuarios') ?>">Usuarios</a>
            <a href="<?= base_url('clientes') ?>">Clientes</a>
            <a href="<?= base_url('profesores') ?>">Profesores</a>
            <a href="<?= base_url('sistemas') ?>">Sistemas</a>
            <a href="<?= base_url('admin_horarios') ?>">Horarios</a>
            <a href="<?= base_url('pagos') ?>">Pagos</a>
            <a href="<?= base_url('suscripciones') ?>">Suscripciones</a>

        <?php elseif (session()->get('id_rol') == 2): ?>
            <h3>Panel Profesor</h3>
            <a href="<?= base_url('pagos') ?>">Pagos</a>
            <a href="<?= base_url('clientes') ?>">Clientes</a>

        <?php else: ?>
            <h3>Mi cuenta</h3>
            <a href="<?= base_url('cliente/pagos') ?>">Mis pagos</a>
            <a href="<?= base_url('cliente/suscripcion') ?>">Mi mensualidad</a>
        <?php endif; ?>

    </aside>

    <section class="dashboard-content" style="padding: 50px 70px;">
        <h1>Bienvenido/a <?= session()->get('nombre') ?> <?= session()->get('apellido') ?></h1>

        <div class="dashboard-card" style="max-width: 1500px; width:100%; padding:35px 40px;">
            <p><strong>Usuario:</strong> <?= session()->get('nombre_usuario') ?></p>
            <p><strong>Email:</strong> <?= session()->get('email') ?></p>
            <p><strong>Rol:</strong> <?= session()->get('rol') ?></p>
        </div>
    </section>

</main>

<script>
    const sidebarOpen = document.getElementById('sidebarOpen');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebar = document.getElementById('dashboardSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    function abrirSidebar() {
        sidebar.classList.add('show-sidebar');
        overlay.classList.add('active');
        sidebarOpen.style.display = 'none';
        sidebarClose.style.display = 'flex';
    }

    function cerrarSidebar() {
        sidebar.classList.remove('show-sidebar');
        overlay.classList.remove('active');
        sidebarOpen.style.display = '';
        sidebarClose.style.display = '';
    }

    if (sidebarOpen && sidebarClose && sidebar && overlay) {
        sidebarOpen.addEventListener('click', abrirSidebar);
        sidebarClose.addEventListener('click', cerrarSidebar);
        overlay.addEventListener('click', cerrarSidebar);

        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                cerrarSidebar();
            }
        });
    }
</script>