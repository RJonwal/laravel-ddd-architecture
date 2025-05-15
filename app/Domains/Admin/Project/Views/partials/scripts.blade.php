<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script src="{{asset('admin-assets/vendor/select2/js/select2.min.js')}}"></script>
<script src="{{asset('admin-assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script>
$(document).ready( function(){
    $(".select2").select2();  

    $('#start_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        startDate: new Date(),
    }).on('changeDate', function (selected) {            
        $('#end_date').val('');
        var minDate = new Date(selected.date.valueOf());
        $('#end_date').datepicker('setStartDate', minDate);
    });

    $('#end_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        startDate: new Date(),
    });
    

    CKEDITOR.config.entities =  false;
    CKEDITOR.config.removeButtons   =  'Image';
    CKEDITOR.config.basicEntities = false;
    CKEDITOR.replaceClass =  'ckeditor';
    

    $('#projectForm, #projectEditForm').validate({
        ignore: '.ignore',

        focusInvalid: false,

        rules: {
            /* 'name': {
                // required: true,
            }, */
            
            /* 'status': {
                required: true,
            }, */
            /* 'cost_of_project': {
                // required: true,
                number: true,
                min: 1,
                max:99999999.99
            }, */
            /*'project_taken_by': {
                required: true,
            },
            'project_discuss_with': {
                required: true,
            },
            'start_date': {
                required: true,
            },
            'end_date': {
                required: true,
            },
            'platform': {
                required: true,
            },
            'tag': {
                required: true,
            },
            'technology': {
                required: true,
            },*/
            
        },
        messages: {
            title: {
                required: 'Title is required dsf',
            },                
            client_name: {
                required: 'Client name is required',
            },
            cost_of_project: {
                required: 'Cost of project is required',
            },                
            project_taken_by: {
                required: 'Project taken by is required',
            },                
            project_discuss_with: {
                required: 'Project discuss with is required',
            },                
            start_date: {
                required: 'Start date is required',
            },                
            end_date: {
                required: 'Delivery date is required',
            },                
            platform: {
                required: 'Platform is required',
            },                
            tag: {
                required: 'Tag is required',
            },                
            technology: {
                required: 'Technology is required',
            },                
            
        },

        // Errors //

        errorPlacement: function errorPlacement(error, element) {

            var $parent = $(element).parents('.form-group');
            // Do not duplicate errors
            if ($parent.find('.jquery-validation-error').length) {
                return;
            }

            $parent.append(
                error.addClass('jquery-validation-error small form-text invalid-feedback')
            );

        },

        highlight: function(element) {

            var $el = $(element);

            var $parent = $el.parents('.form-group');
            $el.addClass('is-invalid');
        },

        unhighlight: function(element) {

            $(element).parents('.form-group').find('.is-invalid').removeClass('is-invalid');

        }

    });

    @can('project_create')
        $(document).on("submit", "#projectForm", function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            var fileVals =  dropzone.getAcceptedFiles();
            var formData = new FormData(this);
            for (var i = 0; i < fileVals.length; i++) {
                formData.append('attachment[]', fileVals[i]);
            }
            storeUpdateProject(formData, url)
        });
    @endcan

    @can('project_edit')
        $(document).on("submit", "#projectEditForm", function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            var formData = new FormData(this);
            if ($('#attachments').length){
                var fileVals =  dropzone.getAcceptedFiles();
                for (var i = 0; i < fileVals.length; i++) {
                    formData.append('attachment[]', fileVals[i]);
                }
            }
            storeUpdateProject(formData, url)
        });
    @endcan
});

// update and store project
function storeUpdateProject(formData, url){
    $('.validation-error-block').remove();
    $('.loader-div').show();
    $.ajax({
        type: 'post',
        url: url,
        dataType: 'json',
        contentType: false,
        processData: false,
        data: formData,
        success: function (response) {
            $('.loader-div').hide();
            if(response.success){
                toasterAlert('success',response.message);  
                setTimeout(function() {                  
                    window.location.replace(response.redirectUrl);
                }, 1500); 
            }
        },
        error: function (response) {
            $('.loader-div').hide();
            $("#sendBtn").attr('disabled', false);
            var errorLabelTitle = '';
            if(response.responseJSON.error_type == 'something_error'){
                toasterAlert('error',response.responseJSON.error);
            } else {
                var errorLabelTitle = '';
                $.each(response.responseJSON.errors, function (key, item) {
                    errorLabelTitle = `<span class="validation-error-block">${item[0]}</span>`;

                    $("input[name='" + key + "']").after(errorLabelTitle);
                    $("textarea[name='" + key + "']").after(errorLabelTitle);

                    $("#"+key).siblings('.select2').after(errorLabelTitle);
                });
            }
        },
        complete: function(res){
            $('.loader-div').hide();
        }
    });   
}

