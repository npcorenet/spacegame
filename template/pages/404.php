<?php $this->layout('templates/base', ['title' => 'Startseite']) ?>

<?php require_once TEMPLATE_DIR.'/parts/navigation.php'?>

<div class="wrapper">
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Seite nicht gefunden</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="error-page">
                <h2 class="headline text-warning"> 404</h2>

                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Diese Seite wurde nicht gefunden.</h3>

                    <p>
                        We could not find the page you were looking for.
                        Meanwhile, you may <a href="../../index.html">return to dashboard</a> or try using the search form.
                    </p>

                    <form class="search-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </div>

    <aside class="control-sidebar control-sidebar-dark">
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>

    <?= require_once TEMPLATE_DIR.'/parts/footer.php' ?>

</div>
