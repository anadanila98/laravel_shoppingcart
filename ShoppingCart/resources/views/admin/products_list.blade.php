@extends('layouts.master_admin')
@section('content')

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Products</a></li>

        </ol>
    </nav>
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-file-text-o" aria-hidden="true"></i><span class="lm10p titlu"> Products list</span></h3>
        </div>
    </div>
    <div class="x_content">
        <div class="table-responsiveX" style="overflow-x:auto">
            <div class="col-12" id="box-oferta">
                <div class="x_panel">
                    <div class="x_content">
                        <a href="{{ route('add_product') }}"
                           class="btn btn-warning  pull-right  " >Add product  <i class="fa fa-check-square"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <table id="tabel-actiuni-fixe"
               class="table table-striped responsive-utilities jambo_table onerow fixed-table-head table-condensed">
            <thead>

            <tr class="headings">
                <th>Nr</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Available</th>
                <th>Actions</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $k=>$linie) {
                echo '<tr>';
                echo '<td>'.($k +1). '</td>';
                echo '<td>'.$linie['title']. '</td>';
                echo '<td>'.$linie['description']. '</td>';
                echo '<td>'.$linie['price']. '</td>';
                echo '<td>'.$linie['stock']. '</td>';
                echo '<td><div class="btn-group" style="min-width: 40px">
    <a href="product_details/'.$linie['id'].'"  class="btn btn-sm btn-default" title="Detalii"><i class="fa fa-search"></i></a></div>     </td>';
            }
            ?>
            </tbody>
        </table>

        <div class="clearfix"></div>
    </div>
</main>

@endsection
