<?php
/**
 * MtContactPage - simple contact page based on MtMail module
 *
 * @link      http://github.com/mtymek/MtContactPage
 * @copyright Copyright (c) 2014 Mateusz Tymek
 * @license   BSD 2-Clause
 */

namespace MtContactPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use MtContactPage\Form\ContactForm;

class ContactController extends AbstractActionController
{
    /**
     * @var ContactForm
     */
    protected $contactForm;

    /**
     * @var string
     */
    protected $sendTo;

    /**
     * Class constructor
     *
     * @param ContactForm $contactForm
     */
    public function __construct(ContactForm $contactForm, $sendTo)
    {
        $this->contactForm = $contactForm;
        $this->sendTo = $sendTo;
    }

    /**
     * Render contact form and handle submission
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $form = $this->contactForm;

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $mailService = $this->mtMail();
                $message = $mailService->compose(array(
                        'subject' => $form->get('subject')->getValue(),
                        'reply-to' => $form->get('from')->getValue(),
                        'to' => $this->sendTo,
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

    /**
     * Render "Thank you" page
     *
     * @return array
     */
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
}
