<?php


namespace PanierBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SmsController extends Controller
{
    public function callAction()
    {
        //returns an instance of Vresh\TwilioBundle\Service\TwilioWrapper
        $twilio = $this->get('twilio.api');

        $message = $twilio->account->messages->sendMessage(
            '+16782646625', // From a Twilio number in your account
            '+21620344708', // Text any number
            "Bonjour Madame/Monsieur, Nous avons bien traiter votre commande "
        );

        //get an instance of \Service_Twilio
        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

        //return new Response($message->sid);
        return $this->redirectToRoute('panier_Afficher');
    }

}