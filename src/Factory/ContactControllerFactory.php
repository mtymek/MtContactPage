<?php
/**
 * MtContactPage - simple contact page based on MtMail module
 *
 * @link      http://github.com/mtymek/MtContactPage
 * @copyright Copyright (c) 2014 Mateusz Tymek
 * @license   BSD 2-Clause
 */

namespace MtContactPage\Factory;

use MtContactPage\Controller\ContactController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContactControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ContactController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appSm = $serviceLocator->getServiceLocator();
        $config = $appSm->get('Configuration');
        return new ContactController(
            $appSm->get('MtContactPage\Form\ContactForm'),
            $config['mt_contact_page']['send_to']
        );
    }
}