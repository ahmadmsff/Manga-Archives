<section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
    <div class="pull-left image">
        <img src="dist/AdminLTE/img/user2-160x160.jpg" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
        <p><?php echo $data['name']; ?></p>
        <p id="id_user" class="hidden" id_user="<?php echo $data['id_user']; ?>"></p>
        <!-- Status -->
        <a href="#"><i class="fas fa-circle text-success"></i> Online</a>
    </div>
    </div>

    <!-- search form (Optional) -->
    <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fas fa-search"></i>
            </button>
        </span>
    </div>
    </form>
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
    <li class="header">NAVIGATION</li>
    <!-- Optionally, you can add icons to the links -->
    <li class="<?php echo $activeHome; ?>"><a href="index.php"><i class="fas fa-home"></i><span class="icon">Home</span></a></li>
    <li class="<?php echo $activeBarang; ?>"><a href="index.php?page=manga"><i class="fas fa-book"></i><span class="icon">Manga</span></a></li>
    <!-- <li class="treeview <?php echo $activeTransaksi; ?>">
        <a href="#"><i class="fas fa-money-bill"></i><span class="icon">Transaksi</span>
        <span class="pull-right-container">
            <i class="fas fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
        <li class="<?php echo $activePenjualan; ?>"><a href="index.php?page=transaksi&act=penjualan"><i class="fas fa-exchange-alt"></i><span class="icon">Penjualan</span></a></li>
        <li><a href="#">Link in level 2</a></li>
        </ul>
    </li>
    <li class="<?php echo $activekategori; ?>"><a href="index.php?page=kategori"><i class="fas fa-tags"></i><span class="icon">Kategori</span></a></li> -->
    <li><a onclick="window.open('cek.php', 'newwindow', 'width=300,height=400'); return false;"><i class="fas fa-sync" target="_blank"></i><span class="icon">Check Update</span></a></li>
    </ul>
    <!-- /.sidebar-menu -->
</section>