/* dropzone start */ 
    let excelFileExtensions = ['xls','xlsx', 'xml', 'csv', 'xlsm', 'xlw', 'xlr'];
    let wordFileExtensions = ['doc', 'docm', 'docx', 'dot'];
    let pdfFileExtensions = ['pdf'];
    let zipFileExtensions = ['zip','rar'];
    let filesExtensions = ['css', 'html', 'txt', 'php', 'sql', 'js'];

    let preloaded = [];
    @if(isset($project->uploads) && $project->uploads)
        @foreach($project->uploads as $record)
            @php 
                $fileNameArray = explode('/', $record->file_path);
                $fileName = end($fileNameArray);
                $fileSize = \File::size(public_path('storage/'.$record->file_path));
                if($record->file_path && Storage::disk('public')->exists($record->file_path)){
                    $MediaImage = asset('storage/'.$record->file_path);
                }else{
                    $MediaImage = '';
                }

            @endphp
            preloaded.push(<?= json_encode(array('id'=>$record->id,'src'=>$MediaImage,'documentType'=>$record->extension, 'fileName' => $fileName, 'size' => $fileSize)); ?>);
        @endforeach
    @endif 

    console.log(preloaded);
    

    Dropzone.autoDiscover = false;
    var dropzone = new Dropzone('#attachments', {
        url: "{% url 'dropzone/images' %}",
        addRemoveLinks: true,
    });

    dropzone.on('addedfile', function(file) {
        $('.dz-message').css('display', 'none');
        var countImage = $("#attachments").find(".dz-complete").length; 
        if(countImage == -1){
            $('.dz-message').css('display', 'block');
        }
        var documentType = file.name.split('.').pop();
        if($.inArray(documentType, excelFileExtensions) != -1){
            $(file.previewElement).find(".dz-image img").attr("src", "{{ asset('default_images/excel.png') }}");
        }else if($.inArray(documentType, wordFileExtensions) != -1){
            $(file.previewElement).find(".dz-image img").attr("src", "{{ asset('default_images/word-icon.png') }}");
        }else if($.inArray(documentType, pdfFileExtensions) != -1){
            $(file.previewElement).find(".dz-image img").attr("src", "{{ asset('default_images/pdf-icon.png') }}");
        }else if($.inArray(documentType, zipFileExtensions) != -1){
            $(file.previewElement).find(".dz-image img").attr("src", "{{ asset('default_images/zip-icon.png') }}");
        }else if($.inArray(documentType, filesExtensions) != -1){
            $(file.previewElement).find(".dz-image img").attr("src", "{{ asset('default_images/file-icon.png') }}");
        } else {
            $(file.previewElement).find(".dz-image img").attr("src", "{{ asset('default_images/file-icon.png') }}");
        }
    });

    $.each(preloaded, function(key,value) {
        var mockFile = { name: value.fileName, size:value.size, path:value.src, id: value.id, type:value.documentType };
        dropzone.emit("addedfile", mockFile);
        if($.inArray(value.documentType, excelFileExtensions) != -1){
            dropzone.emit("thumbnail", mockFile, "{{ asset('default_images/excel.png') }}");
        }else if($.inArray(value.documentType, wordFileExtensions) != -1){
            dropzone.emit("thumbnail", mockFile, "{{ asset('default_images/word-icon.png') }}");
        }else if($.inArray(value.documentType, pdfFileExtensions) != -1){
            dropzone.emit("thumbnail", mockFile, "{{ asset('default_images/pdf-icon.png') }}");
        }else if($.inArray(value.documentType, zipFileExtensions) != -1){
            dropzone.emit("thumbnail", mockFile, "{{ asset('default_images/zip-icon.png') }}");
        }else if($.inArray(value.documentType, filesExtensions) != -1){
            dropzone.emit("thumbnail", mockFile, "{{ asset('default_images/file-icon.png') }}");
        }
        else{
            dropzone.emit("thumbnail", mockFile, value.src);
        }
        dropzone.emit("complete", mockFile);
    });

    dropzone.on("removedfile", function(file) {
        $('.dz-message').css('display', 'block');
        var countImage = $("#attachments").find(".dz-complete").length; 
        if(countImage > 0){
            $('.dz-message').css('display', 'none');
        }
        var removeDocIds = $('#projectDocIds').val();
        if(removeDocIds && file.id) {
            var imageIds = removeDocIds+','+file.id;
            $("#projectDocIds").val(imageIds);
        }
        else if(file.id){
            $("#projectDocIds").val(file.id)
        } 
    });
/* dropzone end */
</script>