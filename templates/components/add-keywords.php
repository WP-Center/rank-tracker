<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Keyword Popup
 */

$iconHelper = wprtContainer('IconHelper');
?>
<div class="wprt_keyword_popup_wrapper">
    <div class="wprt_keyword_popup">
        <div class="wprt_keyword_popup_container">
            <div class="wprt_keyword_popup_step">
                <div class="wprt_keyword_popup_step-keyword step_active">
                    <span>1</span>
                    <span class="step_complete_icon">
                         <svg xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none">
                            <path fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M19 1.75008L5.80209 15L0 9.17505L1.74319 7.4249L5.80209 11.4999L17.2567 0L19 1.75008Z"
                                fill="black" />
                        </svg>
                    </span>

                    <?php esc_html_e('Add Keyword', 'wp-rank-tracker'); ?>
                </div>
                <div class="wprt_keyword_popup_step_border">

                </div>
                <div class="wprt_keyword_popup_step-status">
                    <span>2</span>
                    <span class="step_complete_icon">
                         <svg xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none">
                            <path fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M19 1.75008L5.80209 15L0 9.17505L1.74319 7.4249L5.80209 11.4999L17.2567 0L19 1.75008Z"
                                fill="black" />
                        </svg>
                    </span>
                    <?php esc_html_e('Rank Status', 'wp-rank-tracker'); ?>
                </div>
                <div class="wprt_keyword_popup_step_border">

                </div>
                <div class="wprt_keyword_popup_step-result">
                    <span>3</span>
                    <span class="step_complete_icon">
                         <svg xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15" fill="none">
                            <path fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M19 1.75008L5.80209 15L0 9.17505L1.74319 7.4249L5.80209 11.4999L17.2567 0L19 1.75008Z"
                                fill="black" />
                        </svg>
                    </span>
                    <?php esc_html_e('Rank Result', 'wp-rank-tracker'); ?>
                </div>
            </div>
            <div class="wprt_keyword_popup_content">
                <form class="wprt_keyword_popup_form">
                    <div class="wprt_keyword_popup_close_icon">
                        <a href="javascript:void(0)" class="wprt_keyword_popup_close_link">
                            <?php
                            $iconHelper->getIcon('close.svg');
                            ?>
                        </a>
                    </div>
                    <div class="wprt_keyword_popup_title">
                        <?php esc_html_e('Keyword Details', 'wp-rank-tracker'); ?>
                    </div>
                    <div class="wprt_keyword_popup_country">
                        <select class="wprt_keyword_popup_country_select"
                            required="required"
                            placeholder="<?php esc_attr_e('Select a country...', 'wp-rank-tracker'); ?>"
                            autocomplete="off"
                            name="country">
                            <option value=""></option>
                            <option value="AF">Afghanistan 🇦🇫</option>
                            <option value="AO">Angola 🇦🇴</option>
                            <option value="AL">Albania 🇦🇱</option>
                            <option value="AD">Andorra 🇦🇩</option>
                            <option value="AE">United Arab Emirates 🇦🇪</option>
                            <option value="AR">Argentina 🇦🇷</option>
                            <option value="AM">Armenia 🇦🇲</option>
                            <option value="AG">Antigua and Barbuda 🇦🇬</option>
                            <option value="AU">Australia 🇦🇺</option>
                            <option value="AT">Austria 🇦🇹</option>
                            <option value="AZ">Azerbaijan 🇦🇿</option>
                            <option value="BI">Burundi 🇧🇮</option>
                            <option value="BE">Belgium 🇧🇪</option>
                            <option value="BJ">Benin 🇧🇯</option>
                            <option value="BF">Burkina Faso 🇧🇫</option>
                            <option value="BD">Bangladesh 🇧🇩</option>
                            <option value="BG">Bulgaria 🇧🇬</option>
                            <option value="BH">Bahrain 🇧🇭</option>
                            <option value="BS">Bahamas 🇧🇸</option>
                            <option value="BA">Bosnia and Herzegovina 🇧🇦</option>
                            <option value="BY">Belarus 🇧🇾</option>
                            <option value="BZ">Belize 🇧🇿</option>
                            <option value="BO">Bolivia 🇧🇴</option>
                            <option value="BR">Brazil 🇧🇷</option>
                            <option value="BB">Barbados 🇧🇧</option>
                            <option value="BN">Brunei 🇧🇳</option>
                            <option value="BT">Bhutan 🇧🇹</option>
                            <option value="BW">Botswana 🇧🇼</option>
                            <option value="CF">Central African Republic 🇨🇫</option>
                            <option value="CA">Canada 🇨🇦</option>
                            <option value="CH">Switzerland 🇨🇭</option>
                            <option value="CL">Chile 🇨🇱</option>
                            <option value="CN">China 🇨🇳</option>
                            <option value="CI">Ivory Coast 🇨🇮</option>
                            <option value="CM">Cameroon 🇨🇲</option>
                            <option value="CD">DR Congo 🇨🇩</option>
                            <option value="CG">Republic of the Congo 🇨🇬</option>
                            <option value="CO">Colombia 🇨🇴</option>
                            <option value="KM">Comoros 🇰🇲</option>
                            <option value="CV">Cape Verde 🇨🇻</option>
                            <option value="CR">Costa Rica 🇨🇷</option>
                            <option value="CU">Cuba 🇨🇺</option>
                            <option value="CY">Cyprus 🇨🇾</option>
                            <option value="CZ">Czechia 🇨🇿</option>
                            <option value="DE">Germany 🇩🇪</option>
                            <option value="DJ">Djibouti 🇩🇯</option>
                            <option value="DM">Dominica 🇩🇲</option>
                            <option value="DK">Denmark 🇩🇰</option>
                            <option value="DO">Dominican Republic 🇩🇴</option>
                            <option value="DZ">Algeria 🇩🇿</option>
                            <option value="EC">Ecuador 🇪🇨</option>
                            <option value="EG">Egypt 🇪🇬</option>
                            <option value="ER">Eritrea 🇪🇷</option>
                            <option value="ES">Spain 🇪🇸</option>
                            <option value="EE">Estonia 🇪🇪</option>
                            <option value="ET">Ethiopia 🇪🇹</option>
                            <option value="FI">Finland 🇫🇮</option>
                            <option value="FJ">Fiji 🇫🇯</option>
                            <option value="FR">France 🇫🇷</option>
                            <option value="FM">Micronesia 🇫🇲</option>
                            <option value="GA">Gabon 🇬🇦</option>
                            <option value="GB">United Kingdom 🇬🇧</option>
                            <option value="GE">Georgia 🇬🇪</option>
                            <option value="GH">Ghana 🇬🇭</option>
                            <option value="GN">Guinea 🇬🇳</option>
                            <option value="GM">Gambia 🇬🇲</option>
                            <option value="GW">Guinea-Bissau 🇬🇼</option>
                            <option value="GQ">Equatorial Guinea 🇬🇶</option>
                            <option value="GR">Greece 🇬🇷</option>
                            <option value="GD">Grenada 🇬🇩</option>
                            <option value="GT">Guatemala 🇬🇹</option>
                            <option value="GY">Guyana 🇬🇾</option>
                            <option value="HN">Honduras 🇭🇳</option>
                            <option value="HR">Croatia 🇭🇷</option>
                            <option value="HT">Haiti 🇭🇹</option>
                            <option value="HU">Hungary 🇭🇺</option>
                            <option value="ID">Indonesia 🇮🇩</option>
                            <option value="IN">India 🇮🇳</option>
                            <option value="IE">Ireland 🇮🇪</option>
                            <option value="IR">Iran 🇮🇷</option>
                            <option value="IQ">Iraq 🇮🇶</option>
                            <option value="IS">Iceland 🇮🇸</option>
                            <option value="IL">Israel 🇮🇱</option>
                            <option value="IT">Italy 🇮🇹</option>
                            <option value="JM">Jamaica 🇯🇲</option>
                            <option value="JO">Jordan 🇯🇴</option>
                            <option value="JP">Japan 🇯🇵</option>
                            <option value="KZ">Kazakhstan 🇰🇿</option>
                            <option value="KE">Kenya 🇰🇪</option>
                            <option value="KG">Kyrgyzstan 🇰🇬</option>
                            <option value="KH">Cambodia 🇰🇭</option>
                            <option value="KI">Kiribati 🇰🇮</option>
                            <option value="KN">Saint Kitts and Nevis 🇰🇳</option>
                            <option value="KR">South Korea 🇰🇷</option>
                            <option value="KW">Kuwait 🇰🇼</option>
                            <option value="LA">Laos 🇱🇦</option>
                            <option value="LB">Lebanon 🇱🇧</option>
                            <option value="LR">Liberia 🇱🇷</option>
                            <option value="LY">Libya 🇱🇾</option>
                            <option value="LC">Saint Lucia 🇱🇨</option>
                            <option value="LI">Liechtenstein 🇱🇮</option>
                            <option value="LK">Sri Lanka 🇱🇰</option>
                            <option value="LS">Lesotho 🇱🇸</option>
                            <option value="LT">Lithuania 🇱🇹</option>
                            <option value="LU">Luxembourg 🇱🇺</option>
                            <option value="LV">Latvia 🇱🇻</option>
                            <option value="MA">Morocco 🇲🇦</option>
                            <option value="MC">Monaco 🇲🇨</option>
                            <option value="MD">Moldova 🇲🇩</option>
                            <option value="MG">Madagascar 🇲🇬</option>
                            <option value="MV">Maldives 🇲🇻</option>
                            <option value="MX">Mexico 🇲🇽</option>
                            <option value="MH">Marshall Islands 🇲🇭</option>
                            <option value="MK">Macedonia 🇲🇰</option>
                            <option value="ML">Mali 🇲🇱</option>
                            <option value="MT">Malta 🇲🇹</option>
                            <option value="MM">Myanmar 🇲🇲</option>
                            <option value="ME">Montenegro 🇲🇪</option>
                            <option value="MN">Mongolia 🇲🇳</option>
                            <option value="MZ">Mozambique 🇲🇿</option>
                            <option value="MR">Mauritania 🇲🇷</option>
                            <option value="MU">Mauritius 🇲🇺</option>
                            <option value="MW">Malawi 🇲🇼</option>
                            <option value="MY">Malaysia 🇲🇾</option>
                            <option value="NA">Namibia 🇳🇦</option>
                            <option value="NE">Niger 🇳🇪</option>
                            <option value="NG">Nigeria 🇳🇬</option>
                            <option value="NI">Nicaragua 🇳🇮</option>
                            <option value="NL">Netherlands 🇳🇱</option>
                            <option value="NO">Norway 🇳🇴</option>
                            <option value="NP">Nepal 🇳🇵</option>
                            <option value="NR">Nauru 🇳🇷</option>
                            <option value="NZ">New Zealand 🇳🇿</option>
                            <option value="OM">Oman 🇴🇲</option>
                            <option value="PK">Pakistan 🇵🇰</option>
                            <option value="PA">Panama 🇵🇦</option>
                            <option value="PE">Peru 🇵🇪</option>
                            <option value="PH">Philippines 🇵🇭</option>
                            <option value="PW">Palau 🇵🇼</option>
                            <option value="PG">Papua New Guinea 🇵🇬</option>
                            <option value="PL">Poland 🇵🇱</option>
                            <option value="KP">North Korea 🇰🇵</option>
                            <option value="PT">Portugal 🇵🇹</option>
                            <option value="PY">Paraguay 🇵🇾</option>
                            <option value="QA">Qatar 🇶🇦</option>
                            <option value="RO">Romania 🇷🇴</option>
                            <option value="RU">Russia 🇷🇺</option>
                            <option value="RW">Rwanda 🇷🇼</option>
                            <option value="SA">Saudi Arabia 🇸🇦</option>
                            <option value="SD">Sudan 🇸🇩</option>
                            <option value="SN">Senegal 🇸🇳</option>
                            <option value="SG">Singapore 🇸🇬</option>
                            <option value="SB">Solomon Islands 🇸🇧</option>
                            <option value="SL">Sierra Leone 🇸🇱</option>
                            <option value="SV">El Salvador 🇸🇻</option>
                            <option value="SM">San Marino 🇸🇲</option>
                            <option value="SO">Somalia 🇸🇴</option>
                            <option value="RS">Serbia 🇷🇸</option>
                            <option value="SS">South Sudan 🇸🇸</option>
                            <option value="ST">São Tomé and Príncipe 🇸🇹</option>
                            <option value="SR">Suriname 🇸🇷</option>
                            <option value="SK">Slovakia 🇸🇰</option>
                            <option value="SI">Slovenia 🇸🇮</option>
                            <option value="SE">Sweden 🇸🇪</option>
                            <option value="SZ">Swaziland 🇸🇿</option>
                            <option value="SC">Seychelles 🇸🇨</option>
                            <option value="SY">Syria 🇸🇾</option>
                            <option value="TD">Chad 🇹🇩</option>
                            <option value="TG">Togo 🇹🇬</option>
                            <option value="TH">Thailand 🇹🇭</option>
                            <option value="TJ">Tajikistan 🇹🇯</option>
                            <option value="TM">Turkmenistan 🇹🇲</option>
                            <option value="TL">Timor-Leste 🇹🇱</option>
                            <option value="TO">Tonga 🇹🇴</option>
                            <option value="TT">Trinidad and Tobago 🇹🇹</option>
                            <option value="TN">Tunisia 🇹🇳</option>
                            <option value="TR">Turkey 🇹🇷</option>
                            <option value="TV">Tuvalu 🇹🇻</option>
                            <option value="TZ">Tanzania 🇹🇿</option>
                            <option value="UG">Uganda 🇺🇬</option>
                            <option value="UA">Ukraine 🇺🇦</option>
                            <option value="UY">Uruguay 🇺🇾</option>
                            <option value="US">United States 🇺🇸</option>
                            <option value="UZ">Uzbekistan 🇺🇿</option>
                            <option value="VA">Vatican City 🇻🇦</option>
                            <option value="VC">Saint Vincent and the Grenadines 🇻🇨</option>
                            <option value="VE">Venezuela 🇻🇪</option>
                            <option value="VN">Vietnam 🇻🇳</option>
                            <option value="VU">Vanuatu 🇻🇺</option>
                            <option value="WS">Samoa 🇼🇸</option>
                            <option value="YE">Yemen 🇾🇪</option>
                            <option value="ZA">South Africa 🇿🇦</option>
                            <option value="ZM">Zambia 🇿🇲</option>
                            <option value="ZW">Zimbabwe 🇿🇼</option>
                        </select>
                        <span class="country-select-text"><?php esc_html_e('Location:', 'wp-rank-tracker'); ?></span>
                    </div>
                    <div class="wprt_keyword_popup_content_keyword">
                        <span class="keyword-input-text"><?php esc_html_e('Keyword:', 'wp-rank-tracker'); ?></span>
                        <input class="wprt_keyword_popup_content_keyword_tags"
                            autocomplete="off"
                            type="text"
                            placeholder="<?php esc_attr_e('Enter The Keyword', 'wp-rank-tracker'); ?>"
                            name="keywords"
                            required />
                    </div>
                    <div class="wprt_keyword_popup_submit">
                        <input class="wprt_keyword_popup_submit_btn" type="submit" name="submit"
                            value="<?php esc_attr_e('Add Keywords', 'wp-rank-tracker'); ?>" />
                    </div>
                </form>
                <div class="wprt_rank_status">
                    <div class="wprt_rank_status_image">
                        <div class="wprt_rank_status_image-chrome">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <?php
                        $iconHelper->getIcon('animation-popup.svg');
                        ?>
                    </div>
                    <div class="wprt_rank_status_title">
                        <?php esc_html_e('Thank you for your patience!', 'wp-rank-tracker'); ?>
                    </div>
                    <div class="wprt_rank_status_description">
                        <p><?php esc_html_e('We know you are excited to see results 🤗', 'wp-rank-tracker'); ?></p>
                        <p><?php esc_html_e('We are getting the latest results and will update you soon!', 'wp-rank-tracker'); ?></p>
                    </div>
                </div>
                <div class="wprt_rank_result">
                    <div class="wprt_keyword_popup_close_icon">
                        <a href="javascript:void(0)" class="wprt_keyword_popup_close_link">
                            <?php
                            $iconHelper->getIcon('close.svg');
                            ?>
                        </a>
                    </div>
                    <div class="wprt_rank_result_error">
                        <?php
                        $iconHelper->getIcon('mistake.svg');
                        ?>
                    </div>
                    <div class="wprt_rank_result_update">
                        <?php
                        $iconHelper->getIcon('update.svg');
                        ?>
                    </div>
                    <div class="wprt_rank_result_success">
                        <?php
                        $iconHelper->getIcon('success.svg');
                        ?>
                    </div>
                    <div class="wprt_rank_result_title"></div>
                    <div class="wprt_rank_result_description"></div>
                </div>
                <div class="wprt_rank_delete">
                    <div class="wprt_keyword_popup_close_icon">
                        <a href="javascript:void(0)" class="wprt_keyword_popup_close_link">
                            <?php
                            $iconHelper->getIcon('close.svg');
                            ?>
                        </a>
                    </div>
                    <div class="wprt_rank_delete_icon">
                        <?php
                        $iconHelper->getIcon('question-mark.svg');
                        ?>
                    </div>
                    <div class="wprt_rank_result_title">
                        <?php esc_html_e('Do you want to remove the keyword?', 'wp-rank-tracker') ?>
                    </div>
                    <div class="wprt_rank_result_description">
                        <?php esc_html_e(
                            'You are about the remove %keyword_name% keyword from your list. You will loose all the data for this keyword. Do you want to remove it permanently? ',
                            'wp-rank-tracker'
                        ); ?>
                    </div>
                    <div class="wprt_rank_delete_buttons">
                        <input class="wprt_button_third wprt_rank_delete_cancel"
                            type="submit"
                            name="submit"
                            value="<?php esc_attr_e('Cancel', 'wp-rank-tracker'); ?>" />
                        <input class="wprt_button_primary wprt_rank_delete_submit"
                            type="submit"
                            name="submit"
                            value="<?php esc_attr_e('Remove', 'wp-rank-tracker'); ?>" />
                    </div>
                    <script id="wprt_delete_description_template" type="text/template">
                        <?php esc_html_e(
                            'You are about the remove {{keywordName}} keyword from your list. You will loose all the data for this keyword. Do you want to remove it permanently?',
                            'wp-rank-tracker'
                        ); ?>
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
