import {showResultStep} from "./popup-helper";

export function wprtSendApiRequest(apiEndpoint, params)
{
    const originalEndpoint = apiEndpoint;

    const endpoint = wprtObject.wprtRestUrl + apiEndpoint;

    const options = {
        method: 'POST',
        body: JSON.stringify(params)
    };

    fetch(endpoint, options)
        .then(response => response.json())
        .then(response => {
            handleApiResponse(response, originalEndpoint, params)
        })
}

function handleApiResponse(response, originalEndpoint, params) {
    const { data, success } = response;

    if (success) {
        handleSuccessResponse(data, originalEndpoint, params);
    } else {
        handleErrorResponse(data, originalEndpoint, params);
    }
}

function handleSuccessResponse(data, originalEndpoint, params) {
    const { message, title } = data;

    if (originalEndpoint === 'add') {
        params.isKeywordAdd = true;
        setTimeout(() => {
            showResultStep(message, title,'success')
        }, 2000);
        return;
    }

    if (originalEndpoint === 'update') {
        setTimeout(() => {
            showResultStep(message, title,'success')
        }, 2000);
    }

    if (originalEndpoint === 'update' && params.hasOwnProperty('id')) {
        $('.wprt_update_icon').removeClass('disabled')
    }

    if (originalEndpoint === 'delete' || originalEndpoint === 'remove-license' || originalEndpoint === 'delete-existing-data' || originalEndpoint === 'activation') {
        location.reload();
    }
}

function handleErrorResponse(errorMessage, originalEndpoint, params) {
    const { message, title } = errorMessage;
    setTimeout(() => {
        showResultStep(message,title,'error')
    }, 2000);

    if (originalEndpoint === 'update' && params.hasOwnProperty('isKeywordAdd')) {
        if (errorMessage === wprtObject.wprtDailyUsageLimitExpired && wprtObject.wprtUserFree === '1') {
            setTimeout(() => {
                showResultStep(errorMessage, title,'error')
            }, 2000);
        } else {
            setTimeout(() => {
                location.reload();
            }, 4000);
        }
        return;
    }

    if (errorMessage === wprtObject.wprtInvalidTokenMessage) {
        setTimeout(() => {
            location.reload();
        }, 3000);
    }

    if (originalEndpoint === 'update' && params.hasOwnProperty('id')) {
        $('.wprt_update_icon').removeClass('disabled')
        setTimeout(() => {
            location.reload();
        }, 3000);
    }

    if (originalEndpoint === 'delete') {
        location.reload();
    }
    
    if(originalEndpoint === 'activation') {
        $('.wprt_activation_license_error').addClass('active');
        $('.wprt_activation_license_error_title')[0].innerHTML = errorMessage.title;
        $('.wprt_activation_license_error_description')[0].innerHTML = errorMessage.message;
    }
}
