<?php

namespace AppBundle\Controller;

use DoraBundle\Entity\Jardin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/pers", name="pers")
     */
    public function persAction(Request $request)
    {
        $us=new Jardin();
        $us->setEmail("admin@admin.com");
        $us->setUsername("admin");
        $us->setEnabled(true);
        $us->setPlainPassword("karim123");
        $us->addRole("ROLE_ADMIN");
        $us->setDescription("notre jardin est bien connu sur le nom de jardin rosé comme le vin rosé 
        alors n'hésiter pas d'envoyer vos enfants pour se profiter de leurs enfance Cordialement chers etudiant");
        $us->setNumtel("51887898");
        $us->setName("Jardin rosé");
        $us->setAdresse("tunis");
        $us->setTarif(250);
        $em=$this->getDoctrine()->getManager();
        $em->persist($us);
        $em->flush();



        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/signin", name="user_login")
     */
    public function loginAction(Request $request){
        // i thought it was in the parent controller but it s here so if u want to check the other comment go there lol
        $username=$request->get('username');
        $password=$request->get('password');

        if($request->isMethod("GET")){
            return $this->render("default/login.html.twig",array("msg"=>""));
        }else{

            // Retrieve the security encoder of symfony
            $factory = $this->get('security.encoder_factory');


            $user_manager = $this->get('fos_user.user_manager');
            //$user = $user_manager->findUserByUsername($username);
            // Or by yourself
            $user = $this->getDoctrine()->getManager()->getRepository("UserBundle:User")
                ->findOneBy(array('username' => $username));
            /// End Retrieve user

            // Check if the user exists !
            if(!$user){
                return $this->render("default/login.html.twig",array("msg"=>"user does not exist"));
            }

            /// Start verification
            $encoder = $factory->getEncoder($user);
         ;


            if(!$encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
                return $this->render("default/login.html.twig",array("msg"=>"username or password are incorrect"));
            }
            /// End Verification

            // The password matches ! then proceed to set the user in session

            //Handle getting or creating the user entity likely with a posted form
            // The third parameter "main" can change according to the name of your firewall in security.yml
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);

            // If the firewall name is not main, then the set value would be instead:
            // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
            $this->get('session')->set('_security_main', serialize($token));

            // Fire the login event manually
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            // $us=$this->container->get('security.token_storage')->getToken()->getUser();

            if ($this->container->get('security.authorization_checker')->isGranted("ROLE_ADMIN")) {
                // SUPER_ADMIN roles go to the `admin_home` route
                return $this->redirectToRoute("Page_Admin");
            }elseif($this->container->get('security.authorization_checker')->isGranted('ROLE_CLIENT')) {
                // Everyone else goes to the `home` route
                return $this->redirect("/");
            }

        }
    }







}
