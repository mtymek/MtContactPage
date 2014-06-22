<?php
/**
 * MtContactPage - simple contact page based on MtMail module
 *
 * @link      http://github.com/mtymek/MtContactPage
 * @copyright Copyright (c) 2013-2014 Mateusz Tymek
 * @license   BSD 2-Clause
 */

namespace MtContactPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Form\ContactForm;

class ContactController extends AbstractActionController
{
    /**
     * @var ContactForm
     */
    protected $contactForm;

    public function indexAction()
    {
        $request = $this->getRequest();
        $form = $this->getContactForm();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $mailService = $this->mtMail();
                $message = $mailService->compose(array(
                        'subject' => $form->get('subject')->getValue(),
                        'reply-to' => $form->get('from')->getValue(),
                        'to' => 'mtymek@gmail.com'
                    ),
                    'application/mail/contact.phtml',
                    $form->getData()
                );

                $mailService->send($message);

                return $this->redirect()->toRoute('contact/thank-you');
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function thankYouAction()
    {
        $headers = $this->request->getHeaders();
        if (!$headers->has('Referer')
            || !preg_match('#/contact$#', $headers->get('Referer')->getFieldValue())
        ) {
            return $this->redirect()->toRoute('contact');
        }

        return array();
    }

    /**
     * @param \Application\Form\ContactForm $form
     * @return ContactController provides fluent interface
     */
    public function setContactForm($form)
    {
        $this->contactForm = $form;
        return $this;
    }

    /**
     * @return \Application\Form\ContactForm
     */
    public function getContactForm()
    {
        if (null === $this->contactForm) {
            $this->contactForm = $this->getServiceLocator()->get('MtContactPage\Form\ContactForm');
        }
        return $this->contactForm;
    }
}
