<?php
/**
 * @package Hello_Dolly
 * @version 1.7.2
 */
/*
Plugin Name: Print My Blog - MCC Catalog
Description: Custom template for Mayland Community College.

Author: Morgan Fox
Version: 1.1.0
*/

use PrintMyBlog\entities\DesignTemplate;
use PrintMyBlog\orm\entities\Design;
use Twine\forms\base\FormSection;
use Twine\forms\inputs\AdminFileUploaderInput;
use Twine\forms\inputs\ColorInput;
use Twine\forms\inputs\DatepickerInput;
use Twine\forms\inputs\TextAreaInput;
use Twine\forms\inputs\TextInput;
use Twine\forms\strategies\validation\TextValidation;

define('PMBM_MAIN_FILE', __FILE__);
define('PMBM_MAIN_DIR', __DIR__);
add_action( 'pmb_register_designs', 'pmbm_register_design', 1 );
register_activation_hook(PMBM_MAIN_FILE,'pmbm_activation');

/**
 * Called when this plugin is activated, and gets PMB to check this design exists in the database (and if not, adds it)
 */
function pmbm_activation(){
    pmbm_register_design();
    pmb_check_db();
}

/**
 * Registers the design and design template. This should be done on every request so PMB knows they exist.
 */
function pmbm_register_design() {
    if(! function_exists('pmb_register_design')){
        return;
    }
    pmb_register_design_template(
        'mcc_template',
        function () {
            return [
                'title' => __('MCC Catalog'),
                'format' => 'digital_pdf',
                'dir' => PMBM_MAIN_DIR . '/design/',
                'default' => 'mcc',
                'url' => plugins_url('design/', PMBM_MAIN_FILE),
                'docs' => '',
                'supports' => [
                    'front_matter',
                    'back_matter',
                    'part',
                    'volume',
                    'anthology'
                ],
                'custom_templates' => [
                    'just_content',
                    'center_content'
                ],
                'design_form_callback' => function () {
                    return (new FormSection([
                        'subsections' =>
                            [
                                'internal_footnote_text' => new TextInput([
                                    'html_label_text' => __('Internal Footnote Text', 'print-my-blog'),
                                    'html_help_text' => __('Text to use when replacing a hyperlink with a footnote. "%s" will be replaced with the page number.', 'print-my-blog'),
                                    'default' => __('See page %s.', 'print-my-blog'),
                                    'validation_strategies' => [
                                        new TextValidation(__('You must include "%s" in the footnote text so we know where to put the URL.', 'print-my-blog'), '~.*\%s.*~')
                                    ]
                                ]),
                                'footnote_text' => new TextInput([
                                    'html_label_text' => __('External Footnote Text', 'print-my-blog'),
                                    'html_help_text' => __('Text to use when replacing a hyperlink with a footnote. "%s" will be replaced with the URL', 'print-my-blog'),
                                    'default' => __('See %s.', 'print-my-blog'),
                                    'validation_strategies' => [
                                        new TextValidation(__('You must include "%s" in the footnote text so we know where to put the URL.', 'print-my-blog'), '~.*\%s.*~')
                                    ]
                                ])
                            ],
                    ]))->merge(pmb_generic_design_form());
                },
                'project_form_callback' => function (Design $design) {
                    return new FormSection([
                        'subsections' => [
                            'institution' => new TextInput(
                                [
                                    'html_label_text' => __('Issue', 'print-my-blog'),
                                    'html_help_text' => __('Text that appears at the top-right of the cover'),
                                ]
                            ),
                            'authors' => new TextAreaInput(
                                [
                                    'html_label_text' => __('ByLine', 'print-my-blog'),
                                    'html_help_text' => __('Project Author(s)', 'print-my-blog'),
                                ]
                            ),
                            'date' => new DatepickerInput([
                                'html_label_text' => __('Date Issued', 'print-my-blog'),
                                'html_help_text' => __('Text that appears under the byline', 'print-my-blog'),
                            ]),
                        ]
                    ]);
                }
            ];
        }
    );
    pmb_register_design(
        'mcc_template',
    'mcc',
        function (DesignTemplate $design_template) {
            $preview_folder_url = plugins_url('/design/assets/', PMBM_MAIN_FILE);
            return [
                'title' => __('MCC Catalog', 'print-my-blog'),
                'quick_description' => __('Custom template for Mayland Community College.', 'print-my-blog'),
                'description' => pmb_get_contents(PMBM_MAIN_DIR . '/design/description.php'),
                'author' => [
                    'name' => 'Morgan Fox',
                    'url' => 'https://digitalspaces.dev'
                ],
                'previews' => [
                    [
                        'url' => $preview_folder_url . '/preview1.jpg',
                        'desc' => __('Title page, showing the double-spaced text.', 'print-my-blog')
                    ],
                    [
                        'url' => $preview_folder_url . '/preview2.jpg',
                        'desc' => __('Main matter, showing smaller images and double-spaced text.', 'print-my-blog')
                    ]
                ],
                'design_defaults' => [
                    'custom_css' => ''
                ],
                'project_defaults' => [
                    'institution' => 'Print My Blog'
                ],
            ];
        }
    );
}