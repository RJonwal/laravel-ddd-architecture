<?php

return [

    'crud'=>[
        'add_record'    => 'Successfully Added !',
        'update_record' => 'Successfully Updated !',
        'delete_record' => 'This record has been succesfully deleted!',
        'restore_record'=> 'This record has been succesfully Restored!',
        'merge_record'  => 'This record has been succesfully Merged!',
        'approve_record'=> 'Record Successfully Approved !',
        'status_update' => 'Status successfully updated!',

        // subscription package delete but package is taken by user
        'subscription_plan_taken' => 'Subscription Plan cannot be deleted because it is already taken by users.',

        // remove profile image:
        'profile' => [
            'remove_image' => 'Profile image removed Successfully',
            'remove_image_not_found' => 'Profile image not found',
            'onceClickedRecordDeleted' => 'Do you want to remove profile image ?'
        ]
    ],

    'unable_to_add_blank_field' => 'Sorry, Unable to add a blank field in',
    'data_already_exists' => 'Sorry, You cannot create new with the same name so use existing.',

    'areYouSure'=>'Are you sure you want to delete this record?',
    'areYouSureapprove'=>'Are you sure you want to Approve this record?',
    'areYouSurerestore'=>'Are you sure you want to Restore this Database? It will delete your current database.',
    'deletetitle'=>'Delete Confirmation',
    'restoretitle'=>'Restore Confirmation',
    'approvaltitle'=>'Approval Confirmation',
    'areYouSureRestore'=>'Are you sure you want to restore this record?',
    'error_message'   => 'Something went wrong....please try again later!',
    'has_tasks_error' => 'Cannot delete this milestone because it has associated tasks.',
    'no_record_found' => 'No Records Found!',
    'suspened'=> "Your account has been suspened!",
    'invalid_email'=>'Invalid Email',
    'invalid_otp'=>'Invalid OTP',
    'invalid_pin'=>'Invalid PIN',
    'wrong_credentials'=>'These credentials do not match our records!',
    'not_activate'=>'Your account is not activated.',
    'otp_sent_email'=>'We have successfully sent OTP on your Registered Email',
    'expire_otp'=> 'OTP has been Expired',
    'verified_otp'=> 'OTP successfully Verified.',
    'invalid_token_email'=> 'Invalid Token or Email!',
    'success'=>'Success',
    'register_success'=>'Your account created successfully! Please wait for the approval!',
    'login_success'=>'You have logged in successfully!',
    'logout_success'=>'Logged out successfully!',
    'warning_select_record'=> 'Please select at least one record',
    'required_role'=> "User with the specified email doesn't have the required role.",
    
    'invalid_token'                 => 'Your access token has been expired. Please login again.',
    'not_authorized'                => 'Not Authorized to access this resource/api',
    'not_found'                     => 'Not Found!',
    'endpoint_not_found'            => 'Endpoint not found',
    'resource_not_found'            => 'Resource not found',
    'token_invalid'                 => 'Token is invalid',
    'unexpected'                    => 'Unexpected Exception. Try later',
    
    'data_retrieved_successfully'   => 'Data retrieved successfully',
    'record_retrieved_successfully' => 'Record retrieved successfully',
    'record_created_successfully'   => 'Record created successfully',
    'record_updated_successfully'   => 'Record updated successfully',
    'record_deleted_successfully'   => 'Record deleted successfully',
    'password_updated_successfully' => 'Password updated successfully',

    'profile_updated_successfully'  => 'Profile updated successfully',
    'account_deactivate'            => 'Your account has been deactivated. Please contact the admin.',
    'user_account_deactivate'      => 'Your account has been deactivated.',

    'contact' => [
        'store' => [
            'success' => "Your message has been sent successfully. We will get back to you as soon as possible"
        ]
        ],
    'rating' => [
        'store' => [
            'success' => "Your feedback has been submitted successfully. We appreciate your time and effort in helping us improve our service."
        ]
        ],

    'notification'=>[
        'not_found' => 'Notification not found',
        'mark_as_read' => 'Notification marked as read',
        'no_notification'=>'No notifications to clear!',
        'clear_notification' => 'All notifications have been cleared',
        'delete'             => 'Notification has been deleted successfully!',
    ],

    'warning_messages' => [
        'milestone_not_selected' => "Please select Milestone"
    ]
];
