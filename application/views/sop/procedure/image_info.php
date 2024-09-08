<?php 
    $sessionSopProcedureViewPreviousUrl = $this->session->userdata('session_sop_procedure_view_previous_url');
?>

<div class="nk-content-wrap">
    <div class="nk-block nk-block-lg">
        
        <div class="nk-block-head">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Procedure</h3>
                    <div class="nk-block-des text-soft">
                        <p>Images Procedure</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <a href="<?php if(!empty($sessionSopProcedureViewPreviousUrl)){ echo $sessionSopProcedureViewPreviousUrl; } ?>" class="btn btn-outline-light bg-white d-block d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em></a>
                </div>
            </div>
        </div>
        
        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner">
                    <form action="" method="post" class="form-validate is-alter" enctype="multipart/form-data">
                        <?php if(!empty($imageData['sop_image'])){ ?>
                            <div class="row g-gs">
                                <?php foreach($imageData['sop_image'] as $data){ ?>
                                <div class="col-md-3 text-center">
                                    <div class="card card-bordered">
                                        <div class="card-body">
                                            <p class="card-text"><a class="gallery-image popup-image" href="<?php echo base_url('uploads/sop/procedure/images/'.$data['sop_image']); ?>">
                                                <img class="mb-3" src="<?php echo base_url('uploads/sop/procedure/images/'.$data['sop_image']); ?>" width="200" height="200">
                                            </a></p>
                                        </div>
                                        <div class="card-footer border-top text-muted">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="imageDelete('<?php echo $data['image_id']; ?>')">Delete</a>
                                            <a href="javascript:void(0);" data-link="<?php echo base_url('uploads/sop/procedure/images/'.$data['sop_image']); ?>" id="image_<?php echo $data['image_id']; ?>" class="btn btn-sm btn-primary">Copy URL</a>
                                        </div>
                                    </div>
                                </div> 
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-12">
                                <div class="text-center">
                                    <img src="<?php echo base_url(); ?>source/images/no-data.png" width="300" height="190">
                                    <span class="sub-text mt-3">No data available in table</span>
                                </div>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function imageDelete(image_id){
        var result = confirm("Are you sure to delete ?");
        if(result){
            $.post( "<?php echo base_url('delete-sop-image'); ?>", {image_id:image_id}, function(resp) {
                if(resp == 'ok'){
                    $('#imgb_'+image_id).remove();
                    alert('The image has been removed');
                }else{
                    alert('Some problem occurred, please try again.');
                }
                window.location.reload(true);
            });
        }
    }

    $('a').click(function(){
        copyImageURL(this);
        var imageID = $(this).attr('id');
        $('#'+imageID).removeClass("btn-primary");
        $('#'+imageID).addClass("btn-success");
        $('#'+imageID).text("URL Copied");
        setTimeout(function(){   
            $('#'+imageID).removeClass("btn-success");
            $('#'+imageID).addClass("btn-primary");
            $('#'+imageID).text('Copy URL');
        },500);
    });
    
    function copyImageURL(element) {
        var $blankInput = $("<input>");
        $("body").append($blankInput);
        $blankInput.val($(element).attr("data-link")).select();
        document.execCommand("copy");
        $blankInput.remove();
    }
</script>