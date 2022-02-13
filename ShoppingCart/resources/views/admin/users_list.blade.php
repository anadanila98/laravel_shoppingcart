@extends('layouts.master_admin')
@section('content')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin_dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Users</a></li>

            </ol>
        </nav>
        <div class="page-title">
            <div class="title_left">
                <h3><i class="fa fa-file-text-o" aria-hidden="true"></i><span class="lm10p titlu"> Users list</span></h3>
            </div>
        </div>
        <div class="x_content">
            <table id="tabel-actiuni-fixe"
                   class="table table-striped responsive-utilities jambo_table onerow fixed-table-head table-condensed">
                <thead>

                <tr class="headings">
                    <th>Nr crt</th>
                    <th>Email</th>
                    <th>Admin?</th>
                    <th>Created at</th>
                    <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($users as $k=>$user) {
                    if($user['email']!=Session::get('email')){
                    echo '<tr>';
                    echo '<td>'.($k +1). '</td>';
                    echo '<td>'.$user['email']. '</td>';
                    echo '<td>'.$user['isAdmin']. '</td>';
                    echo '<td>'.$user['created_at']. '</td>';
                    echo '<td><div class="btn-group" style="min-width: 40px">';
                 if($user['isAdmin']==0){
   echo '<a href="" data-target="#editUserModal" data-toggle="modal"
                                           class="btn btn-sm btn-success" title="Detalii" id="approve"
data-user_email="'.$user['email'].'" data-user_id="'.$user['id'].'"><i class="fa fa-check"></i> Give admin right</a></div>';
}
else{
       echo '<div class="btn-group" style="min-width: 40px">
    <a href="" data-target="#editUserModal" data-toggle="modal" data-user_email="'.$user['email'].'" data-user_id="'.$user['id'].'"  class="btn btn-sm btn-danger" title="Detalii" id="notApprove"><i class="fa fa-exclamation-triangle"></i>Remove admin right</a></div>
</td>';
                }}
                }
                ?>
                </tbody>
            </table>

            <div class="clearfix"></div>
        </div>
    </main>
    <div id="editUserModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold"></h5>
                </div>
                <div class="modal-body">
                <form id="edit_form" method="POST" action="{{ route('give_remove_right') }}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="user_id" name="user_id" required style="display: none">
                            <input type="text" class="form-control" id="action_u" name="action_u" style="display: none" >
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-info form_submit" value="Yes">
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

@endsection
