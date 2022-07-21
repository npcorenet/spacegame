<footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
        <?= ($_ENV['SOFTWARE_INDEV'])? '<span class="text-danger h5"> Dev Mode enabled. Version: ' . \App\Software::VERSION_TYPE . '-' . \App\Software::VERSION . '</span>': '' ?>
    </div>
    <strong>Copyright &copy; 2022 <a href="https://npcore.net">npcore.net</a>.</strong> All rights reserved.
</footer>