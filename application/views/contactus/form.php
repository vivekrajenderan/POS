<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">

    $(document).ready(function ()
    {
        $.validator.setDefaults({ignore: []});
        $('#contactus_form').validate($.extend({
            submitHandler: function (form)
            {
                $(form).ajaxSubmit({
                    success: function (response)
                    {
                        $.notify(response.message, {type: response.success ? 'success' : 'danger'});
                        if (response.status == 1)
                        {
                            $('#contactus_form')[0].reset();
                        }
                    },
                    dataType: 'json'
                });

            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:
                    {
                        fullname:
                                {
                                    required: true

                                },
                        email:
                                {
                                    required: true,
                                    email: true,
                                },
                        phone:
                                {
                                    required: true,
                                    number: true,
                                    minlength: 10,
                                    maxlength: 12
                                },
                        subject:
                                {
                                    required: true,
                                    minlength: 10
                                },
                        message:
                                {
                                    required: true,
                                    minlength: 10

                                }
                    },
            messages:
                    {
                        fullname:
                                {
                                    required: "<?php echo $this->lang->line('contactus_fullname_required'); ?>"

                                },
                        email:
                                {
                                    required: "<?php echo $this->lang->line('contactus_email_required'); ?>",
                                    email: "<?php echo $this->lang->line('common_email_invalid_format'); ?>"

                                },
                        phone:
                                {
                                    required: "<?php echo $this->lang->line('contactus_phone_required'); ?>",
                                    number: "<?php echo $this->lang->line('contactus_phone_number'); ?>",
                                    minlength: "<?php echo $this->lang->line('contactus_phone_minlength'); ?>",
                                    maxlength: "<?php echo $this->lang->line('contactus_phone_maxlength'); ?>"
                                },
                        subject:
                                {
                                    required: "<?php echo $this->lang->line('contactus_subject_required'); ?>",
                                    minlength: "<?php echo $this->lang->line('contactus_subject_minlength'); ?>"
                                },
                        message:
                                {
                                    required: "<?php echo $this->lang->line('contactus_message_required'); ?>",
                                    minlength: "<?php echo $this->lang->line('contactus_message_minlength'); ?>"
                                },
                    }
        }, form_support.error));

    });
</script>
<div id="page_title" class="text-center"><?php echo $this->lang->line('contactus_title'); ?></div>
<br>
<ul id="error_message_box" class="error_message_box"></ul>
<?php echo form_open('contactus/savecontact/', array('id' => 'contactus_form', 'autocomplete' => 'off', 'class' => 'form-horizontal')); ?>
<div class="panel-body">
    <div class="row">
        <!-- Name input-->
        <div class="form-group">
            <?php echo form_label($this->lang->line('contactus_fullname'), 'email', array('class' => 'required control-label col-md-2')); ?>

            <div class="col-md-3">
                <?php
                echo form_input(array(
                    'name' => 'fullname',
                    'id' => 'fullname',
                    'class' => 'form-control input-sm',
                    'value' => '')
                );
                ?>
            </div>
        </div>

        <!-- Email input-->
        <div class="form-group">
            <?php echo form_label($this->lang->line('common_email'), 'email', array('class' => 'required control-label col-md-2')); ?>

            <div class="col-md-3">
                <?php
                echo form_input(array(
                    'name' => 'email',
                    'id' => 'email',
                    'class' => 'form-control input-sm required',
                    'value' => '')
                );
                ?>
            </div>
        </div>

        <!-- Phone Number-->
        <div class="form-group">
            <?php echo form_label($this->lang->line('common_phone_number'), 'phone', array('class' => 'required control-label col-md-2')); ?>

            <div class="col-md-3">
                <?php
                echo form_input(array(
                    'name' => 'phone',
                    'id' => 'phone',
                    'class' => 'form-control input-sm',
                    'value' => '')
                );
                ?>
            </div>
        </div>

        <!-- Subject-->
        <div class="form-group">
            <?php echo form_label($this->lang->line('contactus_subject'), 'subject', array('class' => 'required control-label col-md-2')); ?>

            <div class="col-md-3">
                <?php
                echo form_input(array(
                    'name' => 'subject',
                    'id' => 'subject',
                    'class' => 'form-control input-sm',
                    'value' => '')
                );
                ?>
            </div>
        </div>

        <!-- Message body -->
        <div class="form-group">
            <?php echo form_label($this->lang->line('contactus_message'), 'message', array('class' => 'required control-label col-md-2')); ?>

            <div class="col-md-5">
                <?php
                echo form_textarea(array(
                    'name' => 'message',
                    'id' => 'message',
                    'class' => 'form-control input-sm',
                    'cols' => 40,
                    'rows' => 4,
                    'value' => '')
                );
                ?>
            </div>
        </div>

        <!-- Form actions -->
        <div class="form-group">
            <div class="col-md-5 col-sm-1 col-xs-1 text-center">
                <?php
                echo form_submit(array(
                    'name' => 'submit_form',
                    'id' => 'submit_form',
                    'value' => $this->lang->line('common_submit'),
                    'class' => 'btn btn-primary btn-sm'));
                ?>
            </div>
        </div>
    </div>


</div>
<?php echo form_close(); ?>


<?php $this->load->view("partial/footer"); ?>

