import $ from 'jquery';
import {wprtSendApiRequest} from "./api-helper";

export function triggerPopup(method, data)
{
    if(method === 'add') {
        showPopup();
        showAddKeywordStep();
    } else if(method === 'update') {
        showPopup();
        hideAddKeywordStep();
        showLoadingStep();
        wprtSendApiRequest('update', data)
    } else if(method === 'delete') {
        replaceKeywordName(data)
        showPopup();
        hideAddKeywordStep();
        showDeleteKeywordPopup();

        $('.wprt_rank_delete_submit').on('click', function () {
            wprtSendApiRequest('delete', data)
        })
    }
}

export function showPopup() {
    $('.wprt_keyword_popup').show();
    $('.wprt_keyword_popup_wrapper').show();
    const keywordPopupForm = $('.wprt_keyword_popup_form');
    $('.wprt_keyword').addClass('wprt_show_popup');
    keywordPopupForm[0].reset();
    keywordPopupForm.show();
    $('body').addClass('wprt_keyword_disable_scroll')
}

export function hidePopup() {
    $('.wprt_keyword_popup').hide();
    $('.wprt_keyword_popup_wrapper').hide();
    $('.wprt_rank_result').hide();
    $('.wprt_rank_delete').hide();
    $('.wprt_keyword').removeClass('wprt_show_popup');
    $('body').removeClass('wprt_keyword_disable_scroll')
}

function preventTab(e) {
    if (e.keyCode === 9) { // If tab key is pressed
        e.preventDefault() // Stop event from its action
    }
}

function hideAddKeywordStep() {
    $('.wprt_keyword_popup_step').hide();
}

function showAddKeywordStep() {
    $('.wprt_keyword_popup_step').show();
}

export function showLoadingStep() {
    $('.wprt_keyword_popup_step div').eq(0).addClass('step_complete');
    $('.wprt_keyword_popup_form , .wprt_keyword_popup_title').hide();
    $('.wprt_keyword_popup_step div').removeClass('step_active');
    $('.wprt_keyword_popup_step-status').addClass('step_active');

    $('.wprt_rank_status').show();
}

export function showResultStep(response,responseTitle,responseType) {
    $('.wprt_keyword_popup_step-status').addClass('step_active step_complete');
    $('.wprt_rank_result').show();
    $('.wprt_rank_result_' + responseType).show();

    $('.wprt_keyword_popup_step div').removeClass('step_active');
    $('.wprt_keyword_popup_step-result').addClass('step_active');
    $('.wprt_rank_status').hide();
    $('.wprt_rank_result_title').html(responseTitle);
    $('.wprt_rank_result_description').html(response);
}

export function showDeleteKeywordPopup() {
    $('.wprt_keyword_popup_step div').eq(0).addClass('step_complete');
    $('.wprt_keyword_popup_form , .wprt_keyword_popup_title').hide();
    $('.wprt_keyword_popup_step div').removeClass('step_active');

    $('.wprt_rank_delete').show();
}

export function replaceKeywordName(data) {
    const template = $('#wprt_delete_description_template').html();
    $('.wprt_rank_delete .wprt_rank_result_description')[0].innerHTML = template.replace('{{keywordName}}', data['keyword'])
}