<?php
/**
 * MtContactPage - simple contact page based on MtMail module
 *
 * @link      http://github.com/mtymek/MtContactPage
 * @copyright Copyright (c) 2014 Mateusz Tymek
 * @license   BSD 2-Clause
 */

return array(
    'mt_contact_page' => array(
        'send_to' => '',
        'captcha_adapter' => null,
    ),
    'router' => array(
        'routes' => array(
            'contact' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/contact',
                    'defaults' => array(
                        '__NAMESPACE__' => 'MtContactPage\Controller',
                        'controller'    => 'Contact',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'thank-you' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/thank-you',
                            'defaults' => array(
                                'action' => 'thank-you',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'MtContactPage\Form\ContactForm' => 'MtContactPage\Factory\ContactFormFactory',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'MtContactPage\Controller\Contact' => 'MtContactPage\Factory\ContactControllerFactory'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);