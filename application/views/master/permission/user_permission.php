<?php 
    $sessionUserViewPreviousUrl = $this->session->userdata('session_user_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Permission</h4>
                    <div class="nk-block-des text-soft">
                        <p><?php echo $masterUserData['user_name']; ?> - Permission / Department - <?php echo $masterUserData['user_role']; ?> </p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionUserViewPreviousUrl)){ echo $sessionUserViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="nk-block">
                            <div class="card card-bordered">
                                <div class="table-responsive">
                                    <table class="table table-member">
                                        <thead class="tb-member-head thead-light">
                                            <tr class="nk-tb-item tb-member-item tb-tnx-head">
                                                <th class="nk-tb-col">
                                                    <span class="overline-title">Moduls Name</span>
                                                </th>
                                                <th class="nk-tb-col">
                                                    <span class="overline-title">Can Add</span>
                                                </th>
                                                <th class="nk-tb-col">
                                                    <span class="overline-title">Can View</span>
                                                </th>
                                                <th class="nk-tb-col">
                                                    <span class="overline-title">Can Edit</span>
                                                </th>
                                                <th class="nk-tb-col">
                                                    <span class="overline-title">Can Delete</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <?php if(!empty($userPermissionData)){ ?>
                                            <tbody class="tb-member-body">
                                                <?php foreach($userPermissionData as $data){ ?>
                                                <tr class="nk-tb-item tb-member-item">
                                                    <td class="tb-member-info">
                                                        <div class="user-card">
                                                            <div class="user-info">
                                                                <span class="lead-text"><?php echo $data['permission_name']; ?></span>
                                                                <span class="tb-lead"><?php echo $data['permission_alias']; ?></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <?php if($data['can_add'] == 1){ ?>
                                                        <td class="tb-member-role bg-success-dim text-success border-bottom border-success">
                                                            <div class="form">
                                                                <?php if($data['can_add'] == 1){ ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="1">Granted</option>
                                                                        <option value="0">Denied</option>
                                                                    </select>
                                                                <?php } else { ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="0">Denied</option>
                                                                        <option value="1">Granted</option>
                                                                    </select>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td class="tb-member-role bg-danger-dim text-danger border-bottom border-danger">
                                                            <div class="form">
                                                                <?php if($data['can_add'] == 1){ ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="1">Granted</option>
                                                                        <option value="0">Denied</option>
                                                                    </select>
                                                                <?php } else { ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="0">Denied</option>
                                                                        <option value="1">Granted</option>
                                                                    </select>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    <?php } ?>
                                                    <?php if($data['can_view'] == 1){ ?>
                                                        <td class="tb-member-role bg-success-dim text-success border-bottom border-success">
                                                            <div class="form">
                                                                <?php if($data['can_view'] == 1){ ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="1">Granted</option>
                                                                        <option value="0">Denied</option>
                                                                    </select>
                                                                <?php } else { ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="0">Denied</option>
                                                                        <option value="1">Granted</option>
                                                                    </select>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td class="tb-member-role bg-danger-dim text-danger border-bottom border-danger">
                                                            <div class="form">
                                                                <?php if($data['can_view'] == 1){ ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="1">Granted</option>
                                                                        <option value="0">Denied</option>
                                                                    </select>
                                                                <?php } else { ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="0">Denied</option>
                                                                        <option value="1">Granted</option>
                                                                    </select>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    <?php } ?>
                                                    <?php if($data['can_edit'] == 1){ ?>
                                                        <td class="tb-member-role bg-success-dim text-success border-bottom border-success">
                                                            <div class="form">
                                                                <?php if($data['can_edit'] == 1){ ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="1">Granted</option>
                                                                        <option value="0">Denied</option>
                                                                    </select>
                                                                <?php } else { ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="0">Denied</option>
                                                                        <option value="1">Granted</option>
                                                                    </select>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td class="tb-member-role bg-danger-dim text-danger border-bottom border-danger">
                                                            <div class="form">
                                                                <?php if($data['can_edit'] == 1){ ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="1">Granted</option>
                                                                        <option value="0">Denied</option>
                                                                    </select>
                                                                <?php } else { ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="0">Denied</option>
                                                                        <option value="1">Granted</option>
                                                                    </select>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    <?php } ?>
                                                    <?php if($data['can_delete'] == 1){ ?>
                                                        <td class="tb-member-role bg-success-dim text-success border-bottom border-success">
                                                            <div class="form">
                                                                <?php if($data['can_delete'] == 1){ ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="1">Granted</option>
                                                                        <option value="0">Denied</option>
                                                                    </select>
                                                                <?php } else { ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="0">Denied</option>
                                                                        <option value="1">Granted</option>
                                                                    </select>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td class="tb-member-role bg-danger-dim text-danger border-bottom border-danger">
                                                            <div class="form">
                                                                <?php if($data['can_delete'] == 1){ ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="1">Granted</option>
                                                                        <option value="0">Denied</option>
                                                                    </select>
                                                                <?php } else { ?>
                                                                    <select class="form-select js-select2" name="<?php echo $data['rights_id']; ?>[]">
                                                                        <option value="0">Denied</option>
                                                                        <option value="1">Granted</option>
                                                                    </select>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        <?php } else { ?>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5">
                                                        <div class="nk-block-content text-center p-3">
                                                            <span class="sub-text">No data available in table</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                            <?php if(!empty($userPermissionData)) { ?>
                                <div class="form-group mt-3">
                                    <input type="submit" class="btn btn-primary submitBtn" name="submit" value="Save Informations">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>