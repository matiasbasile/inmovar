<?php include ("includes/init.php");?>
<?php $page_act = "informacion" ?>
<!DOCTYPE html>
<html>
<head>
  <?php include ("includes/head.php");?>
</head>
<body>

<?php include ("includes/header.php");?>

    <main id="ts-main">
        <section id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section id="page-title">
            <div class="container">
                <div class="ts-title d-flex justify-content-between">
                    <h1>FAQ</h1>
                    <a href="#" class="mb-0 text-right">
                        <small>Didn’t find an answer?</small>
                        <h4 class="mb-0">Submit a Question</h4>
                    </a>
                </div>

            </div>
        </section>
        <section id="items-grid-and-sidebar">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 navbar-expand-md">
                        <button class="btn bg-white mb-4 w-100 d-block d-md-none" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="float-left">
                                    Show Topics
                                </span>
                            <span class="float-right">
                                    <i class="fa fa-plus small ts-opacity__30"></i>
                                </span>
                        </button>
                        <aside id="sidebar" class="ts-sidebar collapse navbar-collapse">
                            <section class="faq-topics">
                                <div class="ts-box">
                                    <div class="nav flex-column nav-pills" aria-orientation="vertical">
                                        <a href="#" class="nav-link active btn-light my-2">Getting Started</a>
                                        <a href="#" class="nav-link my-2">Your Account</a>
                                        <a href="#" class="nav-link my-2">Recover Password</a>
                                        <a href="#" class="nav-link my-2">Become an Affiliate</a>
                                        <a href="#" class="nav-link my-2">Help For Buyers</a>
                                    </div>
                                </div>
                            </section>
                        </aside>
                    </div>
                    <div class="col-md-8">
                        <section class="faqs">
                            <article class="ts-faq">

                                <h5>Phasellus quis scelerisque ligula. Sed gravida tincidunt purus at tincidunt</h5>
                                <p>
                                    Duis ac dolor et enim volutpat semper. Morbi placerat tempor ornare. Quisque
                                    bibendum ultrices diam, ac fermentum massa egestas quis. Nullam eu nunc in sem
                                    efficitur dapibus. Aliquam ultricies elit nisi, rhoncus euismod purus iaculis
                                    et. Nulla facilisi. Sed aliquet ante quis dui congue, sed ornare diam feugiat.
                                </p>
                                <small>
                                    Was this helpful?
                                    <a href="#" class="mx-2">Yes</a>
                                    <a href="#" class="mx-2">No</a>
                                </small>

                            </article>
                            <article class="ts-faq">

                                <h5>Pellentesque egestas tortor mauris, vel pulvinar justo imperdiet ac.</h5>
                                <p>
                                    Proin odio dolor, tincidunt eget dictum volutpat, consequat cursus libero.
                                    Suspendisse potenti. Curabitur nec venenatis sapien, vel malesuada mi. Nunc
                                    malesuada nisl eu consectetur venenatis.
                                </p>
                                <small>
                                    Was this helpful?
                                    <a href="#" class="mx-2">Yes</a>
                                    <a href="#" class="mx-2">No</a>
                                </small>

                            </article>
                            <article class="ts-faq">

                                <h5>Donec rutrum risus eu blandit rutrum. Sed blandit lacus vitae ipsum rutrum</h5>
                                <p>
                                    Nullam sed pulvinar lectus, quis molestie dolor. Morbi vitae porta eros. Duis
                                    ut nulla pellentesque justo ornare condimentum quis ut magna. Aenean nec egestas
                                    ligula, at euismod ipsum. Praesent sed gravida libero. Pellentesque eleifend non
                                    diam eget molestie. Quisque est elit, tincidunt quis nisi a, placerat mollis eros.
                                    Mauris aliquam mollis volutpat. Mauris accumsan sed est in pulvinar.
                                </p>
                                <p>
                                    Phasellus dictum id lorem sed dictum. Vivamus urna velit, condimentum sit amet
                                    pulvinar et, lobortis nec tellus. Fusce vel pellentesque massa, vel dapibus nunc.
                                    Proin odio dolor, tincidunt eget dictum volutpat, consequat cursus libero.
                                    Suspendisse potenti. Curabitur nec venenatis sapien, vel malesuada mi. Nunc
                                    malesuada nisl eu consectetur venenatis.
                                </p>
                                <small>
                                    Was this helpful?
                                    <a href="#" class="mx-2">Yes</a>
                                    <a href="#" class="mx-2">No</a>
                                </small>

                            </article>

                        </section>
                        <section id="pagination">
                            <div class="container">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination ts-center__horizontal">
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link ts-btn-arrow" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php include ("includes/footer.php");?>
</body>
</html>