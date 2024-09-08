<?php 
    $sessionSopProcedureViewPreviousUrl = $this->session->userdata('session_sop_procedure_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h4 class="title nk-block-title">Procedure</h4>
                    <div class="nk-block-des text-soft">
                        <p>New Procedure</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionSopProcedureViewPreviousUrl)){ echo $sessionSopProcedureViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="card card-bordered">
            <div class="card-inner">
                <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                    <div class="row g-gs">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="sop_title">Sop Title *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="sop_title" placeholder="Enter sop title" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="sop_description">Sop Description *</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control tinymce-default" name="sop_description" placeholder="Enter sop description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="sop_department">Department Name *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="sop_department" placeholder="Enter sop department" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="sop_purpose">Sop Purpose *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="sop_purpose" placeholder="Enter sop purpose" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="sop_outcomes">Sop Outcomes *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="sop_outcomes" placeholder="Enter sop outcomes" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="sop_responsibility">Sop Responsibility *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="sop_responsibility" placeholder="Enter sop responsibility" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="sop_tag">Sop Tag *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control js-tagify tagify" name="sop_tag" placeholder="Enter sop tag" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="sop_status">Sop Status *</label>
                                <div class="form-control-wrap">
                                    <select class="form-control form-select js-select2" name="sop_status" data-placeholder="Select a status" required>
                                        <option label="empty" value=""></option>
                                        <option value="true">True</option>
                                        <option value="false">False</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Images</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" multiple class="form-file-input" id="file-uploader-image" name="sop_image[]">
                                        <label class="form-file-label" for="sop_image[]">Choose files</label>
                                        <div id="feedback-image"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary submitBtn" id="submit-button" name="submit" value="Save Informations">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

<script>
    const fileUploaderImage = document.getElementById('file-uploader-image');
    const feedbackImage = document.getElementById('feedback-image');
    const submitButton = document.getElementById('submit-button');

    fileUploaderImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        const allowedImageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']; 
    
        if (file) {
            
            if (!allowedImageTypes.includes(file.type)) {
                feedbackImage.innerHTML = `<span style="color:red;">Please upload a JPG or JPEG or PNG or GIF image. </span>`;
                submitButton.style.display = 'none';
                return;
            } else {
                feedbackImage.innerHTML = ` `;
                submitButton.style.display = 'block';
                return;
            } 
        }
    });
</script>