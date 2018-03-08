<?php

namespace Drupal\participer\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Session\AccountProxy;


/**
 * Class SubmitForm.
 */
class SubmitForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'submit_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => ' Y participer',
    ];

      $form['sample1'] = array(
      '#type' => 'submit',
      '#value' => 'Ne pas y participer',
      '#submit' => array('::newSubmissionHandlerOne'),
    );

      $form['sample2'] = array(
      '#type' => 'submit',
      '#value' => 'Peut-être y participer',
      '#submit' => array('::newSubmissionHandlerOne'),
    );  

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {


    parent::validateForm($form, $form_state);

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $node = \Drupal::routeMatch()->getParameter('node');
    
    


     $node = \Drupal::routeMatch()->getParameter('node');

     $nid = \Drupal::routeMatch()->getParameter('node')->id();

    // kint($nid); //  die();


     $uid = \Drupal::currentUser()->id();
   //  kint($uid);  // Affiche "1"

     $email = \Drupal::currentUser()->getEmail();
    // kint($email); // Affiche "ibrahima88sow@yahoo.fr"  

     $nom = \Drupal::currentUser()->getAccountName();
     // puisque le bloc contenant le formuilaire n'apparait que dans la page "EVENEMENT "
   //  kint($nom); // Affiche "Admin" 


     $participe = $form_state->getValue('submit');
    // kint($participe); // Affiche "Y participer"
     $participePas = $form_state->getValue('sample1');
     $participePeutEtre = $form_state->getValue('sample2');


 
    // kint($email); // Affiche "ibrahimùa88sow@yahoo.fr"  ou autre choix posté

     $date = time();
    // kint($date);  // Affiche  "1519581968"


    // kint( \Drupal::routeMatch()->getParameter('node')->getType() ); die();
     // Affiche  "evenement"
     // puisque le bloc contenant le formuilaire n'apparait que dans la page "EVENEMENT "
         /// Si le patho à été ete activé on recherchera le mot "EVENEMENT" dans l'url
      $nodeTypeIsEvenement = \Drupal::routeMatch()->getParameter('node')->getType() == 'evenement';
     if($nodeTypeIsEvenement && $participe){

        $connexion= \Drupal::service('database');
        $connexion->insert('presence')
            ->fields(
                array(
                        'nid' =>  $nid,
                        'uid' => $uid ,
                        'nom' =>  $nom,
                        'E-mail' => $email,
                        'participe' => $participe ,
                        'participePas' => $participePas ,
                        'participePeutEtre' => $participePeutEtre ,
                        'date' => $date,
             ))->execute();;

     }


    // $form_state->setRedirect('participer.participer.form',[
    //            'nid' => $nid,
    //       ]);

  }

}
