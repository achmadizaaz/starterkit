<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">

<div class="sidebar-header">
    <span>{{ env('APP_NAME') }}</span>
    <button class="btn btn-sm sidebar-close" onclick="closeSidebar()">
    <i class="bi bi-x-lg"></i>
    </button>
</div>

<ul class="sidebar-menu list-unstyled m-0">

<li>
<a href="#" class="active">
<span class="menu-left">
<i class="bi bi-grid"></i> Dashboard
</span>
</a>
</li>


<li>
<a data-bs-toggle="collapse" href="#menuProduk">
<span class="menu-left">
    <i class="bi bi-box"></i> Produk
</span>
<i class="bi bi-chevron-right menu-arrow"></i>
</a>

<ul class="collapse submenu list-unstyled" id="menuProduk">
<li><a href="#">Data Produk</a></li>
<li><a href="#">Kategori</a></li>
<li><a href="#">Stok</a></li>
</ul>
</li>


<li>
<a data-bs-toggle="collapse" href="#menuUser">
<span class="menu-left">
<i class="bi bi-people"></i> User Management
</span>
<i class="bi bi-chevron-right menu-arrow"></i>
</a>

<ul class="collapse submenu list-unstyled" id="menuUser">
<li><a href="#">Users</a></li>
<li><a href="#">Roles</a></li>
<li><a href="#">Permissions</a></li>
</ul>
</li>


<li>
<a data-bs-toggle="collapse" href="#menuTransaksi">
<span class="menu-left">
<i class="bi bi-cash-stack"></i> Transaksi
</span>
<i class="bi bi-chevron-right menu-arrow"></i>
</a>

<ul class="collapse submenu list-unstyled" id="menuTransaksi">
<li><a href="#">POS</a></li>
<li><a href="#">Pemasukan</a></li>
<li><a href="#">Pengeluaran</a></li>
</ul>
</li>


<li>
<a href="#">
<span class="menu-left">
<i class="bi bi-gear"></i> Pengaturan
</span>
</a>
</li>

</ul>

</div>