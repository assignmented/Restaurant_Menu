<?php
//P3rchth38l@ck
/** Mobile bottom navigation. Highlights $active (home|offers|profile|more). */
$active = $active ?? '';
?>
<nav class="bp-bottom-nav">
    <a href="offers.php" class="<?= $active==='offers'?'active':'' ?>"><i class="fa-solid fa-tag"></i> Offers</a>
    <a href="menu-categories.php" class="<?= $active==='menu'?'active':'' ?>"><i class="fa-solid fa-list"></i> Menu</a>
    <a href="home.php" class="nav-home" aria-label="Home"><i class="fa-solid fa-house"></i></a>
    <a href="more.php" class="<?= $active==='more'?'active':'' ?>"><i class="fa-solid fa-table-cells"></i> More</a>
    <a href="profile.php" class="<?= $active==='profile'?'active':'' ?>"><i class="fa-solid fa-user"></i> Profile</a>
</nav>
