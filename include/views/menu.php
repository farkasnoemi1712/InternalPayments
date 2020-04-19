<div class="sidebar">
    <ul class="nav flex-column"  >
        <li> 
            &nbsp 
        </li>
        <?php if($_SESSION['admin']):?> 
            <li class="nav-item">
                <a class="nav-link active" href="newpaymentlist.php">Add new payment list</a>
            </li>
        <?php endif;?>
        <li class="nav-item">
            <a class="nav-link " href="paymenthistory.php">Payment history</a>
        </li>
        <?php if($_SESSION['admin']):?>
            <li class="nav-item">
                    <a class="nav-link " href="usersettings.php">User settings</a>
            </li>
        <?php endif;?>
        <li class="nav-item">
            <a class="nav-link " href="logout.php">Log out (<?=$_SESSION['username']?>)</a>
        </li>
    </ul>
</div>