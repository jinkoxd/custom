<?php 

namespace Drupal\hello_word\example_user_register;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Messenger\MessengerInterface;

class FormTesting extends FormBase{
    public function getFormId() {
        return 'form_testing';
      }
    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['description'] = [
          '#type' => 'item',
          '#markup' => $this->t('Please enter the title and accept the terms of use of the site.'),
        ];
    
        
    $form['name'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Họ và tên'),
          '#description' => $this->t('Enter the title of the book. Note that the title must be at least 10 characters in length.'),
          '#required' => TRUE,
        ];

        $form['phone'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Số điện thoại'),
            '#description' => $this->t('Enter the title of the book. Note that the title must be at least 10 characters in length.'),
            '#required' => TRUE,
          ];
    
          $form['email'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Email'),
            
          ];

          $form['age'] = array (
            '#type' => 'select',
            '#title' => ('Age:'),
            '#options' => array(
              '10-20' => t('10-20'),
              '20-30' => t('20-30'),
              '30-50' => t('30-50'),
            ),
          );

          $form['describe'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Mô tả bản thân'),

          ];
    
        // Group submit handlers in an actions element with a key of "actions" so
        // that it gets styled correctly, and so that other modules may add actions
        // to the form. This is not required, but is convention.
        $form['actions'] = [
          '#type' => 'actions',
        ];
    
        // Add a submit button that handles the submission of the form.
        $form['actions']['submit'] = [
          '#type' => 'submit',
          '#value' => $this->t('Submit'),
        ];
    
        return $form;
    
      }

      public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);
    
        $name = $form_state->getValue('name');
        $phone = $form_state->getValue('phone');
        $email = $form_state->getValue('email');
        $describe = $form_state->getValue('describe');
        $age = $form_state->getValue('age');
        $accept = $form_state->getValue('accept');
    
        if ($age < 20) {
          // Set an error for the form element with a key of "title".
          $form_state->setErrorByName('title', $this->t('Must be under 18'));
        }
    
        if (empty($accept)){
          // Set an error for the form element with a key of "accept".
          $form_state->setErrorByName('accept', $this->t('You must accept the terms of use to continue'));
        }
    
      }
      public function submitForm(array &$form, FormStateInterface $form_state) {

        // Display the results.
        
        // Call the Static Service Container wrapper
        // We should inject the messenger service, but its beyond the scope of this example.
        $messenger = \Drupal::messenger();
        $messenger->addMessage('Name: '.$form_state->getValue('Name'));
        $messenger->addMessage('Phone: '.$form_state->getValue('Phone'));
        $messenger->addMessage('Email: '.$form_state->getValue('Email'));
        $messenger->addMessage('Describe: '.$form_state->getValue('Age'));
        $messenger->addMessage('Age: '.$form_state->getValue('Describe'));
        $messenger->addMessage('Describe: '.$form_state->getValue('accept'));
    
        // Redirect to home
        $form_state->setRedirect('<front>');
    
      } 
    }
