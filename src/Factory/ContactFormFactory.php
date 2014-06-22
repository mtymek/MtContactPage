<?php
/**
 * MtContactPage - simple contact page based on MtMail module
 *
 * @link      http://github.com/mtymek/MtContactPage
 * @copyright Copyright (c) 2014 Mateusz Tymek
 * @license   BSD 2-Clause
 */

namespace MtContactPage\Factory;

use MtContactPage\Form\ContactFilter;
use MtContactPage\Form\ContactForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContactFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ContactForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        if ($config['mt_contact_page']['captcha_adapter']) {
            $captcha = $serviceLocator->get($config['mt_contact_page']['captcha_adapter']);
        } else {
            $captcha = null;
        }
        $form = new ContactForm('contact', $captcha);
        $form->setInputFilter(new ContactFilter());
        return $form;
    }
}